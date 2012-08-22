(function( $ ) {

/**
 * Fetches a list of resources and fires a callback when they have all finished
 * loading. Supports CSS, JavaScript, Sass and AssetManager groups.
 *
 * TODO: Right now, asset group file type is determined by searching for a
 * file type extension in the URI. Is there a better way to detect file type?
 *
 * @author macbre
 * @author kflorence
 */
var getResources = (function() {
	var l, n, matches, remaining,
		rAssetManagerGroup = /__am\/\d+\/groups?\/.*\/(.*)$/,
		rAssetManagerGroupType = /(js|s?css)/,
		rExtension = /\.(js|s?css)$/;

	return function( resources, success, failure ) {
		var dfd = new $.Deferred();

		// This will be called everytime a resource is loaded
		var complete = function() {
			remaining--;

			// All files have been downloaded
			if ( remaining === 0 ) {
				if ( typeof success == 'function' ) {
					success();
				}

				// Resolve the deferred object
				dfd.resolve();
			}
		};

		// Support single resource
		if ( !$.isArray( resources ) ) {
			resources = [ resources ];
		}

		for ( n = 0, l = remaining = resources.length; n < l; n++ ) {
			var resource = resources[ n ],
				type = typeof resource;

			// "loader" function: $.loadYUI, $.loadJQueryUI
			if ( type == 'function' ) {
				resource.call( $, complete );
				continue;

			// AssetsManager package object (e.g. as passed by JSSnippets)
			} else if ( type == 'object' ) {
				if ( resource.type && resource.url ) {
					type = resource.type;
					resource = resource.url;
				}

			// URI string
			} else if ( type == 'string' ) {
				matches = resource.match( rAssetManagerGroup );
				matches = matches ? matches[ 1 ].match( rAssetManagerGroupType ) : resource.match( rExtension );
				type = matches ? matches[ 1 ] : 'unknown';
			}

			if ( type == 'js' ) {
				$.getScript( resource, complete, failure );

			} else if ( type == 'css' || type == 'scss' ) {
				$.getCSS( resource, complete );

			} else {
				dfd.reject({
					error: 'Unknown type',
					resource: resource
				});
			}
		}

		return dfd.promise();
	}
}());

// Exports
$.getResources = $.getResource = getResources;

})( jQuery );