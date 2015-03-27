/**
 * Provides click tracking for the content of SiteWideMessages in Oasis
 *
 * @author grunny
 */

jQuery( document ).ready( function ( $ ) {
	var	$notificationsArea = $( '#WikiaNotifications' ),
		$firstNotification = $notificationsArea.find( 'div[data-type="5"]' ).first(),
		firstMsgId,
		impTrackObj,
		track = Wikia.Tracker.buildTrackingFunction({
			category: 'sitewidemessages',
			trackingMethod: 'internal'
		});

	if ( $firstNotification.length ) {
		// Track the impression of the first
		track({
			action: Wikia.Tracker.ACTIONS.IMPRESSION,
			label: 'swm-impression',
			value: parseInt( $firstNotification.attr( 'id' ).substr( 4 ) )
		});
	}

	$notificationsArea.find( 'div[data-type="5"]' ).each( function () {
		var msgId = parseInt( $( this ).attr( 'id' ).substr( 4 ) );
		$( this ).find( 'p a' ).click( function (e) {
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				browserEvent: e,
				href: $( this ).attr( 'href' ),
				label: 'swm-link',
				value: msgId
			});
		});
	});
});
