var WAMPage = function() {};

WAMPage.prototype = {
	init: function() {
		var track = Wikia.Tracker.buildTrackingFunction({
			category: 'WAMPage',
			trackingMethod: 'internal',
			action: WikiaTracker.ACTIONS.IMPRESSION
		});
		
		if( window.wgTitle ) {
			if( window.wgWAMPageName && wgTitle === wgWAMPageName ) {
				track({label: 'index'});
			} else if( window.wgWAMFAQPageName && wgTitle === wgWAMFAQPageName ) {
				track({label: 'faq'});
			}
		}
	}
};

var WAMPage = new WAMPage();
$(function () {
	WAMPage.init();
});