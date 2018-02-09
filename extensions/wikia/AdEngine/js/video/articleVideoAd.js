/*global define*/
define('ext.wikia.adEngine.video.articleVideoAd', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.srcProvider',
	'ext.wikia.adEngine.video.player.jwplayer.adsTracking',
	'ext.wikia.adEngine.video.vastDebugger',
	'wikia.log'
], function (adContext, slotsContext, vastUrlBuilder, megaAdUnitBuilder, srcProvider, adsTracking, vastDebugger, log) {
	'use strict';

	var aspectRatio = 640 / 480,
		baseSrc = adContext.get('targeting.skin') === 'oasis' ? 'gpt' : 'mobile',
		featuredVideoPassback = 'jwplayer',
		featuredVideoSlotName = 'FEATURED',
		logGroup = 'ext.wikia.adEngine.video.articleVideoAd';

	function calculateRV(depth) {
		var capping = adContext.get('opts.fvAdsFrequency');

		return (depth < 2 || !capping) ? 1 : (Math.floor((depth - 1) / capping) + 1);
	}

	function buildVastUrl(slotName, position, videoDepth, correlator, slotTargeting, bidParams) {
		var options = {
				correlator: correlator,
				vpos: position
			},
			slotParams = Object.assign({
				passback: featuredVideoPassback,
				pos: slotName,
				rv: calculateRV(videoDepth),
				src: srcProvider.get(baseSrc, {testSrc: 'test'})
			}, slotTargeting);

		if (videoDepth === 1 && bidParams) {
			Object.keys(bidParams).forEach(function (key) {
				slotParams[key] = bidParams[key];
			});
		}
		options.adUnit = megaAdUnitBuilder.build(slotParams.pos, slotParams.src);

		log(['buildVastUrl', position, videoDepth, slotParams, options], log.levels.debug, logGroup);

		return vastUrlBuilder.build(aspectRatio, slotParams, options);
	}

	function shouldPlayAdOnNextVideo(depth) {
		var capping = adContext.get('opts.fvAdsFrequency');

		return adContext.get('opts.replayAdsForFV') && capping > 0 && (depth - 1) % capping === 0;
	}

	function canAdBePlayed(depth) {
		var isReplay = depth > 1,
			adCanBePlayed = !isReplay || (isReplay && shouldPlayAdOnNextVideo(depth)),
			slotIsEnabled = slotsContext.isApplicable(featuredVideoSlotName);

		return slotIsEnabled && adCanBePlayed;
	}

	function shouldPlayPreroll(videoDepth) {
		return canAdBePlayed(videoDepth);
	}

	function shouldPlayMidroll(videoDepth) {
		return adContext.get('opts.isFVMidrollEnabled') && canAdBePlayed(videoDepth);
	}

	function shouldPlayPostroll(videoDepth) {
		return adContext.get('opts.isFVPostrollEnabled') && canAdBePlayed(videoDepth);
	}

	return {
		buildVastUrl: buildVastUrl,
		shouldPlayPreroll: shouldPlayPreroll,
		shouldPlayMidroll: shouldPlayMidroll,
		shouldPlayPostroll: shouldPlayPostroll
	};
});
