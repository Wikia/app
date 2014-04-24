require([ 'jquery' ], function( $ ) {
	'use strict';

	$(function() {
		var mapParams = { 'id': null, 'lat': null, 'long': null, 'zoom': null };

		/**
		 * @desc Shows a modal with map inside
		 *
		 * @param {Object} $target - map thumbnail jQuery object that gives context to which map should be shown
		 */
		function showMap( $target ) {
			var $anchor = $( $target.parent() ),
				param;

			for( param in mapParams ) {
				console.log( param + ': ' + $anchor.data( param ) );
			}
		}

		/** Attach events */
		$('body').on('click', '.wikia-interactive-map-thumbnail img', function(event) {
			event.preventDefault();
			showMap( $(event.target) );
		});
	});
});
