<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

class ChatBanData extends ContextSource {
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


	public function __construct( int $cityId, $load = 1 ) {
		global $wgExternalDatawareDB;

		$this->cityId = $cityId;
		$this->db = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
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

	public function load() {
		$this->setLimit();
		$this->setOffset();
		$this->setOrder();
	}

	public function setUserName( $username = '' ) { $this->userName = $username; }

	public function setLimit( $limit = Listusers::DEF_LIMIT ) { $this->limit = $limit; }

	public function setOffset( $offset = 0 ) { $this->offset = $offset; }

	public function setOrder( $order = '' ) {
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

	public function getUserName() { return $this->userName; }

	public function getLimit() { return $this->limit; }

	public function getOffset() { return $this->offset; }

	public function getOrder() { return $this->order; }

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
			$lang = $this->getLanguage();

			foreach ( $oRes as $row ) {
				$user = User::newFromId( $row->cbu_user_id );
				$admin = User::newFromId( $row->cbu_admin_user_id );

				$data['data'][] = [
					'timestamp'    => $lang->timeanddate( $row->start_date, true ),
					'user'         => Linker::link( $user->getUserPage(), $user->getName() ),
					'user_actions' => $this->getUserLinks( $user ),
					'expires'      => $lang->formatExpiry( $row->end_date, true ),
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

	private function getUserLinks( User $user ) {
		$viewingUser = $this->getUser();
		$userIsBlocked = $viewingUser->isBlocked( true, false );
		$userName = $user->getName();

		$links = [];

		$talkPage = $user->getTalkPage();
		$msg = $talkPage->inNamespace( NS_USER_TALK ) ? 'talkpagelinktext' : 'wall-message-wall-shorten';
		$links[] = Linker::link(
			$talkPage,
			$this->msg( $msg )->escaped()
		);

		$links[] = Linker::link(
			SpecialPage::getSafeTitleFor( 'Contributions', $userName ),
			$this->msg( 'contribslink' )->escaped()
		);

		if ( !$userIsBlocked ) {
			if ( $viewingUser->isAllowed( 'block' ) ) {
				$links[] = Linker::link(
					SpecialPage::getSafeTitleFor( 'Block', $userName ),
					$this->msg( 'blocklink' )->escaped()
				);
			}

			$links[] = Linker::link(
				SpecialPage::getSafeTitleFor( 'Userrights', $userName ),
				$this->msg( 'listgrouprights-rights' )->escaped()
			);
		}

		return "(" . implode( ") &#183; (", $links ) . ")";
	}

}
