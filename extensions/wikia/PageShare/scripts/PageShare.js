require(['wikia.window', 'wikia.tracker', 'jquery'], function(win, tracker, $) {
	'use strict';

	var trackFunc = tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: 'share',
		trackingMethod: 'both'
	});

	function loadShareIcons() {
		var useLang = $.getUrlVar('uselang'),
			browserLang = (win.navigator.language || win.navigator.browserLanguage),
			browserLangShort;

		if (browserLang) {
			browserLangShort = browserLang.substr(0, 2)
		}
		$.nirvana.sendRequest({
			type: 'GET',
			controller: 'PageShare',
			method: 'getShareIcons',
			data: {
				browserLang: browserLangShort,
				useLang: useLang
			},
			callback: pasteShareIcons
		})
	}

	function pasteShareIcons(data) {
		var $container = $('#PageShareContainer');
		if (data.socialIcons) {
			$container.html(data.socialIcons);
			$('#PageShareToolbar').on('click', '.page-share a', shareLinkClick);
		}
	}

	/**
	 * @desc Share click handler
	 *
	 * @param {Event} event
	 */
	function shareLinkClick(event) {
		event.stopPropagation();
		event.preventDefault();

		var service = $(event.target).closest('a'),
			url = service.prop('href'),
			title = service.prop('title'),
			h = (win.innerHeight / 2 | 0), // round down
			w = (win.innerWidth / 2 | 0);  // round down

		trackFunc({label: service.data('share-service')});

		win.open(url, title, 'width=' + w + ',height=' + h);
	}

	// bind events to links
	$(function(){
		loadShareIcons();
	});
});
