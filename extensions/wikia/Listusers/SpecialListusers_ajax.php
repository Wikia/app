<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 */
class ListusersAjax {

	/**
	 * ajax response for request params
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 *
	 * @return AjaxResponse
	 */
	public static function axShowUsers ( ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		$request = RequestContext::getMain()->getRequest();

		$groups 	= $request->getVal('groups');
		$user_id  	= $request->getInt('userid');
		$edits 		= $request->getVal('edits');
		$limit		= $request->getVal('limit');
		$offset		= $request->getVal('offset');
		$loop		= $request->getVal('loop');
		$orders     = explode("|", $request->getVal('order') );

		if ( $limit < 0 || $offset < 0) {
			$response = new AjaxResponse( json_encode( 'invalid value of limit or offset' ) );
			$response->setContentType( 'application/json; charset=utf-8' );
			$response->setResponseCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return $response;
		}

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

		$data = new ListusersData($wgCityId);

		$filterGroups = explode(',', trim($groups));
		$data->setFilterGroup ( $filterGroups );
		$data->setUserId ( $user_id );
		$data->setEditsThreshold( $edits );
		$data->setLimit ( $limit );
		$data->setOffset( $offset );
		$data->setOrder( $orders );
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

					$last_edited  = "-";
					if ( $data['last_edit_ts'] && $data['last_edit_page'] ) {
						$last_edited  = Xml::openElement( 'div' );
						$last_edited .= Xml::tags( 'span',
							array( 'style' => 'font-size:90%;' ),
							Xml::element('a', array( 'href' => $data['last_edit_page'] ), $data['last_edit_ts'] )
						);
						$last_edited .= Xml::tags( 'span',
							array( 'style' => 'font-size:77%; padding-left:8px;' ),
							Xml::element('a', array( 'href' => $data['last_edit_diff'] ), wfMsg('diff') )
						);
						$last_edited .= Xml::closeElement('div');
					}

					$rows[] = array(
						$username, //User name
						$groups, //Groups
						$edits,//Revisions (edits)
						$last_edited//Last edited
					);
				}
			}
			$result['aaData'] = $rows;
			$result['sColumns'] =  join(',', ['username', 'groups', 'revcnt', 'dtedit']);
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
	 * Example: http://sandbox-s6.poznan.wikia.com/index.php?action=ajax&rs=ListusersAjax::axSuggestUsers&query=Mac
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
