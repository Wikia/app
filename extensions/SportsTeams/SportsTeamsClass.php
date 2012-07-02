<?php
/**
 * Base class for managing data.
 *
 * @file
 * @ingroup Extensions
 */
class SportsTeams {

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() { }

	static function getSports() {
		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			'sport',
			array( 'sport_id', 'sport_name' ),
			array(),
			__METHOD__,
			array( 'ORDER BY' => 'sport_order' )
		);

		$sports = array();
		foreach ( $res as $row ) {
			$sports[] = array(
				'id' => $row->sport_id,
				'name' => $row->sport_name
			);
		}

		return $sports;
	}

	/**
	 * Get all teams for the given sport.
	 *
	 * @param $sportId Integer: sport ID
	 * @return Array: array containing each team's name and internal ID number
	 */
	static function getTeams( $sportId ) {
		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			'sport_team',
			array( 'team_id', 'team_name', 'team_sport_id' ),
			array( 'team_sport_id' => intval( $sportId ) ),
			__METHOD__,
			array( 'ORDER BY' => 'team_name' )
		);

		$teams = array();

		foreach ( $res as $row ) {
			$teams[] = array(
				'id' => $row->team_id,
				'name' => $row->team_name
			);
		}

		return $teams;
	}

	static function getTeam( $teamId ) {
		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			'sport_team',
			array( 'team_id', 'team_name', 'team_sport_id' ),
			array( 'team_id' => intval( $teamId ) ),
			__METHOD__,
			array( 'LIMIT' => 1 )
		);

		$teams = array();

		foreach ( $res as $row ) {
			$teams[] = array(
				'id' => $row->team_id,
				'name' => $row->team_name,
				'sport_id' => $row->team_sport_id
			);
		}

		return $teams[0];
	}

	static function getSport( $sportId ) {
		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			'sport',
			array( 'sport_id', 'sport_name' ),
			array( 'sport_id' => intval( $sportId ) ),
			__METHOD__,
			array( 'LIMIT' => 1 )
		);

		$sports = array();

		foreach ( $res as $row ) {
			$sports[] = array(
				'id' => $row->sport_id,
				'name' => $row->sport_name
			);
		}

		return $sports[0];
	}

	static function getNetworkName( $sport_id, $team_id ) {
		if( $team_id ) {
			$network = SportsTeams::getTeam( $team_id );
		} else {
			$network = SportsTeams::getSport( $sport_id );
		}

		return $network['name'];
	}

	public function addFavorite( $user_id, $sport_id, $team_id ) {
		if( $user_id > 0 ) {
			$user = User::newFromId( $user_id );
			$user_name = $user->getName();

			if( !$this->isFan( $user_id, $sport_id, $team_id ) ) {
				$dbw = wfGetDB( DB_MASTER );
				$dbw->insert(
					'sport_favorite',
					array(
						'sf_sport_id' => $sport_id,
						'sf_team_id' => $team_id,
						'sf_user_id' => $user_id,
						'sf_user_name' => $user_name,
						'sf_order' => ( $this->getUserFavoriteTotal( $user_id ) + 1 ),
						'sf_date' => date( 'Y-m-d H:i:s' )
					),
					__METHOD__
				);
				$this->clearUserCache( $user_id );
			}
		}
	}

	static function clearUserCache( $user_id ) {
		global $wgMemc;
		$key = wfMemcKey( 'user', 'teams', $user_id );
		$data = $wgMemc->delete( $key );
	}

	static function getUserFavorites( $user_id, $order = 0 ) {
		global $wgMemc;

		// Try cache first
		$key = wfMemcKey( 'user', 'teams', $user_id );
		$wgMemc->delete( $key ); // @todo FIXME: shouldn't this be, like, commented out...?
		$data = $wgMemc->get( $key );
		if ( $data ) {
			wfDebugLog( 'SportsTeams', "Got favorite teams for {$user_id} from cache" );
			$favs = $data;
		} else {
			$dbr = wfGetDB( DB_MASTER );
			wfDebugLog( 'SportsTeams', "Got favorite teams for {$user_id} from DB" );

			$res = $dbr->select(
				array( 'sport_favorite', 'sport', 'sport_team' ),
				array(
					'sport_id', 'sport_name', 'team_id', 'team_name',
					'sf_user_id', 'sf_user_name', 'sf_order'
				),
				array( 'sf_user_id' => intval( $user_id ) ),
				__METHOD__,
				array( 'ORDER BY' => 'sf_order' ),
				array(
					'sport' => array( 'INNER JOIN', 'sf_sport_id = sport_id' ),
					'sport_team' => array( 'LEFT JOIN', 'sf_team_id = team_id' )
				)
			);

			$favs = array();

			foreach ( $res as $row ) {
				$favs[] = array(
					'sport_id' => $row->sport_id,
					'sport_name' => $row->sport_name,
					'team_id' => ( ( !$row->team_id ) ? 0 : $row->team_id ),
					'team_name' => $row->team_name,
					'order' => $row->sf_order
				);
			}

			$wgMemc->set( $key, $favs );
		}

		return $favs;
	}

	/**
	 * Get the full <img> tag for the given sport team's logo image.
	 *
	 * @param $sport_id Integer: sport ID number
	 * @param $team_id Integer: team ID number, 0 by default
	 * @param $size String: 's' for small, 'm' for medium, 'ml' for
	 *                      medium-large and 'l' for large
	 * @return String: full <img> tag
	 */
	static function getLogo( $sport_id, $team_id = 0, $size ) {
		global $wgUploadPath;

		if( $sport_id > 0 && $team_id == 0 ) {
			$logoTag = '<img src="' . $wgUploadPath . '/sport_logos/' .
				SportsTeams::getSportLogo( $sport_id, $size ) .
				'" border="0" alt="" />';
		} else {
			$logoTag = '<img src="' . $wgUploadPath . '/team_logos/' .
				SportsTeams::getTeamLogo( $team_id, $size ) .
				'" border="0" alt="" />';
		}

		return $logoTag;
	}

	/**
	 * Get the name of the logo image for a given sports team (identified via
	 * its ID number).
	 *
	 * @param $id Integer: sport team ID number
	 * @param $size String: 's' for small, 'm' for medium, 'ml' for
	 *                      medium-large and 'l' for large
	 * @return String: team logo image filename
	 */
	static function getTeamLogo( $id, $size ) {
		global $wgUploadDirectory;

		$files = glob(
			$wgUploadDirectory . '/team_logos/' . $id . '_' . $size . '*'
		);

		if( empty( $files[0] ) ) {
			$filename = 'default_' . $size . '.gif';
		} else {
			$filename = basename( $files[0] );
		}

		return $filename;
	}

	/**
	 * Get the name of the logo image for a given sport (identified via
	 * its ID number).
	 *
	 * @param $id Integer: sport ID number
	 * @param $size String: 's' for small, 'm' for medium, 'ml' for
	 *                      medium-large and 'l' for large
	 * @return String: sport logo image filename
	 */
	static function getSportLogo( $id, $size ) {
		global $wgUploadDirectory;

		$files = glob(
			$wgUploadDirectory . '/sport_logos/' . $id .  '_' . $size . '*'
		);

		if( empty( $files[0] ) ) {
			$filename = 'default_' . $size . '.gif';
		} else {
			$filename = basename( $files[0] );
		}

		return $filename;
	}

	static function getUsersByFavorite( $sport_id, $team_id, $limit, $page ) {
		global $wgMemc;

		// Try cache first
		//$key = wfMemcKey( 'user', 'teams', $user_id );
		//$wgMemc->delete( $key );
		//$data = $wgMemc->get( $key );
		//if( $data ) {
		//	wfDebugLog( 'SportsTeams', "Got favorite teams for {$user_id} from cache" );
		//	$favs = $data;
		//} else {
			$dbr = wfGetDB( DB_SLAVE );
			$where = $options = array();

			if( $limit > 0 ) {
				$limitvalue = 0;
				if( $page ) {
					$limitvalue = $page * $limit - ( $limit );
				}
				//$limit_sql = " LIMIT {$limitvalue},{$limit} ";
				$options['OFFSET'] = intval( $limitvalue );
				$options['LIMIT'] = intval( $limit );
			}
			if( !$team_id ) {
				$where['sf_sport_id'] = intval( $sport_id );
				$where['sf_team_id'] = 0;
			} else {
				$where['sf_team_id'] = intval( $team_id );
			}

			$res = $dbr->select(
				array( 'sport_favorite', 'sport', 'sport_team' ),
				array(
					'sport_id', 'sport_name', 'team_id', 'team_name',
					'sf_user_id', 'sf_user_name', 'sf_order'
				),
				$where,
				__METHOD__,
				$options,
				array(
					'sport' => array( 'INNER JOIN', 'sf_sport_id = sport_id' ),
					'sport_team' => array( 'LEFT JOIN', 'sf_team_id = team_id' )
				)
			);

			$fans = array();

			foreach ( $res as $row ) {
				$fans[] = array(
					'user_id' => $row->sf_user_id,
					'user_name' => $row->sf_user_name
				);
			}
			//$wgMemc->set( $key, $favs );
		//}
		return $fans;
	}

	static function getSimilarUsers( $user_id, $limit = 0, $page = 0 ) {
		$dbr = wfGetDB( DB_MASTER );

		if( $limit > 0 ) {
			$limitvalue = 0;
			if( $page ) {
				$limitvalue = $page * $limit - ( $limit );
			}
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}

		/*
		$teamRes = $dbr->select(
			'sport_favorite',
			'sf_team_id',
			array( 'sf_user_id' => $user_id ),
			__METHOD__
		);

		$teamIds = array();
		foreach ( $teamRes as $teamRow ) {
			$teamIds[] = $teamRow->sf_team_id;
		}
		*/
		$sql = "SELECT DISTINCT(sf_user_id),sf_user_name
			FROM {$dbr->tableName( 'sport_favorite' )}
			WHERE sf_team_id IN
				(SELECT sf_team_id FROM {$dbr->tableName( 'sport_favorite' )} WHERE sf_user_id ={$user_id})
			AND sf_team_id <> 0 AND sf_user_id <> {$user_id}
			ORDER BY sf_id DESC
			{$limit_sql}";

		$res = $dbr->query( $sql, __METHOD__ );
		$fans = array();

		foreach ( $res as $row ) {
			$fans[] = array(
				'user_id' => $row->sf_user_id,
				'user_name' => $row->sf_user_name
			);
		}

		return $fans;
	}

	static function getUsersByPoints( $sport_id, $team_id, $limit, $page ) {
		$dbr = wfGetDB( DB_SLAVE );
		$where = $options = array();

		if( $limit > 0 ) {
			$limitvalue = 0;
			if ( $page ) {
				$limitvalue = $page * $limit - ( $limit );
			}
			$options['OFFSET'] = intval( $limitvalue );
			$options['LIMIT'] = intval( $limit );
		}

		if( !$team_id ) {
			$where['sf_sport_id'] = intval( $sport_id );
			$where['sf_team_id'] = 0;
		} else {
			$where['sf_team_id'] = intval( $team_id );
		}

		$res = $dbr->select(
			array( 'sport_favorite', 'sport', 'sport_team', 'user_stats' ),
			array(
				'sport_id', 'sport_name', 'team_id', 'team_name',
				'sf_user_id', 'sf_user_name', 'sf_order', 'stats_total_points'
			),
			$where,
			__METHOD__,
			$options,
			array(
				'sport' => array( 'INNER JOIN', 'sf_sport_id = sport_id' ),
				'sport_team' => array( 'LEFT JOIN', 'sf_team_id = team_id' ),
				'user_stats' => array( 'LEFT JOIN', 'sf_user_id = stats_user_id' )
			)
		);

		$fans = array();

		foreach ( $res as $row ) {
			$fans[] = array(
				'user_id' => $row->sf_user_id,
				'user_name' => $row->sf_user_name,
				'points' => $row->stats_total_points
			);
		}

		return $fans;
	}

	static function getUserCount( $sport_id, $team_id ) {
		if( !$team_id ) {
			$where = array(
				'sf_sport_id' => $sport_id,
				'sf_team_id' => 0
			);
		} else {
			$where = array( 'sf_team_id' => $team_id );
		}
		$dbr = wfGetDB( DB_SLAVE );
		$count = (int)$dbr->selectField(
			'sport_favorite',
			'COUNT(*) AS the_count',
			$where,
			__METHOD__
		);
		return $count;
	}

	static function getUserFavoriteTotal( $userId ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = (int)$dbr->selectField(
			'sport_favorite',
			'COUNT(*) AS the_count',
			array( 'sf_user_id' => intval( $userId ) ),
			__METHOD__
		);
		return $res;
	}

	static function getFriendsCountInFavorite( $user_id, $sport_id, $team_id ) {
		$where = array();
		if( !$team_id ) {
			$where = array(
				'sf_sport_id' => $sport_id,
				'sf_team_id' => 0
			);
		} else {
			$where = array( 'sf_team_id' => $team_id );
		}

		$dbr = wfGetDB( DB_SLAVE );

		$friends = $dbr->select(
			'user_relationship',
			'r_user_id_relation',
			array( 'r_user_id' => $user_id, 'r_type' => 1 ),
			__METHOD__
		);

		$uids = array();
		foreach ( $friends as $friend ) {
			$uids[] = $friend->r_user_id_relation;
		}

		if ( !empty( $uids ) ) {
			$ourWhere = array_merge(
				$where,
				// @see http://www.mediawiki.org/wiki/Special:Code/MediaWiki/92016#c19527
				array( 'sf_user_id' => $uids )
			);
			$count = (int)$dbr->selectField(
				'sport_favorite',
				'COUNT(*) AS the_count',
				$ourWhere,
				__METHOD__
			);
		} else {
			$count = 0;
		}

		return $count;
	}

	static function getSimilarUserCount( $user_id ) {
		$dbr = wfGetDB( DB_SLAVE );

		$teamIdQuery = $dbr->select(
			'sport_favorite',
			'sf_team_id',
			array( 'sf_user_id' => $user_id ),
			__METHOD__
		);

		$teamIds = array();
		foreach ( $teamIdQuery as $teamId ) {
			$teamIds[] = $teamId->sf_team_id;
		}

		if ( !empty( $teamIds ) ) {
			$count = (int)$dbr->selectField(
				'sport_favorite',
				'COUNT(*) AS the_count',
				array(
					'sf_team_id' => $teamIds,
					'sf_team_id <> 0',
					"sf_user_id <> {$user_id}"
				),
				__METHOD__
			);
		} else {
			$count = 0;
		}

		return $count;
	}

	/**
	 * Is the given user a fan of the given sports team?
	 *
	 * @param $user_id Integer: user ID number
	 * @param $sport_id Integer: sport ID number
	 * @param $team_id Integer: team ID number
	 * @return Boolean: true if the user is a fan, otherwise false
	 */
	static function isFan( $user_id, $sport_id, $team_id ) {
		$where = array( 'sf_user_id' => $user_id );
		if( !$team_id ) {
			$where['sf_sport_id'] = $sport_id;
			$where['sf_team_id'] = 0;
		} else {
			$where['sf_team_id'] = $team_id;
		}

		$dbr = wfGetDB( DB_SLAVE );

		$row = $dbr->selectField(
			'sport_favorite',
			'sf_id',
			$where,
			__METHOD__
		);

		if( !$row ) {
			return false;
		} else {
			return true;
		}
	}

	static function removeFavorite( $user_id, $sport_id, $team_id ) {
		if( !$team_id ) {
			$where_sql = " sf_sport_id = {$sport_id} AND sf_team_id = 0 ";
		} else {
			$where_sql = " sf_team_id = {$team_id} ";
		}

		$dbr = wfGetDB( DB_MASTER );

		// Get the order of team being deleted;
		$sql = "SELECT sf_order FROM {$dbr->tableName( 'sport_favorite' )} WHERE sf_user_id={$user_id} AND {$where_sql}";
		$res = $dbr->query( $sql, __METHOD__ );
		$row = $dbr->fetchObject( $res );
		$order = $row->sf_order;

		// Update orders for those less than one being deleted
		$res = $dbr->update(
			'sport_favorite',
			array( 'sf_order = sf_order - 1' ),
			array( 'sf_user_id' => $user_id, "sf_order > {$order}" ),
			__METHOD__
		);

		// Finally we can remove the fav
		$sql = "DELETE FROM sport_favorite WHERE sf_user_id={$user_id} AND {$where_sql}";
		$res = $dbr->query( $sql, __METHOD__ );
	}

	static function getNetworkURL( $sport_id, $team_id = 0 ) {
		$title = SpecialPage::getTitleFor( 'FanHome' );
		return $title->escapeFullURL( 'sport_id=' . $sport_id . '&team_id=' . $team_id );
	}

	static function getFanUpdatesURL( $sport_id, $team_id = 0 ) {
		$title = SpecialPage::getTitleFor( 'FanUpdates' );
		return $title->escapeFullURL( 'sport_id=' . $sport_id . '&team_id=' . $team_id );
	}

	static function dateDiff( $date1, $date2 ) {
		$dtDiff = $date1 - $date2;

		$totalDays = intval( $dtDiff / ( 24 * 60 * 60 ) );
		$totalSecs = $dtDiff - ( $totalDays * 24 * 60 * 60 );
		$dif['w'] = intval( $totalDays / 7 );
		$dif['d'] = $totalDays;
		$dif['h'] = $h = intval( $totalSecs / ( 60 * 60 ) );
		$dif['m'] = $m = intval( ( $totalSecs - ( $h * 60 * 60 ) ) / 60 );
		$dif['s'] = $totalSecs - ( $h * 60 * 60 ) - ( $m * 60 );

		return $dif;
	}

	static function getTimeOffset( $time, $timeabrv, $timename ) {
		$timeStr = '';
		if( $time[$timeabrv] > 0 ) {
			$timeStr = wfMsgExt( "sportsteams-time-{$timename}", 'parsemag', $time[$timeabrv] );
		}
		if( $timeStr ) {
			$timeStr .= ' ';
		}
		return $timeStr;
	}

	static function getTimeAgo( $time ) {
		$timeArray = self::dateDiff( time(), $time );
		$timeStr = '';
		$timeStrD = self::getTimeOffset( $timeArray, 'd', 'days' );
		$timeStrH = self::getTimeOffset( $timeArray, 'h', 'hours' );
		$timeStrM = self::getTimeOffset( $timeArray, 'm', 'minutes' );
		$timeStrS = self::getTimeOffset( $timeArray, 's', 'seconds' );
		$timeStr = $timeStrD;
		if( $timeStr < 2 ) {
			$timeStr .= $timeStrH;
			$timeStr .= $timeStrM;
			if( !$timeStr ) {
				$timeStr .= $timeStrS;
			}
		}
		if( !$timeStr ) {
			$timeStr = wfMsgExt( 'sportsteams-time-seconds', 'parsemag', 1 );
		}
		return $timeStr;
	}
}