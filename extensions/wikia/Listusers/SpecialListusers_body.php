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

class Listusers extends SpecialPage {
	private $mTitle;
	private $mGroup;
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "Listusers"  /*class*/ );
		wfLoadExtensionMessages("Listusers");
	}
	
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		/*if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}*/
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		
		/**
		 * initial output
		 */
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'Listusers' );
		$wgOut->setPageTitle( wfMsg('listuserstitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$target = $wgRequest->getVal('target');
		if (empty($target)) {
			$target = $wgRequest->getVal('group');
		}

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
			$this->mGroup = array('all','bot','sysop','rollback','bureaucrat');
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
			1 => wfMsg('listusers-1contribution'),
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
		$dbs = wfGetDBExt(DB_SLAVE);
		if (!is_null($dbs)) {
			$aQuery = array();
			if (!empty($aGroups) && is_array($aGroups)) {
				$aQuery[] = "select '' as groupName, count(*) as cnt from `dataware`.`city_local_users` where lu_wikia_id = {$wgCityId} and lu_numgroups = 0 and lu_closed = 0 ";
				foreach ($aGroups as $groupName => $userGroupName) {
					$aQuery[] = "select '{$groupName}' as groupName, count(*) as cnt from `dataware`.`city_local_users` where lu_wikia_id = {$wgCityId} and lu_allgroups like '%{$groupName}%' and lu_closed = 0 group by groupName";
				}
			}
			if (!empty($aQuery)) {
				$query = implode(' union ', $aQuery);
				$res = $dbs->query ($query);
				while ($row = $dbs->fetchObject($res)) {
					$aResult[(empty($row->groupName)) ? "all" : $row->groupName] = $row->cnt;
				}
				$dbs->freeResult($res);
			}
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
	
	private static function __getUsersFromDB($groups, $text = "", $contrib = 0, $limit = 30, $offset = 0, $order = 'username', $desc = -1) {
		global $wgMemc, $wgSharedDB, $wgDBStats;
		global $wgCityId, $wgLang;
		global $wgUser, $wgDBname;
        wfProfileIn( __METHOD__ );
		
		$descOrder = ($desc == -1) ? "" : "desc";
		$orderOption = array(
			"username" => "lu_user_name $descOrder",
			"groups" => "lu_allgroups $descOrder, lu_numgroups $descOrder",
			"revcnt" => "lu_rev_cnt $descOrder",
			"loggedin" => "ts $descOrder"
		);
		$orderby = (isset($orderOption[$order])) ? $orderOption[$order] : $orderOption["username"];
		
		$aUsers = array('cnt' => 0, 'data' => array());
		$subMemkey = md5($groups.$text.$contrib.$offset.$limit.$orderby);
		$memkey = wfForeignMemcKey( $wgCityId, null, "Listusers", $subMemkey );
		$cached = $wgMemc->get($memkey);
		if (!is_array ($cached)) { 
			$dbs = wfGetDBExt(DB_SLAVE);
			if (!is_null($dbs)) {
				$aGroups = array(); 
				$aWhere = array(" lu_wikia_id = {$wgCityId} and lu_closed = 0 ");
				
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
					$aWhere[] = " lu_user_name >= ".$dbs->addQuotes($text)." ";
				}

				if (!empty($contrib)) {
					$aWhere[] = " lu_rev_cnt >= ".intval($contrib);
				}
				
				$aTables = array('`dataware`.`city_local_users`');
				$aWhat = array ( "lu_user_id", "lu_user_name", "lu_numgroups", "lu_allgroups", "lu_rev_cnt", "lu_blocked", "'' as ts" );
				if (!$wgUser->isAnon()) {
					$aTables = array ( '`dataware`.`city_local_users` left join `dataware`.`user_login_history` on (lu_user_id = user_id)' );
					$aWhat = array ( "lu_user_id", "lu_user_name", "lu_numgroups", "lu_allgroups", "lu_rev_cnt", "lu_blocked", "ifnull(max(ulh_timestamp), '') as ts" );
				}
				$res = $dbs->select(
					$aTables,
					$aWhat,
					$aWhere,
					__METHOD__,
					array ( 'GROUP BY' => 'lu_user_id', 'ORDER BY' => $orderby, 'LIMIT' => $limit, 'OFFSET' => intval($offset) * $limit, 'SQL_CALC_FOUND_ROWS' )
				);
				$sk = $wgUser->getSkin();

				while ( $oRow = $dbs->fetchObject( $res ) ) {
					$oUser = User::newFromName($oRow->lu_user_name);
					if ( !($oUser instanceof User) ) continue;
					$__groups = explode(";", $oRow->lu_allgroups);
					$sGroups = "<i>".wfMsg('listusers-nonegroup')."</i>";
					if ( !empty($__groups) && is_array($__groups) ) {
						$sGroups = implode(", ", $__groups);
					}


					$aLinks = array (
						0 => "",
						1 => $sk->makeLinkObj(Title::newFromText('Contributions', NS_SPECIAL), $wgLang->ucfirst(wfMsg('contribslink')), "target={$oUser->getName()}"),
						2 => $sk->makeLinkObj(Title::newFromText('Editcount', NS_SPECIAL), $wgLang->ucfirst(wfMsg('listusersedits')), "username={$oUser->getName()}")
					);
					
					$oUserTalkTitle = Title::newFromText($oUser->getName(), NS_USER_TALK);
					if ( !is_null($oUserTalkTitle) && $oUserTalkTitle instanceof Title ) {
						$aLinks[0] = $sk->makeLinkObj($oUserTalkTitle, $wgLang->ucfirst(wfMsg('talkpagelinktext')));
					}
					
					if ( $wgUser->isAllowed( 'block' ) && (!$wgUser->isBlocked()) ) {
						$aLinks[] = $sk->makeLinkObj(Title::newFromText("BlockIP/{$oUser->getName()}", NS_SPECIAL), $wgLang->ucfirst(wfMsg('blocklink')));
					}
					if ( $wgUser->isAllowed( 'userrights' ) && (!$wgUser->isBlocked()) ) {
						$aLinks[] = $sk->makeLinkObj(Title::newFromText('UserRights', NS_SPECIAL), $wgLang->ucfirst(wfMsg('listgrouprights-rights')), "user={$oUser->getName()}");
					};

					$aUsers['data'][$oRow->lu_user_id] = array(
						'user_id' 		=> $oRow->lu_user_id,
						'user_name' 	=> $oRow->lu_user_name,
						'user_link'		=> $sk->makeLinkObj($oUser->getUserPage(), $oUser->getName()),
						'groups_nbr' 	=> $oRow->lu_numgroups,
						'groups' 		=> $sGroups,
						'rev_cnt' 		=> $oRow->lu_rev_cnt,
						'blcked'		=> $oRow->lu_blocked,
						'links'			=> "(" . implode(") &#183; (", $aLinks) . ")",
						'last_login'	=> (!empty($oRow->ts)) ? $wgLang->timeanddate( wfTimestamp( TS_MW, $oRow->ts ), true ) : "",
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
				if ( !empty($aUsers['data']) && is_array($aUsers['data']) && ($wgUser->isLoggedIn()) ) {
					# last edited 
					$dbr = wfGetDB( DB_SLAVE );
					$aWhere = array( 
						"page_id = rev_page",
						" rev_user in (". $dbr->makeList( array_keys($aUsers['data']) ).") ",
					);
 					$res = $dbr->select(
						array( "`$wgDBname`.`revision`, `$wgDBname`.`page` " ),
						array( "rev_user as user_id", "page_id", "page_title", "page_namespace", "max(rev_timestamp) as ts " ),
						$aWhere,
						__METHOD__,
						array( 'GROUP BY' => 'user_id' )
					);
					while ( $oRow = $dbr->fetchObject( $res ) ) {
						if (isset($aUsers['data'][$oRow->user_id])) {
							$last_edited = $wgLang->timeanddate( wfTimestamp( TS_MW, $oRow->ts ), true );
							$aUsers['data'][$oRow->user_id]['last_edited'] = $sk->makeLinkObj(Title::newFromText( $oRow->page_title, $oRow->page_namespace ), $last_edited);
						}
					}
					$dbr->freeResult( $res );
				}

				$wgMemc->set( $memkey, $aUsers, 60*60*3 );
			}
		} else {
			$aUsers = $cached;
		}

        wfProfileOut( __METHOD__ );
		return $aUsers;
	}
	
	public static function axShowUsers ( $groups, $userSearch, $contrib, $limit = 30, $page = 0, $order = 'username', $desc = -1 ) {
		global $wgRequest, $wgUser,	$wgCityId, $wgDBname;
		global $wgContLang;
		
        wfProfileIn( __METHOD__ );

		$result = array('nbr_records' => 0, 'limit' => $limit, 'page' => $page, 'order' => $order, 'desc' => $desc);

		if ( !empty($wgUser) /*&& !$wgUser->isBlocked() */) {
			wfLoadExtensionMessages("Listusers");
			
			$aUsers = self::__getUsersFromDB($groups, $userSearch, $contrib, $limit, $page, $order, $desc);
			
			if (!empty($aUsers) && is_array($aUsers)) {
				$result['nbr_records'] = (isset($aUsers['cnt'])) ? intval($aUsers['cnt']) : 0;
				$result['data'] = (isset($aUsers['data'])) ? $aUsers['data'] : "";
			}
		} 

		wfProfileOut( __METHOD__ );

		if (!function_exists('json_encode')) {
			$oJson = new Services_JSON();
			return $oJson->encode($result);
		} else {
			return json_encode($result);
		}
	}
}
