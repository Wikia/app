function vote_status( id, vote ) {
	//YAHOO.widget.Effects.Hide( 'status-update' );
	jQuery( '#status-update' ).hide( 1000 );

	sajax_request_type = 'POST';
	sajax_do_call( 'wfVoteUserStatus', [ id, vote ], function( response ) {
			posted = 0;
			document.getElementById( 'status-update' ).innerHTML =
				response.responseText;
			//YAHOO.widget.Effects.Appear( 'status-update' );
			jQuery( '#status-update' ).show();
		}
	);
}

var last_box;

function detEnter( e, num, sport_id, team_id ) {
	var keycode;
	if ( window.event ) {
		keycode = window.event.keyCode;
	} else if ( e ) {
		keycode = e.which;
	} else {
		return true;
	}
	if ( keycode == 13 ) {
		add_message( num, sport_id, team_id );
		return false;
	} else {
		return true;
	}
}

function close_message_box( num ) {
	//YAHOO.widget.Effects.Fade( 'status-update-box-' + num );
	jQuery( '#status-update-box-' + num ).hide( 1000 );
}

/**
 * Show the box for adding a status message from the user profile.
 */
function show_message_box( num, sport_id, team_id ) {
	if( last_box ) {
		jQuery( '#status-update-box-' + last_box ).hide( 2000 );
		//YAHOO.widget.Effects.Hide( 'status-update-box-' + last_box );
	}
	// @todo FIXME: i18n for the button texts ("add" and "cancel")
	document.getElementById( 'status-update-box-' + num ).innerHTML =
		'<input type="text" id="status_text" onkeypress="detEnter(event,' +
			num + ',' + sport_id + ',' + team_id +
			' )" value="" maxlength="150" /> <input type="button" class="site-button" value="add" onclick="add_message(' +
			num + ',' + sport_id + ',' + team_id + ' )" /> <input type="button" class="site-button" value="cancel" onclick="close_message_box(' +
			num + ' )" />';
	jQuery( '#status-update-box-' + num ).show( 1000 );
	//YAHOO.widget.Effects.Appear( 'status-update-box-' + num );
	last_box = num;
}

/**
 * Add a status message from the user profile.
 */
function add_message( num, sport_id, team_id ) {
	var statusUpdateText = document.getElementById( 'status_text' ).value;
	if( statusUpdateText && !posted ) {
		posted = 1;
		//YAHOO.widget.Effects.Hide( 'status-update' );
		jQuery( '#status-update' ).hide();
		sajax_request_type = 'POST';
		sajax_do_call(
			'wfAddUserStatusProfile',
			[ sport_id, team_id, encodeURIComponent( statusUpdateText ), 10 ],
			function( response ) {
				posted = 0;

				if ( document.getElementById( 'status-update' ) == null ) {
					var theDiv2 = document.createElement( 'div' );
					//YAHOO.util.Dom.addClass( theDiv2, 'status-container' );
					jQuery( theDiv2 ).addClass( 'status-container' );
					theDiv2.setAttribute( 'id', 'status-update' );
					//YAHOO.util.Dom.insertBefore( theDiv2, YAHOO.util.Dom.getFirstChild( 'user-page-left' ) );
					jQuery( theDiv2 ).insertBefore( jQuery( '#user-page-left:first' ) );

					var theDiv = document.createElement( 'div' );
					//<div class="user-section-heading">
					jQuery( theDiv ).addClass( 'user-section-heading' );
					//YAHOO.util.Dom.addClass( theDiv, 'user-section-heading' );
					theDiv.innerHTML = '<div class="user-section-title">' +
						__thoughts_text__ + '</div>';
					theDiv.innerHTML += '<div class="user-section-action"><a href="' +
						__more_thoughts_url__ + '" rel="nofollow">' +
						__view_all__ + '</a></div>';
					//YAHOO.util.Dom.insertBefore( theDiv, YAHOO.util.Dom.getFirstChild( 'user-page-left' ) );
					jQuery( theDiv ).insertBefore( jQuery( '#user-page-left:first' ) );
				}

				document.getElementById( 'status-update' ).innerHTML = response.responseText;
				jQuery( '#status-update' ).show();
				//YAHOO.widget.Effects.Appear( 'status-update' );

				close_message_box( num );
			}
		);
	}
}