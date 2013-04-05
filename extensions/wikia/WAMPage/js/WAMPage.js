var WAMPage = function() {};

WAMPage.prototype = {
	init: function() {
		document.getElementById('wam-index').addEventListener(
			'click',
			WAMPage.clickTrackingHandler,
			true
		);
		
		document.getElementById('wam-index-search').addEventListener(
			'change',
			$.proxy(function() {
				WAMPage.clickTrackingHandler(event);
				WAMPage.filterWamIndex(event);
			}, this),
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
				maxDate: 0,
				onSelect: function() {
					if( $(this).closest('#WamFilterDate') ) {
						WAMPage.trackClick('WamPage', Wikia.Tracker.ACTIONS.CLICK, 'wam-search-filter-change', null, {lang: wgContentLanguage, filter: 'date'});
					}
				}
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
		
		if( node.closest('.wam-index-search button').length > 0 ) {
			searchPhrase = $('.wam-index-search button img')
				.parents('form')
				.find('input[name="searchPhrase"]')
				.val();
			WAMPage.trackClick('WamPage', Wikia.Tracker.ACTIONS.SUBMIT, 'wam-search', null, {lang: lang, phrase: searchPhrase}, e);
		} else if ( e.type === 'change' && node.closest('.wam-index-search select[name=langCode]').length > 0 ) {
			WAMPage.trackClick('WamPage', Wikia.Tracker.ACTIONS.CLICK, 'wam-search-filter-change', null, {lang: lang, filter: 'langCode'}, e);
		} else if ( e.type === 'change' && node.closest('.wam-index-search select[name=verticalId]').length > 0 ) {
			WAMPage.trackClick('WamPage', Wikia.Tracker.ACTIONS.CLICK, 'wam-search-filter-change', null, {lang: lang, filter: 'verticalId'}, e);
		}
	},

	filterWamIndex: function(e) {
		$(e.target).parents('.wam-index-search').submit();
	}
};

var WAMPage = new WAMPage();
$(function () {
	WAMPage.init();
});
