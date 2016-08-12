<?php
/**
 * Author: Tomek Odrobny
 * Helper function for extension hook etc.
 */

class FollowHelper {

	const LOG_ACTION_BLOG_POST = 'blogpost';
	const LOG_ACTION_CATEGORY_ADD = 'categoryadd';
	const MAX_WATCHERS_PER_JOB = 1000;

	/**
	 * watchCategory -- static hook/entry for follow article category
	 *
	 * @param $categoryInserts
	 * @param $categoryDeletes
	 * @param $title
	 *
	 * @return bool
	 */
	static public function watchCategories( $categoryInserts, $categoryDeletes, $title ) {
		global $wgUser;

		if ( empty( $categoryInserts ) ) {
			return true;
		}

		$action = self::LOG_ACTION_CATEGORY_ADD;
		$catList = array_keys( $categoryInserts );

		$queryIn = "";
		foreach ( $catList as $value ) {
			$queryIn[] = $value;
		}

		self::emailNotification( $title, $queryIn, NS_CATEGORY, $wgUser, $action, wfMsg( 'follow-categoryadd-summary' ) );

		return true;
	}

	/**
	 * emailNotification -- sent Notification for all related article
	 *
	 * @param Title $childTitle
	 * @param array $list
	 * @param string $namespace
	 * @param User $user
	 * @param string $action
	 * @param string $message
	 *
	 * @throws MWException
	 */
	public static function emailNotification( $childTitle, $list, $namespace, $user, $action, $message ) {

		if ( count( $list ) < 1 ) {
			return;
		}

		$watcherSQL = self::getWatcherSQL( $user->getId(), $namespace, $list, $action );
		$watcherSets = self::getWatcherSets( $watcherSQL );

		if ( empty( $watcherSets ) ) {
			return;
		}

		$wg = \F::app()->wg;
		foreach ( $watcherSets as $watchers ) {
			$task = new FollowEmailTask();
			$task->title( $childTitle );
			$task->wikiId( $wg->CityId );
			$task->call(
				'emailFollowNotifications',
				$wg->User->getId(),
				$watchers,
				$user->getId(),
				$namespace,
				$message,
				$action
			);

			$task->queue();
		}
	}

	/**
	 * Create and return arrays of at most MAX_WATCHERS_PER_JOB watchers
	 *
	 * @param WikiaSQL $watcherSQL
	 *
	 * @return array
	 */
	private static function getWatcherSets( WikiaSQL $watcherSQL ) {
		$currentPage = 0;
		$watcherCount = 0;

		$watcherSets = $watcherSQL->runLoop(
			wfGetDB( DB_SLAVE ),
			function ( &$watcherSets, stdClass $row ) use ( &$currentPage, &$watcherCount ) {
				$title = $row->wl_title;
				$user = $row->wl_user;
				$watcherSets[$currentPage][$title][] = $user;

				$watcherCount++;
				if ( ( $watcherCount % self::MAX_WATCHERS_PER_JOB ) === 0 ) {
					$currentPage++;
				}
			}
		);

		return $watcherSets;
	}

	/**
	 * Generate the WikiaSQL object needed to select all the watchers
	 *
	 * @param int $userId
	 * @param string $namespace
	 * @param array $list
	 *
	 * @return WikiaSQL
	 */
	private static function getWatcherSQL( $userId, $namespace, $list, $action ) {
		/** @var WikiaSQL $watcherSQL */
		$watcherSQL = ( new WikiaSQL() )
			->SELECT( 'wl_user', 'wl_title' )
			->FROM( 'watchlist' )
			->WHERE( 'wl_user' )->NOT_EQUAL_TO( $userId )
			->AND_( 'wl_namespace' )->EQUAL_TO( $namespace )
			->AND_( 'wl_title' )->IN( $list );

		self::addAnyTimeStampCondition( $watcherSQL, $action );

		return $watcherSQL;
	}

	private static function addAnyTimeStampCondition( WikiaSQL $watcherSQL, $action ) {
		// Skip any timestamp checking if this is a blog post
		if ( $action == self::LOG_ACTION_BLOG_POST ) {
			return;
		}

		$timeAgo = self::getTimeBoundary();
		if ( !empty( $timeAgo ) ) {
			$orCondition = "(wl_notificationtimestamp IS NULL OR wl_notificationtimestamp < '$timeAgo')";
			$watcherSQL->AND_( $orCondition );
		} else {
			$watcherSQL->AND_( 'wl_notificationtimestamp' )->IS_NULL();
		}

		return;
	}

	/**
	 * Determine if we should also look at notifications with a timestamp and if so
	 * how new should they be
	 *
	 * RT#55604
	 *
	 * @author: wladek
	 * @throws MWException
	 *
	 * @return null|string
	 */
	private static function getTimeBoundary() {
		$wg = \F::app()->wg;

		// This only matters if we have the notification timeout feature enabled
		if ( empty( $wg->EnableWatchlistNotificationTimeout ) ) {
			return null;
		}

		// Only do something if a timeout has been set (zero is allowed here)
		if ( !isset( $wg->WatchlistNotificationTimeout ) ) {
			return null;
		}

		$timeAgoSecs = time() - intval( $wg->WatchlistNotificationTimeout );
		return wfTimestamp( TS_MW, $timeAgoSecs );
	}

	/**
	 * blogListingBuildRelation - hook after save of blogListing create relations in table
	 *
	 * @param string $title
	 * @param array $cat
	 * @param array $users
	 *
	 * @return bool
	 * @throws DBUnexpectedError
	 */
	static public function blogListingBuildRelation( $title, $cat, $users ) {
		$dbw = wfGetDB( DB_MASTER );

		$exploded = explode( ":", $title );
		if ( count( $exploded ) > 1 ) {
			$title =  $exploded[1];
		}

		$title = Title::makeTitle( NS_BLOG_LISTING, $title );
		$title =  $title->getDBKey();

		$dbw->begin();
		$dbw->delete( 'blog_listing_relation', array( "blr_title = " . $dbw->addQuotes( $title ) ) );

		if ( !empty( $cat ) && is_array( $cat ) ) {
			foreach ( $cat as $value ) {
				$value = Title::makeTitle( NS_CATEGORY, $value );
				$value = $value->getDBKey();
				if ( strlen( $value ) < 1 ) continue;
				$dbw->insert( 'blog_listing_relation',
					array(
						 'blr_relation' => $value,
						 'blr_title' => $title ,
		  				 'blr_type' => 'cat',
				), __METHOD__ );
			}
		}

		if ( !empty( $users ) && is_array( $users ) ) {

			foreach ( $users as $value ) {
				if ( strlen( trim( $value ) ) < 1 ) continue;
				$dbw->insert( 'blog_listing_relation',
					array(
						 'blr_relation' => $value,
						 'blr_title' => $title,
		  				 'blr_type' => 'user',
				), __METHOD__ );
			}
		}
		$dbw->commit();

		return true;
	}

	/**
	 * saveListingRelation -- hook
	 *
	 * @param Article $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minor
	 * @param $undef1
	 * @param $undef2
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 *
	 * @return bool
	 */
	static public function watchBlogListing( &$article, &$user, $text, $summary, $minor, $undef1, $undef2, &$flags, $revision, &$status, $baseRevId ) {
		if ( !$status->value['new'] ) {
			return true;
		}

		$postTitle = $article->getTitle();

		$dbw = wfGetDB( DB_SLAVE );
		if ( defined( 'NS_BLOG_ARTICLE' ) && $postTitle->getNamespace() == NS_BLOG_ARTICLE ) {
			$cat =  array_keys( Wikia::getVar( 'categoryInserts' ) );
			$catIn = array();

			foreach ( $cat as $value ) {
				$title = Title::makeTitle( NS_CATEGORY, $value );
				$catIn[] = $dbw->addQuotes( $title->getDBKey() );
			}
			$username = $user->getName();
			$con = '';

			if ( count( $catIn ) > 0 ) {
				$con .= '(blr_relation in(' . implode( ",", $catIn ) . ') AND blr_type = "cat" ) OR ';
			}
			$con .= '(blr_relation = "' . $dbw->addQuotes( $username ) . '"  AND blr_type = "user" ) ';

			$res = $dbw->select( array( 'blog_listing_relation' ),
					array( 'blr_title' ),
					$con,
					__METHOD__ );
			$related = array();
			while ( $row = $dbw->fetchObject( $res ) ) {
				// Bug fix  //
				$exploded = explode( ":", $row->blr_title );
				if ( count( $exploded ) > 1 ) {
					$title =  $exploded[1];
				} else {
					$title = $row->blr_title;
				}
				$title = Title::makeTitle( NS_BLOG_LISTING, $title );
				$related[] = ucfirst( $title->getDBKey() );
			}

			self::emailNotification(
				$postTitle,
				$related,
				NS_BLOG_LISTING,
				$user,
				self::LOG_ACTION_BLOG_POST,
				wfMessage( 'follow-bloglisting-summary' )->text()
			);

			$userBlogTitleText = $postTitle->getBaseText();
			$userBlogTitle = Title::makeTitle( NS_BLOG_ARTICLE, $userBlogTitleText );
			if ( $userBlogTitle->exists() ) {
				$userBlog[] = ucfirst( $userBlogTitle->getDBKey() );

				self::emailNotification(
					$postTitle,
					$userBlog,
					NS_BLOG_ARTICLE,
					$user,
					self::LOG_ACTION_BLOG_POST,
					wfMessage( 'follow-bloglisting-summary' )->text()
				);
			}
		}

		return true;
	}

	/**
	 * Add link to Special:MyHome in Monaco user menu
	 *
	 * TODO: remove when support for Monaco will be finished
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 *
	 * @param $skin
	 * @param $tpl
	 * @param $custom_user_data
	 *
	 * @return bool
	 */
	public static function addToUserMenu( $skin, $tpl, $custom_user_data ) {

		// don't touch anon users
		global $wgUser;
		if ( $wgUser->isAnon() ) {
			return true;
		}

		$skin->data['userlinks']['watchlist'] = array(
			'text' =>  wfMsg( 'wikiafollowedpages-special-title-userbar' ),
			'href' => Skin::makeSpecialUrl( 'following' ),
		);

		return true;
	}

	/**
	 * Add link to user dropdown in Oasis
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 *
	 * @param $personal_urls
	 * @param $title
	 *
	 * @return bool
	 */
	public static function addPersonalUrl( &$personal_urls, &$title ) {
		// don't touch anon users
		global $wgUser;
		if ( $wgUser->isAnon() ) {
			return true;
		}

		// only for Oasis users
		// replace 'watchlist' with 'followed pages'
		if ( get_class( RequestContext::getMain()->getSkin() ) == 'SkinOasis' ) {
			$personal_urls['watchlist'] = array(
				'text' =>  wfMsg( 'wikiafollowedpages-special-title-userbar' ),
				'href' => Skin::makeSpecialUrl( 'following' ),
			);
		}
		return true;
	}

	/**
	 * showAll -- ajax function to show all feeds on follow list
	 *
	 * @return bool
	 */
	static public function showAll() {
		global $wgRequest, $wgUser;

		$user_id = $wgRequest->getVal( 'user_id' );
		$head = $wgRequest->getVal( 'head' );
		$from = $wgRequest->getVal( 'from' );

		$response = new AjaxResponse();

		$user = User::newFromId( $user_id );
		if ( empty( $user ) || $user->getGlobalPreference( 'hidefollowedpages' ) ) {
			if ( $user->getId() != $wgUser->getId() ) {
				$response->addText( wfMsg( 'wikiafollowedpages-special-hidden' ) );
				return $response;
			}
		}

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars(
			array (
				"data" => FollowModel::getWatchList( $user_id, $from, FollowModel::$ajaxListLimit , $head ),
				"owner" => $wgUser->getId() == $user_id,
				"user_id" =>  $user_id,
				"more" => true,
			)
		);

		$text = $template->render( "followedPages" );

		$response->addText( $text );
		return $response;
	}

	/**
	 * renderFollowPrefs -- render prefs
	 *
	 * @param User $user
	 * @param $defaultPreferences
	 *
	 * @return bool
	 */
	static public function renderFollowPrefs( User $user, &$defaultPreferences ) {
		global $wgUseRCPatrol, $wgEnableAPI, $wgJsMimeType, $wgExtensionsPath, $wgOut, $wgUser;

		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Follow/js/ajax.js\"></script>\n" );

		$watchTypes = array(
			'edit' => 'watchdefault'
		);
		// Kinda hacky
		if ( $user->isAllowed( 'createpage' ) || $user->isAllowed( 'createtalk' ) ) {
			$watchTypes['read'] = 'watchcreations';
		}

		foreach ( $watchTypes as $action => $pref ) {
			if ( $user->isAllowed( $action ) ) {
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
		if ( $wgEnableWallEngine ) {
			if ( $wgEnableUserPreferencesV2Ext ) {
				$section = 'emailv2/email-wall-v2';
				$messageWallthread = 'tog-enotifwallthread-v2';
			}
			else {
				$section = 'watchlist/basic';
				$messageWallthread = 'tog-enotifwallthread';
			}

			// back compatybility
			$option = $wgUser->getGlobalPreference( 'enotifwallthread' );
			if ( empty( $option ) ) {
				$wgUser->setGlobalPreference( 'enotifwallthread', WALL_EMAIL_NOEMAIL );
				$wgUser->saveSettings();
			}

			$defaultPreferences['enotifwallthread'] = array(
				'type' => 'select',
				'section' => $section,
				'options' => array(
					wfMsg( 'tog-enotifmywall-every' ) => WALL_EMAIL_EVERY,
					wfMsg( 'tog-enotifmywall-sincevisited' ) => WALL_EMAIL_SINCEVISITED,
			//		wfMsg('tog-enotifmywall-reminder') => WALL_EMAIL_REMINDER,
					wfMsg( 'tog-enotifmywall-noemail' ) => WALL_EMAIL_NOEMAIL
				),
				'label-message' => $messageWallthread,
			);
		}

		$watchTypes = array();

		$watchTypes['move'] = 'watchmoves';
		$watchTypes['delete'] = 'watchdeletion';

		foreach ( $watchTypes as $action => $pref ) {
			if ( $user->isAllowed( $action ) ) {
				$defaultPreferences[$pref] = array(
					'type' => 'toggle',
					'section' => 'watchlist/advancedwatchlist',
					'label-message' => "tog-$pref",
				);
			}
		}

		// wikiafollowedpages-prefs-watchlist

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

		return false;
	}

	/**
	 * jsVars -- add java script variable to html
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	static public function jsVars( Array &$vars ) {
		$vars[ 'wgEnableWikiaFollowedPages' ] = true;
		$vars[ 'wgFollowedPagesPagerLimit' ] = FollowModel::$specialPageListLimit;
		$vars[ 'wgFollowedPagesPagerLimitAjax' ] = FollowModel::$ajaxListLimit;
		return true;
	}

	static public function addExtraToggles( $extraToggles ) {
		$extraToggles[] = 'hidefollowedpages';
		$extraToggles[] = 'enotiffollowedpages';
		$extraToggles[] = 'enotiffollowedminoredits';
		global $wgEnableWallExt;
		if ( $wgEnableWallExt ) {
			$extraToggles[] = 'enotifwallthread';
			$extraToggles[] = 'enotifmywall';
		}
		return true;
	}

	/**
	 * getMasthead -- return masthead tab for followed pages
	 *
	 * @param $userspace
	 *
	 * @return array
	 * @throws MWException
	 */
	static public function getMasthead( $userspace ) {
		global $wgUser;
		if ( ( $wgUser->getId() > 0 ) && ( $wgUser->getName() == $userspace ) ) {
			return [
				'text' => wfMsg( 'wikiafollowedpages-masthead' ),
				'href' => Title::newFromText( "Following", NS_SPECIAL )->getLocalUrl(),
				'dbkey' => 'Following',
				'tracker' => 'following'
			];
		}
		return null;
	}

	/**
	 * renderUserProfile -- return masthead tab for fallowed pages
	 *
	 * @param $out
	 *
	 * @return array
	 */
	static public function renderUserProfile( &$out ) {
		global $wgTitle, $wgRequest, $wgOut, $wgExtensionsPath, $wgUser;

		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			return true;
		}

		if ( ( $wgUser->getId() != 0 ) && ( $wgRequest->getVal( "hide_followed", 0 ) == 1 ) ) {
			$wgUser->setGlobalPreference( "hidefollowedpages", true );
			$wgUser->saveSettings();
		}

		$key = $wgTitle->getDBKey();

		if ( strlen( $key ) > 0 ) {
			$user = User::newFromName( $key );

			if ( $user == null ) {
				return true;
			}

			if ( $user->getId() == 0 ) {
				// not a real user
				return true;
			}
		} else {
			$user = $wgUser;
		}

		// do not show Followed box on diffs
		if ( $wgRequest->getVal( 'diff', null ) != null ) {
			return true;
		}

		if ( $user->getGlobalPreference( "hidefollowedpages" ) ) {
			return true;
		}

		$data = FollowModel::getUserPageWatchList( $user->getId() );

		$wgOut->addExtensionStyle( "{$wgExtensionsPath}/wikia/Follow/css/userpage.css" );
		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

		if ( count( $data ) == 0 ) $data = null;

		// BugId:2643
		$moreUrl = null;
		if ( $wgUser->getId() == $user->getId() ) {
			$specialPage = SpecialPage::getSafeTitleFor( 'Following', $user->getName() );
			if ( !empty( $specialPage ) ) {
				$moreUrl = $specialPage->getLocalUrl();
			}
		}

		$template->set_vars(
			array(
				"isLogin" => ( $wgUser->getId() == $user->getId() ),
				"hideUrl" => $wgTitle->getFullUrl( "hide_followed=1" ),
				"data" 	=> $data,
				// show "more" only if wathing own user page
				"moreUrl" => $moreUrl,
			)
		);

		$out['followedPages'] = $template->render( "followedUserPage" );
		return true;
	}

	/**
	 * MailNotifyBuildKeys -- return build keys for mail
	 *
	 * @param $keys
	 * @param $action
	 * @param $other_param
	 *
	 * @return array
	 * @throws MWException
	 */
	static public function mailNotifyBuildKeys( &$keys, $action, $other_param ) {
		global $wgEnableForumExt;
		$actionsList = [ self::LOG_ACTION_CATEGORY_ADD, self::LOG_ACTION_BLOG_POST ];
		if ( !in_array( $action, $actionsList ) ) {
			return true;
		}

		$page = Title::newFromText( $keys['$PAGETITLE'] );

		/** @var Title $childTitle */
		$childTitle = $other_param['childTitle'];

		$keys['$PAGETITLE'] = $childTitle->getPrefixedText();
		$keys['$PAGETITLE_URL'] = $childTitle->getFullUrl();

		if ( $action == self::LOG_ACTION_CATEGORY_ADD ) {
			$keys['$CATEGORY_URL'] = $page->getFullUrl();
			$keys['$CATEGORY'] = $page->getText();

			// Format Forum thread URLs when added to category
			if ( !empty( $wgEnableForumExt )
				&& $childTitle->getNamespace() === NS_WIKIA_FORUM_BOARD_THREAD
			) {
				$titleParts = explode( '/', $childTitle->getPrefixedText() );

				// Handle replies, can't use WallMessage::getTopParentObj as the comments
				// index isn't updated yet
				if ( strpos( $titleParts[count( $titleParts ) - 2], ARTICLECOMMENT_PREFIX ) === 0 ) {
					$titleText = implode( '/', array_slice( $titleParts, 0, count( $titleParts ) - 1 ) );
					$childTitle = Title::newFromText( $titleText );
				}
				$wallMessage = WallMessage::newFromTitle( $childTitle );
				$wallMessage->load();
				$threadTitle = Title::newFromText( $wallMessage->getID(), NS_USER_WALL_MESSAGE );

				$keys['$PAGETITLE'] = $wallMessage->getMetaTitle();
				$keys['$PAGETITLE_URL'] = $threadTitle->getFullURL();
			}
			return true;
		}

		if ( $action == self::LOG_ACTION_BLOG_POST ) {
			$keys['$BLOGLISTING_URL'] = $page->getFullUrl();
			$keys['$BLOGLISTING'] = $page->getText();
			return true;
		}

		return true;
	}

	/**
	 * categoryIndexer --  indexer for blog listing page used only one time by indexing script
	 *
	 * @param CreateBlogListingPage $blogListing
	 * @param $article
	 *
	 * @return bool
	 */
	static public function categoryIndexer( &$blogListing, $article ) {
		global $wgRequest;
		if ( $wgRequest->getVal( "makeindex", 0 ) != 1 ) {
			return true;
		}

		if ( $article != null ) {
			$blogListing->parseTag( urldecode( $article ) );
			$cats = BlogTemplateClass::getCategoryNames();
			if ( count( $cats ) > 0 ) {
				self::blogListingBuildRelation( $article, $cats, array() );
			}
		}
		return true;
	}

	/**
	 * SUS-770: Invalidate Followed Pages Rail module if the user follows a page
	 * @param User $user User who followed the page
	 * @param WikiPage|Article $article unused
	 * @return bool true to continue hook processing
	 */
	static public function onWatchArticleComplete( User $user, $article ) {
		Wikia::purgeSurrogateKey(
			$user->getUserPage()
		);
		Wikia::purgeSurrogateKey(
			$user->getTalkPage()
		);
		return true;
	}
}
