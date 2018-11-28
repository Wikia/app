/*global define, require*/
define('wikia.articleVideo.featuredVideo.adsConfiguration', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.slot.service.srcProvider',
	'ext.wikia.adEngine.video.articleVideoAd',
	'ext.wikia.adEngine.video.player.jwplayer.adsTracker',
	'ext.wikia.adEngine.video.vastDebugger',
	'ext.wikia.adEngine.video.vastParser',
	'wikia.articleVideo.featuredVideo.lagger',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.wrappers.prebid'),
	require.optional('ext.wikia.adEngine.lookup.bidders'),
	require.optional('ext.wikia.adEngine.lookup.prebid')
], function (
	adContext,
	page,
	vastUrlBuilder,
	megaAdUnitBuilder,
	slotRegistry,
	srcProvider,
	articleVideoAd,
	adsTracker,
	vastDebugger,
	vastParser,
	fvLagger,
	log,
	win,
	prebidWrapper,
	bidders,
	prebid
) {
	'use strict';

	var moatJwplayerPluginUrl = 'https://z.moatads.com/jwplayerplugin0938452/moatplugin.js',
		moatPartnerCode = 'wikiajwint101173217941';

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
		if (prebid && prebid.getSlotParams && adContext.get('bidders.prebid')) {
			return prebid.getSlotParams(featuredVideoSlotName);
		}

		return {};
	}

	function loadMoatTrackingPlugin() {
		if (!win.moatjw) {
			var scriptElement = win.document.createElement('script');
			scriptElement.async = true;
			scriptElement.src = moatJwplayerPluginUrl;
			win.document.head.appendChild(scriptElement);
		}
	}

	function init(player, bidParams, slotTargeting) {
		var correlator,
			featuredVideoElement = player && player.getContainer && player.getContainer(),
			featuredVideoContainer = featuredVideoElement && featuredVideoElement.parentNode,
			prerollPositionReached = false,
			bidderEnabled = true,
			playerState = {},
			playlistItem = player.getPlaylist(),
			videoId = playlistItem[player.getPlaylistIndex()].mediaid,
			trackingParams = {
				adProduct: 'featured-video',
				slotName: featuredVideoSlotName,
				videoId: videoId
			},
			videoDepth = 0;

		bidParams = bidParams || {};

		function requestBidder() {
			if (!prebidWrapper) {
				return;
			}

			var bid = bidders && bidders.isEnabled()
				? bidders.getWinningVideoBidBySlotName(featuredVideoSlotName, allowedBidders)
				: prebidWrapper.getWinningVideoBidBySlotName(featuredVideoSlotName, allowedBidders);

			if (bid && bid.vastUrl) {
				trackingParams.adProduct = 'featured-video-preroll';
				bidderEnabled = false;
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

			if (adContext.get('bidders.rubiconInFV') && !adContext.get('bidders.rubiconDfp')) {
				allowedBidders.push('rubicon');
			}

			player.on('beforePlay', function () {
				var currentMedia = player.getPlaylistItem() || {},
					prebidParams = getPrebidParams();

				playerState = {
					autoplay: player.getConfig().autostart,
					muted: player.getMute()
				};

				slotTargeting.v1 = currentMedia.mediaid;

				if (prerollPositionReached) {
					return;
				}
				log('Preroll position reached', log.levels.info, logGroup);

				correlator = Math.round(Math.random() * 10000000000);
				trackingParams.adProduct = 'featured-video';
				trackingParams.videoId = currentMedia.mediaid;
				videoDepth += 1;

				if (prebidParams) {
					Object.keys(prebidParams).forEach(function (key) {
						bidParams[key] = prebidParams[key];
					});
				}

				if (articleVideoAd.shouldPlayPreroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-preroll';
					player.playAd(articleVideoAd.buildVastUrl(
						featuredVideoSlotName,
						'preroll',
						videoDepth,
						correlator,
						slotTargeting,
						playerState,
						bidParams
					));
				}
				prerollPositionReached = true;
			});

			player.on('videoMidPoint', function () {
				log('Midroll position reached', log.levels.info, logGroup);
				if (videoDepth > 0 && articleVideoAd.shouldPlayMidroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-midroll';
					playerState.muted = player.getMute();
					player.playAd(articleVideoAd.buildVastUrl(
						featuredVideoSlotName,
						'midroll',
						videoDepth,
						correlator,
						slotTargeting,
						playerState
					));
				}

			});

			player.on('beforeComplete', function () {
				log('Postroll position reached', log.levels.info, logGroup);
				if (videoDepth > 0 && articleVideoAd.shouldPlayPostroll(videoDepth)) {
					trackingParams.adProduct = 'featured-video-postroll';
					playerState.muted = player.getMute();
					player.playAd(articleVideoAd.buildVastUrl(
						featuredVideoSlotName,
						'postroll',
						videoDepth,
						correlator,
						slotTargeting,
						playerState
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
				// https://support.jwplayer.com/customer/portal/articles/2924017
				// According to JWPlayer docs IMA events have pattern 2xxxx
				// Example:
				// IMA Error Code = 1009 (empty vast)
				// JW Error Code = 21009
				var emptyImaVastErrorCode = 20000 + win.google.ima.AdError.ErrorCode.VAST_EMPTY_RESPONSE;

				fvLagger.markAsReady(null);
				vastDebugger.setVastAttributes(featuredVideoContainer, event.tag, 'error', event.ima && event.ima.ad);

				if (bidderEnabled && event.adErrorCode === emptyImaVastErrorCode) {
					requestBidder();
				}
				bidderEnabled = false;
			});

			if (adContext.get('opts.isMoatTrackingForFeaturedVideoEnabled')) {
				player.on('adImpression', function (event) {
					var payload = {
						adImpressionEvent: event,
						partnerCode: moatPartnerCode,
						player: this
					};

					if (adContext.get('opts.isMoatTrackingForFeaturedVideoAdditionalParamsEnabled')) {
						log('Passing additional params to Moat FV tracking', log.levels.info, logGroup);
						var rv = articleVideoAd.calculateRV(videoDepth);
						var params = page.getPageLevelParams();
						payload.ids = {
							zMoatRV: rv <= 10 ? rv.toString() : '10+',
							zMoatS1: params.s1
						};
					}

					log(['Adding payload to MOAT plugin', payload], log.levels.debug, logGroup);
					win.moatjw.add(payload);
				});
			}
		} else {
			trackingParams.adProduct = 'featured-video-no-ad';
			fvLagger.markAsReady(null);
		}

		adsTracker.register(player, trackingParams);
	}

	function trackSetup(mediaId, willAutoplay, willMute) {
		adsTracker.track({
			adProduct: 'featured-video',
			slotName: featuredVideoSlotName,
			src: srcProvider.get(baseSrc, {testSrc: 'test'}, 'JWPLAYER'),
			videoId: mediaId,
			withAudio: !willMute,
			withCtp: !willAutoplay
		}, 'setup');
	}

	return {
		init: init,
		trackSetup: trackSetup,
		loadMoatTrackingPlugin: loadMoatTrackingPlugin
	};
});

// We need to keep it in order to be compatible with ads function on mobile-wiki
// TODO: Remove once we switch globally to AE3 on mobile-wiki
define('wikia.articleVideo.featuredVideo.ads', [
	'wikia.articleVideo.featuredVideo.adsConfiguration'
], function (ads) {
	'use strict';
	return {
		init: ads.init,
		loadMoatTrackingPlugin: ads.loadMoatTrackingPlugin
	};
});
