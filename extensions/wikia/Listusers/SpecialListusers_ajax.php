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
	 * @param       Array   $list
	 */
	public static function axShowUsers ( ) {
		global $wgRequest, $wgUser, $wgCityId;

		wfProfileIn( __METHOD__ );

		$groups 	= $wgRequest->getVal('groups');
		$username 	= $wgRequest->getVal('username');
		$edits 		= $wgRequest->getVal('edits');
		$limit		= $wgRequest->getVal('limit');
		$offset		= $wgRequest->getVal('offset');
		$loop		= $wgRequest->getVal('loop');
		$order		= $wgRequest->getVal('order');
		$numOrder	= $wgRequest->getVal('numOrder');

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
				$data->setUserName ( $username );
				$data->setEdits ( $edits );
				$data->setLimit ( $limit );
				$data->setOffset( $offset );
				$orders = explode("|", $order);
				$data->setOrder( $orders );
				$records = $data->loadData();
			}

			if ( !empty( $records ) && is_array( $records ) ) {
				$result['iTotalRecords'] = intval($limit); #( isset( $records['cnt'] ) ) ?  intval( $records['cnt'] ) : 0;
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
						$last_logged = ( $data['blcked'] ) ? Xml::tags(
							'span',
							array( 'class' => 'listusers_blockeduser' ),
							( isset( $data['last_login'] ) ? $data['last_login'] : "-" )
						) : ( isset( $data['last_login'] ) ? $data['last_login'] : "-" );

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
							$last_logged,//Last logged in
							$last_edited//Last edited
						);
					}
				}
				$result['aaData'] = $rows;
				#$result['nbr_records'] = ( isset( $records['cnt'] ) ) ? intval( $records['cnt'] ) : 0;
				#$result['data'] = ( isset($records['data'] ) ) ? $records['data'] : '';
			}
		}

		#return '{"sEcho": 1, "iTotalRecords": 57, "iTotalDisplayRecords": 57, "sColumns": "platform,engine,browser,grade,version","aaData": [ ["-","Other browsers","All others","U","-"],["Win XP","Trident","AOL browser (AOL desktop)","A","6"],["OSX.2+","Gecko","Camino 1.0","A","1.8"],["OSX.3+","Gecko","Camino 1.5","A","1.8"],["Embedded devices","Misc","Dillo 0.8","X","-"],["Gnome","Gecko","Epiphany 2.20","A","1.8"],["Win 98+ / OSX.2+","Gecko","Firefox 1.0","A","1.7"],["Win 98+ / OSX.2+","Gecko","Firefox 1.5","A","1.8"],["Win 98+ / OSX.2+","Gecko","Firefox 2.0","A","1.8"],["Win 2k+ / OSX.3+","Gecko","Firefox 3.0","A","1.9"]] }';

		wfProfileOut( __METHOD__ );
		return json_encode($result);
	}
}
