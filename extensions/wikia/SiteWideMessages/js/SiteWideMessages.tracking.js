/**
 * Provides click tracking for the content of SiteWideMessages in Oasis
 *
 * @author grunny
 */

jQuery( document ).ready( function ( $ ) {
	var	$notificationsArea = $( '#WikiaNotifications' ),
		$firstNotification = $notificationsArea.find( 'div[data-type="5"]' ).first(),
		firstMsgId,
		impTrackObj;
	if ( $firstNotification.length ) {
		firstMsgId = parseInt( $firstNotification.attr( 'id' ).substr( 4 ) )
		impTrackObj= {
			ga_category: 'sitewidemessages',
			ga_action: WikiaTracker.ACTIONS.IMPRESSION,
			ga_label: 'swm-impression',
			ga_value: firstMsgId
		};
		// Track the impression of the first 
		WikiaTracker.trackEvent(
			'trackingevent',
			impTrackObj,
			'internal'
		);
	}
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