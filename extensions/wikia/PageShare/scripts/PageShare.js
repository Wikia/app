define('wikia.pageShare', ['wikia.window', 'wikia.tracker', 'jquery'], function (win, tracker, $) {
	'use strict';

	var trackFunc = tracker.buildTrackingFunction({
		action: win.Wikia.Tracker.ACTIONS.CLICK,
		category: 'social-share',
		trackingMethod: 'analytics'
	});

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
			h = Math.floor(win.innerHeight / 2),
			w = Math.floor(win.innerWidth / 2);

		trackFunc({label: service.data('share-service')});
		win.open(url, title, 'width=' + w + ',height=' + h);
	}

	function appendShareIcons(data) {
		if (data.socialIcons) {
			var url = encodeURIComponent(win.location.origin + win.location.pathname),
				title = encodeURIComponent(win.document.title),
				description = encodeURIComponent($('meta[property="og:description"]').attr('content'));

			$('#PageShareContainer')
				.html(data.socialIcons
					.replace(/\$url/g, url)
					.replace(/\$title/g, title)
					.replace(/\$description/g, description)
				)
				.on('click', '.page-share a', shareLinkClick);
		}
	}

	function loadShareIcons() {
		var mCacheQueryStringParam = $.getUrlVar('mcache'),
			requestData = {
				lang: getShareLang($.getUrlVar('uselang')),
				isTouchScreen: win.Wikia.isTouchScreen() ? 1 : 0
			};

		if (mCacheQueryStringParam) {
			requestData.mcache = mCacheQueryStringParam;
		}

		$.nirvana.sendRequest({
			type: 'GET',
			controller: 'PageShare',
			method: 'getShareIcons',
			data: requestData,
			callback: appendShareIcons
		});
	}

	/**
	 * @desc Returns a language code.
	 * If user is logged in, language code is read from user's preferences.
	 * For anonymous users first two letters of the browser/system regional preferences are used.
	 * Both values are ignored and overwritten if function is provided with a non-false parameter.
	 *
	 * @param {*} useLangQueryStringParam
	 * @returns {String|null}
	 */
	function getShareLang(useLangQueryStringParam) {
		// forced by param
		if (useLangQueryStringParam) {
			return useLangQueryStringParam;
		// logged in user
		} else if (win.wgUserName) {
			return win.wgUserLanguage;
		// anonymous user who uses
		// Chrome or Firefox
		} else if (win.navigator.languages) {
			return win.navigator.languages[0].substr(0, 2);
		// Safari
		} else if (win.navigator.language) {
			return win.navigator.language.substr(0, 2);
		// Internet Exploder
		} else if (win.navigator.userLanguage) {
			return win.navigator.userLanguage.substr(0, 2);
		// something exotic
		} else {
			return null;
		}
	}

	return {
		loadShareIcons: loadShareIcons,
		getShareLang: getShareLang
	};
});
