<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of EditConflict.
 *
 * EditConflict is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * EditConflict is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with EditConflict; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * Group-level based edit page access for MediaWiki. Monitors current edit sessions.
 * Version 0.4.2
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the EditConflict extension. It is not a valid entry point.\n" );
}

# a "magic" edit_id value which will indicate that no such edit_id is in the DB edits table
# ( valid edit_id value in DB cannot be negative number )
# usually indicates that the user's edit session was finished
define( 'EC_NO_EDITING', -1 );

# time of edit "session" expiration (in seconds)
# !! it should be at least twice longer than EditConflict.editSleep value defined in js !!
define( 'EC_AJAX_EXPIRE_TIME', 1*60 );

# total time of edit until the record will be deleted (three hours)
# (counts when client has no javascript)
# !! decrease to 3*60 for the debugging purposes !!
define( 'EC_EDIT_EXPIRE_TIME', 3*60*60 );

# conflict notifications will expire in 30 days (in seconds)
define( 'EC_NOTIFICATION_EXPIRE_TIME', 30*24*60*60 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'EditConflict',
	'version' => '0.4.2',
	'author' => 'QuestPC',
	'url' => 'https://www.mediawiki.org/wiki/Extension:EditConflict',
	'descriptionmsg' => 'editconflict_desc'
);

EditConflict::startup();

$wgExtensionMessagesFiles['EditConflict'] = EditConflict::$ExtDir . '/EditConflict_i18n.php';
$wgAutoloadClasses['ec_CurrentEdits'] = EditConflict::$ExtDir . '/CurrentEdits.php';
$wgSpecialPages['CurrentEdits'] = 'ec_CurrentEdits';

$wgHooks['EditPageMergeChanges'][] = 'EditConflict::doEditConflict';
$wgHooks['MakeGlobalVariablesScript'][] = 'EditConflict::jsWikiMessages';
$wgHooks['BeforePageDisplay'][] = 'EditConflict::checkNotification';
$wgHooks['EditPage::showEditForm:fields'][] = 'EditConflict::initEditing';
$wgHooks['userCan'][] = 'EditConflict::checkEditConflict';
$wgHooks['UserGetRights'][] = 'EditConflict::checkUserPageDelete';
$wgHooks['ArticleDeleteComplete'][] = 'EditConflict::checkArticleDelete';

$wgAjaxExportList[] = 'EditConflict::getNotifyText';
$wgAjaxExportList[] = 'EditConflict::clearRevId';
$wgAjaxExportList[] = 'EditConflict::markEditing';
$wgAjaxExportList[] = 'EditConflict::checkEditButton';

class EditConflict {

	# setup variable, define EditConflict::$alwaysEditClickEvent = true; in LocalSettings.php AFTER the inclusion of extension
	# to always insert an edit click ajax check, whether the user is allowed to edit the page
	# ( slower, will almost always capture the edit click )
	# otherwise, the edit click ajax check will be performed only when there already was ongoing edit before the page was loaded
	# ( faster, by default, click may sometimes display edit window with "access denied" message )
	static $alwaysEditClickEvent;

	static $ExtDir; // extension directory
	static $ScriptPath; // extension apache web path
	static $onLoadScript; // body.onload script
	static $userCanEditCached = null; // previous result of userCan hook to reduce numbers of DB calls
	static $groupWeights = Array();
	static $useEditPageMergeChangesHook = false; // non-patched core by default

	var $mTitle;
	var $mArticle;
	var $prev_userid;
	var $prev_user;
	var $prev_userpage;

	# constructor, used only when hook 'EditPageMergeChanges' is available in includes/EditPage.php
	# @param   $title, $article - current version (before the conflict) of the existing (conflicting) page
	function __construct( $title, $article ) {
		$this->mTitle = $title;
		$this->mArticle = $article;
		# user id who saved the existing article revision
		$this->prev_userid = $this->mArticle->getUser();
		# his user object
		$this->prev_user = User::newFromId( $this->prev_userid );
		# page of user who created existing revision
		$this->prev_userpage = $this->prev_user->getUserPage();
	}

	static function getGroupWeight( $user ) {
		// check, whether we have an standard or a patched version of mediawiki
		$realFunction = array( 'User', 'getGroupParameters' );
		if ( is_callable( $realFunction ) ) {
			return $user->getGroupParameters()->weight;
		} else {
			if ( !isset( self::$groupWeights['*'] ) ) {
				throw new MWException( __METHOD__ . ' EditConflict::$groupWeights[\'*\'] for anoymous user group is not defined in LocalSettings.php' );
			}
			// set minimal possible result (anonymous)
			$result = self::$groupWeights['*'];
			$usergroups = $user->getEffectiveGroups();
			// now find the group of highest weight to which $user belongs
			foreach( self::$groupWeights as $groupname => $groupWeight ) {
				if ( in_array( $groupname, $usergroups ) &&
							$groupWeight > $result ) {
					$result = $groupWeight;
				}
			}
			return $result;
		}
	}

	# copy the conflicting article revision to subpage in user namespace
	# used in includes/EditPage.php
	# uses the data obtained in constructor
	function copy() {
		# title to which the existing revision will be moved (in NS_USER)
		$moved_title_str = $this->prev_userpage->getPrefixedDBkey() . '/' . $this->mTitle->getDBkey();
		$moved_title = Title::newFromText( $moved_title_str );
		# corresponding article
		$moved_article = new Article( $moved_title );
		# get latest revision of existing (saved in progress) article
		$prev_revision = Revision::newFromId( $this->mArticle->getLatest() );
		# get the text of the existing revision
		$prev_text = $prev_revision->userCan( Revision::DELETED_TEXT ) ? $prev_revision->getRawText() : "";
		# save the existing revision into the subpage in userpage
		$moved_article->doEdit( $prev_text, 'Copied from [[' . $this->mTitle->getPrefixedDBkey() .  ']] due to edit conflict' );
		# fill out DB-specific fields
		$db = wfGetDB( DB_MASTER );
		$row['page_namespace'] = $this->mTitle->getNamespace();
		$row['page_title'] = $this->mTitle->getDBkey();
		$row['page_touched'] = $db->timestamp( $prev_revision->getTimestamp() );
		$row['user_name'] = $this->prev_user->getName();
#		$row['ns_user_rev_id'] = $moved_article->getRevIdFetched();
#		$row['ns_user_rev_id'] = $moved_title->getPreviousRevisionID( $moved_article->getLatest() );
#		$row['ns_user_rev_id'] = $moved_article->getOldID();
		$row['ns_user_rev_id'] = $moved_title->getLatestRevID();
		$db->replace( 'ec_edit_conflict', array('ns_user_rev_id'), $row, __METHOD__ );
	}

	# called as the 'EditPageMergeChanges' hook to handle the conflict between the users of different weights
	# @return true when merge was successful, false - merge failed
	static function doEditConflict( &$editpage, $text ) {
		global $wgUser;
		if ( self::$useEditPageMergeChangesHook ) {
			# the user who made previous edit, to whom we have an conflict
			$prev_user = User::newFromId( $editpage->mArticle->getUser() );
			# in case of edit conflict, user who belongs to group with higher weight wins ("successful merge")
			if ( self::getGroupWeight( $wgUser ) > ($prev_ug_weight = self::getGroupWeight( $prev_user ) ) ) {
				wfDebug( __METHOD__ . " suppressing edit conflict, current user has higher groupweight than previous user.\n" );
				if ( $prev_ug_weight > 0 && $editpage->mTitle->getNamespace() == NS_MAIN ) {
					# copy the conflicting revision only when in main namespace and 
					# previous user groupweight is higher than zero
					$ec = new EditConflict( $editpage->mTitle, $editpage->mArticle );
					$ec->copy();
				}
				return true;
			}
		}
		return false;
	}

	static function addOnLoadScript( $sourcetext ) {
		self::$onLoadScript .= $sourcetext;
	}
	
	# generates OutputPage header and onload scripts, if necessary
	static function generateHeader( $output ) {
		global $wgJsMimeType;
		if ( self::$onLoadScript !== '' ) {
			$head = '<link rel="stylesheet" href="' . self::$ScriptPath . '/notify.css" />' . "\n";
			$head .= '<script type="' . $wgJsMimeType . '" src="' . self::$ScriptPath . '/notify.js"></script>' . "\n";
			$head .= '<script type="' . $wgJsMimeType . '">EditConflict.addEvent(window,"load",function () {' . self::$onLoadScript . '});</script>' . "\n";
			$output->addScript( $head );
		}
	}

	# delete expired edits and conflict notifications
	static function deleteExpiredData( $db ) {
		# delete expired edits
		$query = 'DELETE FROM ' . $db->tableName( 'ec_current_edits' ) . ' WHERE edit_time < ' . $db->addQuotes( wfTimestamp( TS_MW, time() - EC_AJAX_EXPIRE_TIME ) ) . ' OR start_time < ' . $db->addQuotes( wfTimestamp( TS_MW, time() - EC_EDIT_EXPIRE_TIME ) );
		$db->query( $query , __METHOD__ );
		# delete expired conflict notifications
		$query = 'DELETE FROM ' . $db->tableName( 'ec_edit_conflict' ) . ' WHERE page_touched < ' . $db->addQuotes( wfTimestamp( TS_MW, time() - EC_NOTIFICATION_EXPIRE_TIME ) );
		$db->query( $query , __METHOD__ );
	}

	# places JS call which will display copied revisions notifications, if any
	# @param   $user - current user
	# @param   $title - current title
	static function processConflictNotifications( $db, $user, $title ) {
		$user_name = $user->getName();
		$res = $db->select( 'ec_edit_conflict', 'ns_user_rev_id', 'user_name=' . $db->addQuotes( $user_name ), __METHOD__, array( 'LIMIT'=>10, 'ORDER_BY'=>'page_touched DESC' ) );
		if ( $db->numRows( $res ) > 0 ) {
			# ajax runs in minimal (commandline-like) environment, so $wgTitle during ajax php calls is a mainpage stub
			# thus, we are passing real article id of the current title to ajax js (then to ajax php)
			$notify_list = $title->getArticleId();
			while ( $row = $db->fetchObject( $res ) ) {
				$notify_list .= ',' . strval( intval( $row->ns_user_rev_id ) );
			}
			# will call JS getNotifyText() with the array of pages revid's for user notification
			self::addOnLoadScript( 'EditConflict.getNotifyText([' . $notify_list . ']);' );
		}
	}

	# checks if the user is allowed to edit the title
	# (whether there are other user with higher weight editing the title already)
	# @param   $db    - database object
	# @param   $user  - user object
	# @param   $title - title object
	# @return  EC_NO_EDITING : when user is allowed to edit OR
	#          edit_id : editing 'session' number (key from 'ec_current_edits') otherwise
	static function canUserEdit( $db, $user, $title ) {
		$edit_id = EC_NO_EDITING; // non_existent (user can edit)
		if ( $title instanceof Title ) {
			# current page NS & dbkey
			$where['page_namespace'] = $title->getNamespace();
			$where['page_title'] = $title->getDBkey();
			# select current editings of the current title, if available
			$res = $db->select( 'ec_current_edits', array( 'edit_id', 'user_name' ), $where, __METHOD__, array( 'ORDER BY'=>'start_time DESC' ) );
			if ( $db->numRows( $res ) > 0 ) {
				$max_user_weight = -1; // below the minimal
				$current_user_weight = self::getGroupWeight( $user );
				# get an editId of user who has the maximal weight
				# (should be checked in PHP, not DB - because weights are defined in PHP)
				while ( $row = $db->fetchObject( $res ) ) {
					$editing_user = User::newFromName( $row->user_name );
					$editing_user_weight = -1; // below the minimal
					if ( $editing_user instanceof User ) {
						$editing_user_weight = self::getGroupWeight( $editing_user );
					}
					if ( $editing_user_weight > $current_user_weight &&
								$max_user_weight < $editing_user_weight ) {
						$edit_id = $row->edit_id;
						$max_user_weight = $editing_user_weight;
					}
				}
			}
		}
		# allow to edit the title
		return $edit_id;
	}

	# places JS call which will attach onclick event to the edit link,
	# if there's another user of higher weight already editing the title
	# @param   $user - current user
	# @param   $title - current title
	static function processEditButton( $db, $user, $title ) {
		# check, whether the page is being already edited ('true') or not ('false')
		$disallow_edit = ( ( $edit_id = self::canUserEdit( $db, $user, $title ) ) != EC_NO_EDITING ) ? 'true' : 'false';
		# ajax runs in minimal (commandline-like) environment, so $wgTitle during ajax php calls is a mainpage stub
		# thus, we are passing real article id of the current title to ajax js (then to ajax php)
		$article_id = $title->getArticleId();
		if ( self::$alwaysEditClickEvent || $disallow_edit ) {
			# insert ajax check into the edit button anchor, second parameter indicates whether the article is already edited by privileged user
			self::addOnLoadScript( 'EditConflict.findEditKey(' . $article_id . ',' . $disallow_edit . ');' );
		}
	}

	# called as the 'MakeGlobalVariablesScript' hook to make required mediawiki variables be available in JS code
	static function jsWikiMessages( &$vars ) {
		$vars['ec_already_editing'] = wfMsg( 'ec_already_editing' );
		return true;
	}

	# called as the 'BeforePageDisplay' hook to show "copied due to conflict" notification messages to the current user
	# (if there are any such messages)
	static function checkNotification( &$out, &$sk = null ) {
		global $wgUser;
		# show the notifications only in main namespace and only for action=view
		# (to be less annoying and to don't conflict with special pages)
		if ( $out->getTitle()->getNamespace() == NS_MAIN && self::isViewAction() ) {
			$db = wfGetDB( DB_MASTER );
			self::deleteExpiredData( $db );
			# set current user's conflict notifications (if any)
			self::processConflictNotifications( $db, $wgUser, $out->getTitle() );
			# set edit link button handler, in case user of higher weight already edits this page
			self::processEditButton( $db, $wgUser, $out->getTitle() );
		}
		self::generateHeader( $out );
		return true;
	}

	// called via AJAX from notify.js to get current list of copied conflicted revisions
	// @param   args[0] - article_id of current title
	// @param   args[1..n] - list of revid that were copied to the subpage in the user's page
	static function getNotifyText() {
		global $wgUser;
		$args = func_get_args();
		if ( count( $args ) < 2 ) {
			return '';
		}
		# get current title
		$current_article_id = intval( array_shift( $args ) );
		$current_title = Title::newFromID( $current_article_id );
		$current_title_str = $current_title->getPrefixedDBkey();

		$skin = $wgUser->getSkin();
		$user_name = $wgUser->getName();
		$user_title = $wgUser->getUserPage();
		$user_title_dbkey = $user_title->getPrefixedDBkey();

		$result = '';
		$entries_set = '';
		$db = wfGetDB( DB_MASTER );
		$first_elem = true;
		foreach( $args as $ns_user_rev_id ) {
			if ( $first_elem ) {
				$first_elem = false;
			} else {
				$entries_set .= ',';
			}
			$entries_set .= $db->addQuotes( $ns_user_rev_id );
		}
		$res = $db->select( 'ec_edit_conflict', array( 'ns_user_rev_id', 'page_namespace', 'page_title', 'page_touched' ), 'ns_user_rev_id IN (' . $entries_set . ') AND user_name=' . $db->addQuotes( $user_name ), __METHOD__, array( 'ORDER'=>'page,page_touched' ) );
		if ( $db->numRows( $res ) > 0 ) {
			$result .= '<span style="color:red;">' . wfMsg( 'ec_copied_revisions' ) . '</span> ';
			$prev_title_str = '';
			$first_elem = true;
			while ( $row = $db->fetchObject( $res ) ) {
				$source_title = Title::newFromText( $row->page_title, intval( $row->page_namespace ) );
				$source_title_str = $source_title->getPrefixedDBkey();
				if ( $prev_title_str != $source_title_str ) {
					if ( $first_elem ) {
						$first_elem = false;
					} else {
						$result .= '</li>';
					}
					$result .= '<li>';
					# display 
					$result .= ( $source_title_str != $current_title_str ) ? $skin->makeKnownLinkObj( $source_title ) : htmlspecialchars( $source_title );
					$result .= ': ';
					$prev_title_str = $source_title_str;
				}
				$dest_title_str = $user_title_dbkey . '/' . $source_title_str;
				$dest_title = Title::newFromDBkey( $dest_title_str );
				$result .= '<span id="EditConflict_' . $row->ns_user_rev_id . '">(' . $skin->makeKnownLinkObj( $dest_title, 'rev. ' . $row->ns_user_rev_id . '', 'oldid=' . $row->ns_user_rev_id ) . '&#160;<span class="closelink" title="' . wfMsg( 'ec_close_warning' ) . '" onclick="EditConflict.clearRevId(' . $row->ns_user_rev_id . ');">&#8251;</span>' . ')</span> ';
			}
			$result .= '</li>';
		}
		return $result;
	}

	// called via AJAX from notify.js to remove an single entry from the list of copied conflicted revisions
	// @param    args[0] = revid;
	static function clearRevId() {
		$args = func_get_args();
		if ( count( $args ) != 1 ) {
			return '';
		}
		$ns_user_rev_id = intval( $args[0] );
		$db = wfGetDB( DB_MASTER );
		# delete the revision checked out by the user
		$db->delete( 'ec_edit_conflict', array( 'ns_user_rev_id'=>$ns_user_rev_id ), __METHOD__ );
		return strval( $ns_user_rev_id );
	}

	# called as 'EditPage::showEditForm:fields' hook to mark the page currently being edited in the database
	# this hooks is not being called when the user has no rights to edit the specific page
	# so the additional checks for such case are not required
	static function initEditing( &$editpage, &$output ) {
		global $wgUser;
		# will add watchEdit AJAX loop (which indicates ongoing editing) only for users who has (userweight > 0)
		# this should reduce server load (and, lowest status user editing can always be "overtaken" anyway)
		if ( self::getGroupWeight( $wgUser ) > 0 ) {
			$db = wfGetDB( DB_MASTER );
			$row['page_namespace'] = $editpage->mTitle->getNamespace();
			$row['page_title'] = $editpage->mTitle->getDBkey();
			$row['start_time'] = $row['edit_time'] = wfTimestampNow();
			$row['user_name'] = $wgUser->getName();
			$db->replace( 'ec_current_edits', array( 'edit_id', 'user_page' ), $row, __METHOD__ );
			# select an edit_id because replace does not support Database::insertId()
			$res = $db->select( 'ec_current_edits', array( 'edit_id' ), array( 'user_name'=>$row['user_name'], 'page_namespace'=>$row['page_namespace'], 'page_title'=>$row['page_title'] ), __METHOD__ );
			if ( $row = $db->fetchObject( $res ) ) {
				# will call JS watchEdit() with the array of pages revid's for user notification
				# cannot user self::generateHeader here because MW ajax script is included AFTER this hook
				# thus, at this stage OutputPage doesn't have ajax functions defined :-/
				self::addOnLoadScript('EditConflict.watchEdit([' . $row->edit_id . ']);' );
			}
		}
		return true;
	}

	# called via AJAX from notify.js in a loop to mark the page in DB as "being edited"
	// @param    args[0] - editId of the current editing
	static function markEditing() {
		$args = func_get_args();
		# non-existent editId indicates an error
		$edit_id = EC_NO_EDITING; // non-existent (user can edit)
		$db = wfGetDB( DB_MASTER );
		if ( isset( $args[0] ) ) {
			$edit_id = intval( $args[0] );
			# the editing in progress
			# update the timestamp of the editing so it won't expire on page load
			$res = $db->update( 'ec_current_edits', array( 'edit_time'=>wfTimestampNow() ), array( 'edit_id'=>$edit_id ), __METHOD__ );
		}
		# pass editId to the AJAX callback
		return strval( $edit_id );
	}

	# called via AJAX from notify.js to check, whether the user is allowed to click edit button
	# @param    args[0] - an article_id of the title to check
	# @return   string "y"/"n" - will be used in AJAX callback setClickEventResult() to enable / disable going to edit location
	static function checkEditButton() {
		global $wgUser;
		$args = func_get_args();
		$result = 'y';
		if ( count( $args ) > 0 ) {
			$current_article_id = intval( $args[0] );
			$current_title = Title::newFromID( $current_article_id );
			$db = wfGetDB( DB_MASTER );
			self::deleteExpiredData( $db );
			$result = ( self::canUserEdit( $db, $wgUser, $current_title ) == EC_NO_EDITING ) ? 'y' : 'n';
			# pass the future event result to the AJAX callback
		}
		return $result;
	}

	# @param    $title - Title object
	# @param    $ns - optional numerical code of namespace
	# @return   boolean true, when the title is valid local title (optionally in the selected namespace)
	static function validLocalTitle( $title, $ns = null ) {
		$result = $title instanceOf Title && $title->isLocal() && $title->getText() != '-';
		if ( $ns !== null ) {
			$result = $result && $title->getNamespace() == $ns;
		}
		return $result;
	}

	static function isViewAction() {
		global $wgRequest;
		$action = $wgRequest->getVal( 'action' );
		return !$wgRequest->wasPosted() && ( $action === null || $action == '' || $action == 'view' );
	}

	static function isPageSubmit() {
		global $wgRequest;
		$action = $wgRequest->getVal( 'action' );
		return $wgRequest->wasPosted() && $action == 'submit';
	}

	# called as the 'userCan' hook to disable action=edit
	# in case the user with higher weight is already editing the title
	static function checkEditConflict( &$title, &$user, $action, &$result ) {
		# restrict rights only if proposed action is 'edit' AND title is valid local AND
		# active action is NOT 'view' (otherwise edit link will be disabled in SkinTemplate.php !)
		# (we will need that link for JS part of AJAX)
		# AND we aren't submitting article (otherwise posted article will be lost)
		if ( $action == 'edit' && self::validLocalTitle( $title, NS_MAIN ) &&
					!self::isViewAction() && !self::isPageSubmit() ) {
			if ( self::$userCanEditCached === null ) {
				$res = self::canUserEdit( wfGetDB( DB_MASTER ), $user, $title );
				if ( self::canUserEdit( wfGetDB( DB_MASTER ), $user, $title ) != EC_NO_EDITING ) {
					$result = self::$userCanEditCached = false;
					return false;
				}
				self::$userCanEditCached = true;
			} else {
				if ( !self::$userCanEditCached ) {
					$result = false;
					return false;
				}
			}
		}
		return true;
	}

	static function addRight( $right, &$aRights ) {
		# union of rights
		$aRights = array_unique( array_merge( $aRights, array( $right ) ) );
	}

	static function removeRight( $right, &$aRights ) {
		if ( in_array( $right, $aRights ) ) {
			$key = array_search( $right, $aRights );
			unset( $aRights[ $key ] );
		}
	}

	# called as the 'UserGetRights' hook to allow user to delete his own page and the subpages of that page
	static function checkUserPageDelete( $user, &$aRights ) {
		global $wgTitle;
		# in case the copying of conflicting revisions to User's page/subpage is enabled
		if ( self::$useEditPageMergeChangesHook ) {
			# enable the deletion of user's page and his subpages
			if ( self::validLocalTitle( $wgTitle, NS_USER ) ) {
				$user_name_pq = preg_quote( $user->getName(), '`' );
				$title_str = $wgTitle->getText();
				if ( preg_match( '`^(' . $user_name_pq . '|' . $user_name_pq . '/.*)$`u', $title_str ) ) {
					self::addRight( 'delete', $aRights );
				}
			}
		}
		return true;
	}

	# called as the 'ArticleDeleteComplete' hook to remove user notifications belonging to deleted article
	static function checkArticleDelete( &$article, &$user, $reason, $id ) {
		$title = $article->getTitle();
		if ( $title->getNamespace() == NS_USER ) {
			$db = wfGetDB( DB_MASTER );
			$res = $db->select( 'archive', 'ar_title', array( 'ar_page_id'=>$id ), __METHOD__, array( 'LIMIT'=>1, 'ORDER BY'=>'ar_rev_id DESC' ) );
			if ( $row = $db->fetchObject( $res ) ) {
				$src = explode( '/', $row->ar_title );
				if ( count( $src ) == 2 ) {
					$where['page_namespace'] = NS_MAIN;
					$where['page_title'] = $src[1];
					$src_user = User::newFromName( $src[0] );
					$where['user_name'] = $src_user == null ? $src[0] : $src_user->getName();
					$db->delete( 'ec_edit_conflict', $where, __METHOD__ );
				}
			}
		}
		return true;
	}

	# extension startup
	static function startup() {
		global $wgScriptPath;
		foreach( array( 'wgUseAjax' ) as $globalVar ) {
			global $$globalVar;
			if ( !$$globalVar ) {
				die( "This extension requires \$$globalVar = true; in LocalSettings.php. Either disable the extension or change LocalSettings.php, accordingly.\n" );
			}
		}
		// static properties initialization (various paths)
		self::$ExtDir = str_replace( "\\", "/", dirname(__FILE__) ); // filesys path with windows path fix
		$dir_parts = explode( '/', self::$ExtDir );
		$top_dir = array_pop( $dir_parts );
		# currently two separate editings of the same page by the same user are considered a single edit
		self::$ScriptPath = $wgScriptPath . '/extensions' . ( ( $top_dir == 'extensions' ) ? '' : '/' . $top_dir ); // apache virtual path
		self::$alwaysEditClickEvent = false;
		self::$onLoadScript = '';
		self::$groupWeights = Array( '*' => 1, 'user' => 2, 'bureaucrat' => 3, 'sysop' => 4 );
	}

}
