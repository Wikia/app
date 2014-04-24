require([ 'jquery' ], function( $ ) {
	'use strict';

	$(function() {
		/**
		 * @desc Shows a modal with map inside
		 *
		 * @param {Object} $target - map thumbnail jQuery object that gives context to which map should be shown
		 */
		function showMap( $target ) {
			var $anchor = $( $target.parent()),
				mapId = $anchor.data( 'map-id' );

			require( [ 'wikia.ui.factory' ], function ( uiFactory ) {
				uiFactory.init( [ 'modal' ] ).then( function ( uiModal ) {
					var modalConfig = {
						vars: {
							id: 'interactiveMap-' + mapId,
							size: 'large',
							content: getMapInIframe( getDataParams( $anchor ) )
						}
					};

					uiModal.createComponent( modalConfig, function ( mapModal ) {
						mapModal.show();
					});
				});
			});
		}

		/**
		 * @desc Creates an object with data from data-* parameters of a jQuery wrapper on DOM element
		 * @param $el jQuery wrapped DOM element from which the data will be extracted
		 * @returns {Object} with map-id, lat, lon and zoom parameters
		 */
		function getDataParams( $el ) {
			var result = { 'map-id': null, 'lat': null, 'lon': null, 'zoom': null },
				paramName;

			for( paramName in result ) {
				result[ paramName ] = $el.data( paramName );
			}

			return result;
		}

		/**
		 * @desc Build and returns map URL
		 * @param {Object} params gathered from DOM element data-* attributes
		 * @see getDataParams()
		 * @returns {string}
		 */
		function getMapUrl( params ) {
			var config = window.wgIntMapConfig,
				url;

			url = config.protocol + '://';
			url += config.hostname + ':' + config.port + '/api/' + config.version + '/render/';
			url += params['map-id'] + '/' + params.zoom + '/' + params.lat + '/' + params.lon;

			return url;
		}

		/**
		 * @desc Builds and returns map in an iframe
		 * @param params
		 * @returns {string}
		 */
		function getMapInIframe( params ) {
			return 'Map URL: ' + getMapUrl( params );
		}

		/** Attach events */
		$('body').on('click', '.wikia-interactive-map-thumbnail img', function(event) {
			event.preventDefault();
			showMap( $(event.target) );
		});
	});
});
