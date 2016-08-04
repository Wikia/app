/**
 * Convenient service accessor for various map services to be used
 * mainly by external extensions.
 */

/*global jQuery, mediaWiki, maps */
/*global confirm */

( function ( $, mw, maps ) {

	'use strict';

	/**
	 * @since 3.5
	 *
	 * @class
	 * @abstract
	 */
	maps.services = {};

	/**
	 * @since 3.5
	 *
	 * @param {object}
	 * @return {this}
	 */
	var services = function ( container ) {

		if ( $.type( container ) !== 'object' ) {
			throw new Error( 'The container is not of the correct type ' + $.type( container ) );
		}

		this.container = container;

		return this;
	};

	/* Public methods */

	services.prototype = {

		constructor: services,

		/**
		 * @since 3.5
		 *
		 * @param {string}
		 */
		render: function( service ) {

			if ( service === 'googlemaps' || service === 'maps' || service === 'googlemaps3' ) {
				this.google();
			};

			if ( service === 'openlayers' ) {
				this.openlayers();
			};

			if ( service === 'leaflet' || service === 'leafletmaps' ) {
				this.leaflet();
			};
		},

		/**
		 * Google service
		 *
		 * @since 3.5
		 */
		google: function() {

			var self = this;

			// https://www.mediawiki.org/wiki/ResourceLoader/Modules#mw.loader.using
			mw.loader.using( 'ext.maps.googlemaps3' ).done( function () {

				if ( typeof google === 'undefined' ) {
					throw new Error( 'The google map service is unknown, please ensure that the API or module is loaded correctly.' );
				}

				self.container.find( '.maps-googlemaps3' ).each( function() {
					var $this = $( this );
					$this.googlemaps( $.parseJSON( $this.find( 'div').text() ) );
				} );
			} );
		},

		/**
		 * Openlayers service
		 *
		 * @since 3.5
		 */
		openlayers: function() {

			var self = this;

			// https://www.mediawiki.org/wiki/ResourceLoader/Modules#mw.loader.using
			mw.loader.using( 'ext.maps.openlayers' ).done( function () {

				if ( typeof OpenLayers !== 'undefined' ) {
					// Same as in ext.maps.openlayers.js
					OpenLayers.ImgPath = mw.config.get( 'egMapsScriptPath' ) + '/includes/services/OpenLayers/OpenLayers/img/';
					OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;
					OpenLayers.Util.onImageLoadErrorColor = 'transparent';
					OpenLayers.Feature.prototype.popupClass = OpenLayers.Class(
						OpenLayers.Popup.FramedCloud,
						{
							'autoSize': true,
							'minSize': new OpenLayers.Size( 200, 100 )
						}
					);
				}

				self.container.find( '.maps-openlayers' ).each( function() {
					var $this = $( this),
						mapData = $.parseJSON( $this.find( 'div').text() );

					$this.openlayers( $this.attr( 'id' ), mapData );
				} );
			} );
		},

		/**
		 * Leaflet service
		 *
		 * @since 3.5
		 */
		leaflet: function() {

			var self = this;

			// https://www.mediawiki.org/wiki/ResourceLoader/Modules#mw.loader.using
			mw.loader.using( 'ext.maps.leaflet' ).done( function () {

				$( '.maps-leaflet' ).each( function() {
					var $this = $( this );
					$this.leafletmaps( $.parseJSON( $this.find( 'div').text() ) );
				} );
			} );
		}
	};

	maps.services = services;

}( jQuery, mediaWiki, maps ) );
