<?php

$wgHooks['AddNewAccount'][] = 'fnAddFavoriteTeam';

function fnAddFavoriteTeam( $user ) {
	if ( isset( $_COOKIE['sports_sid'] ) ) {
		$sport_id = $_COOKIE['sports_sid'];
		$team_id = $_COOKIE['sports_tid'];
		$thought = $_COOKIE['thought'];

		if( !$team_id ) {
			$team_id = 0;
		}

		if( $sport_id != 0 ) {
			$s = new SportsTeams();
			$s->addFavorite( $user->getID(), $sport_id, $team_id );

			if( $thought ) {
				$b = new UserStatus();
				$m = $b->addStatus( $sport_id, $team_id, $thought );
			}
		}
	}

	return true;
}