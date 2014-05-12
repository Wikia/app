jQuery( document ).ready( function( $ ) {

	/* Emulate placeholder if not supported by browser */
	if ( !( 'placeholder' in document.createElement( 'input' ) ) ) {
		$( 'input[placeholder]' ).placeholder();
	}

	/* Enable makeCollapsible */
	$( '.mw-collapsible' ).makeCollapsible();

	/* Lazy load jquery.tablesorter */
	if ( $( 'table.sortable' ).length ) {
		mw.loader.using( 'jquery.tablesorter', function() {
			$( 'table.sortable' ).tablesorter({
				// wikia change start - react to sorting completion BAC-718
				complete: function() {
					$(document).trigger('tablesorter_sortComplete');
				}
				// wikia change end
			});
		});
	}

	/* Enable CheckboxShiftClick */
	$( 'input[type=checkbox]:not(.noshiftselect)' ).checkboxShiftClick();

	/* Add accesskey hints to the tooltips */
	mw.util.updateTooltipAccessKeys();

} );
