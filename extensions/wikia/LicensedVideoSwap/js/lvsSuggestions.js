/**
 * Clicking on the more suggestions link will slide down a row of
 * thumbnails that are additional possible matches for the non-premium
 * video
 */
define( 'lvs.suggestions', [], function() {

	"use strict";

	function init( $container ) {
		$container.on( 'click', '.more-link', function( e ) {
			e.preventDefault();
			var $this = $( this ),
				$toggleDiv = $this.parent().next( '.more-videos' );

			// Show suggestions
			if ( $this.hasClass( 'collapsed' ) ) {
				$this.removeClass( 'collapsed' );
				$toggleDiv.slideDown();
			// Hide suggestions
			} else {
				$this.addClass( 'collapsed' );
				$toggleDiv.slideUp();
			}

		});
	}

	return {
		init: init
	};

});