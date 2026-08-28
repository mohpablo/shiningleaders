import Alpine from 'alpinejs';
import initI18n from './i18n/index.js';

// Initialize Alpine.js for UI components, state, dropdowns, etc.
window.Alpine = Alpine;
Alpine.start();

// Initialize your vanilla JS translation script
initI18n();