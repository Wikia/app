/**
 * The following attempts to determine whether the browser has native overflow support
 * so we can enable it but not polyfill
 *
 * @see http://filamentgroup.github.com/Overthrow/
 */

Features.addTest('overflow', function(){
	// Features-first. iOS5 overflow scrolling property check - no UA needed here. thanks Apple :)
	return "WebkitOverflowScrolling" in document.documentElement.style ||
	// Touch events aren't supported and screen width is greater than X
	// ...basically, this is a loose "desktop browser" check.
	// It may wrongly opt-in very large tablets with no touch support.
	( !("ontouchmove" in document) && window.screen.width > 1200 ) ||
	// Hang on to your hats.
	// Whitelist some popular, overflow-supporting mobile browsers for now and the future
	// These browsers are known to get overlow support right, but give us no way of detecting it.
	(function(){
		var ua = window.navigator.userAgent,
			// Webkit crosses platforms, and the browsers on our list run at least version 534
			webkit = ua.match( /AppleWebKit\/([0-9]+)/ ),
			wkversion = webkit && webkit[1],
			wkLte534 = webkit && wkversion >= 534;

		return (
			/* Android 3+ with webkit gte 534
			 ~: Mozilla/5.0 (Linux; U; Android 3.0; en-us; Xoom Build/HRI39) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13 */
			(ua.match( /Android ([0-9]+)/ ) && RegExp.$1 >= 3 && wkLte534) ||
			/* Blackberry 7+ with webkit gte 534
			 ~: Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en-US) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0 Mobile Safari/534.11+ */
			(ua.match( / Version\/([0-9]+)/ ) && RegExp.$1 >= 0 && window.blackberry && wkLte534) ||
			/* Blackberry Playbook with webkit gte 534
			 ~: Mozilla/5.0 (PlayBook; U; RIM Tablet OS 1.0.0; en-US) AppleWebKit/534.8+ (KHTML, like Gecko) Version/0.0.1 Safari/534.8+ */
			(ua.indexOf( /PlayBook/ ) > -1 && RegExp.$1 >= 0 && wkLte534) ||
			/* Firefox Mobile (Fennec) 4 and up
			 ~: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:2.1.1) Gecko/ Firefox/4.0.2pre Fennec/4.0. */
			(ua.match( /Fennec\/([0-9]+)/ ) && RegExp.$1 >= 4) ||
			/* WebOS 3 and up (TouchPad too)
			 ~: Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.0; U; en-US) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/233.48 Safari/534.6 TouchPad/1.0 */
			(ua.match( /wOSBrowser\/([0-9]+)/ ) && RegExp.$1 >= 233 && wkLte534) ||
			/* Nokia Browser N8
			 ~: Mozilla/5.0 (Symbian/3; Series60/5.2 NokiaN8-00/012.002; Profile/MIDP-2.1 Configuration/CLDC-1.1 ) AppleWebKit/533.4 (KHTML, like Gecko) NokiaBrowser/7.3.0 Mobile Safari/533.4 3gpp-gba
			 ~: Note: the N9 doesn't have native overflow with one-finger touch. wtf */
			(ua.match( /NokiaBrowser\/([0-9\.]+)/ ) && parseFloat(RegExp.$1) === 7.3 && webkit && wkversion >= 533)
		);
	})();
});