define('ooyalaVideo', ['jquery', 'wikia.window', 'wikia.loader', 'wikia.log'], function ($, window, loader, log) {

	function OoyalaVideo(elementId, ooyalaJsFile, ooyalaVideoId, ooyalaPlayerOptions) {
		var _this = this;

		this.$playerElement = $('#' + elementId);

		if(typeof ooyalaPlayerOptions === 'undefined') {
			ooyalaPlayerOptions = {
				autoplay: true,
				width: '100%',
				height: '100%'
			};
		}

		loadJs(ooyalaJsFile).done(function () {
			window.OO.ready(function () {
				_this.player = window.OO.Player.create(elementId, ooyalaVideoId, ooyalaPlayerOptions);
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


	function loadJs(resource) {
		return loader({
			type: loader.JS,
			resources: resource
		}).fail(loadFail);
	}

	function loadFail(data) {
		var message = data.error + ':';

		$.each(data.resources, function () {
			message += ' ' + this;
		});

		log(message, log.levels.error, 'asd');
	}

	return OoyalaVideo;

});