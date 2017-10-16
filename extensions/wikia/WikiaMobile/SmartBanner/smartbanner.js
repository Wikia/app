/**
 * Smart Banner by Jakub Olek
 *
 * preety much based on:
 * jQuery Smart Banner
 * Copyright (c) 2012 Arnold Daniels <arnold@jasny.net>
 * Based on 'jQuery Smart Web App Banner' by Kurt Zenisek @ kzeni.com
 */
define('smartbanner', ['wikia.window', 'wikia.cookies', 'jquery', 'track'], function smartbanner(window, cookie, $, track) {
	'use strict';

	var html = window.document.documentElement,
		defaults = {
			appStoreLanguage: window.wgUserLanguage || 'us', // Language code for App Store
			iconGloss: null, // Force gloss effect for iOS even for precomposed
			url: null, // The URL for the button. Keep null if you want the button to link to the app store.
			daysHidden: 15, // Duration to hide the banner after being closed (0 = always show banner)
			daysReminder: 90 // Duration to hide the banner after "VIEW" is clicked *separate from when the close button is clicked* (0 = always show banner)
		},
		day = 86400000,
		hide = function () {
			html.className = html.className.replace(' sb-shown', '');
		},
		link;

	return function (options) {
		var type = options.type || 'ios',
			meta = document.querySelector(
				(type === 'android') ? 'meta[name="google-play-app"]' : 'meta[name="apple-itunes-app"]'
			),
			appId,
			cookieData = {
				domain: window.wgCookieDomain,
				path: window.wgCookiePath
			};

		track.event('smart-banner', track.IMPRESSION, {
			method: 'analytics'
		});

		// Get info from meta data// Get info from meta data
		if (meta) {
			appId = /app-id=([^\s,]+)/.exec(meta.getAttribute('content'))[1];

			options = $.extend(defaults, options);

			if (type === 'android') {
				link = 'https://play.google.com/store/apps/details?id=' +
					appId +
					'&referrer=utm_source%3Dwikia%26utm_medium%3Dsmartbanner%26utm_term%3D' +
					window.wgDBname;
			} else {
				link = 'https://itunes.apple.com/' +
					options.appStoreLanguage +
					'/app/id' +
					appId;
			}

			document.body.insertAdjacentHTML('afterbegin', Mustache.render(options.template, {
				type: type,
				title: options.title || '',
				author: options.author || '',
				inStore: options.price ?
					options.price.toUpperCase() +
						' - ' +
						(type === 'android' ? options.inGooglePlay : options.inAppStore) :
					'',
				gloss: options.iconGloss === null ? type === 'ios' : options.iconGloss,
				link: (options.url ? options.url : link),
				button: options.button || 'VIEW',
				icon: options.icon
			}));

			html.className += ' sb-shown';

			document.getElementsByClassName('smartbanner')[0].addEventListener('click', function (ev) {
				var t = ev.target,
					className = t.className;

				if (~className.indexOf('sb-button')) {
					hide();

					cookie.set('sb-installed', 1, $.extend(cookieData, {
						expires: options.daysReminder * day
					}));

					track.event('smart-banner', track.CLICK, {
						label: 'app-store',
						method: 'analytics'
					}, ev);
				} else if (~className.indexOf('sb-close') || ~className.indexOf('sb-close-btn')) {
					hide();

					cookie.set('sb-closed', 1, $.extend(cookieData, {
						expires: options.daysHidden * day
					}));

					track.event('smart-banner', track.CLICK, {
						label: 'dismiss',
						method: 'analytics'
					});
				}
			});
		}
	};
});
