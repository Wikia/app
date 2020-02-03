$(function() {
    function getCookie(name) {
        var nameEQ = name + '=';
        var ca = document.cookie.split(';');
    
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
    
        return null;
    }

    if (!getCookie('dismissed-privacy-notification')) {
        var message = 'Please take notice that we have updated our <a href="www.fandom.com/privacy-policy">privacy policy</a>, <a href="www.fandom.com/terms-of-use">terms of use</a> and <a href="www.fandom.com/terms-of-sale">terms of sale</a> to (a) provide greater transparency around the ways we collect, process, and use personal information, and to implement the requirements of the California Consumer Privacy Act (CCPA), and (b) to create a single privacy policy, terms of use and terms of sale across all of our properties. These changes went into effect on January 1, 2020.';
        // display notification
        new BannerNotification(message).show();

        $('.wds-banner-notification__close').on('click', function() {
            // set cookie
            document.cookie = 'dismissed-privacy-notification=true; path=/';
        });
    }   
});
