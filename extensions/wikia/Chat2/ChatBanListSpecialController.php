<?php

/**
 * Controller for Wikia's Special:ChatBanList
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @author Kuba Karminski <jkarminski@wikia-inc.com> for Wikia.com
 *
 */
class ChatBanListSpecialController extends WikiaSpecialPageController
{

	function __construct() {
		parent::__construct( 'ChatBanList', 'chatbanlist' );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$out = $this->getOutput();
		$out->addModules( 'ext.Chat2.ChatBanList' );
		$out->setPageTitle( $this->msg( 'chatbanlist' )->text() );
		$out->setRobotPolicy( 'noindex,nofollow' );
		$out->setArticleRelated( false );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * ajax response for request params
	 *
	 */
	public function axShowUsers() {

		wfProfileIn( __METHOD__ );

		$username = $this->getVal( 'username' );
		$limit = $this->request->getVal( 'limit' );
		$offset = $this->request->getVal( 'offset' );
		$loop = $this->request->getVal( 'loop' );
		$order = $this->request->getVal( 'order' );


		/*
		 * initial values for response
		 */
		$result = [
			'sEcho'                => intval( $loop ),
			'iTotalRecords'        => 0,
			'iTotalDisplayRecords' => 0,
			'aaData'               => [],
		];


		$records = [];
		$data = new ChatBanData( $this->wg->cityId, 0 );
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

			if ( isset( $records['data'] ) ) {
				foreach ( $records['data'] as $record ) {
					$result['aaData'] [] = [
						$record['timestamp'],
						$record['user'] . "<br />" . $record['user_actions'],
						$record['expires'],
						$record['admin_user'] . "<br />" . $record['admin_links'],
						$record['reason'],
					];
				}
			}
		}

		$this->response->setFormat('json');
		$this->response->setValues($result);

		wfProfileOut(__METHOD__);

	}

}

