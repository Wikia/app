<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

class ChatBanData
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
	 * @var Object
	 */
	private $skin;

	/**
	 * Database
	 * @var string
	 */
	private $db;

	/**
	 * @var string
	 */
	private $table;


	function __construct( $city_id, $load = 1 ) {
		global $wgExternalDatawareDB;

		$this->cityId = $city_id;
		$this->db = $wgExternalDatawareDB;
		$this->table = 'chat_ban_users';
		$this->skin = RequestContext::getMain()->getskin();

		$this->orderOptions = [
			'timestamp' => [ 'start_date %s' ],
			'target'    => [ 'cbu_user_id %s' ],
			'expires'   => [ 'end_date %s' ],
			'blockedBy' => [ 'cbu_admin_user_id %s' ],
			'reason'    => [ 'reason %s' ],
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

	function setOrder( $orders = [ ] ) {
		if ( empty( $orders ) || !is_array( $orders ) ) {
			$orders = [ Listusers::DEF_ORDER ];
		}

		$validSortDirections = [
			'asc',
			'desc',
		];

		# order by
		$this->order = [ ];
		foreach ( $orders as $order ) {
			list ( $orderName, $orderDesc ) = explode( ":", $order );
			if ( isset( $this->orderOptions[ $orderName ] ) && in_array( $orderDesc, $validSortDirections ) ) {
				foreach ( $this->orderOptions[ $orderName ] as $orderStr ) {
					$this->order[] = sprintf( $orderStr, $orderDesc );
				}
			}
		}
		if ( empty( $this->order ) ) {
			$this->order[] = 'start_date DESC';
		}
	}

	function getUserName() { return $this->userName; }

	function getLimit() { return $this->limit; }

	function getOffset() { return $this->offset; }

	function getOrder() { return $this->order; }

	public function loadData() {
		global $wgMemc, $wgLang;
		wfProfileIn( __METHOD__ );

		/* initial values for result */
		$data = [
			'cnt'      => 0,
			'sColumns' => implode( ",", array_keys( $this->orderOptions ) ),
			'data'     => [ ],
		];

		$orderBy = implode( ",", $this->order );
		$subMemkey = [
			'O' . $this->offset,
			'O' . $orderBy,
			'L' . $this->limit,
			'U' . $this->userName,
		];

		$memkey = wfForeignMemcKey( $this->cityId, null, "cbdata", md5( implode( ', ', $subMemkey ) ) );
		$cached = $wgMemc->get( $memkey );

		if ( empty( $cached ) ) {
			/* db handle */
			$dbs = wfGetDB( DB_SLAVE, [ ], $this->db );

			/* initial conditions for SQL query */
			$where = [
				'cbu_wiki_id' => $this->cityId,
				"cbu_user_id != ''",
				"end_date > '" . wfTimestamp( TS_MW ) . "'",
			];

			/* filter: user name */
			$userId = User::IdFromName( $this->userName );

			if ( $userId !== null ) {
				$where[] = " cbu_user_id = " . $dbs->addQuotes( $userId );
			}

			/* number of records */
			$row = $dbs->selectRow(
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
				$oRes = $dbs->select(
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
						'ORDER BY' => $orderBy,
						'LIMIT'    => $this->limit,
						'OFFSET'   => intval( $this->offset ),
					]
				);

				$data['data'] = [ ];
				while ( $row = $dbs->fetchObject( $oRes ) ) {

					$user = User::newFromId( $row->cbu_user_id );
					$admin = User::newFromId( $row->cbu_admin_user_id );

					$data['data'][] = [
						'timestamp'    => $wgLang->timeanddate( $row->start_date, true ),
						'user'         => $this->skin->link( $user->getUserPage(), $user->getName() ),
						'user_actions' => $this->getUserLinks( $user ),
						'expires'      => $wgLang->formatExpiry( $row->end_date, true ),
						'admin_user'   => $this->skin->link( $admin->getUserPage(), $admin->getName() ),
						'admin_links'  => $this->getUserLinks( $admin ),
						'reason'       => Linker::commentBlock( $row->reason ),
					];

				}
				$dbs->freeResult( $oRes );

				if ( !empty( $data ) ) {
					$wgMemc->set( $memkey, $data, 60 * 60 );
				}
			}
		} else {
			$data = $cached;
		}

		wfProfileOut( __METHOD__ );

		return $data;
	}

	private function getUserLinks( $user ) {
		global $wgLang, $wgUser;

		$userIsBlocked = $wgUser->isBlocked( true, false );
		$this->skin = RequestContext::getMain()->getskin();
		$oEncUserName = urlencode( $user->getName() );
		$links = [
			0 => "",
			1 => $this->skin->link(
				Title::newFromText( 'Contributions', NS_SPECIAL ),
				$wgLang->ucfirst( wfMsg( 'contribslink' ) ),
				"target={$oEncUserName}"
			),
		];

		global $wgEnableWallExt;
		if ( !empty( $wgEnableWallExt ) ) {
			$oUTitle = Title::newFromText( $user->getName(), NS_USER_WALL );
			$msg = 'wall-message-wall-shorten';
		} else {
			$oUTitle = Title::newFromText( $user->getName(), NS_USER_TALK );
			$msg = 'talkpagelinktext';
		}

		if ( $oUTitle instanceof Title ) {
			$links[0] = $this->skin->link( $oUTitle, $wgLang->ucfirst( wfMsg( $msg ) ) );
		}

		if ( $wgUser->isAllowed( 'block' ) && ( !$userIsBlocked ) ) {
			$links[] = $this->skin->link(
				Title::newFromText( "BlockIP/{$user->getName()}", NS_SPECIAL ),
				$wgLang->ucfirst( wfMsg( 'blocklink' ) )
			);
		}
		if ( $wgUser->isAllowed( 'userrights' ) && ( !$userIsBlocked ) ) {
			$links[] = $this->skin->link(
				Title::newFromText( 'UserRights', NS_SPECIAL ),
				$wgLang->ucfirst( wfMsg( 'listgrouprights-rights' ) ),
				"user={$oEncUserName}"
			);
		};

		return "(" . implode( ") &#183; (", $links ) . ")";
	}

}
