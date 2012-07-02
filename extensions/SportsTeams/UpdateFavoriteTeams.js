/**
 * JavaScript used on Special:UpdateFavoriteTeams
 *
 * Originally the first two functions were inline JS and the third function was
 * located in UserProfile's UpdateProfile.js.
 *
 * @file
 */
var UpdateFavoriteTeams = {
	fav_count: 0, // has to have an initial value...

	showNext: function() {
		jQuery( '#add_more' ).hide();
		if( jQuery( '#fav_' + ( UpdateFavoriteTeams.fav_count + 1 ) ) ) {
			if ( document.getElementById( 'fav_' + ( UpdateFavoriteTeams.fav_count + 1 ) ).style.display == 'none' ) {
				jQuery( '#fav_' + ( UpdateFavoriteTeams.fav_count + 1 ) ).show();
				UpdateFavoriteTeams.fav_count++;
			}
		}
	},

	removeFan: function( sid, tid ) {
		document.sports_remove.s_id.value = sid;
		document.sports_remove.t_id.value = tid;
		document.sports_remove.submit();
	},

	saveTeams: function() {
		var favs = '';
		var sport_id, team_id;
		for( var x = 1; x <= UpdateFavoriteTeams.fav_count; x++ ) {
			if( document.getElementById( 'sport_' + x ).value !== 0 ) {
				sport_id = document.getElementById( 'sport_' + x ).value;
				team_id = document.getElementById( 'team_' + x ).value;

				favs += sport_id + ',' + team_id + '|';
			}
		}

		document.sports.favorites.value = favs;
		document.sports.submit();
	}
};