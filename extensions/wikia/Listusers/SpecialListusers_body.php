<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) { 
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ; 
}

class ListUsers extends SpecialPage {
	private $mTitle;
	private $mGroup;
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "ListUsers"  /*class*/, 'listusers' /*restriction*/);
		wfLoadExtensionMessages("ListUsers");
	}
	
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( 'listusers' ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		/**
		 * initial output
		 */
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'ListUsers' );
		$wgOut->setPageTitle( wfMsg('listuserstitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$target = $wgRequest->getVal('target');

		if (!empty($target)) { 
			if ( strpos($target, ",") !== false )  {
				$this->mGroup = explode(",", $target);
			} else {
				$this->mGroup = array($target);
			}
		} else {
			if ( !empty($subpage) ) {
				if ( strpos($subpage, ",") !== false )  {
					$this->mGroup = explode(",", $subpage);
				} else {
					$this->mGroup = array($subpage);
				}
			} 
		}

		if (empty($this->mGroup)) {
			$this->mGroup = array('all');
		}

		/**
		 * show form
		 */
		$this->showForm();
		#$this->showArticleList();
	}

	/* draws the form itself  */
	function showForm ($error = "") {
		global $wgOut, $wgContLang;
		global $wgExtensionsPath;
        wfProfileIn( __METHOD__ );
		$action = $this->mTitle->escapeLocalURL("");
		$aGroups = $this->getAllGroups();
		$groupList = $this->getGroupList($aGroups);
		$contributed = array( 
			0 => wfMsg('listusersallusers'),
			5 => wfMsg('listusers-5contributions'),
			10 => wfMsg('listusers-10contributions'),
			20 => wfMsg('listusers-20contributions'),
			50 => wfMsg('listusers-50contributions'),
			100 => wfMsg('listusers-100contributions')
		);

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
			"error"				=> $error,
            "action"			=> $action,
            "groupList"			=> $groupList,
            "aGroups"			=> $aGroups,
            "mGroup"			=> $this->mGroup,
            "contributed"		=> $contributed,
            "wgContLang"		=> $wgContLang,
            "wgExtensionsPath" 	=> $wgExtensionsPath, 
            "selContrib"		=> 5
        ));
        $wgOut->addHTML( $oTmpl->execute("main-form") );
        wfProfileOut( __METHOD__ );
	}
	
	function getResults() {
		global $wgOut, $wgRequest ;
        wfProfileIn( __METHOD__ );

		/* no list when no user */
		if (empty($this->mTag)) {
			wfProfileOut( __METHOD__ );
			return false ;
		}

		/* before, we need that numResults */
        wfProfileOut( __METHOD__ );
	}
	
	private function getGroupList( $aGroups ) {
		global $wgMemc, $wgSharedDB;
		global $wgCityId;
        wfProfileIn( __METHOD__ );
		$aResult = array();
		$memkey = wfForeignMemcKey( $wgSharedDB, null, "getGroupList");
		$cached = "";#$wgMemc->get($memkey);
		if (!is_array ($cached)) { 
			$dbs = wfGetDBExt();
			if (!is_null($dbs)) {
				$aQuery = array();
				if (!empty($aGroups) && is_array($aGroups)) {
					$aQuery[] = "select '' as groupName, count(*) as cnt from `dataware`.`city_local_users` where lu_wikia_id = {$wgCityId} and lu_numgroups = 0 ";
					foreach ($aGroups as $groupName => $userGroupName) {
						$aQuery[] = "select '{$groupName}' as groupName, count(*) as cnt from `dataware`.`city_local_users` where lu_wikia_id = {$wgCityId} and lu_allgroups like '%{$groupName}%' group by groupName";
					}
				}
				if (!empty($aQuery)) {
					$query = implode(' union ', $aQuery);
					$res = $dbs->query ($query);
					while ($row = $dbs->fetchObject($res)) {
						$aResult[(empty($row->groupName)) ? "all" : $row->groupName] = $row->cnt;
					}
					$dbs->freeResult($res);
					$wgMemc->set( $memkey, $aResult, 60*60 );
				}
			}
		} else { 
			$aResult = $cached;
		}
		
        wfProfileOut( __METHOD__ );
		return $aResult;
	}
	
	private function getAllGroups() {
		wfProfileIn( __METHOD__ );
		$aResult = array('all' => wfMsg('listusersnogroup'));
		foreach( User::getAllGroups() as $group ) {
			$aResult[$group] = User::getGroupName($group);
		}
		wfProfileOut( __METHOD__ );
		return $aResult;
	}

	public function getRedirect() {
		// todo
	}
	
	private static function __getUsersFromDB($groups, $text = "", $contrib = 0, $limit = 30, $offset = 0) {
		global $wgMemc, $wgSharedDB, $wgDBStats;
		global $wgCityId, $wgLang;
		global $wgUser;
        wfProfileIn( __METHOD__ );
		
		$aUsers = array('cnt' => 0, 'data' => array());
		$memkey = wfForeignMemcKey( $wgSharedDB, null, "ListUsers", "articles", str_replace(" ", "_", $groups.$text.$contrib.$offset) );
		$cached = ""; #$wgMemc->get($memkey);
		if (!is_array ($cached)) { 
			$dbs = wfGetDBExt();
			if (!is_null($dbs)) {
				$aGroups = array(); 
				$aWhere = array(" lu_wikia_id = {$wgCityId} ");
				
				if (!empty($groups)) {
					$aGroups = explode(",", $groups);
					if ( !empty($aGroups) && is_array($aGroups) ) {
						$whereGroup = array();
						foreach ($aGroups as $id => $sGroup) {
							if (!empty($sGroup)) {
								if ($sGroup == 'all') {
									$whereGroup[] = " lu_allgroups = '' ";
								} else {
									$whereGroup[] = " lu_allgroups like '%".$dbs->escapeLike($sGroup)."%' ";
								}
							} 
						}
						if (!empty($whereGroup) && is_array($whereGroup)) {
							$aWhere[] = implode(" or ", $whereGroup);
						}
					}
				}
				
				if (!empty($text)) {
					$aWhere[] = " lu_user_name like '".$dbs->escapeLike($text)."%' ";
				}

				if (!empty($contrib)) {
					$aWhere[] = " lu_rev_cnt >= ".intval($contrib);
				}
				
				$res = $dbs->select(
					array ( '`dataware`.`city_local_users`' ),
					array ( "lu_user_id", "lu_user_name", "lu_numgroups", "lu_allgroups", "lu_rev_cnt", "lu_blocked" ),
					$aWhere,
					__METHOD__,
					array ( 'ORDER BY' => 'lu_user_name', 'LIMIT' => $limit, 'OFFSET' => intval($offset) * $limit, 'SQL_CALC_FOUND_ROWS' )
				);
				$sk = $wgUser->getSkin();

				while ( $oRow = $dbs->fetchObject( $res ) ) {
					$oUser = User::newFromName($oRow->lu_user_name);
					$__groups = explode(";", $oRow->lu_allgroups);
					$sGroups = "<i>".wfMsg('listusers-nonegroup')."</i>";
					if ( !empty($__groups) && is_array($__groups) ) {
						$sGroups = implode(", ", $__groups);
					}
					
					$aLinks = array (
						0 => $sk->makeLinkObj(Title::newFromText('Contributions', NS_SPECIAL), $wgLang->ucfirst(wfMsg('contribslink')), "target={$oUser->getName()}"),
						1 => $sk->makeLinkObj(Title::newFromText("Editcount/{$oUser->getName()}", NS_SPECIAL), $wgLang->ucfirst(wfMsg('listusersedits')), ""),
						2 => $sk->makeLinkObj(Title::newFromText("BlockIP/{$oUser->getName()}", NS_SPECIAL), $wgLang->ucfirst(wfMsg('blocklink'))),
						3 => $sk->makeLinkObj(Title::newFromText('UserRights', NS_SPECIAL), $wgLang->ucfirst(wfMsg('listgrouprights-rights')), "user={$oUser->getName()}"),
					);
					
					$aUsers['data'][$oRow->lu_user_id] = array(
						'user_id' 		=> $oRow->lu_user_id,
						'user_name' 	=> $oRow->lu_user_name,
						'user_link'		=> $sk->makeLinkObj($oUser->getUserPage(), $oUser->getName()),
						'groups_nbr' 	=> $oRow->lu_numgroups,
						'groups' 		=> $sGroups,
						'rev_cnt' 		=> $oRow->lu_rev_cnt,
						'blcked'		=> $oRow->lu_blocked,
						'links'			=> "(" . implode(") &#183; (", $aLinks) . ")",
					);
				}
				$dbs->freeResult( $res );

				# nbr all records 
				$res = $dbs->query('SELECT FOUND_ROWS() as rowcount');
				$oRow = $dbs->fetchObject ( $res );
				$aUsers['cnt'] = $oRow->rowcount;
				$dbs->freeResult( $res );
				
				# last logged in 
				$aWhere = array();
				if ( !empty($aUsers['data']) && is_array($aUsers['data']) ) {
					$aWhere = array( " user_id in (". $dbs->makeList( array_keys($aUsers['data']) ).") " );
					$res = $dbs->select(
						array( '`dataware`.`user_login_history`' ),
						array( "user_id", "max(ulh_timestamp) as ts" ),
						$aWhere,
						__METHOD__,
						array( 'GROUP BY' => 'user_id' )
					);
					while ( $oRow = $dbs->fetchObject( $res ) ) {
						if (isset($aUsers['data'][$oRow->user_id])) {
							$aUsers['data'][$oRow->user_id]['last_login'] = $wgLang->timeanddate( wfTimestamp( TS_MW, $oRow->ts ), true );
						}
					}
					$dbs->freeResult( $res );
					
					# last edited 
					$aWhere = array( 
						"rev_wikia_id" => $wgCityId, 
						" rev_user in (". $dbs->makeList( array_keys($aUsers['data']) ).") " 
					);
 					$res = $dbs->select(
						array( '`dataware`.`blobs`' ),
						array( "rev_user as user_id", "rev_page_id", "rev_namespace", "max(rev_timestamp) as ts" ),
						$aWhere,
						__METHOD__,
						array( 'GROUP BY' => 'rev_page_id, rev_namespace' )
					);
					while ( $oRow = $dbs->fetchObject( $res ) ) {
						if (isset($aUsers['data'][$oRow->user_id])) {
							$last_edited = $wgLang->timeanddate( wfTimestamp( TS_MW, $oRow->ts ), true );
							$aUsers['data'][$oRow->user_id]['last_edited'] = $sk->makeLinkObj(Title::newFromId($oRow->rev_page_id), $last_edited);
						}
					}
					$dbs->freeResult( $res );
				}
				
				$wgMemc->set( $memkey, $aUsers, 60*60*3 );
			}
		} else { 
			$aUsers = $cached;
		}
		
        wfProfileOut( __METHOD__ );
		return $aUsers;
	}
	
	public static function axShowUsers ( $groups, $userSearch, $contrib, $limit = 30, $page = 0 ) {
		global $wgRequest, $wgUser,	$wgCityId, $wgDBname;
		global $wgContLang;
		
        wfProfileIn( __METHOD__ );

		if (empty($wgUser)) { 
			return false;
		}

		if ( $wgUser->isBlocked() ) {
			return;
		}
		
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		wfLoadExtensionMessages("ListUsers");

		if( !$wgUser->isAllowed( 'listusers' ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		$result = array('nbr_records' => 0, 'limit' => $limit, 'page' => $page) ;
		$aUsers = self::__getUsersFromDB($groups, $userSearch, $contrib, $limit, $page);
		
		if (!empty($aUsers) && is_array($aUsers)) {
			$result['nbr_records'] = (isset($aUsers['cnt'])) ? intval($aUsers['cnt']) : 0;
			$result['data'] = (isset($aUsers['data'])) ? $aUsers['data'] : "";
		}

		#error_log ("result = ".print_r($result, true) . "\n", 3, "/tmp/moli.log");

        wfProfileOut( __METHOD__ );

		if (!function_exists('json_encode')) {
			$oJson = new Services_JSON();
			return $oJson->encode($result);
		} else {
			return json_encode($result);
		}
	}
}
