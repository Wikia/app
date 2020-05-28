// This file is not currently being used but left in repo for future use
$(function() {
    if (!window.Wikia.Cookies.get('dismissed-privacy-notification')) {
        var message = 'Please take notice that we have updated our <a href="https://www.fandom.com/privacy-policy">privacy policy</a>, <a href="https://www.fandom.com/terms-of-use">terms of use</a> and <a href="https://www.fandom.com/terms-of-sale">terms of sale</a> to (a) provide greater transparency around the ways we collect, process, and use personal information, and to implement the requirements of the California Consumer Privacy Act (CCPA), and (b) to create a single privacy policy, terms of use and terms of sale across all of our properties. These changes went into effect on January 1, 2020.';
        // display notification

        if (typeof BannerNotification !== "function") {
            return;
        }

        var notification = new BannerNotification(message).show();

        function getCookieDomain(hostname) {
            var parts = hostname.split('.');
        
            var cookieDomain = '.' + parts[parts.length-2] + '.' + parts[parts.length - 1];
            // These exceptions require a third part for a valid cookie domain. This isn't
            // a definitive list but rather the most likely domains on which Fandom would
            // host a site.
            var exceptions = [
                '.co.jp',
                '.co.nz',
                '.co.uk',
            ];
            if (exceptions.indexOf(cookieDomain) >= 0) {
                cookieDomain = '.' + parts[parts.length - 3] + cookieDomain;
            }
        
            return cookieDomain;
        }

        notification.onClose(function() {
            window.Wikia.Cookies.set('dismissed-privacy-notification', true, { domain: getCookieDomain(window.location.hostname), path: '/' });
        });
    }   
});
