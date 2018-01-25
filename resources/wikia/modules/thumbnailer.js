/**
 * Helper module to generate the URL to a thumbnail of specific size from JS.
 * This file references and supports both the current thumbnailer, aka Vignette, and the legacy thumbnailer.
 *
 * @author Piotr Bablok <piotrbablok@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @author James Sutterfield james@wikia-inc.com
 *
 * IMPORTANT: this code needs to be kept in sync with Apache rewrites and the thumbnailer servers' code
 */

(function (context) {
	'use strict';

	function thumbnailer() {
		//targets the image file extension
		var extRegExp = /\.(jpg|jpeg|gif|bmp|png|svg)$/i,
			imagePath = '/images/',
			legacyThumbnailerPath = '/images/thumb/',
			// [0-9a-f-]{36} is to match UUIDs like in
			// https://vignette.wikia.nocookie.net/ff8b7617-46fa-4efb-ac2f-ff98edf04bcf
			thumbnailerBaseURLRegex = new RegExp('(.*/revision/\\w+|.*/[0-9a-f-]{36}).*'),
			thumborProxyUrl = 'http://dev-igor:5050';

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
			width = (width || 50);

			console.log('### Original URL', url);
			// FIXME hackathon hack
			url = url.replace('https://vignette.wikia.nocookie.net', thumborProxyUrl);
			console.log('### Thumbor proxy URL', url);

			if (isLegacyThumbnailerUrl(url)) {
				// URL points to a thumbnail, remove crop and size
				url = clearThumbOptions(url);
			} else if (!isThumbUrl(url)) {
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
			if (isThumbnailerUrl(url)) {
				var query = getThumbQueryParams(url);
				url = clearThumbOptions(url);

				if (query) {
					url += '?' + query;
				}
			} else if (isLegacyThumbnailerUrl(url)) {
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
			return url && /\/images\/thumb\//.test(url);
		}

		/**
		 * Checks if url points to thumbnailer
		 * @private
		 * @param {String} url
		 * @returns {boolean}
		 */
		function isThumbnailerUrl(url) {
			return url && (/dev-igor/.test(url) || /\/\/vignette(-poz|\d?)\.wikia/.test(url));
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

		function getThumbQueryParams(url) {
			var query = null,
				queryStart = url.indexOf('?');

			if (queryStart != -1) {
				query = url.substring(url.indexOf('?') + 1);
			}

			return query;
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
		 *
		 * URL before:
		 * http://vignette.wikia.nocookie.net/thelastofus/f/ff/Joel.png/revision/latest
		 *
		 * URL after:
		 * http://vignette.wikia.nocookie.net/thelastofus/f/ff/Joel.png/revision/latest/zoom-crop/width/240/height/240
		 *
		 * @private
		 * @param {String} url
		 * @param {String} type
		 * @param {Integer} width
		 * @param {Integer} height
		 * @returns {String}
		 */
		function addThumbnailerParameters(url, type, width, height) {
			var originalUrl = clearThumbOptions(url),
				queryParams = getThumbQueryParams(url),
				thumbnailerRoute = (type === 'video' || type === 'nocrop') ? '/fixed-aspect-ratio' : '/zoom-crop';

			url = originalUrl + thumbnailerRoute + '/width/' + width + '/height/' + height;

			if (queryParams) {
				url += '?' + queryParams;
			}

			return url;
		}

		/**
		 * Constructs complete legacy thumbnailer url by appending parameters to url
		 * URL before: http://img2.wikia.nocookie.net/__cb0/thelastofus/images/f/ff/Joel.png
		 * URL after: http://img2.wikia.nocookie.net/__cb0/thelastofus/images/thumb/f/ff/Joel.png/90x55-Joel.png
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

			// See examples above and https://one.wikia-inc.com/wiki/Engineering/Thumbnailer_URLs for more information
			// on the tokenization here.
			tokens.push(
				width +
				(height ? 'x' + height : 'px-') +
				((type === 'video' || type === 'nocrop') ? '-' :  'x2-') +
				last +
				'.png'
			);
			return tokens.join('/');
		}

		return {
			getThumbURL: getThumbURL,
			getImageURL: getImageURL,
			isThumbUrl: isThumbUrl,
			isLegacyThumbnailerUrl: isLegacyThumbnailerUrl
		};
	}

	if (context.define && context.define.amd) {
		context.define('wikia.thumbnailer', thumbnailer);
	}
	context.Wikia = context.Wikia || {};
	context.Wikia.Thumbnailer = thumbnailer();
}(this));
