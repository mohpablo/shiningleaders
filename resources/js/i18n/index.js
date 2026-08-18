import dictionary from './dictionary.js';

const STORAGE_KEY = 'app_lang';
const LANGS = ['ar', 'en'];
const TASHKEEL = /[\u064B-\u0652\u0670\u0640]/g;
const TRANSLATABLE_ATTRS = {
    placeholder: 'i18nPlaceholder',
    title: 'i18nTitle',
    'aria-label': 'i18nAriaLabel',
    alt: 'i18nAlt',
};

const normalize = (value) => value.replace(TASHKEEL, '').replace(/\s+/g, ' ').trim();

const table = new Map();
for (const [arabic, english] of Object.entries(dictionary)) {
    table.set(normalize(arabic), english);
}

const phrases = [...table.keys()].sort((a, b) => b.length - a.length);
const phrasePattern = new RegExp(
    phrases.map((phrase) => phrase.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')).join('|'),
    'g'
);

const originals = new WeakMap();
let currentLang = 'ar';
let observer = null;

function translate(value) {
    const normalized = normalize(value);
    if (!normalized) return null;

    const exact = table.get(normalized);
    if (exact !== undefined) {
        const [, leading, , trailing] = value.match(/^(\s*)([\s\S]*?)(\s*)$/);
        return `${leading}${exact}${trailing}`;
    }

    phrasePattern.lastIndex = 0;
    if (!phrasePattern.test(normalized)) return null;
    phrasePattern.lastIndex = 0;

    return normalized.replace(phrasePattern, (match) => table.get(match) ?? match);
}

function isSkipped(node) {
    const parent = node.parentElement;
    if (!parent) return true;
    if (parent.closest('script, style, textarea, code, pre, [data-i18n-ignore]')) return true;
    return false;
}

function applyToTextNode(node, lang) {
    const original = originals.get(node);

    if (lang === 'ar') {
        if (original !== undefined) node.nodeValue = original;
        return;
    }

    const source = original !== undefined ? original : node.nodeValue;
    const translated = translate(source);
    if (translated === null || translated === source) return;

    if (original === undefined) originals.set(node, node.nodeValue);
    node.nodeValue = translated;
}

function applyToAttributes(element, lang) {
    for (const [attr, datasetKey] of Object.entries(TRANSLATABLE_ATTRS)) {
        if (!element.hasAttribute(attr)) continue;

        const stored = element.dataset[datasetKey];

        if (lang === 'ar') {
            if (stored !== undefined) element.setAttribute(attr, stored);
            continue;
        }

        const source = stored !== undefined ? stored : element.getAttribute(attr);
        const translated = translate(source);
        if (translated === null || translated === source) continue;

        if (stored === undefined) element.dataset[datasetKey] = source;
        element.setAttribute(attr, translated);
    }
}

function walk(root, lang) {
    if (root.nodeType === Node.TEXT_NODE) {
        if (!isSkipped(root)) applyToTextNode(root, lang);
        return;
    }

    if (root.nodeType !== Node.ELEMENT_NODE && root.nodeType !== Node.DOCUMENT_FRAGMENT_NODE) return;

    if (root.nodeType === Node.ELEMENT_NODE) applyToAttributes(root, lang);

    const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT | NodeFilter.SHOW_ELEMENT);
    let node = walker.nextNode();
    while (node) {
        if (node.nodeType === Node.TEXT_NODE) {
            if (!isSkipped(node)) applyToTextNode(node, lang);
        } else {
            applyToAttributes(node, lang);
        }
        node = walker.nextNode();
    }
}

function updateDocumentAttributes(lang) {
    const html = document.documentElement;
    html.lang = lang;
    html.dir = lang === 'ar' ? 'rtl' : 'ltr';
    html.dataset.lang = lang;

    const title = translate(document.title);
    if (lang === 'en' && title) {
        document.title = title;
    }
}

function updateToggleLabels(lang) {
    document.querySelectorAll('[data-lang-toggle]').forEach((button) => {
        button.textContent = lang === 'ar' ? 'English' : 'العربية';
        button.setAttribute('aria-label', lang === 'ar' ? 'Switch to English' : 'التبديل إلى العربية');
    });
}

function applyLanguage(lang) {
    currentLang = LANGS.includes(lang) ? lang : 'ar';
    localStorage.setItem(STORAGE_KEY, currentLang);

    if (observer) observer.disconnect();
    updateDocumentAttributes(currentLang);
    walk(document.body, currentLang);
    updateToggleLabels(currentLang);
    if (observer) observer.observe(document.body, { childList: true, subtree: true, characterData: true });
}

function watchDynamicContent() {
    observer = new MutationObserver((mutations) => {
        if (currentLang === 'ar') return;

        for (const mutation of mutations) {
            if (mutation.type === 'characterData') {
                if (!isSkipped(mutation.target)) applyToTextNode(mutation.target, currentLang);
                continue;
            }
            mutation.addedNodes.forEach((node) => walk(node, currentLang));
        }
    });

    observer.observe(document.body, { childList: true, subtree: true, characterData: true });
}

function getStoredLanguage() {
    const stored = localStorage.getItem(STORAGE_KEY);
    return LANGS.includes(stored) ? stored : 'ar';
}

function bindToggles() {
    document.addEventListener('click', (event) => {
        const toggle = event.target.closest('[data-lang-toggle]');
        if (!toggle) return;
        event.preventDefault();
        applyLanguage(currentLang === 'ar' ? 'en' : 'ar');
    });
}

export function setLanguage(lang) {
    applyLanguage(lang);
}

export function getLanguage() {
    return currentLang;
}

export default function initI18n() {
    const start = () => {
        watchDynamicContent();
        bindToggles();
        applyLanguage(getStoredLanguage());
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
}
