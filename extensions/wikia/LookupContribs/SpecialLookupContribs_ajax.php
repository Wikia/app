<?php

class LookupContribsAjax {

	public static function axData() {
		global $wgRequest, $wgUser;

		$username 	= $wgRequest->getVal( 'username' );
		$dbname		= $wgRequest->getVal( 'wiki' );
		$mode 		= $wgRequest->getVal( 'mode' );
		$nspace		= $wgRequest->getVal( 'ns', -1 );
		$limit		= $wgRequest->getVal( 'limit' );
		$offset		= $wgRequest->getInt( 'offset' );
		$loop		= $wgRequest->getVal( 'loop' );
		$order		= $wgRequest->getVal( 'order' );
		$lookupUser = $wgRequest->getBool( 'lookupUser' );

		$result = [
			'sEcho' => intval( $loop ),
			'iTotalRecords' => 0,
			'iTotalDisplayRecords' => 0,
			'sColumns' => '',
			'aaData' => []
		];

		// $dbname, $username, $mode, $limit = 25, $offset = 0, $nspace = -1

		if ( empty( $wgUser ) ) {
			return "";
		}
		if ( $wgUser->isBlocked() ) {
			return "";
		}
		if ( !$wgUser->isLoggedIn() ) {
			return "";
		}
		if ( !$wgUser->isAllowed( 'lookupcontribs' ) ) {
			return json_encode( $result );
		}

		$user = User::newFromName( $username );
		if ( !$user instanceof User || $user->isAnon() ) {
			return json_encode( $result );
		}

		$oLC = new LookupContribsCore( $user );
		if ( empty( $mode ) ) {
			$oLC->setLimit( $limit );
			$oLC->setOffset( $offset );
			$oLC->setOrder( $order );
			$activity = $oLC->getUserActivity();

			if ( !empty( $activity ) ) {
				$result['iTotalRecords'] = intval( $limit );
				$result['iTotalDisplayRecords'] = intval( $activity['cnt'] );

				if ( $lookupUser ) {
					$result['sColumns'] = 'id,title,url,lastedit,edits,posts,lastpost,userrights,blocked';
					$result['aaData'] = self::prepareLookupUserData( $activity['data'], $username );
				} else {
					$result['sColumns'] = 'id,dbname,title,url,lastedit,options,edits';
					$result['aaData'] = self::prepareLookupContribsData( $activity['data'] );
				}
			}
		} else {
			$oLC->setDBname( $dbname );
			$oLC->setMode( $mode );
			$oLC->setNamespaces( $nspace );
			$oLC->setLimit( $limit );
			$oLC->setOffset( $offset );
			$data = $oLC->fetchContribs();

			$result = [];

			if ( !empty( $data ) && is_array( $data ) ) {
				$result['iTotalRecords'] = intval( $limit );
				$result['iTotalDisplayRecords'] = intval( $data['cnt'] );
				$result['sColumns'] = 'id,title,links,edit';
				$rows = [];
				if ( isset( $data['data'] ) ) {
					$loop = 1;
					foreach ( $data['data'] as $id => $row ) {
						[ $link, $diff, $hist, $contrib, $edit, $removed ] = array_values( $oLC->produceLine( $row ) );
						$rows[] = [
							$loop + $offset, // id
							$link, // title
							$diff . ' ' . $hist . ' ' . $contrib, // links to diff, history and user contribution (link to special page)
							$edit
						];
						$loop++;
					}
				}
				$result['aaData'] = $rows;
			}
		}

		$response = new AjaxResponse( json_encode($result) );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}

	/**
	 * Generates row data for user if ajax call was sent from Special:LookupContribs
	 *
	 * @param array $activityData data retrieved from LookupContribsCore::getUserActivity()
	 *
	 * @return array
	 */
	private static function prepareLookupContribsData( $activityData ) {
		$wg = F::app()->wg;

		$rows = [];
		foreach ( $activityData as $row ) {
			$rows[] = [
				$row['id'], // wiki Id
				$row['dbname'], // wiki dbname
				$row['title'], // wiki title
				$row['url'], // wiki url
				F::app()->wg->Lang->timeanddate( wfTimestamp( TS_MW, $row['lastedit'] ), true ), // last edited
				'', // options
				$wg->ContLang->formatNum( $row['edits'] ),
			];
		}

		return $rows;
	}

	/**
	 * Generates row data for user if ajax call was sent from Special:LookupUser
	 *
	 * @param array $activityData data retrieved from LookupContribsCore::getUserActivity()
	 *
	 * @return array
	 */
	private static function prepareLookupUserData( $activityData, $username ) {
		$wg = F::app()->wg;

		$rows = [];
		foreach ( $activityData as $row ) {
			$discussionActivity = DiscussionsActivity::fetchDiscussionPostCountAndDate( $username, $row['id'] );
			$rows[] = [
				$row['id'], // wiki Id
				$row['title'], // wiki title
				$row['url'], // wiki url
				$wg->Lang->timeanddate( wfTimestamp( TS_MW, $row['lastedit'] ), true ), // last edited
				$wg->ContLang->formatNum( $row['edits'] ),
				$discussionActivity['count'],
				$discussionActivity['date'],
				LookupUserPage::getUserData( $username, $row['id'], $row['url'] ), // user rights
				LookupUserPage::getUserData( $username, $row['id'], $row['url'], true ), // blocked
			];
		}

		return $rows;
	}
}
