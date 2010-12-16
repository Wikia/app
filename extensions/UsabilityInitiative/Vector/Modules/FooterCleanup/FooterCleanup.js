/* Prototype code to demonstrate proposed edit page footer cleanups */
/* First draft and will be changing greatly */

$j(document).ready( function() {
	if( !wgVectorEnabledModules.footercleanup ) {
		return true;
	}
	$j( '#editpage-copywarn' )
		.add( '.editOptions' )
		.wrapAll( '<div id="editpage-bottom"></div>' );
	$j( '#wpSummary' )
		.data( 'hint',
			$j( '#wpSummaryLabel span small' )
				.remove()
				.text()
				// FIXME - Not a long-term solution. This change should be done in the message itself
				.replace( /\)|\(/g, '' )
		)
		.change( function() {
			if ( $j( this ).val().length == 0 ) {
				$j( this )
					.addClass( 'inline-hint' )
					.val( $j( this ).data( 'hint' ) );
			} else {
				$j( this ).removeClass( 'inline-hint' );
			}
		} )
		.focus( function() {
			if ( $j( this ).val() == $j( this ).data( 'hint' ) ) {
				$j( this )
					.removeClass( 'inline-hint' )
					.val( "" );
			}
		})
		.blur( function() { $j( this ).trigger( 'change' ); } )
		.trigger( 'change' );
	$j( '#wpSummary' )
		.add( '.editCheckboxes' )
		.wrapAll( '<div id="editpage-summary-fields"></div>' );
		
	$j( '#editpage-specialchars' ).remove();
	
	// transclusions
	// FIXME - bad CSS styling here with double class selectors. Should address here. 
	var transclusionCount = $j( '.templatesUsed ul li' ).size();
	$j( '.templatesUsed ul' )
		.wrap( '<div id="transclusions-list" class="collapsible-list collapsed"></div>' )
		.parent()
		// FIXME: i18n, remove link from message and let community add link to transclusion page if it exists
		.prepend( '<label>This page contains <a href="http://en.wikipedia.org/wiki/transclusion">transclusions</a> of <strong>'
			+ transclusionCount 
			+ '</strong> other pages.</label>' );
	$j( '.mw-templatesUsedExplanation' ).remove();
	
	$j( '.collapsible-list label' )
		.click( function() {
			$j( this )
				.parent()
				.toggleClass( 'expanded' )
				.toggleClass( 'collapsed' )
				.find( 'ul' )
				.slideToggle( 'fast' );
			return false;
		})
		.trigger( 'click' );
	$j( '#wpPreview, #wpDiff, .editHelp, #editpage-specialchars' )
		.remove();
	$j( '#mw-editform-cancel' )
		.remove()
		.appendTo( '.editButtons' );
} );
