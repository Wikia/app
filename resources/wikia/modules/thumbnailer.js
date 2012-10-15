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
		//targets the image file extension
		var extRegExp = new RegExp('\\.(jpg|jpeg|gif|bmp|png|svg)$', 'i'),
			imagePath = '/images/',
			thumbPath = '/images/thumb/';

		/**
		 * @public
		 *
		 * Checks if a URL points to a thumbnail
		 *
		 * @param {String} url The URL of an image or thumbnail
		 *
		 * @return {Boolean} true if it's a thumbnail or false if it's an image
		 */
		function isThumbUrl(url) {
			return url && url.indexOf('/thumb/') > 0;
		}

		/**
		 * @private
		 *
		 * Removes the thumbnail options part from a thumbnail URL
		 *
		 * @param {String} url The URL of a thumbnail
		 *
		 * @return {String} the URL without the thymbnail options
		 */
		function clearThumbOptions(url) {
			//The URL of a thumbnail is in the following format:
			//http://domain/image_path/image.ext/thumbnail_options.ext
			//so return the URL till the last / to remove the options
			return url.substring(0, url.lastIndexOf('/'));
		}

		/**
		 * @private
		 *
		 * Switches a thumb path into an image path and vice versa inside an URL
		 *
		 * @param {String} url The URL of an image or thumbnail
		 * @param {String} type Either 'image' or 'thumb'
		 *
		 * @return {String} the URL with the switched path
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
			return url;
		}

		return {
			isThumbUrl: isThumbUrl,

			/**
			 * @public
			 *
			 * Converts the URL of a full size image or of a thumbnail into one of a thumbnail of
			 * the specified size and returns it
			 *
			 * @param {String} url The URL to the full size image or a thumbnail
			 * @param {String} type The type, either 'image' (default, the result will be cropped)
			 * or 'video' (the result will be squeezed)
			 * @param {Integer} width The width of the thumbnail to fetch
			 * @param {Integer} height The height of the thumbnail to fetch
			 */
			getThumbURL: function getThumbURL(url, type, width, height) {
				url = url || '';
				height = height || 0;
				width = (width || 50) + (height ? '' : 'px');


				if (isThumbUrl(url)) {
					// URL points to a thumbnail, remove crop and size
					url = clearThumbOptions(url);
				} else {
					// URL points to an image, convert to thumbnail URL
					url = switchPathTo(url, 'thumb');
				}

				//add parameters to the URL
				var tokens = url.split('/'),
					last = tokens.slice(-1)[0].replace(extRegExp, '');

				tokens.push(width + (height ? 'x' + height : '-') + ((type == 'video' || type == 'nocrop') ? '-' :  'x2-') + last + '.png');
				return tokens.join('/');
			},

			/**
			 * @public
			 *
			 * Converts the URL of a thumbnail into one of a full size image
			 *
			 * @param {String} url The URL to a thumbnail
			 */
			getImageURL: function getImageURL(url) {
				if (isThumbUrl(url)) {
					// URL points to a thumbnail
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