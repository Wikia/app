require( [ 'jquery', 'wikia.ui.modal' ], function( $, modal ) {
	$(function() {

		/**
		 * Shows a modal; unified function for different modals
		 *
		 * @parma {String} id - unique id of modal element in DOM
		 * @param {Object} modal - wikia.ui.modal instance
		 */
		function showModal( id, modal ) {
			var $modal = modal.init( id );
			if( $modal.isShown() ) {
				$modal.hide();
			} else {
				$modal.show();
			}
		}

		// opening a small modal example
		$( "#showSmallModalExample" ).click(function() {
			var id = "smallModalExample";
			showModal( id, modal );
		} );

		// opening a medium modal example
		$( "#showMediumModalExample" ).click(function() {
			var id = "mediumModalExample";
			showModal( id, modal );
		} );

		// opening a large modal example
		$( "#showLargeModalExample" ).click(function() {
			var id = "largeModalExample";
			showModal( id, modal );
		} );

		// opening a small modal example over large modal
		$( '#largeModalAltLink' ).click( function(event) {
			var id = "smallModalExampleOverLarge";
			event.preventDefault();

			if( !$( "#" + id ).exists() ) {
				// create modal if it doesn't exist
				require( [ 'wikia.ui.factory' ], function( uiFactory ) {
					uiFactory.init( 'modal').then( function( uiModal ) {
						var smallModal = uiModal.render( {
							type: "default",
							vars: {
								"id": id,
								"size": 'small',
								"content": $.msg( 'styleguide-example-modal-small-over-large-message' ),
								"class": "styleguide-example-small-over-large",
								"title": $.msg( 'styleguide-example-modal-small-over-large-title' ),
								"closeButton": true,
								"closeText": $.msg( 'styleguide-example-modal-close-text' )
							}
						} );

						$( 'body' ).append( smallModal );
						showModal( id, modal );
					} );
				} );
			} else {
				showModal( id, modal );
			}
		});

	} );

} );
