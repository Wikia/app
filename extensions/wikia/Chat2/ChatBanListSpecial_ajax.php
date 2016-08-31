<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */
class ChatBanListAjax
{

	/**
	 * ajax response for request params
	 *
	 */
	public static function axShowUsers() {
		global $wgRequest, $wgUser, $wgCityId;

		wfProfileIn( __METHOD__ );

		$username = $wgRequest->getVal( 'username' );
		$limit = $wgRequest->getVal( 'limit' );
		$offset = $wgRequest->getVal( 'offset' );
		$loop = $wgRequest->getVal( 'loop' );
		$order = $wgRequest->getVal( 'order' );

		$result = [
			'sEcho'                => intval( $loop ),
			'iTotalRecords'        => 0,
			'iTotalDisplayRecords' => 0,
			'sColumns'             => '',
			'aaData'               => [],
		];

		if ( is_object( $wgUser ) ) {

			$records = [];
			$data = new ChatBanData( $wgCityId, 0 );
			if ( is_object( $data ) ) {
				$data->setUserName( $username );
				$data->setLimit( $limit );
				$data->setOffset( $offset );
				$orders = explode( "|", $order );
				$data->setOrder( $orders );
				$records = $data->loadData();
			}

			if ( !empty( $records ) && is_array( $records ) ) {
				$result = [
					'iTotalRecords'        => intval( $limit ),
					'iTotalDisplayRecords' => intval( $records['cnt'] ),
					'sColumns'             => $records['sColumns'],
				];
				$aaData = [];
				if ( isset( $records['data'] ) ) {
					foreach ( $records['data'] as $record ) {
						$aaData[] = [
							$record['timestamp'],
							$record['user'] . "<br />" . $record['user_actions'],
							$record['expires'],
							$record['admin_user'] . "<br />" . $record['admin_links'],
							$record['reason'],
						];
					}
				}
				$result['aaData'] = $aaData;
			}
		}

		wfProfileOut( __METHOD__ );

		return json_encode( $result );
	}
}
