/**
 * JavaScript for SRF semanticFormats util namespace
 *
 * @since 1.8
 * @release 0.2
 *
 * @file
 * @ingroup SRF
 *
 * @licence GNU GPL v2 or later
 * @author mwjames
 */
( function( $, mw, srf ) {
 'use strict';

	/*global semanticFormats:true mediaWiki:true*/

	////////////////////////// PRIVATE METHODS //////////////////////////

	var _cacheTime = 1000 * 60 * 60 * 24; // 24 hours

	var _CL_mwspinner   = 'mw-small-spinner';
	var _CL_srfIspinner = 'srf-spinner-img';
	var _CL_srfspinner  = 'srf-spinner';

	////////////////////////// PUBLIC INTERFACE /////////////////////////

	/**
	 * Module for formats utilities namespace
	 * @since 1.8
	 * @type Object
	 */
	srf.util = srf.util || {};

	/**
	 * Constructor
	 * @var Object
	 */
	srf.util = function( settings ) {
		$.extend( this, settings );
	};

	srf.util.prototype = {
		/**
		 * Get image url
		 * @since 1.8
		 * @param options
		 * @param callback
		 * @return string
		 */
		getImageURL: function( options, callback ) {
			var title = options.title,
				cacheTime = options.cachetime;

			// Get cache time
			cacheTime = cacheTime === undefined ? _cacheTime : cacheTime;

			// Get url from cache otherwise do an ajax call
			var url = $.jStorage.get( title );

			if ( url !== null ) {
				if ( typeof callback === 'function' ) { // make sure the callback is a function
					callback.call( this, url ); // brings the scope to the callback
				}
				return;
			}

			// Get url via ajax
			$.getJSON(
			mw.config.get( 'wgScriptPath' ) + '/api.php',
			{
				'action': 'query',
				'format': 'json',
				'prop'  : 'imageinfo',
				'iiprop': 'url',
				'titles': title
			},
			function( data ) {
				if ( data.query && data.query.pages ) {
					var pages = data.query.pages;
					for ( var p in pages ) {
						if ( pages.hasOwnProperty( p ) ) {
							var info = pages[p].imageinfo;
							for ( var i in info ) {
								if ( info.hasOwnProperty( i ) ) {
									$.jStorage.set( title , info[i].url, { TTL: cacheTime } );
									if ( typeof callback === 'function' ) { // make sure the callback is a function
										callback.call( this, info[i].url ); // brings the scope to the callback
									}
									return;
								}
							}
						}
					}
				}
				if ( typeof callback === 'function' ) { // make sure the callback is a function
					callback.call( this, false ); // brings the scope to the callback
				}
				}
			);
		},

		/**
		 * Get title url
		 * @since 1.8
		 * @param options
		 * @param callback
		 * @return string
		 */
		getTitleURL: function( options, callback ) {
			var title = options.title,
				cacheTime = options.cachetime;

			// Get cache time
			cacheTime = cacheTime === undefined ? _cacheTime : cacheTime;

			// Get url from cache otherwise do an ajax call
			var url = $.jStorage.get( title );
			if ( url !== null ) {
				if ( typeof callback === 'function' ) { // make sure the callback is a function
					callback.call( this, url ); // brings the scope to the callback
				}
				return;
			}

			// Get url via ajax
			$.getJSON(
				mw.config.get( 'wgScriptPath' ) + '/api.php',
				{
					'action': 'query',
					'format': 'json',
					'prop'  : 'info',
					'inprop': 'url',
					'titles': title
				},
				function( data ) {
					if ( data.query && data.query.pages ) {
						var pages = data.query.pages;
						for ( var p in pages ) {
							if ( pages.hasOwnProperty( p ) ) {
								var info = pages[p];
									$.jStorage.set( title, info.fullurl, { TTL: cacheTime } );
									if ( typeof callback === 'function' ) { // make sure the callback is a function
										callback.call( this, info.fullurl ); // brings the scope to the callback
									}
									return;
							}
						}
					}
				if ( typeof callback === 'function' ) { // make sure the callback is a function
					callback.call( this, false ); // brings the scope to the callback
				}
				}
			);
		},

		/**
		 * Get spinner for a local element
		 * @since 1.8
		 * @param options
		 * @return object
		 */
		spinner: {
			create: function( options ) {

				// Select the object from its context and determine height and width
				var obj = options.context.find( options.selector ),
					h = mw.html,
					width  = obj.width(),
					height = obj.height();

				// Add spinner to target object
				obj.after( h.element( 'span', { 'class' : _CL_srfIspinner + ' ' + _CL_mwspinner }, null ) );

				// Adopt height and width to avoid clutter
				options.context.find( '.' + _CL_srfIspinner + '.' + _CL_mwspinner )
					.css( { width: width, height: height } )
					.data ( 'spinner', obj ); // Attach the original object as data element
				obj.remove(); // Could just hide the element instead of removing it

			},
			replace: function ( options ){
				// Replace spinner and restore original instance
				options.context.find( '.' + _CL_srfIspinner + '.' + _CL_mwspinner )
					.replaceWith( options.context.find( '.' + _CL_srfIspinner ).data( 'spinner' ) ) ;
			},
			hide: function ( options ){
				// Hide spinner
				options.context.find( '.' + _CL_srfspinner ).hide();
			}
		}
	};

} )( jQuery, mediaWiki, semanticFormats );