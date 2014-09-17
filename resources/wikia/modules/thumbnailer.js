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
			legacyThumbnailerPath = '/images/thumb/',
			thumbnailerBaseURLRegex = /(.*\/revision\/\w+).*/;

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
			return isLegacyThumbnailerUrl(url) || isThumbnailerUrl(url);
		}

		/**
		 * Checks if url points to legacy thumbnailer
		 * @private
		 * @param {String} url
		 * @returns {Boolean}
		 */
		function isLegacyThumbnailerUrl(url) {
			return url && url.indexOf(legacyThumbnailerPath) > 0;
		}

		/**
		 * Checks if url points to thumbnailer
		 * @private
		 * @param {String} url
		 * @returns {boolean}
		 */
		function isThumbnailerUrl(url) {
			return url && url.indexOf('vignette') > 0;
		}

		/**
		 * Removes the thumbnail options part from a thumbnail URL
		 * @private
		 * @param {String} url The URL of a thumbnail
		 * @return {String} The URL without the thumbnail options
		 */
		function clearThumbOptions(url) {
			var clearedOptionsUrl;

			if (isThumbnailerUrl(url)) {
				clearedOptionsUrl = url.replace(thumbnailerBaseURLRegex, '$1');
			} else {
				//The URL of a legacy thumbnail is in the following format:
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
				to = legacyThumbnailerPath;
			} else {
				from = legacyThumbnailerPath;
				to = imagePath;
			}

			url = url.replace(from, to);
			return url;
		}

		/**
		 * Constructs complete thumbnailer url by appending parameters to url
		 * @private
		 * @param {String} url
		 * @param {String} type
		 * @param {Integer} width
		 * @param {Integer} height
		 * @returns {String} The URL with parameters for the thumbnailer added
		 */
		function addParametersToUrl(url, type, width, height) {
			if (isThumbnailerUrl(url)) {
				url = addThumbnailerParameters(url, type, width, height);
			} else {
				url = addLegacyThumbnailerParameters(url, type, width, height);
			}
			return url;
		}

		/**
		 * Constructs complete thumbnailer url by appending parameters to url
		 * @private
		 * @param {String} url
		 * @param {String} type
		 * @param {Integer} width
		 * @param {Integer} height
		 * @returns {String}
		 */
		function addThumbnailerParameters(url, type, width, height) {
			var thumbnailerRoute = (type === 'video' || type === 'nocrop') ? '/fixed-aspect-ratio' : '/zoom-crop';
			return url + thumbnailerRoute + '/width/' + width + '/height/' + height;
		}

		/**
		 * Constructs complete legacy thumbnailer url by appending parameters to url
		 * @private
		 * @param {String} url
		 * @param {String} type
		 * @param {Integer} width
		 * @param {Integer} height
		 * @returns {String}
		 */
		function addLegacyThumbnailerParameters(url, type, width, height) {
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
