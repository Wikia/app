define('wikia.articleVideo.featuredVideo.ads', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.slot.service.srcProvider',
	'ext.wikia.adEngine.video.articleVideoAd',
	'ext.wikia.adEngine.video.player.jwplayer.adsTracking',
	'ext.wikia.adEngine.video.vastDebugger',
	'ext.wikia.adEngine.video.vastParser',
	'wikia.articleVideo.featuredVideo.lagger',
	'wikia.log',
	require.optional('ext.wikia.adEngine.wrappers.prebid'),
], function (
	adContext,
	vastUrlBuilder,
	megaAdUnitBuilder,
	slotRegistry,
	srcProvider,
	articleVideoAd,
	adsTracking,
	vastDebugger,
	vastParser,
	fvLagger,
	log,
	prebid
) {
	'use strict';

	var allowedBidders = ['wikiaVideo'],
		baseSrc = adContext.get('targeting.skin') === 'oasis' ? 'gpt' : 'mobile',
		featuredVideoSlotName = 'FEATURED',
		featuredVideoSource,
		logGroup = 'wikia.articleVideo.featuredVideo.ads';

	function parseVastParamsFromEvent(event) {
		return vastParser.parse(event.tag, {
			imaAd: event.ima && event.ima.ad
		});
	}

	function getPrebidParams() {
		if (prebid) {
			return prebid.get().getAdserverTargetingForAdUnitCode(featuredVideoSlotName);
		}

		return {};
	}

	return function (player, bidParams, slotTargeting) {
		var correlator,
			featuredVideoElement = player && player.getContainer && player.getContainer(),
			featuredVideoContainer = featuredVideoElement && featuredVideoElement.parentNode,
			prerollPositionReached = false,
			bidderEnabled = true,
			trackingParams = {
				adProduct: 'featured-video',
				slotName: featuredVideoSlotName
			},
			videoDepth = 0;

		bidParams = bidParams || {};

		function requestBidder() {
			if (!prebid) {
				return;
			}

			var bid = prebid.getWinningVideoBidBySlotName(featuredVideoSlotName, allowedBidders);

			if (bid && bid.vastUrl) {
				trackingParams.adProduct = 'featured-video-preroll';
				player.playAd(bid.vastUrl);
			}
		}

		slotTargeting = slotTargeting || {};
		featuredVideoSource = srcProvider.get(baseSrc, {testSrc: 'test'}, 'JWPLAYER');
		trackingParams.src = featuredVideoSource;

		if (adContext.get('opts.showAds')) {
			player.on('adBlock', function () {
				trackingParams.adProduct = 'featured-video';
			});

			if (adContext.get('bidders.rubiconInFV')) {
				allowedBidders.push('rubicon')
			}

			player.on('beforePlay', function () {
				var currentMedia = player.getPlaylistItem() || {};

				slotTargeting.v1 = currentMedia.mediaid;

				if (prerollPositionReached) {
					return;
				}
				log('Preroll position reached', log.levels.info, logGroup);

				correlator = Math.round(Math.random() * 10000000000);
				trackingParams.adProduct = 'featured-video';
				videoDepth += 1;

				var prebidParams = getPrebidParams();
				Object.keys(prebidParams).forEach(function (key) {
					bidParams[key] = prebidParams[key];
				});

				if (articleVideoAd.shouldPlayPreroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-preroll';
					player.playAd(articleVideoAd.buildVastUrl(
						featuredVideoSlotName,
						'preroll',
						videoDepth,
						correlator,
						slotTargeting,
						player.getMute(),
						bidParams
					));
				}
				prerollPositionReached = true;
			});

			player.on('videoMidPoint', function () {
				log('Midroll position reached', log.levels.info, logGroup);
				if (articleVideoAd.shouldPlayMidroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-midroll';
					player.playAd(articleVideoAd.buildVastUrl(
						featuredVideoSlotName,
						'midroll',
						videoDepth,
						correlator,
						slotTargeting,
						player.getMute()
					));
				}

			});

			player.on('beforeComplete', function () {
				log('Postroll position reached', log.levels.info, logGroup);
				if (articleVideoAd.shouldPlayPostroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-postroll';
					player.playAd(articleVideoAd.buildVastUrl(
						featuredVideoSlotName,
						'postroll',
						videoDepth,
						correlator,
						slotTargeting,
						player.getMute()
					));
				}
			});

			player.on('complete', function () {
				prerollPositionReached = false;
			});

			player.on('adRequest', function (event) {
				var vastParams = parseVastParamsFromEvent(event);
				slotRegistry.storeScrollY(featuredVideoSlotName);

				bidderEnabled = false;
				vastDebugger.setVastAttributesFromVastParams(featuredVideoContainer, 'success', vastParams);

				fvLagger.markAsReady(vastParams.lineItemId);
			});

			player.on('adError', function (event) {
				fvLagger.markAsReady(null);
				vastDebugger.setVastAttributes(featuredVideoContainer, event.tag, 'error', event.ima && event.ima.ad);

				if (bidderEnabled) {
					requestBidder();
				}
				bidderEnabled = false;
			});
		} else {
			trackingParams.adProduct = 'featured-video-no-ad';
			fvLagger.markAsReady(null);
		}

		adsTracking(player, trackingParams);
	};
});
