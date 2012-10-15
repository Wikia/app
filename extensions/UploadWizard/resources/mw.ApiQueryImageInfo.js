/**
 * Library to assist with fetching images
 * Abstracted out of some code which was in mw.UploadWizard which is no longer necessary.
 * This may have a number of bugs, as I'm just leaving it here to save the functionality, it's not yet used in anything
 */
( function( mw, $ ) { 

	$.extend( mw.Api.prototype, { 	

		/** 
		 * Get information about an image.
	 	 * TODO the API can handle multiple titles, this assumes only one
		 * @param {mw.Title} title of the image
		 * @param {Array} properties: array of strings of properties wanted (see api documentation) 
	 	 * @param {Object} extraParams: parameters (such as width; not needed for all calls).
		 * @param {Function} ok: success callback, takes a javascript object like imageinfo results (see API Docs)
		 * @param {Function} err: error callback
		 */
		getImageInfo: function( title, properties, extraParams, ok, err ) {
			var params = {
				'prop': 'imageinfo',
				'titles': title.toString()
			};
			if (  extraParams.width  !== undefined ) {
				params['iiurlwidth'] = extraParams.width;
			}
			params.iiprop = properties.join( '|' );

			var success = function( data ) {
				if ( !data || !data.query || !data.query.pages ) {
					return;
				}

				var foundImageInfo = false;
				$j.each( data.query.pages, function( id, page ) {
					if ( page.imageinfo && page.imageinfo.length ) {
						var imageinfo = page.imageinfo[0];
						ok( imageinfo );
						foundImageInfo = true;
						return false;
					}
				} );
				
				if ( ! foundImageInfo ) {
					err( data );
				}
			};
			
			this.get( params, { ok: ok, err: err } );
		},

		/** 
		 * Get information about the thumbnail of an image.
		 * @param {mw.Title} title of the image
		 * @param {Number} width desired
	 	 * @param {Function} execute on success, taking an object with the properties of src, width, height
	 	 * @param {Function} to execute if error encountered
		 */
		getThumbnail: function( title, width, ok, err ) {
		
			var extraParams = { 'width': width };
                   	var properties = [ 'url', 'size' ];

			var success = function( imageinfo ) {
				ok( {
			       		'src': imageinfo.thumburl, 
			       		'width': imageinfo.thumbwidth, 
			      		'height': imageinfo.thumbheight 
				} );
			};
	
			this.getImageInfo( title, properties, extraParams, success, err );
		}
		
	} );

}) ( window.mediaWiki, jQuery );


