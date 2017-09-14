/*global define*/
define('ext.wikia.adEngine.video.player.playwire.playwirePlayerFactory', [], function () {
	'use strict';

	function create(api, playerId, params) {
		return {
			api: api,
			id: playerId,
			container: params.container,
			addEventListener: function (eventName, callback) {
				this.api.on(this.id, eventName, callback);
			},
			play: function (width, height) {
				this.api.dispatchEvent(this.id, 'wikiaAdPlayTriggered');
				this.resize(width, height);
				this.api.playMedia(this.id);
				this.api.dispatchEvent(this.id, 'wikiaAdStarted');
			},
			stop: function () {
				this.api.dispatchEvent(this.id, 'wikiaAdStop');
				this.api.stopMedia(this.id);
				this.api.dispatchEvent(this.id, 'wikiaAdCompleted');
			},
			resize: function (width, height) {
				this.api.resizeVideo(this.id, width + 'px', height + 'px');
			}
		};
	}

	return {
		create: create
	};
});
