jQuery(function( $ ) {
	'use strict';

	var $article = $( '#WikiaArticle' ),
		$tables = $article.find( 'table' ),
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

	// Listen for window resizes and check again for wide tables
	$( window ).on( 'resize', $.debounce( 100, scan ) );
});