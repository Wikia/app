(function( $ ){

	$.fn.contents = function() {
		      return this[0].childNodes;
	};

	$.getSassCommonURL = function( scssFilePath, params ) {
		return wgCdnRootUrl + wgAssetsManagerQuery.replace('%1$s', 'sass').replace('%4$d', wgStyleVersion).replace('%3$s', escape($.param(params ? params : sassParams))).replace('%2$s', scssFilePath);
	}

	$.getScript = function( resource, onComplete ) {
		var scriptElement = document.createElement( 'script' );
		scriptElement.src = resource;
		scriptElement.onload = onComplete;
		document.head.appendChild( scriptElement );
	};

	$.getResources = function( resources, callback ) {
		var isJs = /.js(\?(.*))?$/,
			isCss = /.css(\?(.*))?$/,
			isSass = /.scss/,
			remaining = length = resources.length;

		var onComplete = function() {
			remaining--;
			// all files have been downloaded
			if (remaining == 0) {
				if (typeof callback == 'function') {
					callback();
				}
			}
		};

		// download files
		for ( var n = 0; n < length; n++ ) {
			var resource = resources[n];
			console.log("Load: " + resource);
			if ( isJs.test( resource ) ) {
				$.getScript( resource, onComplete );
			} else if ( isCss.test( resource ) || isSass.test( resource ) ) {
				$.getCSS( resource, onComplete );
			}
		};
	};
	// show modal dialog with content fetched via AJAX request
	$.fn.getModal = function(url, id, options) {
		// get modal content via AJAX
		$.get(url, function(html) {
			options = $.isObject(options) ? options : {};

			var callbackBefore = options.callbackBefore,
			callback = options.callback;

			options.html = html;

			// fire callbackBefore if provided
			if (typeof callbackBefore == 'function') {
				callbackBefore();
			}

			// makeModal() if requested
			if (typeof id == 'string') {
				$.openModal(options);
			}

			// fire callback if provided
			if (typeof callback == 'function') {
				callback();
			}
		});
	}

	// show modal popup with static title and content provided
	$.showModal = function(title, content, options) {
		options = $.isObject(options) ? options : {};

		var callbackBefore = options.callbackBefore,
		callback = options.callbackBefore;

		options.html = content;

		// fire callbackBefore if provided
		if ($.isFunction(callbackBefore)) {
			callbackBefore();
		}

		$.openModal(options);

		// fire callback if provided
		if ($.isFunction(callback)) {
			callback();
		}

	}

	$.showLoader = function(element, options) {
		options = options || null;

		element.append('<div class=WikiaMobileLoader><img class=WikiaMobileLoaderImg src=../skins/wikiamobile/images/loader50x50.png></img></div>');

		if(options) {
			var loader = element.find('.WikiaMobileLoader'),
			loaderImg = loader.find('.WikiaMobileLoaderImg');

			if(options.center) {
				loader.addClass('center');
			}
			if(options.size) {
				loaderImg.css('width', options.size);
			}
		}

	}

	$.hideLoader = function(element) {
		element.find('.WikiaMobileLoader').remove();
	}

})( Zepto );
