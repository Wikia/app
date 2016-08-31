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

	private $mCityId;
	private $mUserName;
	private $mLimit;
	private $mOffset;
	private $mOrder;
	private $mOrderOptions;
	private $sk;
	private $mDBh;
	private $mTable;

	function __construct( $city_id, $load = 1 ) {
		global $wgExternalDatawareDB;

		$this->mCityId = $city_id;
		$this->mDBh = $wgExternalDatawareDB;
		$this->mTable = 'chat_ban_users';
		$this->sk = RequestContext::getMain()->getSkin();

		$this->mOrderOptions = [
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

	function setUserName( $username = '' ) { $this->mUserName = $username; }

	function setLimit( $limit = Listusers::DEF_LIMIT ) { $this->mLimit = $limit; }

	function setOffset( $offset = 0 ) { $this->mOffset = $offset; }

	function setOrder( $orders = [] ) {
		if ( empty( $orders ) || !is_array( $orders ) ) {
			$orders = [ Listusers::DEF_ORDER ];
		}

		$validSortDirections = [
			'asc',
			'desc',
		];

		# order by
		$this->mOrder = [];
		if ( !empty( $orders ) ) {
			foreach ( $orders as $order ) {
				list ( $orderName, $orderDesc ) = explode( ":", $order );
				if ( isset( $this->mOrderOptions[ $orderName ] ) && in_array( $orderDesc, $validSortDirections ) ) {
					foreach ( $this->mOrderOptions[ $orderName ] as $orderStr ) {
						$this->mOrder[] = sprintf( $orderStr, $orderDesc );
					}
				}
			}
		}
		if ( empty( $this->mOrder ) ) {
			$this->mOrder[] = 'start_date DESC';
		}
	}

	function getUserName() { return $this->mUserName; }

	function getLimit() { return $this->mLimit; }

	function getOffset() { return $this->mOffset; }

	function getOrder() { return $this->mOrder; }

	public function loadData() {
		global $wgMemc, $wgLang;
		wfProfileIn( __METHOD__ );

		/* initial values for result */
		$data = [
			'cnt'      => 0,
			'sColumns' => implode( ",", array_keys( $this->mOrderOptions ) ),
			'data'     => [],
		];

		$orderby = implode( ",", $this->mOrder );
		$subMemkey = [
			'O' . $this->mOffset,
			'O' . $orderby,
			'L' . $this->mLimit,
			'U' . $this->mUserName,
		];

		$memkey = wfForeignMemcKey( $this->mCityId, null, "cbdata", md5( implode( ', ', $subMemkey ) ) );
		$cached = $wgMemc->get( $memkey );

		if ( empty( $cached ) ) {
			/* db handle */
			$dbs = wfGetDB( DB_SLAVE, [], $this->mDBh );

			/* initial conditions for SQL query */
			$where = [
				'cbu_wiki_id' => $this->mCityId,
				"cbu_user_id != ''",
				"end_date > '" . wfTimestamp( TS_MW ) . "'",
			];

			/* filter: user name */
			$user = User::newFromName( $this->mUserName );
			if ( $user instanceof User ) {
				$where[] = " cbu_user_id = " . $dbs->addQuotes( $user->getId() );
			}

			/* number of records */
			$oRow = $dbs->selectRow(
				$this->mTable,
				[ 'count(0) as cnt' ],
				$where,
				__METHOD__
			);
			if ( is_object( $oRow ) ) {
				$data['cnt'] = $oRow->cnt;
			}

			if ( $data['cnt'] > 0 ) {
				/* select records */
				$oRes = $dbs->select(
					[
						$this->mTable,
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
						'ORDER BY' => $orderby,
						'LIMIT'    => $this->mLimit,
						'OFFSET'   => intval( $this->mOffset ),
					]
				);

				$data['data'] = [];
				while ( $oRow = $dbs->fetchObject( $oRes ) ) {

					$oUser = User::newFromId( $oRow->cbu_user_id );
					$oAdmin = User::newFromId( $oRow->cbu_admin_user_id );

					$data['data'][] = [
						'timestamp'    => $wgLang->timeanddate( $oRow->start_date, true ),
						'user'         => $this->sk->link( $oUser->getUserPage(), $oUser->getName() ),
						'user_actions' => $this->getUserLinks( $oUser ),
						'expires'      => $wgLang->formatExpiry( $oRow->end_date, true ),
						'admin_user'   => $this->sk->link( $oAdmin->getUserPage(), $oAdmin->getName() ),
						'admin_links'  => $this->getUserLinks( $oAdmin ),
						'reason'       => Linker::commentBlock( $oRow->reason ),
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

	private function getUserLinks( $oUser ) {
		global $wgLang, $wgUser;

		$userIsBlocked = $wgUser->isBlocked( true, false );
		$this->sk = RequestContext::getMain()->getSkin();
		$oEncUserName = urlencode( $oUser->getName() );
		$links = [
			0 => "",
			1 => $this->sk->link(
				Title::newFromText( 'Contributions', NS_SPECIAL ),
				$wgLang->ucfirst( wfMsg( 'contribslink' ) ),
				"target={$oEncUserName}"
			),
		];

		global $wgEnableWallExt;
		if ( !empty( $wgEnableWallExt ) ) {
			$oUTitle = Title::newFromText( $oUser->getName(), NS_USER_WALL );
			$msg = 'wall-message-wall-shorten';
		} else {
			$oUTitle = Title::newFromText( $oUser->getName(), NS_USER_TALK );
			$msg = 'talkpagelinktext';
		}

		if ( $oUTitle instanceof Title ) {
			$links[0] = $this->sk->link( $oUTitle, $wgLang->ucfirst( wfMsg( $msg ) ) );
		}

		if ( $wgUser->isAllowed( 'block' ) && ( !$userIsBlocked ) ) {
			$links[] = $this->sk->link(
				Title::newFromText( "BlockIP/{$oUser->getName()}", NS_SPECIAL ),
				$wgLang->ucfirst( wfMsg( 'blocklink' ) )
			);
		}
		if ( $wgUser->isAllowed( 'userrights' ) && ( !$userIsBlocked ) ) {
			$links[] = $this->sk->link(
				Title::newFromText( 'UserRights', NS_SPECIAL ),
				$wgLang->ucfirst( wfMsg( 'listgrouprights-rights' ) ),
				"user={$oEncUserName}"
			);
		};

		return "(" . implode( ") &#183; (", $links ) . ")";
	}

}
