<?php

class ListGlobalUsersAjax {

	public static function axShowUsers ( ) {
		wfProfileIn( __METHOD__ );

		$request = RequestContext::getMain()->getRequest();

		$groups 	= $request->getVal('groups');
		$user_id  	= $request->getInt('userid');
		$limit		= $request->getVal('limit');
		$offset		= $request->getVal('offset');
		$loop		= $request->getVal('loop');

		if ( $request->getVal( 'username' ) ) {
			$user_id = User::idFromName( $request->getVal( 'username' ) );
		}

		if ( !isset($edits) ) {
			$edits = Listusers::DEF_EDITS;
		}

		$result = array(
			'sEcho' => intval($loop),
			'iTotalRecords' => 0,
			'iTotalDisplayRecords' => 0,
			'sColumns' => '',
			'aaData' => array()
		);

		$data = new ListGlobalUsersData();

		$filterGroups = explode(',', trim($groups));
		$data->setFilterGroup ( $filterGroups );
		$data->setUserId ( $user_id );
		$data->setLimit ( $limit );
		$data->setOffset( $offset );
		$records = $data->loadData();

		if ( !empty( $records ) ) {
			$result['iTotalRecords'] = intval( $limit );
			$result['iTotalDisplayRecords'] = intval($records['cnt']);
			$rows = array();
			if ( isset($records['data'] ) ) {
				foreach ( $records['data'] as $user_id => $data ) {
					$username  = Xml::openElement('div', array( 'class' => ( $data['blcked'] ) ? 'listusers_blockeduser' : '' ) );
					$username .= Xml::tags( 'span', array( 'style' => 'font-size:90%;font-weight:bold;padding-left:5px;' ), $data['user_link'] );
					$username .= "<br />";
					$username .= Xml::tags( 'span', array( 'style' => 'font-size:77%; padding-left:5px;' ), $data['links'] );
					$username .= Xml::closeElement('div');

					$groups = ( $data['blcked'] ) ? Xml::tags( 'span', array( 'class' => 'listusers_blockeduser' ), $data['groups'] ) : $data['groups'];
					$edits = ( $data['blcked'] ) ? Xml::tags( 'span', array( 'class' => 'listusers_blockeduser' ), $data['rev_cnt'] ) : $data['rev_cnt'];

					$rows[] = array(
						$username, //User name
						$groups, //Groups
						$edits,//Revisions (edits)
					);
				}
			}
			$result['aaData'] = $rows;
			$result['sColumns'] =  join(',', ['username', 'groups', 'revcnt']);
		}

		wfProfileOut( __METHOD__ );

		$response = new AjaxResponse( json_encode($result) );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}

	/**
	 * Get the list of IDs of users that were active on a given wiki.
	 *
	 * Results are cached for a short period (5 minutes).
	 *
	 * @param int $cityId
	 * @return int[]
	 * @see SUS-3207
	 */
	private static function getWikiUsers( int $cityId ) {
		$fname = __METHOD__;

		return WikiaDataAccess::cache(
			wfSharedMemcKey(__METHOD__, $cityId),
			WikiaResponse::CACHE_VERY_SHORT,
			function() use ($cityId, $fname) {
				global $wgSpecialsDB;

				$dbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
				return $dbr->selectFieldValues(
					ListusersData::TABLE,
					'user_id',
					[
						'wiki_id' => $cityId,
					],
					$fname
				);
			}
		);
	}

	/**
	 * Return a list of user names that match a given prefix and were active on a current wiki
	 *
	 * Example: http://sandbox-s6.poznan.wikia.com/index.php?action=ajax&rs=ListGlobalUsersAjax::axSuggestUsers&query=Mac
	 *
	 * @return AjaxResponse
	 * @see SUS-3207
	 */
	public static function axSuggestUsers() {
		global $wgExternalSharedDB, $wgCityId, $wgContLang;

		$query = RequestContext::getMain()->getRequest()->getText('query');

		// uppercase the first letter
		$query = $wgContLang->ucfirst( $query );

		$resp = [
			$query
		];

		// get the list of user IDs that are active on a wiki
		$wikiUsers = self::getWikiUsers( $wgCityId );

		if ( !empty( $wikiUsers ) && $query !== '' ) {
			// get the list of user names from accounts that were active on a wiki
			$dbr = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);
			$user_names = $dbr->selectFieldValues(
				'user',
				'user_name',
				[
					'user_id' => $wikiUsers,
					sprintf('user_name %s', $dbr->buildLike($query, $dbr->anyString() ) ),
				],
				__METHOD__,
				[
					'LIMIT' => 50,
					'ORDER BY' => 'user_name'
				]
			);

			$resp[] = $user_names;
		}

		$response = new AjaxResponse( json_encode($resp) );
		$response->setContentType( 'application/json; charset=utf-8' );
		$response->setCacheDuration( WikiaResponse::CACHE_VERY_SHORT );

		return $response;
	}
}
