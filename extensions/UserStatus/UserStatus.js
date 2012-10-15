/**
 * JavaScript functions used by UserStatus.
 *
 * When updating this file, please remember to update
 * /extensions/SportsTeams/fanhome.js too, because these functions are
 * duplicated over there.
 *
 * @file
 */
var posted = 0;

function add_status() {
	var statusUpdateText = document.getElementById( 'user_status_text' ).value;
	if( statusUpdateText && !posted ) {
		posted = 1;

		sajax_request_type = 'POST';
		sajax_do_call(
			'wfAddUserStatusNetwork',
			[ __sport_id__, __team_id__, encodeURIComponent( statusUpdateText ),
			__updates_show__ ],
			function( response ) {
				posted = 0;
				window.location = __redirect_url__;
			}
		);
	}
}

function vote_status( id, vote ) {
	sajax_request_type = 'POST';
	sajax_do_call( 'wfVoteUserStatus', [ id, vote ], function( response ) {
		document.getElementById( 'user-status-vote-' + id ).innerHTML = response.responseText;
	});
}

function delete_message( id ) {
	if( confirm( 'Are you sure you want to delete this thought?' ) ) {
		sajax_request_type = 'POST';
		sajax_do_call( 'wfDeleteUserStatus', [ id ], function( response ) {
			jQuery( 'span#user-status-vote-' + id ).parent().parent().parent()
				.hide( 1000 );
			//window.location = wgArticlePath.replace( '$1', 'Special:UserStatus' );
		});
	}
}