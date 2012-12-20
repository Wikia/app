(function( window, $ ) {

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
	var rAssetManagerGroup = new RegExp( window.wgAssetsManagerQuery
			// Escape any special regex characters in the URL
			.replace( /[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&' )
			// Escape forward slashes (required for string)
			.replace( /\//g, '\\/' )
			// Replace the first parameter to match group or groups
			.replace( '%1\\$s', 'groups?' )
			// Replace remaining parameters with wildcard matches
			.replace( /%\d\\\$(?:s|d)/g, '(.*)' )
		),
		rAssetManagerGroupType = /(js|s?css)/,
		rExtension = /\.(js|s?css)$/;

	return function( resources, success, failure ) {
		var l, n, matches, remaining,
			dfd = new $.Deferred();

		// This will be called everytime a resource is loaded
		var complete = function() {
			remaining--;

			// All files have been downloaded
			if ( remaining < 1 ) {
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

		// Nothing to load
		if ( !( l = remaining = resources.length ) ) {
			complete();
		}

		for ( n = 0; n < l; n++ ) {
			var resource = resources[ n ],
				type = typeof resource;

			// AssetsManager package object (e.g. as passed by JSSnippets)
			if ( type == 'object' ) {
				if ( resource.type && resource.url ) {
					type = resource.type;
					resource = resource.url;
				}

			// URI string
			} else if ( type == 'string' ) {
				matches = resource.match( rAssetManagerGroup );
				matches = matches ? matches[ 3 ].match( rAssetManagerGroupType ) : resource.match( rExtension );
				type = matches ? matches[ 1 ] : 'unknown';
			}

			if ( type == 'js' ) {
				$.getScript( resource, complete, failure );

			} else if ( type == 'css' || type == 'scss' ) {
				$.getCSS( resource, complete );

			// Loader function: $.loadYUI, $.loadJQueryUI
			} else if ( type == 'function' ) {
				resource.call( $, complete );

			} else {
				$().log('getResources: unknown type ' + resource);

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

})( window, jQuery );
