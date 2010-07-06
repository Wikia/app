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
			return true;
		}
		
		wfLoadExtensionMessages( 'Follow' );
				
		$dbw = wfGetDB( DB_SLAVE );
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
	
	function emailNotification($childTitle, $list, $namespace, $user, $action, $message) {
		global $wgTitle;
		
		wfProfileIn( __METHOD__ );

		if ( count($list) < 1 ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
	
		$dbw = wfGetDB( DB_SLAVE );
		$queryIn = "";
		foreach ($list as $value) {
                    $queryIn[] = $dbw->addQuotes( $value ) ;
		}

		$con =
				'wl_namespace = '.$namespace.' '
				.' and wl_title in('.implode(",",$queryIn).') '
				.' and wl_user != ' . intval( $user->getID()  )
				.' and wl_notificationtimestamp IS NULL';

		$res = $dbw->select( array( 'watchlist' ),
				array( 'wl_user, wl_title' ),
				$con,
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
		

		$now = wfTimestampNow();
		
		foreach ($watchers as $key => $value) {
			$enotif = new EmailNotification();
			$title = Title::makeTitle( $namespace, $key );		
			$enotif->notifyOnPageChange( $user, $title,
				$now,
				$message,
				0,
				0,
				$action,
				array('childTitle' => $childTitle) );
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
                
		$dbw->begin();
		$dbw->delete( 'blog_listing_relation', array( "blr_title = ". $dbw->addQuotes( $title ) ) );

		if ((!empty($cat)) && (is_array($cat)) ) {
			foreach ($cat as $value) {
				if( strlen($value) < 1 ) continue;
				$dbw->insert('blog_listing_relation',
					array(
						 'blr_relation' => $value,
						 'blr_title' => $title,
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
		wfLoadExtensionMessages( 'Follow' );
		
		$dbw = wfGetDB( DB_SLAVE );
		if ($article->getTitle()->getNamespace() == NS_BLOG_ARTICLE ) {
			$title = Title::makeTitle( NS_CATEGORY, $key ); 	
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
                                    $related[] =  $exploded[1];
                                } else {
                                    $related[] = $row->blr_title;
                                }
			}
			self::emailNotification($article->getTitle(), $related, NS_BLOG_LISTING, $user, "blogpost", wfMsg('follow-bloglisting-summary'));
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
	

	/*
	 * Add link to Special:MyHome in Monaco user menu
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

		wfLoadExtensionMessages('Follow');
		$skin->data['userlinks']['watchlist'] = array(
			'text' =>  wfMsg('wikiafollowedpages-special-title-userbar'),
			'href' => Skin::makeSpecialUrl('following'),
		);

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
		global $wgRequest,$wgUser,$wgExternalSharedDB,$wgWikiaEnableConfirmEditExt;
		wfProfileIn(__METHOD__);
		
		wfLoadExtensionMessages( 'Follow' );
		
		$user_id = $wgRequest->getVal( 'user_id' );
		$head = $wgRequest->getVal( 'head' );
                $from = $wgRequest->getVal( 'from' );
                
                $response = new AjaxResponse();
		
		$user = User::newFromId($user_id);
		if ( empty($user) || $user->getOption('hidefollowedpages') ) {
			if( $user->getId() != $wgUser->getId() ) {
				$response->addText( wfMsg('wikiafollowedpages-special-hidden') );
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
	
	
	static public function renderFollowPrefs($self, $out) {
		global $wgUser, $wgEnableWikiaFollowedPages, $wgEnotifWatchlist, $wgEnotifMinorEdits,$disableEmailPrefs,$wgStyleVersion, $wgExtensionsPath, $wgJsMimeType;
		wfProfileIn(__METHOD__);
		wfLoadExtensionMessages( 'Follow' );
		$watchlistToggles = array();
					
		$self->mUsedToggles['hidefollowedpages'] = true;
		$self->mUsedToggles['enotiffollowedpages']  = true;
		$self->mUsedToggles['enotiffollowedminoredits']  = true;

		$wgUser->setOption( 'enotiffollowedpages', $wgUser->getOption( 'enotifwatchlistpages' ) );
		$wgUser->setOption( 'enotiffollowedminoredits', $wgUser->getOption( 'enotifminoredits' ) );
	
		$out->addHTML(
			Xml::fieldset( wfMsg( 'prefs-watchlist' ) ) .
			$self->getToggles( $watchlistToggles )
		);
		if( $wgUser->isAllowed( 'createpage' ) || $wgUser->isAllowed( 'createtalk' ) ) {
			$out->addHTML( $self->getToggle( 'watchcreations' ) );
		}
		
		if( $wgUser->isAllowed( 'edit' ) )
			$out->addHTML( $self->getToggle( 'watchdefault' ) );
		
		$out->addHTML( ($wgEnotifWatchlist) ? $self->getToggle( 'enotiffollowedpages', false, $disableEmailPrefs ) : '');
		$out->addHTML( ($wgEnotifWatchlist && $wgEnotifMinorEdits) ? $self->getToggle( 'enotiffollowedminoredits', false, $disableEmailPrefs ) : '');	
		$out->addHTML( $self->getToggle( 'hidefollowedpages', false  ) );	
		
		$out->addHTML( "<br><h2>".wfMsg('wikiafollowedpages-prefs-advanced')."</h2>" );			
		foreach( array(  'move' => 'watchmoves', 'delete' => 'watchdeletion' ) as $action => $toggle ) {
			if( $wgUser->isAllowed( $action ) )
				$out->addHTML( $self->getToggle( $toggle ) );
		}
		
		$watchlistToggles = array( 'watchlisthideminor', 'watchlisthidebots', 'watchlisthideown',
			'watchlisthideanons', 'watchlisthideliu' );
				
		$out->addHTML(
			"<br><h2>".wfMsg('wikiafollowedpages-prefs-watchlist')."</h2>".
			Xml::inputLabel( wfMsg( 'prefs-watchlist-days' ), 'wpWatchlistDays', 'wpWatchlistDays', 3, $self->mWatchlistDays ) . ' ' .
			wfMsgHTML( 'prefs-watchlist-days-max' ) .
			'<br />' .
			Xml::inputLabel( wfMsg( 'prefs-watchlist-edits' ), 'wpWatchlistEdits', 'wpWatchlistEdits', 3, $self->mWatchlistEdits ) . ' ' .
			wfMsgHTML( 'prefs-watchlist-edits-max' ) .
			'<br /><br />' .
			$self->getToggle( 'extendwatchlist' ).
			$self->getToggles( $watchlistToggles )
			 );	
			
		$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Follow/js/ajax.js?{$wgStyleVersion}\"></script>\n");
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
	
	static public function jsVars($vars) {
		$vars[ 'wgEnableWikiaFollowedPages' ] = true;
                $vars[ 'wgFollowedPagesPagerLimit' ] = FollowModel::$specialPageListLimit;
                $vars[ 'wgFollowedPagesPagerLimitAjax' ] = FollowModel::$ajaxListLimit;
		return true;	
	} 
	
	static public function addExtraToggles($extraToggles) {
		$extraToggles[] = 'hidefollowedpages';
		$extraToggles[] = 'enotiffollowedpages';
		$extraToggles[] = 'enotiffollowedminoredits';
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
		wfLoadExtensionMessages( 'Follow' );
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
		global $wgTitle, $wgRequest, $wgOut, $wgStyleVersion, $wgExtensionsPath, $wgJsMimeType, $wgStyleVersion, $wgUser;
		wfProfileIn(__METHOD__);
		if( ($wgUser->getId() != 0) && ($wgRequest->getVal( "hide_followed", 0) == 1) ) {
			$wgUser->setOption( "hidefollowedpages", true ); 
			$wgUser->saveSettings();
		}
		
		$key = $wgTitle->getDBKey(); 	
		
		if ( strlen($key) > 0 ) {
			$user = User::newFromName($key);

			if ($user == null) {
				return true;
			}
		
			if($user->getId() == 0) {
				//not a real user
				return true;
			}
		} else {
			$user = $wgUser;
		}
		
		// do not show Followed box on diffs
		if ( $wgRequest->getVal( 'diff', null ) != null ) {
			return true;
		}
		
		if( $user->getOption( "hidefollowedpages" ) ) {
			return true;
		}
		
		$data = FollowModel::getUserPageWatchList( $user->getId() );
		
		wfLoadExtensionMessages( 'Follow' );
				
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/Follow/css/userpage.css?{$wgStyleVersion}");	
		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		
		if ( count($data) == 0 ) $data = null;
	/*	
		if ( count($data) > 5 ) {
			$data2 = array_slice($data, 5 );
			$data = array_slice($data, 0, 5);
		} */
		
		$template->set_vars(
			array (
				"isLogin" => ($wgUser->getId() == $user->getId() ),
				"hideUrl" => $wgTitle->getFullUrl( "hide_followed=1" ),
				"data" 	=> $data,
				// show "more" only if wathing own user page 
				"moreUrl" => $wgUser->getId() == $user->getId() ? Skin::makeSpecialUrlSubpage('following', $user->getName()) : null,
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
