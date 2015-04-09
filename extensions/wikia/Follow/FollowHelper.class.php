<?php
/*
 * Author: Tomek Odrobny
 * Helper function for extension hook etc.
 */

class FollowHelper {

	/**
	 * watchCategory -- static hook/entry for foolow article category
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return bool
	 */
	static public function watchCategories($categoryInserts, $categoryDeletes, $title) {
		global $wgUser;
		wfProfileIn( __METHOD__ );
		if ( empty($categoryInserts) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$action = "categoryadd";
		$catList = array_keys($categoryInserts);

		$queryIn = "";
		foreach ($catList as $value) {
			$queryIn[] = $value;
		}

		self::emailNotification($title, $queryIn, NS_CATEGORY, $wgUser, $action, wfMsg('follow-categoryadd-summary'));

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * emailNotification -- sent Notification for all related article  ,
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return bool
	 */
	public static function emailNotification($childTitle, $list, $namespace, $user, $action, $message) {
		global $wgTitle;

		wfProfileIn( __METHOD__ );

		if ( count($list) < 1 ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$dbw = wfGetDB( DB_SLAVE );
		$queryIn = array();
		foreach ($list as $value) {
			$queryIn[] = $dbw->addQuotes( $value ) ;
		}

		/* Wikia change begin - @author: wladek */
		/* RT#55604: Add a timeout to the watchlist email block */

	 	global $wgEnableWatchlistNotificationTimeout, $wgWatchlistNotificationTimeout;

		$now = wfTimestampNow();
	  	if ( !empty($wgEnableWatchlistNotificationTimeout) && isset($wgWatchlistNotificationTimeout) ) { // not using !empty() to allow setting integer value 0
			$blockTimeout = wfTimestamp(TS_MW,wfTimestamp(TS_UNIX,$now) - intval($wgWatchlistNotificationTimeout) );
			$notificationTimeoutSql = "(wl_notificationtimestamp IS NULL OR wl_notificationtimestamp < '$blockTimeout')";
		} else {
			$notificationTimeoutSql = "wl_notificationtimestamp IS NULL";
		}

		if($action == "blogpost") {
			$notificationTimeoutSql = "1";
		}

		$res = $dbw->select( array( 'watchlist' ),
				array( 'wl_user, wl_title' ),
				array(
					'wl_user != ' . intval( $user->getID() ),
					'wl_namespace' => $namespace ,
					'wl_title in('.implode(",",$queryIn).') ',
					$notificationTimeoutSql
				),
		__METHOD__ );

		$watchers = array();
		while ($row = $dbw->fetchObject( $res ) ) {
			if ( empty($watchers[$row->wl_title]) ) {
				$watchers[$row->wl_title] = array( $row->wl_user );
			} else {
				if( in_array($row->wl_user, $watchers[$row->wl_title]) ) {
					$watchers[$row->wl_title][] = $row->wl_user;
				}
			}
		}

		/**
		 * Selecting all watching users took to long
		 * and was causing timeouts. It's been moved to a task.
		 * @see CE-1239 by adamk@wikia-inc.com
		 */
		if ( !empty( $watchers ) ) {
			$oTask = new FollowEmailTask();
			$oTask->title( $childTitle );
			$oTask->wikiId( F::app()->wg->CityId );
			$oTask->call( 'emailFollowNotifications', $watchers, $user->getId(), $namespace, $message, $action );
			$oTask->queue();
		}

		wfProfileOut( __METHOD__ );
	}


	/*
	 * blogListingBuildRelation - hook after save of blogListing create relations in table
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return bool
	 */
	static public function blogListingBuildRelation($title, $cat, $users){
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );

		$exploded = explode(":", $title);
		if(count($exploded) > 1) {
			$title =  $exploded[1];
		}

		$title = Title::makeTitle( NS_BLOG_LISTING, $title );
		$title =  $title->getDBKey();

		$dbw->begin();
		$dbw->delete( 'blog_listing_relation', array( "blr_title = ". $dbw->addQuotes( $title ) ) );

		if ((!empty($cat)) && (is_array($cat)) ) {
			foreach ($cat as $value) {
				$value = Title::makeTitle( NS_CATEGORY, $value );
				$value = $value->getDBKey();
				if( strlen($value) < 1 ) continue;
				$dbw->insert('blog_listing_relation',
					array(
						 'blr_relation' => $value,
						 'blr_title' => $title ,
		  				 'blr_type' => 'cat',
				), __METHOD__);
			}
		}

		if ((!empty($users)) && (is_array($users)) ) {

			foreach ($users as $value) {
				if( strlen(trim($value)) < 1 ) continue;
				$dbw->insert('blog_listing_relation',
					array(
						 'blr_relation' => $value,
						 'blr_title' => $title,
		  				 'blr_type' => 'user',
				), __METHOD__);
			}
		}
		$dbw->commit();
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * saveListingRelation -- hook for ,
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return bool
	 */
	static public function watchBlogListing(&$article, &$user, $text, $summary, $minor, $undef1, $undef2, &$flags, $revision, &$status, $baseRevId ) {
		if (!$status->value['new']){
			return true;
		}
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_SLAVE );
		if (defined('NS_BLOG_ARTICLE') && $article->getTitle()->getNamespace() == NS_BLOG_ARTICLE ) {
			$cat =  array_keys( Wikia::getVar( 'categoryInserts' ) );
			$catIn = array();

			foreach ( $cat as $value ) {
				$title = Title::makeTitle( NS_CATEGORY, $value );
				$catIn[] = $dbw->addQuotes( $title->getDBKey() );
			}
			$username = $user->getName();
			$con = '';

			if( count($catIn) > 0 ) {
				$con .= '(blr_relation in('.implode(",",$catIn).') AND blr_type = "cat" ) OR ';
			}
			$con .= '(blr_relation = "'. $dbw->addQuotes( $username ).'"  AND blr_type = "user" ) ';

			$res = $dbw->select( array( 'blog_listing_relation' ),
					array( 'blr_title' ),
					$con,
					__METHOD__ );
			$related = array();
			while ($row = $dbw->fetchObject( $res ) ) {
				//Bug fix  //
				$exploded = explode(":", $row->blr_title);
				if(count($exploded) > 1) {
					$title =  $exploded[1];
				} else {
					$title = $row->blr_title;
				}
				$title = Title::makeTitle( NS_BLOG_LISTING, $title );
				$related[] = ucfirst($title->getDBKey());
			}
			self::emailNotification($article->getTitle(), $related, NS_BLOG_LISTING, $user, "blogpost", wfMsg('follow-bloglisting-summary'));
		}
		wfProfileOut( __METHOD__ );
		return true;
	}


	/*
	 * Add link to Special:MyHome in Monaco user menu
	 *
	 * TODO: remove when support for Monaco will be finished
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function addToUserMenu($skin, $tpl, $custom_user_data) {
		wfProfileIn(__METHOD__);

		// don't touch anon users
		global $wgUser;
		if ($wgUser->isAnon()) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$skin->data['userlinks']['watchlist'] = array(
			'text' =>  wfMsg('wikiafollowedpages-special-title-userbar'),
			'href' => Skin::makeSpecialUrl('following'),
		);

		wfProfileOut(__METHOD__);
		return true;
	}

	/*
	 * Add link to user dropdown in Oasis
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function addPersonalUrl(&$personal_urls, &$title) {
		wfProfileIn(__METHOD__);

		// don't touch anon users
		global $wgUser;
		if ($wgUser->isAnon()) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// only for Oasis users
		// replace 'watchlist' with 'followed pages'
		if (get_class(RequestContext::getMain()->getSkin()) == 'SkinOasis') {
			$personal_urls['watchlist'] = array(
				'text' =>  wfMsg('wikiafollowedpages-special-title-userbar'),
				'href' => Skin::makeSpecialUrl('following'),
			);
		}
		wfProfileOut(__METHOD__);
		return true;
	}


	/**
	 * showAll -- ajax function to show all feeds on follow list
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return bool
	 */
	static public function showAll(){
		global $wgRequest, $wgUser;
		wfProfileIn(__METHOD__);

		$user_id = $wgRequest->getVal( 'user_id' );
		$head = $wgRequest->getVal( 'head' );
		$from = $wgRequest->getVal( 'from' );

		$response = new AjaxResponse();

		$user = User::newFromId($user_id);
		if ( empty($user) || $user->getOption('hidefollowedpages') ) {
			if( $user->getId() != $wgUser->getId() ) {
				$response->addText( wfMsg('wikiafollowedpages-special-hidden') );
				wfProfileOut(__METHOD__);
				return $response;
			}
		}

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars(
			array (
				"data" 	=> FollowModel::getWatchList( $user_id, $from, FollowModel::$ajaxListLimit ,$head ),
				"owner" => $wgUser->getId() == $user_id,
				"user_id" =>  $user_id,
				"more" => true,
			)
		);

		$text = $template->render( "followedPages" );

		$response->addText( $text );
		wfProfileOut(__METHOD__);
		return $response;
	}

	/**
	 * renderFollowPrefs -- render prefs
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return bool
	 */
	static public function renderFollowPrefs(User $user, &$defaultPreferences) {
		global $wgUseRCPatrol, $wgEnableAPI, $wgJsMimeType, $wgExtensionsPath, $wgOut, $wgUser;
		wfProfileIn(__METHOD__);

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Follow/js/ajax.js\"></script>\n");

		$watchTypes = array(
			'edit' => 'watchdefault'
		);
		// Kinda hacky
		if( $user->isAllowed( 'createpage' ) || $user->isAllowed( 'createtalk' ) ) {
			$watchTypes['read'] = 'watchcreations';
		}

		foreach( $watchTypes as $action => $pref ) {
			if( $user->isAllowed( $action ) ) {
				$defaultPreferences[$pref] = array(
					'type' => 'toggle',
					'section' => 'watchlist/basic',
					'label-message' => "tog-$pref",
				);
			}
		}

		$defaultPreferences['enotiffollowedpages'] = array(
			'type' => 'toggle',
			'section' => 'watchlist/basic',
			'label-message' => "tog-enotiffollowedpages",
		);

		$defaultPreferences['enotiffollowedminoredits'] = array(
			'type' => 'toggle',
			'section' => 'watchlist/basic',
			'label-message' => "tog-enotiffollowedminoredits",
		);

		$defaultPreferences['hidefollowedpages'] = array(
			'type' => 'toggle',
			'section' => 'watchlist/basic',
			'label-message' => "tog-hidefollowedpages",
		);

		global $wgEnableWallEngine, $wgEnableUserPreferencesV2Ext;
		if($wgEnableWallEngine) {
			if ($wgEnableUserPreferencesV2Ext) {
				$section = 'emailv2/email-wall-v2';
				$messageWallmy = 'tog-enotifmywall-v2';
				$messageWallthread = 'tog-enotifwallthread-v2';
			}
			else {
				$section = 'watchlist/basic';
				$messageWallmy = 'tog-enotifmywall';
				$messageWallthread = 'tog-enotifwallthread';
			}

			//back compatybility
			$option = $wgUser->getOption('enotifwallthread');
			if(empty($option)){
				$wgUser->setOption('enotifwallthread', WALL_EMAIL_NOEMAIL);
				$wgUser->saveSettings();
			}

			$defaultPreferences['enotifwallthread'] = array(
				'type' => 'select',
				'section' => $section,
				'options' => array(
					wfMsg('tog-enotifmywall-every') => WALL_EMAIL_EVERY,
					wfMsg('tog-enotifmywall-sincevisited') => WALL_EMAIL_SINCEVISITED,
			//		wfMsg('tog-enotifmywall-reminder') => WALL_EMAIL_REMINDER,
					wfMsg('tog-enotifmywall-noemail') => WALL_EMAIL_NOEMAIL
				),
				'label-message' => $messageWallthread,
			);
		}


		$watchTypes = array();

		$watchTypes['move'] = 'watchmoves';
		$watchTypes['delete'] = 'watchdeletion';

		foreach( $watchTypes as $action => $pref ) {
			if( $user->isAllowed( $action ) ) {
				$defaultPreferences[$pref] = array(
					'type' => 'toggle',
					'section' => 'watchlist/advancedwatchlist',
					'label-message' => "tog-$pref",
				);
			}
		}


		//wikiafollowedpages-prefs-watchlist

		## Watchlist #####################################
		$defaultPreferences['watchlistdays'] =
				array(
					'type' => 'float',
					'min' => 0,
					'max' => 7,
					'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
					'help' => wfMsgHtml( 'prefs-watchlist-days-max' ),
					'label-message' => 'prefs-watchlist-days',
				);
		$defaultPreferences['wllimit'] =
				array(
					'type' => 'int',
					'min' => 0,
					'max' => 1000,
					'label-message' => 'prefs-watchlist-edits',
					'help' => wfMsgHtml( 'prefs-watchlist-edits-max' ),
					'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
				);
		$defaultPreferences['extendwatchlist'] =
				array(
					'type' => 'toggle',
					'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
					'label-message' => 'tog-extendwatchlist',
				);
		$defaultPreferences['watchlisthideminor'] =
				array(
					'type' => 'toggle',
					'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
					'label-message' => 'tog-watchlisthideminor',
				);
		$defaultPreferences['watchlisthidebots'] =
				array(
					'type' => 'toggle',
					'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
					'label-message' => 'tog-watchlisthidebots',
				);
		$defaultPreferences['watchlisthideown'] =
				array(
					'type' => 'toggle',
					'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
					'label-message' => 'tog-watchlisthideown',
				);
		$defaultPreferences['watchlisthideanons'] =
				array(
					'type' => 'toggle',
					'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
					'label-message' => 'tog-watchlisthideanons',
				);
		$defaultPreferences['watchlisthideliu'] =
				array(
					'type' => 'toggle',
					'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
					'label-message' => 'tog-watchlisthideliu',
				);
		if ( $wgEnableAPI ) {
			# Some random gibberish as a proposed default
			$hash = sha1( mt_rand() . microtime( true ) );
			$defaultPreferences['watchlisttoken'] =
					array(
						'type' => 'text',
						'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
						'label-message' => 'prefs-watchlist-token',
						'help' => wfMsgHtml( 'prefs-help-watchlist-token', $hash )
					);
		}

		if ( $wgUseRCPatrol ) {
			$defaultPreferences['watchlisthidepatrolled'] =
					array(
						'type' => 'toggle',
						'section' => 'watchlist/wikiafollowedpages-prefs-watchlist',
						'label-message' => 'tog-watchlisthidepatrolled',
					);
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	/**
	 * jsVars -- add java script varibale to html
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return bool
	 */
	static public function jsVars(Array &$vars) {
		$vars[ 'wgEnableWikiaFollowedPages' ] = true;
		$vars[ 'wgFollowedPagesPagerLimit' ] = FollowModel::$specialPageListLimit;
		$vars[ 'wgFollowedPagesPagerLimitAjax' ] = FollowModel::$ajaxListLimit;
		return true;
	}

	static public function addExtraToggles($extraToggles) {
		$extraToggles[] = 'hidefollowedpages';
		$extraToggles[] = 'enotiffollowedpages';
		$extraToggles[] = 'enotiffollowedminoredits';
		global $wgEnableWallExt;
		if($wgEnableWallExt) {
			$extraToggles[] = 'enotifwallthread';
			$extraToggles[] = 'enotifmywall';
		}
		return true;
	}

	/**
	 * getMasthead -- return mashead tab for fallowed pages
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return  array
	 */
	static public function getMasthead($userspace) {
		global $wgUser;
		if(($wgUser->getId() > 0) && ($wgUser->getName() == $userspace)) {
			return array('text' => wfMsg('wikiafollowedpages-masthead'), 'href' => Title::newFromText("Following", NS_SPECIAL )->getLocalUrl(), 'dbkey' => 'Following', 'tracker' => 'following');
		}
		return null;
	}


	/**
	 * renderUserProfile -- return mashead tab for fallowed pages
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return  array
	 */
	static public function renderUserProfile(&$out) {
		global $wgTitle, $wgRequest, $wgOut, $wgExtensionsPath, $wgJsMimeType, $wgUser;
		wfProfileIn(__METHOD__);
		if( F::app()->checkSkin( 'wikiamobile' ) ){
			wfProfileOut(__METHOD__);
			return true;
		}

		if( ($wgUser->getId() != 0) && ($wgRequest->getVal( "hide_followed", 0) == 1) ) {
			$wgUser->setOption( "hidefollowedpages", true );
			$wgUser->saveSettings();
		}

		$key = $wgTitle->getDBKey();

		if ( strlen($key) > 0 ) {
			$user = User::newFromName($key);

			if ($user == null) {
				wfProfileOut(__METHOD__);
				return true;
			}

			if($user->getId() == 0) {
				//not a real user
				wfProfileOut(__METHOD__);
				return true;
			}
		} else {
			$user = $wgUser;
		}

		// do not show Followed box on diffs
		if ( $wgRequest->getVal( 'diff', null ) != null ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		if( $user->getOption( "hidefollowedpages" ) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$data = FollowModel::getUserPageWatchList( $user->getId() );

		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/Follow/css/userpage.css");
		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

		if ( count($data) == 0 ) $data = null;
		/*
		if ( count($data) > 5 ) {
			$data2 = array_slice($data, 5 );
			$data = array_slice($data, 0, 5);
		} */

		// BugId:2643
		$moreUrl = null;
		if ($wgUser->getId() == $user->getId()) {
			$specialPage = SpecialPage::getSafeTitleFor('Following', $user->getName());
			if (!empty($specialPage)) {
				$moreUrl = $specialPage->getLocalUrl();
			}
		}

		$template->set_vars(
			array(
				"isLogin" => ($wgUser->getId() == $user->getId() ),
				"hideUrl" => $wgTitle->getFullUrl( "hide_followed=1" ),
				"data" 	=> $data,
				// show "more" only if wathing own user page
				"moreUrl" => $moreUrl,
			)
		);
		wfProfileOut(__METHOD__);
		$out['followedPages'] = $template->render( "followedUserPage" );
		return true;
	}

	/**
	 * MailNotifyBuildKeys -- return build keys for mail
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return  array
	 */
	static public function mailNotifyBuildKeys(&$keys, $action, $other_param) {
		global $wgEnableForumExt;
		$actionsList = array('categoryadd', 'blogpost');
		if (!in_array($action, $actionsList)) {
			return true;
		}

		$page = Title::newFromText( $keys['$PAGETITLE'] );

		$keys['$PAGETITLE'] = $other_param['childTitle']->getPrefixedText();
		$keys['$PAGETITLE_URL'] = $other_param['childTitle']->getFullUrl();

		if($action == 'categoryadd') {
			$keys['$CATEGORY_URL'] = $page->getFullUrl();
			$keys['$CATEGORY'] = $page->getText();

			// Format Forum thread URLs when added to category
			if ( !empty( $wgEnableForumExt )
				&& $other_param['childTitle']->getNamespace() === NS_WIKIA_FORUM_BOARD_THREAD
			) {
				$title = $other_param['childTitle'];
				$titleParts = explode( '/', $title->getPrefixedText() );

				// Handle replies, can't use WallMessage::getTopParentObj as the comments
				// index isn't updated yet
				if ( strpos( $titleParts[count( $titleParts ) - 2], ARTICLECOMMENT_PREFIX ) === 0 ) {
					$titleText = implode( '/', array_slice( $titleParts, 0, count( $titleParts ) - 1 ) );
					$title = Title::newFromText( $titleText );
				}
				$wallMessage = WallMessage::newFromTitle( $title );
				$wallMessage->load();
				$threadTitle = Title::newFromText( $wallMessage->getID(), NS_USER_WALL_MESSAGE );

				$keys['$PAGETITLE'] = $wallMessage->getMetaTitle();
				$keys['$PAGETITLE_URL'] = $threadTitle->getFullURL();
			}
			return true;
		}

		if($action == 'blogpost') {
			$keys['$BLOGLISTING_URL'] = $page->getFullUrl();
			$keys['$BLOGLISTING'] = $page->getText();
			return true;
		}

		return true;
	}


	/**
	 * categoryIndexer --  indexer for blog listing page used only one time by indexing script
	 *
	 * @static
	 * @access public
	 *
	 *
	 * @return  bool
	 */
	static public function categoryIndexer(&$self, $article) {
		global $wgRequest;
		if( $wgRequest->getVal("makeindex", 0) != 1 ) {
			return true;
		}

		if($article != null) {
			$self->parseTag(urldecode( $article ));
			$cats = BlogTemplateClass::getCategoryNames();
			if(count($cats) > 0) {
				self::blogListingBuildRelation($article, $cats, array());
			}
		}
		return true;
	}
}
