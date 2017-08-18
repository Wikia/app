// !function(a9,a,p,s,t,A,g){if(a[a9])return;function q(c,r){a[a9]._Q.push([c,r])}a[a9]={init:function(){q("i",arguments)},fetchBids:function(){q("f",arguments)},setDisplayBids:function(){},_Q:[]};A=p.createElement(s);A.async=!0;A.src=t;g=p.getElementsByTagName(s)[0];g.parentNode.insertBefore(A,g)}("apstag",window,document,"script","//c.amazon-adsystem.com/aax2/apstag.js");
// apstag.init({
// 	pubID: 'xxxx',
// 	adServer: 'googletag'
// });
// apstag.fetchBids({
// 	slots: [{
// 		slotID: 'div-gpt-ad-1475102693815-0',
// 		sizes: [[300, 250], [300, 600]]
// 	},
// 		{
// 			slotID: 'div-gpt-ad-1475185990716-0',
// 			sizes: [[728 ,90]]
// 		}],
// 	timeout: 2e3
// }, function(bids) {
// 	// Your callback method, in this example it triggers the first DFP request for googletag's disableInitialLoad integration after bids have been set
// 	googletag.cmd.push(function(){
// 		apstag.setDisplayBids();
// 		googletag.pubads().refresh();
// 	});
// });


/*global define*/
define('ext.wikia.adEngine.lookup.a9', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, slotsContext, factory, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.a9',
		config = {
			oasis: {
				BOTTOM_LEADERBOARD: ['728x90', '970x250'],
				INCONTENT_BOXAD_1: ['300x250', '300x600'],
				TOP_LEADERBOARD: ['728x90', '970x250'],
				TOP_RIGHT_BOXAD: ['300x250', '300x600']
			},
			mercury: {
				MOBILE_IN_CONTENT: ['300x250', '320x480'],
				MOBILE_PREFOOTER: ['320x50', '300x250'],
				MOBILE_TOP_LEADERBOARD: ['320x50']
			}
		},
		rendered = false,
		amazonId = '3115',
		slots = [];

	function call(skin, onResponse) {
		var a9Script = doc.createElement('script'),
			context = adContext.getContext(),
			node = doc.getElementsByTagName('script')[0];

		slots = slotsContext.filterSlotMap(config[skin]);

		a9Script.type = 'text/javascript';
		a9Script.async = true;
		a9Script.src = '//c.amazon-adsystem.com/aax2/apstag.js';
		// a9Script.addEventListener('load', function () {
		// 	var renderAd = win.amznads.renderAd;
		// 	if (!win.amznads.getAdsCallback || !renderAd) {
		// 		return;
		// 	}
		// 	win.amznads.getAdsCallback(amazonId, onResponse);
		// 	win.amznads.renderAd = function (doc, adId) {
		// 		renderAd(doc, adId);
		// 		rendered = true;
		// 	};
		// });

		node.parentNode.insertBefore(a9Script, node);
	}

	function calculatePrices() {
	}

	function encodeParamsForTracking(params) {
	}

	function getSlotParams(slotName) {
	}

	function getPrices() {
	}

	function isSlotSupported(slotName) {
		return slots[slotName];
	}

	return factory.create({
		logGroup: logGroup,
		name: 'a9',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
