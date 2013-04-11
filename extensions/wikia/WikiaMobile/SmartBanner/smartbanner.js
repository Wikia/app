/**
 * Smart Banner by Jakub Olek
 *
 * preety much based on:
 * jQuery Smart Banner
 * Copyright (c) 2012 Arnold Daniels <arnold@jasny.net>
 * Based on 'jQuery Smart Web App Banner' by Kurt Zenisek @ kzeni.com
 */
window.addEventListener('load', function(){
	require(['wikia.window', 'wikia.cookies'], function(window, cookie){
		'use strict';

		var origHtmlMargin = ~~document.documentElement.style.marginTop, // Get the original margin-top of the HTML element so we can take that into account
			options = {
				title: 'Game Guides', // What the title of the app should be in the banner (defaults to <title>)
				author: 'Wikia', // What the author of the app should be in the banner (defaults to <meta name="author"> or hostname)
				price: 'FREE', // Price of the app
				appStoreLanguage: 'us', // Language code for App Store
				inAppStore: 'On the App Store', // Text of price for iOS
				inGooglePlay: 'In Google Play', // Text of price for Android
				icon: null, // The URL of the icon (defaults to <meta name="apple-touch-icon">)
				iconGloss: null, // Force gloss effect for iOS even for precomposed
				button: 'VIEW', // Text for the install button
				url: null, // The URL for the button. Keep null if you want the button to link to the app store.
				scale: 'auto', // Scale based on viewport size (set to 1 to disable)
				speedIn: 300, // Show animation speed of the banner
				speedOut: 400, // Close animation speed of the banner
				daysHidden: 15, // Duration to hide the banner after being closed (0 = always show banner)
				daysReminder: 90, // Duration to hide the banner after "VIEW" is clicked *separate from when the close button is clicked* (0 = always show banner)
				force: null // Choose 'ios' or 'android'. Don't do a browser check, just always show this banner
			},
			standalone = navigator.standalone, // Check if it's already a standalone web app or running within a webui view of an app (not mobile safari)
			type,
			scale,
			appId,
			title,
			author;

		// Detect banner type (iOS or Android)
		if (options.force) {
			type = options.force
		} else if (navigator.userAgent.match(/iPad|iPhone|iPod/i) != null) {
			if (navigator.userAgent.match(/Safari/i) != null &&
				(navigator.userAgent.match(/CriOS/i) != null ||
					window.Number(navigator.userAgent.substr(navigator.userAgent.indexOf('OS ') + 3, 3).replace('_', '.')) < 6)) type = 'ios' // Check webview and native smart banner support (iOS 6+)
		} else if (navigator.userAgent.match(/Android/i) != null) {
			type = 'android'
		}

		// Don't show banner if device isn't iOS or Android, website is loaded in app or user dismissed banner
		//if (!type || standalone || cookie.get('sb-closed') || cookie.get('sb-installed')) {
		//	return
		//}

		// Calculate scale
		scale = options.scale == 'auto' ? window.document.body.offsetWidth / window.screen.width : options.scale
		if (scale < 1) scale = 1

		// Get info from meta data
		var meta = document.querySelectorAll(type == 'android' ? 'meta[name="google-play-app"]' : 'meta[name="apple-itunes-app"]')
		if (meta.length == 0) return

		appId = /app-id=([^\s,]+)/.exec(meta[0].getAttribute('content'))[1]
		title = options.title ? options.title : document.querySelector('title').textContent.replace(/\s*[|\-?].*$/, '')
		author = options.author ? options.author : (document.querySelectorAll('meta[name="author"]').length ? document.querySelector('meta[name="author"]').getAttribute('content') : window.location.hostname)

		var create = function() {
			var iconURL,
				link = (options.url ? options.url : (type == 'android' ? 'market://details?id=' : ('https://itunes.apple.com/' + options.appStoreLanguage + '/app/id')) + appId),
				inStore = options.price ? options.price + ' - ' + (type=='android' ? options.inGooglePlay : options.inAppStore) : '',
				gloss = options.iconGloss === null ? (type=='ios') : options.iconGloss;

			document.body.insertAdjacentHTML('afterbegin', '<div id="smartbanner" class="'+type+'"><div class="sb-container"><a href="#" class="sb-close">&times;</a><span class="sb-icon"></span><div class="sb-info"><strong>'+title+'</strong><span>'+author+'</span><span>'+inStore+'</span></div><a href="'+link+'" class="sb-button"><span>'+options.button+'</span></a></div></div>');

			if (options.icon) {
				iconURL = options.icon
			} else if (document.querySelectorAll('link[rel="apple-touch-icon-precomposed"]').length > 0) {
				iconURL = document.querySelector('link[rel="apple-touch-icon-precomposed"]').getAttribute('href')
				if (options.iconGloss === null) gloss = false
			} else if (document.querySelectorAll('link[rel="apple-touch-icon"]').length > 0) {
				iconURL = document.querySelector('link[rel="apple-touch-icon"]').getAttribute('href')
			}
			if (iconURL) {
				document.querySelector('#smartbanner .sb-icon').style.backgroundImage = 'url('+iconURL+')';
				if (gloss) document.querySelector('#smartbanner .sb-icon').className += 'gloss'
			} else{
				document.querySelector('#smartbanner').className += 'no-icon'
			}

		},
		hide = function(callback) {
			document.documentElement.style.top = 0;
		},
		close = function(e) {
			e.preventDefault();
			hide();
			cookie.set('sb-closed', 1, options.daysHidden);
		},
		install = function() {
			hide();
			cookie.set('sb-installed', 1, options.daysReminder);
		};

		create();

		document.documentElement.style.top = '80px';
		document.querySelector('#smartbanner .sb-close').addEventListener('click', close);
		document.querySelector('#smartbanner .sb-button').addEventListener('click', install);
	});
});
