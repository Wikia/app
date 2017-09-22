<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

class ChatBanData extends WikiaModel
{
	use PermissionsServiceAccessor;

	/**
	 * @var string
	 */
	private $cityId;

	/**
	 * @var string
	 */
	private $userName;

	/**
	 * @var int
	 */
	private $limit;

	/**
	 * @var int
	 */
	private $offset;

	/**
	 * @var string
	 */
	private $order;

	/**
	 * @var array
	 */
	private $orderOptions;

	/**
	 * @var string
	 */
	private $db;

	/**
	 * @var string
	 */
	private $table;


	function __construct( $city_id, $load = 1 ) {
		parent::__construct();

		$this->cityId = $city_id;
		$this->db = $this->getDatawareDB();
		$this->table = 'chat_ban_users';

		$this->orderOptions = [
			'timestamp' => 'start_date %s',
			'target'    => 'cbu_user_id %s',
			'expires'   => 'end_date %s',
			'blockedBy' => 'cbu_admin_user_id %s',
		];

		if ( $load == 1 ) {
			$this->load();
		}
	}

	function load() {
		$this->setLimit();
		$this->setOffset();
		$this->setOrder();
	}

	function setUserName( $username = '' ) { $this->userName = $username; }

	function setLimit( $limit = Listusers::DEF_LIMIT ) { $this->limit = $limit; }

	function setOffset( $offset = 0 ) { $this->offset = $offset; }

	function setOrder( $order = '' ) {
		if ( empty( $order ) ) {
			// default order
			$order = 'timestamp:desc';
		}

		$validSortDirections = [
			'asc',
			'desc',
		];

		list ( $orderName, $orderDesc ) = explode( ":", $order );
		if ( isset( $this->orderOptions[ $orderName ] ) && in_array( $orderDesc, $validSortDirections ) ) {
			$this->order = sprintf( $this->orderOptions[ $orderName ], $orderDesc );
		}
	}

	function getUserName() { return $this->userName; }

	function getLimit() { return $this->limit; }

	function getOffset() { return $this->offset; }

	function getOrder() { return $this->order; }

	public function loadData() {

		wfProfileIn( __METHOD__ );

		/* initial values for result */
		$data = [
			'cnt'      => 0,
			'sColumns' => 'timestamp,target,expires,blockedBy,reason',
			'data'     => [ ],
		];

		/* initial conditions for SQL query */
		$where = [
			'cbu_wiki_id' => $this->cityId,
			"cbu_user_id != ''",
			"end_date > '" . wfTimestamp( TS_MW ) . "'",
		];

		/* filter: user name */
		$userId = User::IdFromName( $this->userName );

		if ( $userId !== null ) {
			$where[] = " cbu_user_id = " . $this->db->addQuotes( $userId );
		}

		/* number of records */
		$row = $this->db->selectRow(
			$this->table,
			[ 'count(0) as cnt' ],
			$where,
			__METHOD__
		);
		if ( is_object( $row ) ) {
			$data['cnt'] = $row->cnt;
		}

		if ( $data['cnt'] > 0 ) {
			/* select records */
			$oRes = $this->db->select(
				[
					$this->table,
				],
				[
					'start_date',
					'cbu_user_id',
					'end_date',
					'cbu_admin_user_id',
					'reason',
				],
				$where,
				__METHOD__,
				[
					'ORDER BY' => $this->order,
					'LIMIT'    => $this->limit,
					'OFFSET'   => intval( $this->offset ),
				]
			);

			$data['data'] = [ ];
			while ( $row = $this->db->fetchObject( $oRes ) ) {

				$user = User::newFromId( $row->cbu_user_id );
				$admin = User::newFromId( $row->cbu_admin_user_id );

				$data['data'][] = [
					'timestamp'    => $this->wg->Lang->timeanddate( $row->start_date, true ),
					'user'         => Linker::link( $user->getUserPage(), $user->getName() ),
					'user_actions' => $this->getUserLinks( $user ),
					'expires'      => $this->wg->Lang->formatExpiry( $row->end_date, true ),
					'admin_user'   => Linker::link( $admin->getUserPage(), $admin->getName() ),
					'admin_links'  => $this->getUserLinks( $admin ),
					'reason'       => Linker::commentBlock( $row->reason ),
				];

			}
			$this->db->freeResult( $oRes );

		}

		wfProfileOut( __METHOD__ );

		return $data;
	}

	private function getUserLinks( $user ) {

		$userIsBlocked = $this->wg->User->isBlocked( true, false );
		$username = $user->getName();
		$links = [
			0 => "",
			1 => Linker::link(
				SpecialPage::getSafeTitleFor( 'Contributions', $username ),
				wfMessage( 'contribslink' )->text()
			),
		];

		if ( !empty( $this->wg->EnableWallExt ) ) {
			$oUTitle = Title::newFromText( $username, NS_USER_WALL );
			$msg = 'wall-message-wall-shorten';
		} else {
			$oUTitle = Title::newFromText( $username, NS_USER_TALK );
			$msg = 'talkpagelinktext';
		}

		if ( $oUTitle instanceof Title ) {
			$links[0] = Linker::link( $oUTitle, wfMessage( $msg )->text() );
		}

		if ( $this->wg->User->isAllowed( 'block' ) && ( !$userIsBlocked ) ) {
			$links[] = Linker::link(
				SpecialPage::getSafeTitleFor( 'Block', $username ),
				wfMessage( 'blocklink' )->text()
			);
		}
		if ( $this->wg->User->isAllowed( 'userrights' ) && ( !$userIsBlocked ) ) {
			$links[] = Linker::link(
				SpecialPage::getSafeTitleFor( 'UserRights', $username ),
				wfMessage( 'listgrouprights-rights' )->text()
			);
		}

		return "(" . implode( ") &#183; (", $links ) . ")";
	}

}
