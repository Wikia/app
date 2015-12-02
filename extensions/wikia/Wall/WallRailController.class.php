<?php

class WallRailController extends WikiaController {
	static $usersData = array();
	static $anonsData = array();

	public function executeIndex() {
		$app = F::App();
		wfProfileIn( __METHOD__ );

		$this->response->addAsset( 'extensions/wikia/Wall/css/WallHistoryRail.scss' );
		$this->usersInvolved = array_merge( $this->getUsersData( self::$usersData ), $this->getUsersData( self::$anonsData ) );

		if ( $this->wg->EnableWallExt ) {
			$this->showTalkPage = false;
		} else {
			$this->showTalkPage = true;
		}

		wfProfileOut( __METHOD__ );
	}


	private function getUsersData( $usersObjects ) {
		$key = 0;

		$usersInvolved = array();
		$sorting = array();

		foreach ( $usersObjects as $user ) {
			if ( $user->isAnon() ) {
				$name = wfMsg( 'oasis-anon-user' );
			}

			$username = $user->getName();
			$userpage = $user->getUserPage()->getFullUrl();

			$usersInvolved[$key]['userpage'] = $userpage;
			if ( empty( $name ) ) {
				$usersInvolved[$key]['name1'] = $username;
				$sorting[$key] = $username;
			} else {
				$usersInvolved[$key]['name1'] = $name;
				$usersInvolved[$key]['name2'] = $username;

				// if user has real name and is not an anon use the real name
				// if he's an anon use username
				$sorting[$key] = ( $user->isAnon() ) ? $username : $name;
			}

			$usersInvolved[$key]['username'] = $username;
			$usersInvolved[$key]['userpage'] = $userpage;
			$usersInvolved[$key]['userwall'] = Title::newFromText( $username, NS_USER_WALL )->getFullUrl();
			$usersInvolved[$key]['usertalk'] = Title::newFromText( $username, NS_USER_TALK )->getFullUrl();

			$usersInvolved[$key]['usercontribs'] = Skin::makeSpecialUrl( 'Contributions' ) . '/' . $username;
			$usersInvolved[$key]['userblock'] = Skin::makeSpecialUrl( 'Block' ) . '/' . $username;
			$key++;
		}
		$sorting = array_map( 'mb_strtolower', $sorting );
		array_multisort( $sorting, SORT_ASC, SORT_STRING, $usersInvolved );

		return $usersInvolved;
	}

	static public function addUser( $userId, $user ) {
		if ( $user instanceof User ) {
			WallRailController::$usersData[$userId] = $user;
		}
	}

	static public function addAnon( $userId, $user ) {
		if ( $user instanceof User ) {
			WallRailController::$anonsData[$userId] = $user;
		}
	}

}
