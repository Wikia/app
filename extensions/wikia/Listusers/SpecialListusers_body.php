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
		global $wgExtensionsPath, $wgStylePath, $wgUser;
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
            "wgExtensionsPath" 		=> $wgExtensionsPath, 
	    "wgStylePath"		=> $wgStylePath,
            "selContrib"		=> 5,
            "wgUser"			=> $wgUser
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
		global $wgMemc, $wgExternalDatawareDB;
		global $wgCityId;
		wfProfileIn( __METHOD__ );
		$aResult = array();

		$memkey = wfForeignMemcKey( $wgCityId, null, "Listusers", "groupList" );
		$cached = $wgMemc->get($memkey);
		if ( empty($cached) ) {
			$dbs = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
			if (!is_null($dbs)) {
				$aQuery = array();
				if (!empty($aGroups) && is_array($aGroups)) {
					$aQuery[] = "select '' as groupName, count(*) as cnt from city_local_users where lu_wikia_id = {$wgCityId} and lu_numgroups = 0 and lu_closed = 0 ";
					foreach ($aGroups as $groupName => $userGroupName) {
						$aQuery[] = "select '{$groupName}' as groupName, count(*) as cnt from city_local_users where lu_wikia_id = {$wgCityId} and lu_allgroups like '%{$groupName}%' and lu_closed = 0 group by groupName";
					}
				}
				if (!empty($aQuery)) {
					$query = implode(' union ', $aQuery);
					$res = $dbs->query($query, __METHOD__ );
					while ($row = $dbs->fetchObject($res)) {
						$aResult[(empty($row->groupName)) ? "all" : $row->groupName] = $row->cnt;
					}
					$dbs->freeResult($res);
				}
				$wgMemc->set( $memkey, $aResult, 60*60 );
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
	
	private static function __getUsersFromDB($groups, $text = "", $contrib = 0, $limit = 30, $offset = 0, $order = 'username', $desc = -1) {
		global $wgMemc, $wgExternalDatawareDB;
		global $wgCityId, $wgLang;
		global $wgUser, $wgDBname;
		wfProfileIn( __METHOD__ );

		$descOrder = ($desc == -1) ? "" : "desc";
		$orderOption = array(
			"username" => "lu_user_name $descOrder",
			"groups" => "lu_allgroups $descOrder, lu_numgroups $descOrder",
			"revcnt" => "lu_rev_cnt $descOrder",
			"loggedin" => "ts $descOrder",
			"dtedit" => "max_rev $descOrder"
		);
		$orderby = (isset($orderOption[$order])) ? $orderOption[$order] : $orderOption["username"];

		$aUsers = array('cnt' => 0, 'data' => array());
		$data = array('cnt' => 0, 'rows' => array());
		$subMemkey = md5('G'.$groups.'T'.$text.'C'.$contrib.'O'.$offset.'L'.$limit.'O'.$orderby);
		$memkey = wfForeignMemcKey( $wgCityId, null, "Listusers", $subMemkey );
		$cached = $wgMemc->get($memkey);
		if (!is_array ($cached)) { 
			$dbs = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
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

				$aTables = array('city_local_users');
				$aWhat = array ( "lu_user_id", "lu_user_name", "lu_numgroups", "lu_allgroups", "lu_rev_cnt", "lu_blocked" );
				$aTables = array ( 
					'city_local_users 
					left join user_summary s1 on (lu_user_id = s1.user_id) and (s1.city_id = 0)
					left join user_summary s2 on (lu_user_id = s2.user_id) and (s2.city_id = '.$wgCityId.')'
				);
				$aWhat[] = "ifnull(unix_timestamp(s1.last_logged_in), 0) as ts";
				$aWhat[] = "ifnull(s2.rev_last, 0) as max_rev";
				$aWhat[] = "ifnull(unix_timestamp(s2.ts_edit_last), 0) as ts_edit";
				$res = $dbs->select(
					$aTables,
					$aWhat,
					$aWhere,
					__METHOD__,
					array ( 'GROUP BY' => 'lu_user_id', 'ORDER BY' => $orderby, 'LIMIT' => $limit, 'OFFSET' => intval($offset) * $limit, 'SQL_CALC_FOUND_ROWS' )
				);

				while ( $oRow = $dbs->fetchObject( $res ) ) {
					$data['rows'][] = $oRow;
				}
				$dbs->freeResult( $res );

				# nbr all records 
				$res = $dbs->query('SELECT FOUND_ROWS() as rowcount');
				$oRow = $dbs->fetchObject ( $res );
				$data['cnt'] = $oRow->rowcount;
				$dbs->freeResult( $res );
				$wgMemc->set( $memkey, $data, 60*60*3 );
			}
		} else {
			$data = $cached;
		}

		$sk = $wgUser->getSkin();
		if ( isset($data['cnt']) && ($data['cnt'] > 0) ) {
			$aUsers['cnt'] = $data['cnt'];
 			foreach ($data['rows'] as $id => $oRow) {
				$oUser = User::newFromName($oRow->lu_user_name);
				# check by ID id, if user not found
				if ( !($oUser instanceof User) ) {
					$oUser = User::newFromId($oRow->lu_user_id);
				}
				# hmmm ... if user not found
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
					'user_name' 	=> $oUser->getName(),
					'user_link'		=> $sk->makeLinkObj($oUser->getUserPage(), $oUser->getName()),
					'groups_nbr' 	=> $oRow->lu_numgroups,
					'groups' 		=> $sGroups,
					'rev_cnt' 		=> $oRow->lu_rev_cnt,
					'blcked'		=> $oRow->lu_blocked,
					'links'			=> "(" . implode(") &#183; (", $aLinks) . ")",
					'last_login'	=> (!empty($oRow->ts)) ? $wgLang->timeanddate( $oRow->ts, true ) : "",
				);
				
				# last revision and date of last edit
				$aUsers['data'][$oRow->lu_user_id]['last_edit_ts'] = 
					(!empty($oRow->ts_edit)) ? $wgLang->timeanddate( $oRow->ts_edit, true ) : "";
					
				if ( !empty($oRow->max_rev) ) { 
					$oRevision = Revision::newFromId($oRow->max_rev);
					if ( !is_null($oRevision) ) {
						$oTitle = $oRevision->getTitle();
						if ( !is_null($oTitle) ) {
							$aUsers['data'][$oRow->lu_user_id]['last_edit_page'] = $oTitle->getLocalUrl();
							$aUsers['data'][$oRow->lu_user_id]['last_edit_diff'] = $oTitle->getLocalUrl('diff=prev&oldid=' . $oRow->max_rev);
						}
					}
				}
			}
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
	
	public static function Activeusers( &$list ) {
		$list['Activeusers'] = array( 'SpecialRedirectToSpecial', 'Activeusers', 'Listusers' );
		return true;
	}
	
	/**
	 * update list users table on user right change
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       User    $user object
	 * @param       Array   $addgroup - selected groups for user
	 * @param       Array   $removegroup - disabled groups for user
	 */
	static public function updateUserRights( &$user, $addgroup, $removegroup ) {
		global $wgCityId, $wgExternalDatawareDB;
		
		if ( $user instanceof User ) {
			$dbr = wfGetDB(DB_SLAVE, 'blobs', $wgExternalDatawareDB);
			$condition = array( 
				"lu_user_id" 	=> $user->getID(),
				"lu_wikia_id" 	=> $wgCityId
			);

			$s = $dbr->selectRow( 
				"city_local_users", 
				array( "lu_allgroups" ), 
				$condition,
				__METHOD__ 
			);
			if ( $s !== false ) {
				$lu_groups = array();
				$lu_singlegroup = "";
				if ( !empty( $s->lu_allgroups ) ) {
					$lu_groups = explode( ";", $s->lu_allgroups );
					if ( !empty($addgroup) ) {
						$lu_groups = array_unique( array_merge($lu_groups, $addgroup) );
					} 
					if ( !empty($removegroup) ) {
						$lu_groups = array_unique( array_diff($lu_groups, $removegroup) );
					}
					if ( !empty($lu_groups) ) { 
						sort($lu_groups);
						$elements = count($lu_groups);
						$lu_singlegroup = ( $elements > 0 ) ? $lu_groups[$elements-1] : "";
						
						$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
						$dbw->update(
							"city_local_users",
							array(
								"lu_singlegroup" => $lu_singlegroup,
								"lu_allgroups"   => @implode(";", $lu_groups)
							),
							$condition,
							__METHOD__
						);
					}
				}
			}
		}

		return true;
	}

}
