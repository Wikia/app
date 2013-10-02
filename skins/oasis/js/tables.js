jQuery(function( $ ) {
	'use strict';

	var $article = $( '#WikiaArticle' ),
		$tables = $article.find( 'table' ),
		$wikiaBarWrapper = $( '#WikiaBarWrapper' ),
		template =
			'<div class="table-wrapper table-is-wide">' +
				'<div class="table-scrollable"></div>' +
			'</div>';

	// Scans tables inside of the article and applies overflow hint styles
	// on any tables that are wider than the article content area.
	function scan() {
		$tables.each(function() {
			var $table = $( this ),
				$scrollable = $table.parent( '.table-scrollable' ),
				isWide = $table.width() > $article.width();

			// Wrap wide tables that aren't already wrapped
			if ( isWide && !$scrollable.length ) {
				$table.wrap( template );
				$scrollable = $table.parent( '.table-scrollable' );

			// Unwrap wrapped tables if they fit inside the article
			} else if ( !isWide && $scrollable.length ) {
				$table.unwrap().unwrap();
			}

			// Add or remove the floating scrollbar for wrapped tables
			$scrollable.floatingScrollbar( isWide );
		});
	}

	function updateFloatingScrollbar() {
		var bottom = $wikiaBarWrapper.length &&
			!$wikiaBarWrapper.hasClass( 'hidden' ) ? $wikiaBarWrapper.height() : 0;

		// Update the scrollbar immediately (if present)
		$( '#floating-scrollbar' ).css( 'bottom', bottom );

		// Update the bottom reference so that new scrollbars that are created
		// or updated will get the new bottom height.
		$.floatingScrollbarOptions.bottom = bottom;
	}

	scan();

	$( window )
		.on( 'resize', $.debounce( 50, scan ) )
		.on( 'WikiaBarStateChanged WikiaBarReady', updateFloatingScrollbar );
});
