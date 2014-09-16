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
		var extRegExp = /\.(jpg|jpeg|gif|bmp|png|svg)$/i,
			imagePath = '/images/',
			oldThumbnailerPath = '/images/thumb/',
			newThumbnailerBaseURLRegex = /(.*\/revision\/\w+\/).*/;

		/**
		 * Converts the URL of a full size image or of a thumbnail into one of a thumbnail of
		 * the specified size and returns it
		 * @public
		 * @param {String} url The URL to the full size image or a thumbnail
		 * @param {String} type The type, either 'image' (default, the result will be cropped)
		 * or 'video' (the result will be squeezed)
		 * @param {Integer} width The width of the thumbnail to fetch
		 * @param {Integer} height The height of the thumbnail to fetch
		 */
		function getThumbURL(url, type, width, height) {
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

			return addParametersToUrl(url, type, width, height);
		}

		/**
		 * Converts the URL of a thumbnail into one of a full size image
		 * @public
		 * @param {String} url The URL to a thumbnail
		 */
		function getImageURL(url) {
			if (isThumbUrl(url)) {
				// URL points to a thumbnail
				url = clearThumbOptions(url);
				url = switchPathTo(url, 'image');
			}

			return url;
		}

		/**
		 * Checks if a URL points to a thumbnail
		 * @public
		 * @param {String} url The URL of an image or thumbnail
		 * @return {Boolean} True f it's a thumbnail or false if it's an image
		 */
		function isThumbUrl(url) {
			return isOldThumbnailerUrl(url) || isNewThumbnailerUrl(url);
		}

		function isOldThumbnailerUrl(url) {
			return url && url.indexOf('/thumb/') > 0;
		}

		function isNewThumbnailerUrl(url) {
			return url && url.indexOf('vignette') > 0;
		}

		/**
		 * Removes the thumbnail options part from a thumbnail URL
		 * @private
		 * @param {String} url The URL of a thumbnail
		 * @return {String} The URL without the thymbnail options
		 */
		function clearThumbOptions(url) {
			var clearedOptionsUrl;

			if (isNewThumbnailerUrl(url)) {
				clearedOptionsUrl = url.replace(newThumbnailerBaseURLRegex, '$1');
			} else {
				//The URL of a thumbnail is in the following format:
				//http://domain/image_path/image.ext/thumbnail_options.ext
				//so return the URL till the last / to remove the options
				clearedOptionsUrl = url.substring(0, url.lastIndexOf('/'));
			}
			return clearedOptionsUrl;
		}

		/**
		 * Switches a thumb path into an image path and vice versa inside an URL
		 * @private
		 * @param {String} url The URL of an image or thumbnail
		 * @param {String} type Either 'image' or 'thumb'
		 * @return {String} The URL with the switched path
		 */
		function switchPathTo(url, type) {
			var from,
				to,
				thumb = (type === 'thumb');

			if (thumb) {
				from = imagePath;
				to = oldThumbnailerPath;
			} else {
				from = oldThumbnailerPath;
				to = imagePath;
			}

			url = url.replace(from, to);
			return url;
		}

		function addParametersToUrl(url, type, width, height) {
			if (isNewThumbnailerUrl(url)) {
				url = addNewThumbnailerParameters(url, width, height);
			} else {
				url = addOldThumbnailerParameters(url, type, width, height);
			}
			return url;
		}

		// TODO Make sure this is the correct thumbnailer route to hit
		function addNewThumbnailerParameters(url, width, height) {
			return url + "fixed-aspect-ratio/width/" + width + "/height/" + height;
		}

		function addOldThumbnailerParameters(url, type, width, height) {
			var tokens = url.split('/'),
				last = tokens.slice(-1)[0].replace(extRegExp, '');

			tokens.push(width + (height ? 'x' + height : '-') + ((type === 'video' || type === 'nocrop') ? '-' :  'x2-') + last + '.png');
			return tokens.join('/');
		}

		return {
			getThumbURL: getThumbURL,
			getImageURL: getImageURL,
			isThumbUrl: isThumbUrl
		};
	}

	if (context.define && context.define.amd) {
		context.define('wikia.thumbnailer', thumbnailer);
	}
	context.Wikia = context.Wikia || {};
	context.Wikia.Thumbnailer = thumbnailer();
}(this));
