<?php

class RecipesTweaks {

	private static $headerStripeShown = null;

	/**
	 * Add CSS/JS files
	 */
	public static function beforePageDisplay(&$out, &$sk) {
		global $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		$out->addExtensionStyle("{$wgExtensionsPath}/wikia/RecipesTweaks/RecipesTweaks.css?{$wgStyleVersion}");
		$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/RecipesTweaks/RecipesTweaks.js?{$wgStyleVersion}\"></script>\n");
		return true;
	}

	/**
	 * Add CSS class to <body> when header stripe is shown
	 */
	public static function addBodyClass(&$classes) {
		wfProfileIn(__METHOD__);

		if (self::isHeaderStripeShown()) {
			$classes .= ' recipes_header_stripe_shown';
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Replace "Watchlist" link with link to "Saved Recipes"
	 */
	public static function replaceWatchlistUserLink(&$skin, &$tpl, &$user_data) {
		wfProfileIn(__METHOD__);

		if (!empty($skin->data['userlinks']['watchlist'])) {
			// i18n
			wfLoadExtensionMessages('RecipesTweaks');

			$skin->data['userlinks']['watchlist'] = array(
				'text' => wfMsg('savedpages'),
				'href' => Skin::makeSpecialUrl('SavedPages'),
			);
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Add article action bar
	 */
	public static function renderArticleActionBar(&$skin, &$tpl) {
		global $wgStylePath;
		wfProfileIn(__METHOD__);

		if (!self::isHeaderStripeShown()) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// don't break skins other than Monaco
		if (get_class($skin) != 'SkinMonaco') {
			wfProfileOut(__METHOD__);
			return false;
		}

		// i18n
		wfLoadExtensionMessages('RecipesTweaks');

		// get list of content actions
		$contentActions = $tpl->data['content_actions'];

		// force watch action to be displayed
		if($skin->iscontent && !isset($contentActions['watch']) && !isset($contentActions['unwatch'])) {
			$contentActions['watch'] = array(
				'text' => wfMsg('watch'),
				'href' => '#'
			);
		}

		// let's reorder and filter content actions
		// scan for article actions to be added in given order
		$actions = array('watch', 'unwatch', 'share_feature', 'edit', 'delete', 'move', 'protect');

		$actionBar = array();
		foreach($actions as $actionName) {
			if (isset($contentActions[$actionName])) {
				$actionBar[$actionName] = $contentActions[$actionName];
			}
		}

		// don't render empty action bar
		if (empty($actionBar)) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// render action bar
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');

		$template->set_vars(array(
			'actionBar' => $actionBar,
			'skin' => $skin,
			'wgStylePath' => $wgStylePath
		));

		$html = $template->render('actionBar');

		// add action bar before article content
		$tpl->data['bodytext'] = $html . $tpl->data['bodytext'];

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Render search box, "Add new recipe" tab and article rating tool (if needed)
	 */
	public static function renderArticleHeaderTabs($skin) {
		wfProfileIn(__METHOD__);

		global $wgTitle, $wgUser, $wgRequest;

		// i18n
		wfLoadExtensionMessages('RecipesTweaks');

		// render tabs
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		global $wgBlankImgUrl;
		$template->set_vars(array(
			'blank' => $wgBlankImgUrl,
			'newRecipeAction' => Skin::makeSpecialUrl('CreatePage'),
			'searchAction' =>  $skin->data['searchaction'],
			'skin' => $wgUser->getSkin(),
		));

		// show rating only on main namespace (for existing articles, ignore main pages and actions other than view)
		if (self::isArticleView()) {
			$rating = self::getArticleRating();
			$template->set('rating', $rating);
		}

		echo $template->render('headerTabs');

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Render article title and first contributor data
	 */
	public static function renderArticleHeaderStripe($skin) {
		wfProfileIn(__METHOD__);

		// show header stripe only on certain namespaces and for certain actions
		if (!self::isHeaderStripeShown()) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// i18n
		wfLoadExtensionMessages('RecipesTweaks');

		// render header stripe
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');

		// article title (with special case for main page)
		$isMainPage = self::isMainPage();
		if ($isMainPage) {
			$template->set('title', wfMsg('recipes-mainpage-title'));
		}
		else {
			$template->set('title', $skin->data['title']);
		}

		// get first contributor (only for main namespace / exclude main page)
		if (self::isArticleView()) {
			global $wgTitle;
			$firstRevision = $wgTitle->getFirstRevision();

			if (!empty($firstRevision)) {
				$creator = User::newFromId( $firstRevision->getRawUser() );

				// render contributor's avatar
				$avatar = Masthead::newFromUser($creator)->getImageTag(20, 20);

				// for anons and users without user pages
				$url = Skin::makeSpecialUrl('Contributions/' . $creator->getName());

				// show avatar and link to user page only for registered users
				if ($creator->isLoggedIn()) {
					$label = $creator->getName();

					// link to user page only if it exists
					$userPage = $creator->getUserPage();
					if ($userPage->exists()) {
						$url = $userPage->getLocalUrl();
					}
				}
				else {
					// anon creator
					$label = wfMsg('recipes-contributed-by-anon');
				}

				// link to contributor's user page
				$userLink = Xml::element('a', array('href' => $url), $label);

				$template->set_vars(array(
					'avatar' => $avatar,
					'showContrib' => true,
					'userLink' => $userLink,
				));
			}
		}

		echo $template->render('headerStripe');

		// hide article title rendered by MW
		global $wgSupressPageTitle;
		$wgSupressPageTitle = true;

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Add users's five most recently saved pages
	 */
	public static function renderUserSavedPagesBox(&$skin, &$tpl) {
		wfProfileIn(__METHOD__);

		if (!self::isUserPage()) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// i18n
		wfLoadExtensionMessages('RecipesTweaks');

		// create instance of User class
		global $wgTitle;
		$userName = $wgTitle->getText();
		$user = User::newFromName($userName);

		// user page of not existing user
		if (empty($user) || $user->getId() == 0) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$userId = $user->getId();

		// get user's saved pages
		$pages = self::getSavedPages($user->getId(), 5, false);

		// link to Special:SavedPages for current user
		global $wgUser;
		if ($userId == $wgUser->getId()) {
			$moreLink = Skin::makeSpecialUrl('SavedPages');
		}
		else {
			$moreLink = Skin::makeSpecialUrl("SavedPages/{$userName}");
		}

		// render user saved pages box
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'moreLink' => $moreLink,
			'pages' => $pages,
		));

		$html = $template->render('userSavedPagesBox');

		// add floating box before article content
		$tpl->data['bodytext'] = $html . $tpl->data['bodytext'];

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Show header stripe when there's no user masthead
	 */
	public static function isHeaderStripeShown() {
		wfProfileIn(__METHOD__);

		if ( is_null(self::$headerStripeShown) ) {
			// show only on view
			global $wgRequest;
			$action = $wgRequest->getVal('action', 'view');
			$actions = array('view', 'purge', 'delete', 'protect', 'history', 'watch', 'unwatch');

			// "detect" user masthead
			$isMastheadShown = Masthead::isMastheadShown();

			// don't show on pages with user masthead and on actions other than "view"
			self::$headerStripeShown = empty($isMastheadShown) && in_array($action, $actions);
		}

		wfProfileOut(__METHOD__);

		return self::$headerStripeShown;
	}

	/**
	 * Get rating for current article
	 */
	private static function getArticleRating() {
		wfProfileIn(__METHOD__);

		global $wgArticle;
		$articleId = $wgArticle->getId();

		$FauxRequest = new FauxRequest(array(
			'action' => 'query',
			'list' => 'wkvoteart',
			'wkpage' => $articleId,
			'wkuservote' => true
		));

		$oApi = new ApiMain($FauxRequest);
		try { $oApi->execute(); } catch (Exception $e) {};
		$aResult =& $oApi->GetResultData();

		if( !empty( $aResult['query']['wkvoteart'] ) ) {
			if(!empty($aResult['query']['wkvoteart'][$articleId]['uservote'])) {
				$voted = true;
			} else {
				$voted = false;
			}
			if (!empty($aResult['query']['wkvoteart'][$articleId]['votesavg'])) {
				$rating = $aResult['query']['wkvoteart'][$articleId]['votesavg'];
			} else {
				$rating = 0;
			}
		} else {
			$voted = false;
			$rating = 0;
		}

		$rating = round($rating * 2)/2;
		$ratingPx = round($rating * 17);

		wfProfileOut(__METHOD__);

		return array(
			'stars' => $rating,
			'pixels' => $ratingPx,
			'voted' => $voted,
		);
	}

	/**
	 * Check if current article is main page
	 */
	private static function isMainPage() {
		global $wgArticle, $wgTitle;

		wfProfileIn(__METHOD__);

		$mainpage = wfMsgForContent('mainpage');

		$isMainpage = ($wgTitle->getArticleId() == Title::newMainPage()->getArticleId() && $wgTitle->getArticleId() != 0);

		if(!$isMainpage) {
			if(!empty($wgArticle->mRedirectedFrom)) {
				if($mainpage == $wgArticle->mRedirectedFrom->getPrefixedText()) {
					$isMainpage = true;
				}
			}
		}

		wfProfileOut(__METHOD__);

		return $isMainpage;
	}

	/**
	 * Check if current article is "main" (not a subpage of) user page (ignore actions other than view)
	 */
	private static function isUserPage() {
		wfProfileIn(__METHOD__);

		global $wgTitle, $wgRequest;

		$action = $wgRequest->getVal('action', 'view');
		$ns = $wgTitle->getNamespace();

		$res = ($ns == NS_USER) && in_array($action, array('view', 'purge')) && !$wgTitle->isSubpage();

		wfProfileOut(__METHOD__);

		return $res;
	}

	/**
	 * Check if current page is an existing article from main namespace (exclude mainpage) and action is 'view'
	 */
	private static function isArticleView() {
		wfProfileIn(__METHOD__);

		global $wgTitle, $wgRequest;

		$action = $wgRequest->getVal('action', 'view');
		$ns = $wgTitle->getNamespace();

		$res = ($ns == NS_MAIN) && $wgTitle->exists() && in_array($action, array('view', 'purge')) && !self::isMainPage();

		wfProfileOut(__METHOD__);

		return $res;
	}

	/**
	 * Return list of pages from watchlist - order by addition time
	 * Eventually add information about creator of each page
	 */
	public static function getSavedPages($userId, $limit = 500, $withCreators = true) {
		wfProfileIn(__METHOD__);

		$dbr = wfGetDB(DB_SLAVE);

		$res = $dbr->select(
			'watchlist',
			'wl_namespace, wl_title',
			array('wl_user' => $userId, 'wl_namespace % 2 = 0', 'wl_namespace != '.NS_USER_TALK, 'wl_namespace != '.NS_FILE),
			__METHOD__,
			array('ORDER BY' => 'wl_wikia_addedtimestamp DESC', 'LIMIT' => $limit)
		);

		$out = array();

		foreach( $res as $row ) {
			$title = Title::newFromText($row->wl_title, $row->wl_namespace);

			if(!($title instanceof Title)) {
				continue;
			}

			$item = array(
				'title' => $title->getPrefixedText(),
				'url' => $title->getLocalUrl()
			);

			if($withCreators) {
				$firstRevision = $title->getFirstRevision();

				if(!($firstRevision instanceof Revision)) {
					continue;
				}

				$userCreator = User::newFromId($firstRevision->getRawUser());

				if(!($userCreator instanceof User)) {
					continue;
				}


				// if it is a logged in user
				if(!$userCreator->isAnon()) {
					$item['userTitle'] = $userCreator->getName();

					// if logged in user has an existing user page
					$userPage = $userCreator->getUserPage();
					if($userPage->exists()) {
						$item['userUrl'] = $userPage->getLocalUrl();
					}

				} else {
					$item['userTitle'] = wfMsg('recipes-contributed-by-anon');
				}

				// if link to user page has not been set (anon user or logged in user without user page) then point to Specia:Contributions
				if(!isset($item['userUrl'])) {
					$item['userUrl'] = Skin::makeSpecialUrl('Contributions/'.$userCreator->getName());
				}
			}

			$out[] = $item;
		}

		wfProfileOut(__METHOD__);

		return $out;
	}
}
