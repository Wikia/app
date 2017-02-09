define('ooyalaVideo', ['jquery', 'wikia.window', 'wikia.loader'], function ($, window, loader) {

	function OoyalaVideo(elementId, ooyalaJsFile, ooyalaVideoId, ooyalaPlayerOptions) {
		var self = this;

		this.$playerElement = $('#' + elementId);

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
			});
		});
	}

	OoyalaVideo.prototype.miniControls = function () {
		this.getControlsElement().addClass('oo_mini_controls').removeClass('oo_full_controls');
	};

	OoyalaVideo.prototype.fullControls = function () {
		this.getControlsElement().removeClass('oo_mini_controls').addClass('oo_full_controls');
	};

	OoyalaVideo.prototype.getControlsElement = function () {
		if (!this.$controlsElement) {
			this.$controlsElement = this.$playerElement.find('.oo_controls');
		}
		return this.$controlsElement;
	};

	return OoyalaVideo;

});