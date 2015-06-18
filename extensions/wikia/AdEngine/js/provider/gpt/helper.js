/*global define,setTimeout*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.helper', [
	'wikia.log',
	'ext.wikia.adEngine.provider.gpt.adDetect',
	'ext.wikia.adEngine.provider.gpt.adElement',
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'ext.wikia.adEngine.slotTweaker',
	require.optional('ext.wikia.adEngine.provider.gpt.sraHelper')
], function (log, adDetect, AdElement, googleTag, slotTweaker, sraHelper) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.helper';

	/**
	 * Push ad to queue and flush if it should be
	 *
	 * @param {string}   slotName           - slot name
	 * @param {Object}   slotElement        - slot div container
	 * @param {string}   slotPath           - slot path
	 * @param {Object}   slotTargeting      - slot targeting details
	 * @param {Object}   extra              - optional parameters
	 * @param {function} extra.success      - on success callback
	 * @param {function} extra.error        - on error callback
	 * @param {boolean}  extra.sraEnabled   - whether to use Single Request Architecture
	 * @param {string}   extra.forcedAdType - ad type for callbacks info
	 */
	function pushAd(slotName, slotElement, slotPath, slotTargeting, extra) {
		var element = new AdElement('wikia_gpt_helper' + slotPath);

		extra = extra || {};
		slotTargeting = JSON.parse(JSON.stringify(slotTargeting)); // copy value

		function callSuccess(adInfo) {
			if (typeof extra.success === 'function') {
				extra.success(adInfo);
			}
		}

		function callError(adInfo) {
			slotTweaker.hide(element.getId());
			if (typeof extra.error === 'function') {
				adInfo = adInfo || {};
				adInfo.method = 'hop';
				extra.error(adInfo);
			}
		}

		function queueAd() {
			log(['queueAd', slotName, slotElement, element], 'debug', logGroup);
			slotElement.appendChild(element.getNode());

			googleTag.addSlot(slotName, slotPath, slotTargeting, element);
		}

		function gptCallback(gptEvent) {
			log(['gptCallback', element.getId(), gptEvent], 'info', logGroup);
			element.updateDataParams(gptEvent);

			var iframe = element.getNode().querySelector('div[id*="_container_"] iframe');

			// IE doesn't allow us to inspect GPT iframe at this point.
			// Let's launch our callback in a setTimeout instead.
			setTimeout(function () {
				adDetect.onAdLoad(element.getId(), gptEvent, iframe, callSuccess, callError, extra.forcedAdType);
			}, 0);
		}

		if (!googleTag.isInitialized()) {
			googleTag.init();
		}

		log(['pushAd', slotName], 'info', logGroup);
		if (!slotTargeting.flushOnly) {
			googleTag.registerCallback(element.getId(), gptCallback);
			googleTag.push(queueAd);
		}

		if (!extra.sraEnabled || sraHelper.shouldFlush(slotName)) {
			googleTag.flush();
		}
	}

	return {
		pushAd: pushAd
	};
});
