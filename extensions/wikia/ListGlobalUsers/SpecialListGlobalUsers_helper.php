<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jarek Cellary
 * @version: $Id$
 */

use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Permissions\PermissionsService;
use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

class ListGlobalUsersData {
	use PermissionsServiceAccessor;

	private $mCityId;
	private $mGroups;
	private $mFilterGroup;
	private $mUserId;
	private $mLimit;
	private $mOffset;
	private $mUseKey;

	const CACHE_VERSION = 'v5';

	function __construct( ) {

		$this->mUseKeyOptions = array(
			'groups' 	=> '',
		);
	}

	function load() {
		$this->setLimit();
		$this->setOffset();
		$this->loadGroups();
	}

	function setFilterGroup ( $group = array() ) { $this->mFilterGroup = $group; }
	function getFilterGroup () { return $this->mFilterGroup; }

	function setUserId	    ( int $user_id ) { $this->mUserId = $user_id; }
	function setLimit    	( $limit = ListGlobalUsers::DEF_LIMIT ) { $this->mLimit = $limit; }
	function setOffset   	( $offset = 0 ) { $this->mOffset = $offset; }

	function getGroups   	() { return $this->mGroups; }

	public function loadData()
	{
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$context = RequestContext::getMain();
		$lang = $context->getLanguage();

		$subMemkey = array(
			'G'  . implode(",", is_array($this->mFilterGroup) ? $this->mFilterGroup : array()),
			'U'  . $this->mUserId,
			'O'  . $this->mOffset,
			'L'  . $this->mLimit,
			'L'  . $lang->getCode(), // localized messages are cached, vary by user language
		);

		$memkey = wfForeignMemcKey( $this->mCityId, __CLASS__, self::CACHE_VERSION, md5( implode(', ', $subMemkey) ) );
		$cached = $wgMemc->get($memkey);

		if ( empty($cached) ) {
			$data = $this->doLoadData( $context, $lang );

			// BugId:12643 - We DO NOT want to cache empty arrays.
			if ( !empty( $data ) ) {
				$wgMemc->set( $memkey, $data, 60*60 );
			}

		} else {
			$data = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}

	private function doLoadData( RequestContext $context, $lang ) {
		$user = $context->getUser();

		$groups = is_array( $this->mFilterGroup ) ?
			$this->mFilterGroup :
			$this->permissionsService->getConfiguration()->getGlobalGroups();

		$usersInGroups = $this->permissionsService->getUsersInGroups( $groups );
		$data = [];

		if ( count( $usersInGroups ) > 0 ) {
			$userIsBlocked = $user->isBlocked( true, false );
			$sk = $context->getSkin();

			foreach ( $usersInGroups as $userId => $userGroups ) {
				// SUS-2772: don't do a DB query for every row
				$oUser = User::newFromId( $userId );

				/* groups */
				$groups = explode(";", $userGroups);
				$group = "<i>" . wfMsg('listGlobalUsers-nonegroup') . "</i>";
				if ( !empty( $groups ) ) {
					$group = implode(", ", $groups);
				}

				$oEncUserName = urlencode( $oUser->getName() );

				$links = array (
					0 => "",
					1 => $sk->makeLinkObj(
						Title::newFromText( 'Contributions', NS_SPECIAL ),
						$lang->ucfirst( wfMsg('contribslink') ),
						"target={$oEncUserName}"
					),
					2 => $sk->makeLinkObj(
						Title::newFromText( 'Editcount', NS_SPECIAL ),
						$lang->ucfirst( wfMsg('listGlobalUsersedits') ),
						"username={$oEncUserName}"
					)
				);

				global $wgEnableWallExt;
				if(!empty($wgEnableWallExt)) {
					$oUTitle = Title::newFromText($oUser->getName(), NS_USER_WALL);
					$msg = 'wall-message-wall-shorten';
				} else {
					$oUTitle = Title::newFromText($oUser->getName(), NS_USER_TALK);
					$msg = 'talkpagelinktext';
				}

				if ( $oUTitle instanceof Title ) {
					$links[0] = $sk->makeLinkObj( $oUTitle, $lang->ucfirst(wfMsg($msg) ) );
				}

				if ( $user->isAllowed( 'block' ) && ( !$userIsBlocked ) ) {
					$links[] = $sk->makeLinkObj(
						Title::newFromText( "BlockIP/{$oUser->getName()}", NS_SPECIAL ),
						$lang->ucfirst( wfMsg('blocklink') )
					);
				}
				if ( $user->isAllowed( 'userrights' ) && ( !$userIsBlocked ) ) {
					$links[] = $sk->makeLinkObj(
						Title::newFromText( 'UserRights', NS_SPECIAL ),
						$lang->ucfirst( wfMsg('listgrouprights-rights') ),
						"user={$oEncUserName}"
					);
				};

				$data[ 'data' ][ $userId ] = array(
					'user_id' 			=> $userId,
					'user_name' 		=> $oUser->getName(),
					'user_link'			=> $sk->makeLinkObj($oUser->getUserPage(), $oUser->getName()),
					'groups_nbr' 		=> count( $userGroups ),
					'groups' 			=> $group,
					'rev_cnt' 			=> 0, //TODO
					'blcked'			=> false, //TODO $oRow->user_is_blocked,
					'links'				=> "(" . implode( ") &#183; (", $links ) . ")",
					'last_edit_page' 	=> null,
					'last_edit_diff'	=> null,
					'last_edit_ts'		=> "" //TODO remove
				);
			}
		}
		return $data;
	}

	private $statsDB;

	private function getStatsDB() {
		if ( empty( $statDB ) ) {

			global $wgDWStatsDB;
			$this->statsDB = wfGetDB( DB_SLAVE, array(), $wgDWStatsDB );
		}
		return $this->statsDB;
	}

	private function getUserEdits( $wikiId, $userIds ) {
		$dbs = $this->getStatsDB();

		$result = $dbs->select(
			array( 'rollup_wiki_user_events' ),
			array( 'user_id', 'SUM(edits) as edits' ),
			array(
				'period_id' => DataMartService::PERIOD_ID_MONTHLY,
				'wiki_id' => $wikiId,
				'user_id' => $userIds,
			),
			__METHOD__
		);

		$data = [];
		foreach( $result as $row ) {
			$data[] = [
				'user_id' => $row->user_id,
				'edits' => $row->edits
			];
		}
		$dbs->freeResult( $result );

		return $data;
	}

	/*
	 * load all groups for selected Wikis
	 *
	 * @access public
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param
	 */
	private function loadGroups() {
		global $wgContLang, $wgMemc;
		wfProfileIn( __METHOD__ );

		$memkey = wfForeignMemcKey( $this->mCityId, null, ListGlobalUsers::TITLE, "groups", $wgContLang->getCode() );
		$cached = $wgMemc->get($memkey);

		if ( empty ( $cached ) ) {
			$this->mGroups[ ListGlobalUsers::DEF_GROUP_NAME ] = array(
				'name' 	=> wfMsg('listGlobalUsersnogroup'),
				'count' => 0
			);

			global $wgExternalSharedDB;
			$config = $this->permissionsService()->getConfiguration();
			$globalGroups = $config->getGlobalGroups();

			$centralDbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

			ListusersData::loadCountOfUsersInGroups( $centralDbr, $globalGroups, $this->mGroups );
		} else {
			$this->mGroups = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $this->mGroups;
	}
}
