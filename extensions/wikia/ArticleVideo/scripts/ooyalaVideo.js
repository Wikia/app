/*
 * If we want to continue using ooyala player for "premium videos"
 * we should merge this with ooyala handler (Ooyala.js from VideoHandlers dir)
 */
define('ooyalaVideo', ['jquery', 'wikia.window', 'wikia.loader'], function ($, window, loader) {

	function OoyalaVideo(elementId, ooyalaJsFile, ooyalaVideoId, onCreate) {
		var self = this,
			ooyalaPlayerOptions = {
				autoplay: false,
				width: '100%',
				height: '100%',
				onCreate: onCreate
			};

		loader({
			type: loader.JS,
			resources: ooyalaJsFile
		}).done(function () {
			window.OO.ready(function () {
				self.player = window.OO.Player.create(elementId, ooyalaVideoId, ooyalaPlayerOptions);
				self.$controls = $('#' + elementId + ' .oo_controls');
			});
		});
	}

	OoyalaVideo.prototype.sizeChanged = function () {
		if (this.player) {
			this.player.mb.publish(OO.EVENTS.SIZE_CHANGED);
		}
	};

	OoyalaVideo.prototype.hideControls = function () {
		if (this.$controls) {
			this.$controls.hide();
		}
	};

	OoyalaVideo.prototype.showControls = function () {
		if (this.$controls) {
			this.$controls.show();
		}
	};

	return OoyalaVideo;

});
