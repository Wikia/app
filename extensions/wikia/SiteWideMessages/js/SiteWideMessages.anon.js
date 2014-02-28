( function ( $, mw, window ) {
	'use strict';

	var AnonSiteWideMessages = {
		init: function () {
			var $notificationArea = $( '#WikiaNotifications' ),
				hasNotifications = $notificationArea.length ? 1 : 0,
				self = this;

			$.nirvana.sendRequest( {
				controller: 'SiteWideMessagesController',
				method: 'getAnonMessages',
				format: 'html',
				type: 'GET',
				data: {
					hasnotifications: hasNotifications,
					lastdismissed: $.storage.get( 'swm-lastdismissed' )
				}
			} ).done( function( data ) {
				var	$body,
					$siteWideMessages,
					$firstSWM;

				if ( hasNotifications ) {
					$notificationArea.append( data );
				} else {
					$body = $( 'body' );
					$body.addClass( 'notifications' );
					$body.append( data );
					$notificationArea = $( '#WikiaNotifications' );
				}

				$siteWideMessages = $notificationArea.find( 'div[data-type="5"]' );

				if ( $siteWideMessages.length ) {
					$firstSWM = $siteWideMessages.first();

					// Track first notification impression
					if ( $firstSWM.length ) {
						self.track( {
							action: window.Wikia.Tracker.ACTIONS.IMPRESSION,
							label: 'swm-impression',
							value: parseInt( $firstSWM.attr( 'id' ).substr( 4 ), 10 )
						} );
					}

					// Handle dismissing notifications
					$siteWideMessages.find( '.close-notification' )
						.click( $.proxy( self.handleClose, self ) );

					// Track clicks of links within messages
					$siteWideMessages.each( function() {
						var msgId = parseInt( $( this ).attr( 'id' ).substr( 4 ), 10 );
						$( this ).find( 'p a' ).click( function( ev ) {
							self.track( {
								action: window.Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
								browserEvent: ev,
								href: $( this ).attr( 'href' ),
								label: 'swm-link',
								value: msgId
							} );
						} );
					} );
				}
			} );
		},

		handleClose: function ( ev ) {
			var	notification = $( ev.currentTarget ).parent(),
				messageId = parseInt( notification.attr( 'id' ).substr( 4 ), 10 ),
				$nextNotification = notification.next(),
				nextMessageId;

			$.nirvana.sendRequest( {
				controller: 'SiteWideMessagesController',
				method: 'dismissAnonMessage',
				data: {
					messageid: messageId
				}
			} );

			$.storage.set( 'swm-lastdismissed', messageId );

			this.track( {
				action: window.Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON,
				browserEvent: ev,
				label: 'swm-dismiss',
				value: messageId
			} );

			notification.remove();
			$nextNotification.show();

			if ( $nextNotification.length ) {
				nextMessageId = parseInt( $nextNotification.attr( 'id' ).substr( 4 ), 10 );

				// Track next message impression
				this.track( {
					action: window.Wikia.Tracker.ACTIONS.IMPRESSION,
					label: 'swm-impression',
					value: nextMessageId
				} );
			}
		},

		track: window.Wikia.Tracker.buildTrackingFunction( {
			category: 'sitewidemessages',
			trackingMethod: 'internal'
		} )
	};

	$( function() {
		AnonSiteWideMessages.init();
	} );

}( jQuery, mediaWiki, this ) );
