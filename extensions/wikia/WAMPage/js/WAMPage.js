var WAMPage = function() {};

WAMPage.prototype = {
	init: function() {
		var track = WikiaTracker.buildTrackingFunction({
			category: 'WAMPage',
			trackingMethod: 'internal',
			action: WikiaTracker.ACTIONS.IMPRESSION
		});
		
		if( window.wgTitle && window.wgWAMPageName && wgTitle === wgWAMPageName ) track({label: 'index'});
		if( window.wgTitle && window.wgWAMFAQPageName && wgTitle === wgWAMFAQPageName ) track({label: 'faq'});
	}
};

var WAMPage = new WAMPage();
$(function () {
	WAMPage.init();
});