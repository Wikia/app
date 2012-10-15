var SportsTeamsUserProfile = {
	posted: 0,
	lastBox: '',

	voteStatus: function( id, vote ) {
		jQuery( '#status-update' ).hide( 1000 );

		sajax_request_type = 'POST';
		sajax_do_call( 'wfVoteUserStatus', [ id, vote ], function( response ) {
				SportsTeamsUserProfile.posted = 0;
				document.getElementById( 'status-update' ).innerHTML =
					response.responseText;
				jQuery( '#status-update' ).show();
			}
		);
	},

	detEnter: function( e, num, sport_id, team_id ) {
		var keycode;
		if ( window.event ) {
			keycode = window.event.keyCode;
		} else if ( e ) {
			keycode = e.which;
		} else {
			return true;
		}
		if ( keycode == 13 ) {
			SportsTeamsUserProfile.addMessage( num, sport_id, team_id );
			return false;
		} else {
			return true;
		}
	},

	closeMessageBox: function( num ) {
		jQuery( '#status-update-box-' + num ).hide( 1000 );
	},

	/**
	 * Show the box for adding a status message from the user profile.
	 */
	showMessageBox: function( num, sport_id, team_id ) {
		if( SportsTeamsUserProfile.lastBox ) {
			jQuery( '#status-update-box-' + SportsTeamsUserProfile.lastBox ).hide( 2000 );
		}

		var addMsg, cancelMsg;
		// No proper i18n for pre-ResourceLoader MWs (because I'm lazy)
		if ( jQuery.isFunction( mw.msg ) ) {
			addMsg = mw.msg( 'sportsteams-profile-button-add' );
			cancelMsg = mw.msg( 'sportsteams-profile-button-cancel' );
		} else {
			addMsg = 'add';
			cancelMsg = 'cancel';
		}

		document.getElementById( 'status-update-box-' + num ).innerHTML =
			'<input type="text" id="status_text" onkeypress="detEnter(event,' +
			num + ',' + sport_id + ',' + team_id +
			' )" value="" maxlength="150" /> <input type="button" class="site-button" value="' +
				addMsg + '" onclick="SportsTeamsUserProfile.addMessage(' +
			num + ',' + sport_id + ',' + team_id + ' )" /> <input type="button" class="site-button" value="' +
				cancelMsg + '" onclick="SportsTeamsUserProfile.closeMessageBox(' +
				num + ' )" />';
		jQuery( '#status-update-box-' + num ).show( 1000 );
		SportsTeamsUserProfile.lastBox = num;
	},

	/**
	 * Add a status message from the user profile.
	 */
	addMessage: function( num, sport_id, team_id ) {
		var statusUpdateText = document.getElementById( 'status_text' ).value;
		if( statusUpdateText && !SportsTeamsUserProfile.posted ) {
			SportsTeamsUserProfile.posted = 1;
			jQuery( '#status-update' ).hide();
			sajax_request_type = 'POST';
			sajax_do_call(
				'wfAddUserStatusProfile',
				[ sport_id, team_id, encodeURIComponent( statusUpdateText ), 10 ],
				function( response ) {
					SportsTeamsUserProfile.posted = 0;

					if ( document.getElementById( 'status-update' ) === null ) {
						var theDiv2 = document.createElement( 'div' );
						jQuery( theDiv2 ).addClass( 'status-container' );
						theDiv2.setAttribute( 'id', 'status-update' );
						jQuery( theDiv2 ).insertBefore( jQuery( '#user-page-left:first' ) );

						var theDiv = document.createElement( 'div' );
						jQuery( theDiv ).addClass( 'user-section-heading' );
						theDiv.innerHTML = '<div class="user-section-title">' +
							__thoughts_text__ + '</div>';
						theDiv.innerHTML += '<div class="user-section-action"><a href="' +
							__more_thoughts_url__ + '" rel="nofollow">' +
							__view_all__ + '</a></div>';
						jQuery( theDiv ).insertBefore( jQuery( '#user-page-left:first' ) );
					}

					document.getElementById( 'status-update' ).innerHTML = response.responseText;
					jQuery( '#status-update' ).show();

					SportsTeamsUserProfile.closeMessageBox( num );
				}
			);
		}
	}
};