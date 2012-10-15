/**
 * Script for the MoodBar ToolTip
 *
 * @author Rob Moen, 2011
 */
jQuery( document ).ready( function( $ ) {

	var mb = mw.moodBar;
	
	$.extend( mb.ui, {
		tooltip: null,

		// returns true if cookie is not set, otherwise returns false
		shouldShow: function() {

			shown = ( $.cookie( mb.cookiePrefix() + 'tooltip' ) == '1' ); // has this been shown ?
			if ( !shown ) {
				return true;	
			} 
			return false;
				
		},

		showTooltip: function () {
			//set tooltip cookie
			$.cookie( mb.cookiePrefix() + 'tooltip', '1', { 'path': '/', 'expires': Number( mb.conf.disableExpiration ) } );
			$( '#mw-head' ).append( mb.ui.tooltip ); // attach tooltip
			setTimeout( function() {
				mb.ui.tooltip.fadeOut();
			}, 4000 );		
		}

	} );

	// Build Tooltip
	mb.ui.tooltip = $('<div>').attr('id', 'moodbar-tooltip-overlay-wrap')
					.append(
						$('<div>').attr('id', 'moodbar-tooltip-overlay')
						.append(
							$('<div>').attr('id', 'moodbar-tooltip-pointy')
						).append(
							$('<div>').attr('id', 'moodbar-tooltip-title')
								.text( mw.msg( 'moodbar-tooltip-title' ) 
								.replace( new RegExp( $.escapeRE('{{SITENAME}}'), 'g' ), mw.config.get( 'wgSiteName' ) )
							)
						)
					);
	
	if ( !mb.isDisabled() && mb.ui.shouldShow()) {
		mb.ui.showTooltip();
	}

} );