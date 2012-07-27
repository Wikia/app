/**
 * Helper module to generate the URL to a thumbnail of specific size from JS
 *
 * @author Piotr Bablok <piotrbablok@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * IMPORTANT: this code needs to be kept in sync with Apache rewrites and the thumbnailer servers' code
 */
/*global define*/

(function (context) {
	'use strict';

	function thumbnailer() {
		//targets the resize part of a thumbnail's URL
		var sizeRegExp = new RegExp('\\/[0-9]+px\\-'),
			//targets the crop part of a thumbnai's URL
			cropRegExp = new RegExp('\\/[0-9]+(\\,|%2C)[0-9]+(\\,|%2C)[0-9]+(\\,|%2C)[0-9]+\\-'),
			imagePath = '/images/',
			thumbPath = '/images/thumb/';

		/**
		 * @private
		 */
		function isThumbUrl(url) {
			return url.indexOf('/thumb/') > 0;
		}

		/**
		 * @private
		 */
		function clearThumbOptions(url) {
			return url.replace(sizeRegExp, '/').replace(cropRegExp, '/');
		}

		/**
		 * @private
		 */
		function switchPathTo(url, type) {
			var from,
				to,
				thumb = (type === 'thumb');

			if (thumb) {
				from = imagePath;
				to = thumbPath;
			} else {
				from = thumbPath;
				to = imagePath;
			}

			url = url.replace(from, to);

			if (thumb) {
				url += '/' + url.substr(url.lastIndexOf('/') + 1);
			} else {
				url = url.substr(0, url.lastIndexOf('/'));
			}

			return url;
		}

		return {
			/**
			 * @public
			 *
			 * Converts the URL of a full size image or of a thumbnail into one of a thumbnail of
			 * the specified size
			 *
			 * @param {String} url The URL to the full size image or a thumbnail
			 * @param {String} type The type, either 'image' (default) or 'video'
			 * @param {Integer} width The width of the thumbnail to fetch
			 * @param {Integer} height The height of the thumbnail to fetch
			 */
			getThumbURL: function getThumbURL(url, type, width, height) {
				width = width || 50;
				height = height || 50;

				if (isThumbUrl(url)) {
					// URL points to a thumbnail, remove crop and size
					url = clearThumbOptions(url);
				} else {
					// URL points to an image, convert to thumbnail URL
					url = switchPathTo(url, 'thumb');
				}

				// add parameters to the URL
				var tokens = url.split('/'),
					last = tokens.slice(-1)[0];

				tokens[tokens.length - 1] = width + 'x' + height + ((type === 'video') ? '-' :  'x2-') + last + '.png';
				return tokens.join('/');
			},

			/**
			 * @public
			 *
			 * Converts the URL of a thumbnail into one of a full size image
			 *
			 * @param {String} url The URL to the full size image or a thumbnail
			 */
			getImageURL: function getImageURL(url) {
				if (isThumbUrl(url)) {
					// URL points to a thumbnail, remove crop and size
					url = clearThumbOptions(url);
					url = switchPathTo(url, 'image');
				}

				return url;
			}
		};
	}

	if (typeof define !== 'undefined' && define.amd) {
		//AMD
		define('thumbnailer', thumbnailer);
	} else {
		//Namespace
		if (!context.Wikia) {
			context.Wikia = {};
		}

		context.Wikia.Thumbnailer = thumbnailer();
	}
}(this));