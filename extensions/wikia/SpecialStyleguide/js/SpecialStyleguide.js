require(['jquery'], function($) {
	$(function() {

		var $toc = $('#styleguideTOC');

		if ($toc.length) {
			require(['wikia.window', 'wikia.ui.toc'], function(w, TOC) {

				var tocOffsetTop = $toc.offset().top,
					TOC_TOP_MARGIN = 10, // const for top margin of fixed TOC set in CSS
					tocInstance = new TOC($toc);

				tocInstance.init();

				/**
				 * Fix / unfix TOC position
				 */
				function setTOCPosition() {
					var scrollTop = $('body').scrollTop();

					// in Chrome $('body').scrollTop() does change when you scroll whereas $('html').scrollTop() doesn't
					// in Firefox/IE $('html').scrollTop() does change when you scroll whereas $('body').scrollTop() doesn't
					scrollTop = ( scrollTop === 0 ) ? $('html').scrollTop() : scrollTop;

					if( scrollTop >= tocOffsetTop - TOC_TOP_MARGIN ) {
						$toc.addClass('toc-fixed');
					} else {
						$toc.removeClass('toc-fixed');
					}
				}

				var throttled = $.throttle( 50, setTOCPosition);
				$(w).on('scroll', throttled);
			});
		}

		/**
		 * Show hide Style guide section
		 *
		 * @param {Object} $target - jQuery selector (show/hide link) that gives context to which element should be show / hide
		 */
		function showHideSections($target) {
			var	$section = $target.parent().next(),
				linkLabel;

			$section.toggleClass('shown');

			linkLabel = ($section.hasClass('shown') ? $.msg( 'styleguide-hide-parameters' ) : $.msg( 'styleguide-show-parameters' ));
			$target.text(linkLabel);
		}

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

		/** Attach events */
		$('body').on('click', '#mw-content-text section .toggleParameters', function(event) {
			event.preventDefault();
			showHideSections($(event.target));
		});

		/** Let's skip default browser action for example links/buttons (DAR-2172) */
		$('.example').on( 'click', 'a', function(event) {
			event.preventDefault();
		});

		require( [ 'wikia.ui.modal' ], function( modal ) {
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
	});
});
