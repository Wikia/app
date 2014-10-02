define('mediaGallery.controllers.lightbox', [], function () {
	'use strict';

	var LightboxController = function (options) {
		this.model = options.model;
	};

	LightboxController.prototype.init = function () {
		$(window).on('ligthboxArticleMedia', $.proxy(this.addMedia, this));
	};

	LightboxController.prototype.addMedia = function (e, lightboxData) {
		$.each(this.model, function () {
			var thumbData = {
				thumbUrl: Wikia.Thumbnailer.getThumbURL(
					decodeURI(this.thumbUrl),
					'image',
					lightboxData.width,
					lightboxData.height
				),
				title: decodeURI(this.title),
				key: decodeURI(this.dbKey),
				type: 'image'
			};

			lightboxData.thumbArr.push(thumbData);
		});
	};

	return LightboxController;
});
