require(['jquery'], function ($) {
    'use strict';

    console.log('js loading');

    var tagManagerNoScript = '<!-- Google Tag Manager (noscript) -->' +
    '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MDPTN53"' +
    'height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' +
    '<!-- End Google Tag Manager (noscript) -->';

    // $('head').prepend(tagManagerScript);
    $('body').prepend(tagManagerNoScript);
});
