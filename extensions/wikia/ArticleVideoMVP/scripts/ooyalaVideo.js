define('ooyalaVideo', ['jquery', 'wikia.window', 'wikia.loader'], function ($, window, loader) {

	function OoyalaVideo(elementId, ooyalaJsFile, ooyalaVideoId, ooyalaPlayerOptions) {
		var self = this;

		if (typeof ooyalaPlayerOptions === 'undefined') {
			ooyalaPlayerOptions = {
				autoplay: true,
				width: '100%',
				height: '100%'
			};
		}

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
		this.player.mb.publish(OO.EVENTS.SIZE_CHANGED);
	};

	OoyalaVideo.prototype.hideControls = function () {
		this.$controls.hide();
	};

	OoyalaVideo.prototype.showControls = function () {
		this.$controls.show();
	};

	return OoyalaVideo;

});
