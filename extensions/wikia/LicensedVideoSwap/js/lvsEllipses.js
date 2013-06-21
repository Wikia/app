/*
 * The design calls for all of the "posted in" titles to be on one line.
 * This function calculates whether or not we need to truncate that list
 * and show a "more" link based on the width of that line.
 */

define( 'lvs.ellipses', [], function() {

	"use strict";

	/**
	 * @param jQuery $container The wrapper element for the main body of this page
	 */
	function init( $container ) {
		var wrapperWidth,
			ellipsesWidth,
			truncatedWidth,
			undef;

		function initPopover( elem ) {
			var popoverTimeout = 0;

			function setPopoverTimeout() {
				popoverTimeout = setTimeout( function() {
					elem.popover( 'hide' );
				}, 300 );
			}

			elem.popover({
				trigger: 'manual',
				placement: 'top',
				content: function() {
					var list = elem.next().find('ul').clone(),
						details = list.wrap( '<div class="details"></div>' );

					return details.parent();
				}
			}).on( 'mouseenter', function() {
					clearTimeout( popoverTimeout );
					$( '.popover' ).remove();
					elem.popover( 'show' );

				}).on('mouseleave', function() {
					setPopoverTimeout();
					$( '.popover' ).mouseenter( function() {
						clearTimeout( popoverTimeout );
					}).mouseleave( function() {
							setPopoverTimeout();
						});
				});
		}

		$container.find('.posted-in').each(function() {
			var $this = $( this ),
				$msg = $this.children( 'div' ),
				msgWidth = $msg.width(),
				$ellipses = $this.find( '.ellipses' );

			// get constant DOM widths only once
			if ( ellipsesWidth === undef ) {
				ellipsesWidth = $ellipses.width();
				// get wrapper width
				wrapperWidth = $this.width();
				// calculate width to truncate to
				truncatedWidth = wrapperWidth - ellipsesWidth;
			}

			if ( msgWidth > wrapperWidth ) {
				$msg.addClass( 'processed' ).width( truncatedWidth );
				$ellipses.show();
				initPopover( $ellipses );
			}
		});
	}

	return {
		init: init
	};

});