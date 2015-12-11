/*global define*/
define('ext.wikia.adEngine.lookup.dfpSniffer', [
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (params, doc, log, win) {
	'use strict';
	var isCampaignEnabled = false,
		logGroup = 'ext.wikia.adEngine.lookup.dfpSniffer',
		pubAds,
		slotName = 'CAMPAIGN';

	function hasCampaign() {
		return isCampaignEnabled;
	}

	function renderEnded(ad) {
		var slotDiv;
		if (!ad.isEmpty && ad.slot && ad.slot.getSlotElementId() === slotName) {
			isCampaignEnabled = !ad.isEmpty && win.campaign && win.campaign.enabled;
			slotDiv = doc.getElementById(slotName);
			slotDiv.setAttribute('data-gpt-line-item-id', ad.lineItemId || 'null');
			slotDiv.setAttribute('data-gpt-creative-id', ad.creativeId || 'null');
			if (hasCampaign()) {
				log('DFP campaign detected', 'info', logGroup);
			}
		}
	}

	function enableServices() {
		win.googletag.cmd.push(function () {
			pubAds = win.googletag.pubads();

			pubAds.collapseEmptyDivs();
			pubAds.enableSingleRequest();
			pubAds.disableInitialLoad();
			pubAds.addEventListener('slotRenderEnded', renderEnded);

			win.googletag.enableServices();
		});
	}

	function loadGpt() {
		win.googletag = win.googletag || {};
		win.googletag.cmd = win.googletag.cmd || [];

		var gads = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		gads.async = true;
		gads.type = 'text/javascript';
		gads.src = '//www.googletagservices.com/tag/js/gpt.js';

		node.parentNode.insertBefore(gads, node);
		enableServices();
	}

	function defineSlot() {
		var adUnitId = [
			'/5441',
			'wka.' + params.getSite(),
			params.getMappedVertical(),
			'',
			params.getPageType(),
			'gpt',
			slotName
		].join('/');

		win.googletag.cmd.push(function () {
			var slot = win.googletag.defineOutOfPageSlot(adUnitId, slotName);

			slot.addService(pubAds);
			slot.setTargeting('s1', '_adtest');
			slot.setTargeting('artid', '2135');
			slot.setTargeting('src', 'sniffer');
			win.googletag.display(slotName);
			pubAds.refresh([slot]);
			log('Sniffing for campaign', 'debug', logGroup);
		});
	}

	function init() {
		log('Init', 'debug', logGroup);
		loadGpt();
		defineSlot();
	}

	return {
		init: init,
		hasCampaign: hasCampaign
	};
});
