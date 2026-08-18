{{-- Applies the stored language direction before first paint to avoid a flash of RTL. --}}
<script>
    (function () {
        var lang = localStorage.getItem('app_lang') === 'en' ? 'en' : 'ar';
        var html = document.documentElement;
        html.lang = lang;
        html.dir = lang === 'en' ? 'ltr' : 'rtl';
        html.dataset.lang = lang;
    })();
</script>
