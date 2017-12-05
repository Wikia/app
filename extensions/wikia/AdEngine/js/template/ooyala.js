/*global define*/
define('ext.wikia.adEngine.template.ooyala', [
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.log',
	'wikia.videoBootstrap'
], function (vastUrlBuilder, log, VideoBootstrap) {
	'use strict';
	var libraryUrl = 'https://player.ooyala.com/v3/52bc289bedc847e3aa8eb2b347644f68?platform=html5-priority',
		logGroup = 'ext.wikia.adEngine.template.ooyala';

	function show(params) {
		var aspectRatio = params.width / params.height,
			playerId = 'ooyala_' + Math.floor((1 + Math.random()) * 0x10000),
			vastTargeting = {
				passback: 'ooyala',
				pos: params.slotName,
				src: params.src
			},
			vb;

		vb = new VideoBootstrap(params.container, {
			html: '<div id="' + playerId + '" style="width: 100%; height: 100%;"></div>',
			width: params.width,
			height: params.height,
			jsParams: {
				playerId: playerId,
				videoId: params.videoId,
				autoPlay: params.autoPlay || true,
				tagUrl: params.vastUrl || vastUrlBuilder.build(aspectRatio, vastTargeting),
				jsFile: [
					libraryUrl,
					'extensions/wikia/VideoHandlers/js/handlers/lib/OoyalaAgeGate.js'
				],
				onCreate: params.onReady
			},
			init: 'wikia.videohandler.ooyala',
			scripts: [
				'extensions/wikia/VideoHandlers/js/handlers/Ooyala.js'
			]
		});

		log(['show', vb, params], 'debug', logGroup);
	}

	return {
		show: show
	};
});
