(function () {
    'use strict';
    var sidebar = document.querySelector('.home-sidebar');
    var banner = document.querySelector('header .banner_t');
    if (!sidebar || !banner) return;

    function visible(element) {
        var rect = element.getBoundingClientRect();
        var style = window.getComputedStyle(element);
        return rect.width > 0 && rect.height > 0 &&
            style.display !== 'none' && style.visibility !== 'hidden';
    }

    function update() {
        // Reserve the sidebar offset whenever the banner occupies layout space,
        // including an empty ad slot that has not loaded its creative yet.
        var hasBanner = visible(banner);
        sidebar.classList.toggle('has-top-banner', hasBanner);
    }

    var observer = null;
    function observeContent() {
        if (!observer) return;
        observer.disconnect();
        observer.observe(banner);
        banner.querySelectorAll('[id^="yandex_rtb_"], iframe, img').forEach(function (element) {
            observer.observe(element);
        });
    }
    if ('ResizeObserver' in window) observer = new ResizeObserver(update);
    if ('MutationObserver' in window) {
        new MutationObserver(function () {
            observeContent();
            update();
        }).observe(banner, {childList: true, subtree: true, attributes: true});
    }
    banner.addEventListener('load', update, true);
    window.addEventListener('resize', update);
    observeContent();
    update();
}());
