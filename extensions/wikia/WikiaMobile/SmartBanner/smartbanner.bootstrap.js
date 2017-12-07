$(function () {
	'use strict';

	require(['wikia.window', 'wikia.cookies', 'wikia.loader', 'JSMessages'], function (window, cookie, loader, msg) {
		var ua = window.navigator.userAgent,
			standalone = navigator.standalone, // Check if it's already a standalone web app or running within a webui view of an app (not mobile safari)
			type;

		// Detect banner type (iOS or Android)
		if (ua.match(/iPad|iPhone|iPod/i) !== null) {
			if (ua.match(/Safari/i) !== null && (ua.match(/CriOS/i) !== null || // Check webview and native smart banner support (iOS 6+)
				window.Number(ua.substr(ua.indexOf('OS ') + 3, 3).replace('_', '.')) < 6
			)) {
				type = 'ios';
			}
		} else if (ua.match(/Android/i) !== null) {
			type = 'android';
		}

		//Don't show banner if device isn't iOS or Android, website is loaded in app or user dismissed banner
		if (type && !standalone && !cookie.get('sb-closed') && !cookie.get('sb-installed') &&
			window.wgAppName &&
			window.wgAppIcon
		) {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: '/extensions/wikia/WikiaMobile/SmartBanner/smartbanner.mustache',
					scripts: 'wikiamobile_smartbanner_js',
					styles: '//extensions/wikia/WikiaMobile/SmartBanner/smartbanner.scss',
					messages: 'SmartBanner'
				}
			}).done(function (res) {
				loader.processStyle(res.styles);
				loader.processScript(res.scripts);

				require(['smartbanner'], function (sb) {
					sb({
						title: window.wgAppName, //set in WikiaMobileService
						type: type,
						template: res.mustache[0],
						price: msg('wikiasmartbanner-price'), // Price of the app
						button: msg('wikiasmartbanner-view'),
						inAppStore: msg('wikiasmartbanner-appstore'), // Text of price for iOS
						inGooglePlay: msg('wikiasmartbanner-googleplay'), // Text of price for Android
						icon: window.wgAppIcon.search(/^https?:\/\//) === 0 ?
							window.wgAppIcon : window.wgExtensionsPath + window.wgAppIcon // The URL of the icon (defaults to <meta name="apple-touch-icon">)
					});
				});
			});
		}
	});
});
