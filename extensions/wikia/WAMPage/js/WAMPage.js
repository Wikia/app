var WAMPage = function() {};

WAMPage.prototype = {
	init: function() {
		var track = Wikia.Tracker.buildTrackingFunction({
			category: 'WAMPage',
			trackingMethod: 'internal',
			action: Wikia.Tracker.ACTIONS.IMPRESSION
		});
		
		if( window.wgTitle ) {
			if( window.wgWAMPageName && wgTitle === wgWAMPageName ) {
				track({label: 'index'});
			} else if( window.wgWAMFAQPageName && wgTitle === wgWAMFAQPageName ) {
				track({label: 'faq'});
			}
		}

		$.when(
			// jQuery UI datepicker plugin
			mw.loader.use(['jquery.ui.datepicker'])
		).done($.proxy(function(getResourcesData) {
			$('#WamFilterDate').datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				maxDate: 0
			})
		}, this));
	}
};

var WAMPage = new WAMPage();
$(function () {
	WAMPage.init();
});