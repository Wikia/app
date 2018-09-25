require([
    'wikia.window',
    'wikia.cookies',
], function (window, cookie) {
    'use strict';
    if (cookie.get('autologin_done') === null && window.wgUserName === null) {
        var iframe = window.document.createElement('iframe');
        iframe.src = mw.config.get('wgSafariPoCUrl');
        window.document.getElementById('WikiaArticle').appendChild(iframe);

        window.addEventListener('message',function(event) {
            if (event.data === "poc_auth_worked") {
                alert('poc_auth_worked event received, will reload the page');
                window.location.reload();
            }
        }, false);
    }
});
