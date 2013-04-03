var WAMPage = function() {};

WAMPage.prototype = {
	init: function() {
		document.getElementById('wam-index').addEventListener(
			'click',
			WAMPage.clickTrackingHandler,
			true
		);

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
	},

	trackClick: function (category, action, label, value, params, event) {
		Wikia.Tracker.track({
			action: action,
			browserEvent: event,
			category: category,
			label: label,
			trackingMethod: 'internal',
			value: value
		}, params);
	},

	clickTrackingHandler: function (e) {
		var node = $(e.target),
			lang = wgContentLanguage,
			searchPhrase;
		if (node.closest('.wam-index-search button').length > 0) {
			searchPhrase = $('.wam-index-search button img')
				.parents('form')
				.find('input[name="searchPhrase"]')
				.val();
			WAMPage.trackClick('WamPage', Wikia.Tracker.ACTIONS.SUBMIT, 'wamsearch', null, {lang: lang, phrase: searchPhrase}, e);
		}
	}
};

var WAMPage = new WAMPage();
$(function () {
	WAMPage.init();
});
