$(function() {
    if (!window.Wikia.Cookies.get('dismissed-privacy-notification')) {
        var message = 'Please take notice that we have updated our <a href="https://www.fandom.com/privacy-policy">privacy policy</a>, <a href="https://www.fandom.com/terms-of-use">terms of use</a> and <a href="https://www.fandom.com/terms-of-sale">terms of sale</a> to (a) provide greater transparency around the ways we collect, process, and use personal information, and to implement the requirements of the California Consumer Privacy Act (CCPA), and (b) to create a single privacy policy, terms of use and terms of sale across all of our properties. These changes went into effect on January 1, 2020.';
        // display notification
        var notification = new BannerNotification(message).show();

        notification.onClose(function() {
            window.Wikia.Cookies.set('dismissed-privacy-notification', true, { domain: 'fandom.com', path: '/' });
        });
    }   
});
