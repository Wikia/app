var WAMPage = function() {};

WAMPage.prototype = {
	init: function() {
		if( wgTitle === 'WAM' ) {
			$().log('Trying to track WAM impression...');
			
			require(['WAMPageTracker'], function(WAMPageTracker) {
				WAMPageTracker.track('index');
			});
		}

		if( wgTitle === 'WAM/FAQ' ) {
			$().log('Trying to track WAM/FAQ impression...');
			
			require(['WAMPageTracker'], function(track) {
				WAMPageTracker.track('faq');
			});
		}
	}
};

var WAMPage = new WAMPage();
$(function () {
	WAMPage.init();
});