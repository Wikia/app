/**
 * Collapsing script for Special:LanguageStats in MediaWiki Extension:Translate
 * @author Krinkle <krinklemail (at) gmail (dot) com>
 * @created January 3, 2011
 * @license GPL v2, CC-BY-SA-3.0
 */
jQuery( document ).ready( function( $ ) {

	var	$translateTable =  $( '.mw-sp-translate-table' ),
		$metaRows = $( 'tr[data-ismeta=1]', $translateTable );

	// Only do stuff if there are any meta group rows on this pages
	if ( $metaRows.size() ) {

		$metaRows.each( function() {
			// Get info and cache selectors
			var	$thisGroup = $(this),
				thisGroupId = $thisGroup.attr( 'data-groupid' ),
				$thisChildRows = $( 'tr[data-parentgroups~="' + thisGroupId + '"]', $translateTable );

			// Only do the collapse stuff if this Meta-group actually has children on this page
			if ( $thisChildRows.size() ) {

				// Build toggle link
				var $toggler = $( '<span class="mw-sp-langstats-toggle mw-sp-langstats-expander">[</span>' ).append( $( '<a href="#" onclick="return false;"></a>' ).text( mw.msg( 'translate-langstats-expand' ) ) ).append( ']' ).click( function() {
					var $el = $( this );
					// Switch the state and toggle the rows
					if ( $el.hasClass( 'mw-sp-langstats-expander' ) ) {
						$thisChildRows.fadeIn();
						$el.removeClass( 'mw-sp-langstats-expander' ).addClass( 'mw-sp-langstats-collapser' )
						   .find( '> a' ).text( mw.msg( 'translate-langstats-collapse' ) );
					} else {
						$thisChildRows.fadeOut();
						$el.addClass( 'mw-sp-langstats-expander' ).removeClass( 'mw-sp-langstats-collapser' )
						   .find( '> a' ).text( mw.msg( 'translate-langstats-expand' ) );
					}
				} );

				// Add the toggle link to the first cell of the meta group table-row
				$thisGroup.find( ' > td:first' ).append( $toggler );
			}
		} );

		// Create, bind and append the toggle-all button
		var $allChildRows = $( 'tr[data-parentgroups]', $translateTable ),
			$allToggles_cache = null,
			$toggleAllButton = $( '<span class="mw-sp-langstats-expander">[</span>' ).append( $( '<a href="#" onclick="return false;"></a>' ).text( mw.msg( 'translate-langstats-expandall' ) ) ).append( ']' ).click( function() {
				var	$el = $( this ),
					$allToggles = !!$allToggles_cache ? $allToggles_cache : $( '.mw-sp-langstats-toggle', $translateTable );
				// Switch the state and toggle the rows
				// and update the local toggles too
				if ( $el.hasClass( 'mw-sp-langstats-expander' ) ) {
					$allChildRows.show();
					$el.add( $allToggles ).removeClass( 'mw-sp-langstats-expander' ).addClass( 'mw-sp-langstats-collapser' );
					$el.find( '> a' ).text( mw.msg( 'translate-langstats-collapseall' ) );
					$allToggles.find( '> a' ).text( mw.msg( 'translate-langstats-collapse' ) );
				} else {
					$allChildRows.hide();
					$el.add( $allToggles ).addClass( 'mw-sp-langstats-expander' ).removeClass( 'mw-sp-langstats-collapser' );
					$el.find( '> a' ).text( mw.msg( 'translate-langstats-expandall' ) );
					$allToggles.find( '> a' ).text( mw.msg( 'translate-langstats-expand' ) );
				}
			} );

		// Initially hide them
		$allChildRows.hide();

		// Add the toggle-all button above the table
		$( '<p class="mw-sp-langstats-toggleall"></p>' ).append( $toggleAllButton ).insertBefore( $translateTable );
	}
} );

// When hovering a row, adjust brightness of the last two custom-colored cells as well
// See also translate.langstats.css for the highlighting for the other normal rows
mw.loader.using( 'jquery.colorUtil' , function() {

	$( '.mw-sp-translate-table.wikitable tr' ).hover( function() {
	
		$( '> td:last', this )
				// Get last two cells
				.prev( 'td' ).andSelf()
				// 30% more brightness
				.css( 'background-color', function( i, val ) {
					return $.colorUtil.getColorBrightness( val, +0.3 );
				} );
	}, function() {
		$( '> td:last', this )
			// Get last two cells
			.prev( 'td' ).andSelf()
			// 30% less brightness
			.css( 'background-color', function( i, val ) {
				return $.colorUtil.getColorBrightness( val, -0.3 );
			} );
	} );

} );