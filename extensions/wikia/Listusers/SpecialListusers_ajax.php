<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

class ListusersAjax {

	/**
	 * ajax response for request params
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 */
	public static function axShowUsers ( ) {
		global $wgUser, $wgCityId;
		wfProfileIn( __METHOD__ );

		$request = RequestContext::getMain()->getRequest();

		$groups 	= $request->getVal('groups');
		$user_id  	= $request->getInt('userid');
		$edits 		= $request->getVal('edits');
		$limit		= $request->getVal('limit');
		$offset		= $request->getVal('offset');
		$loop		= $request->getVal('loop');
		$order		= $request->getVal('order');

		// FIXME: SUS-3207 - temporarily support searching via user name
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

		if ( is_object($wgUser) ) {

			$records = array();
			$data = new ListusersData($wgCityId, 0);
			if ( is_object($data) ) {
				$filterGroups = explode(',', trim($groups));
				$data->setFilterGroup ( $filterGroups );
				$data->setUserId ( $user_id );
				$data->setEdits ( $edits );
				$data->setLimit ( $limit );
				$data->setOffset( $offset );
				$orders = explode("|", $order);
				$data->setOrder( $orders );
				$records = $data->loadData();
			}

			if ( !empty( $records ) && is_array( $records ) ) {
				$result['iTotalRecords'] = intval( $limit );
				$result['iTotalDisplayRecords'] = intval($records['cnt']);
				$result['sColumns'] = $records['sColumns'];
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
			}
		}

		wfProfileOut( __METHOD__ );
		return json_encode($result);
	}
}
