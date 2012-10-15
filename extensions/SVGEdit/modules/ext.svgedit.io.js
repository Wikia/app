/**
 * SVGEdit extension
 * @copyright 2010-2011 Brion Vibber <brion@pobox.com>
 */

/**
 * Static functions for reaching the calling MediaWiki instance.
 */
var mwSVG = window.mwSVG = {
	/**
	 * Fetch the API endpoint URL for our MediaWiki instance.
	 *
	 * @return string URL to MediaWiki API.
	 */
	api: function() {
		return wgScriptPath + '/api' + wgScriptExtension;
	},

	/**
	 * Fetch an SVG file's imageinfo data from the MediaWiki system...
	 *
	 * @param {String} target
	 * @param {function(imageinfo)} callback
	 */
	fetchInfo: function(target, callback) {
		var params = {
			format: 'json',
			action: 'query',
			prop: 'imageinfo',
			titles: 'File:' + target,
			iiprop: 'size|url|mime'
		};
		$.get(mwSVG.api(), params, function(data) {
			var imageinfo = {};
			$.each(data.query.pages, function(key, pageInfo) {
				if (pageInfo.imageinfo && pageInfo.imageinfo.length) {
					imageinfo = pageInfo.imageinfo[0];
				}
			});
			callback(imageinfo);
		});
	},

	/**
	 * Fetch an SVG file from the MediaWiki system...
	 * Requires same-origin, an allowed cross-origin policy,
	 * or a (not yet implemented) JSONP proxy.
	 *
	 * @param {String} url as returned via fetchInfo previously
	 * @param {function(xmlSource, textStatus, xhr)} callback
	 * @param {function(xhr, textStatus, errorThrown)} onerror
	 */
	fetchFile: function(url, callback, onerror) {
		// if proxy blah blah
		$.ajax({
			url: url,
			success: callback,
			error: onerror,
			dataType: 'text',
			cache: false
		});
	},

	/**
	 * Fetch an SVG file from the MediaWiki system...
	 * Requires ApiSVGProxy extension to be loaded.
	 *
	 * @param {String} target
	 * @param {function(xmlSource, textStatus, xhr)} callback
	 */
	fetchSVG: function(target, callback) {
		var params = {
			action: 'svgproxy',
			file: 'File:' + target,
			format: 'xml'
		};
		$.get(mwSVG.api(), params, callback, 'text');
	},

	/**
	 * Get an edit token for the given file page
	 *
	 * @param {String} target: filename
	 * @param {function(token)} callback
	 */
	fetchToken: function(target, callback) {
		var params = {
			format: 'json',
			action: 'query',
			prop: 'info',
			intoken: 'edit',
			titles: 'File:' + target
		};
		$.get(mwSVG.api(), params, function(data) {
			var token = null;
			$.each(data.query.pages, function(key, pageInfo) {
				token = pageInfo.edittoken;
			});
			callback(token);
		});
	},

	/**
	 * Save an SVG file back to MediaWiki... whee!
	 *
	 * @param {String} target: filename
	 * @param {String} data: SVG data to save
	 * @param {String} comment: text summary of the edit
	 * @param {function(data, textStatus, xhr)} callback: called on completion
	 */
	saveSVG: function(target, data, comment, callback) {
		mwSVG.fetchToken(target, function(token) {
			var multipart = new FormMultipart({
				action: 'upload',
				format: 'json',

				filename: target,
				comment: comment,
				token: token,
				ignorewarnings: 'true'
			});
			multipart.addPart({
				name: 'file',
				filename: target,
				type: 'image/svg+xml',
				encoding: 'binary',
				data: data
			});

			var onError = function(xhr, textStatus, errorThrown) {
				alert('Error saving file.');
			};

			var ajaxSettings = {
				type: 'POST',
				url: mwSVG.api(),
				contentType: multipart.contentType(),
				data: multipart.toString(),
				processData: false,
				success: callback,
				error: onError
			};
			$.ajax(ajaxSettings);
		});
	}
};
