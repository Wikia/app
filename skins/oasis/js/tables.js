jQuery(function( $ ) {
	'use strict';

	var $article = $( '#WikiaArticle' ),
		$tables = $article.find( 'table' ),
		$wikiaBarWrapper = $( '#WikiaBarWrapper' ),
		template = '<div class="table-wrapper"><div class="table-scrollable"></div></div>';

	// Scans tables inside of the article and applies overflow hint styles
	// on any tables that are wider than the article content area.
	function scan() {
		$tables.each(function() {
			var $table = $( this ),
				isWide = $table.width() > $article.width();

			if ( isWide && !$table.parent( '.table-scrollable' ).length ) {
				$table.wrap( template );
			}

			$table
				.parent( '.table-scrollable' ).floatingScrollbar( isWide )
				.parent( '.table-wrapper' ).toggleClass( 'table-is-wide', isWide );
		});
	}

	scan();

	// TODO: remove this when WikiaBar goes away
	function updateFloatingScrollbar() {
		var isVisible = $wikiaBarWrapper.length && !$wikiaBarWrapper.hasClass( 'hidden' );
		$( '#floating-scrollbar' ).css( 'bottom', isVisible ? $wikiaBarWrapper.height() : 0 );
		$.floatingScrollbarUpdate();
	}

	$( window )
		// Listen for window resizes and check again for wide tables
		.on( 'resize', $.debounce( 100, scan ) )
		.on( 'WikiaBarStateChanged WikiaBarReady', updateFloatingScrollbar );
});