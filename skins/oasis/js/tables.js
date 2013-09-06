jQuery(function( $ ) {
	'use strict';

	var $scrollbar,
		$article = $( '#WikiaArticle' ),
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

		// Cache when available
		if ( !$scrollbar || !$scrollbar.length ) {
			$scrollbar = $( '#floating-scrollbar' );
		}

		$scrollbar.css( 'bottom', isVisible ? $wikiaBarWrapper.height() : 0 );
	}

	$( window )
		.on( 'resize', $.debounce( 100, scan ) )
		.on( 'WikiaBarStateChanged WikiaBarReady', updateFloatingScrollbar )
		.one( 'floatingScrollbarUpdate', updateFloatingScrollbar );
});