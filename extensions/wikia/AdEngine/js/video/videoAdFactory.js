/* global define */
define('ext.wikia.adEngine.video.videoAdFactory', [
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.video.googleIma',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.log'
], function (DOMElementTweaker, googleIma, vastUrlBuilder, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.videoAdFactory';

	function init() {
		return googleIma.init();
	}

	function create(width, height, adSlot, slotParams) {
		var vastUrl = vastUrlBuilder.build(width / height, slotParams);
		log(['VAST URL: ', vastUrl], log.levels.info, logGroup);

		return {
			addEventListener: function (name, callback) {
				if (this.events[name]) {
					this.events[name].push(callback);
				} else {
					throw new Error('Event name ' + name + '  not supported');
				}
			},
			events: {
				onStart: [],
				onFinished: []
			},
			adSlot: adSlot,
			width: width,
			height: height,
			ima: googleIma.setupIma(vastUrl, adSlot, width, height),
			play: function () {
				var self = this;

				this.events.onFinished.push(function () {
					self.ima = googleIma.setupIma(vastUrl, adSlot, self.width, self.height);
				});

				this.ima.playVideo(this.width, this.height, this.events);
			},
			resize: function (width, height) {
				this.width = width;
				this.height = height;
				this.ima.resize(width, height);
			}
		};
	}

	return {
		create: create,
		init: init
	};
});
