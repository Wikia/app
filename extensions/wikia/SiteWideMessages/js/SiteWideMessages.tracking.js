/**
 * Provides click tracking for the content of SiteWideMessages in Oasis
 *
 * @author grunny
 */

jQuery( document ).ready( function ( $ ) {
	var $notificationsArea = $( '#WikiaNotifications' );
	$notificationsArea.find( 'div[data-type="5"]' ).each( function () {
		var msgId = parseInt( $( this ).attr( 'id' ).substr( 4 ) );
		$( this ).find( 'p a' ).click( function () {
			var trackObj = {
				ga_category: 'sitewidemessages',
				ga_action: WikiaTracker.ACTIONS.CLICK_LINK_TEXT,
				ga_label: 'swm-link',
				ga_value: msgId,
				href: $( this ).attr( 'href' )
			};
			WikiaTracker.trackEvent(
				'trackingevent',
				trackObj,
				'internal'
			);
		} );
	} );
} );