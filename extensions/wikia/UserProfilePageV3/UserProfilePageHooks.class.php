<?php
class UserProfilePageHooks {

	/**
	 * @brief remove User:: from back link
	 *
	 * @author Tomek Odrobny
	 *
	 * @param $title Title
	 */

	static public function onSkinSubPageSubtitleAfterTitle($title, &$ptext) {
		if (!empty($title) && $title->getNamespace() == NS_USER) {
			$ptext = $title->getText();
		}

		return true;
	}



	/**
	 * @brief adds wiki id to cache and fav wikis instantly
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		global $wgCityId;
		if ($revision !== NULL) { // do not count null edits
			$wikiId = intval($wgCityId);

			if ($user instanceof User && $wikiId > 0) {
				$userIdentityBox = new UserIdentityBox(F::app(), $user, UserProfilePageController::MAX_TOP_WIKIS);
				$userIdentityBox->addTopWiki($wikiId);
			}
		}
		return true;
	}

	//WikiaMobile hook to add assets so they are minified and concatenated
	static public function onWikiaMobileAssetsPackages( &$jsStaticPackages, &$jsExtensionPackages, &$scssPackages){
		$wg = F::app()->wg;
		if ( $wg->Title->getNamespace() === NS_USER ) {
			$scssPackages[] = 'userprofilepage_scss_wikiamobile';
		}
		return true;
	}

	/**
	 * @brief hook handler
	 */
	static public function onSkinTemplateOutputPageBeforeExec($skin, $template) {
		return self::addToUserProfile($skin, $template);
	}
	/**
	 *
	 * Monobook fallback for UUP
	 *
	 */

	static function addToUserProfile(&$skin, &$tpl) {
		wfProfileIn(__METHOD__);

		$wg = F::app()->wg;

		// don't output on Oasis
		if (get_class(RequestContext::getMain()->getSkin()) == 'SkinOasis') {
			wfProfileOut(__METHOD__);
			return true;
		}

		$action = $wg->Request->getVal('action', 'view');
		if ($wg->Title->getNamespace() != NS_USER || ($action != 'view' && $action != 'purge')) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// construct object for the user whose page were' on
		$user = User::newFromName($wg->Title->getDBKey());

		// sanity check
		if (!is_object($user)) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$user->load();

		// abort if user has been disabled
		if (defined('CLOSED_ACCOUNT_FLAG') && $user->mRealName == CLOSED_ACCOUNT_FLAG) {
			wfProfileOut(__METHOD__);
			return true;
		}
		// abort if user has been disabled (v2, both need to be checked for a while)
		$disabledOpt = $user->getOption('disabled');
		if (!empty($disabledOpt)) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$html = '';

		$out = array();
		wfRunHooks('AddToUserProfile', array(&$out, $user));

		if (count($out) > 0) {
			$wg->Out->addExtensionStyle("{$wg->ExtensionsPath}/wikia/UserProfilePageV3/css/UserprofileMonobook.css");

			$html .= "<div id='profile-content'>";
			$html .= "<div id='profile-content-inner'>";
			$html .= $tpl->data['bodytext'];
			$html .= "</div>";
			$html .= "</div>";

			$wg->Out->addStyle("common/article_sidebar.css");

			$html .= '<div class="article-sidebar">';
			if (isset($out['UserProfile1'])) {
				$html .= $out['UserProfile1'];
			}
			if (isset($out['achievementsII'])) {
				$html .= $out['achievementsII'];
			}
			if (isset($out['followedPages'])) {
				$html .= $out['followedPages'];
			}
			$html .= '</div>';

			$tpl->data['bodytext'] = $html;
		}
		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Don't send 404 status for user pages with filled in masthead (bugid:44602)
	 * @brief hook handler
	 */
	static public function onBeforeDisplayNoArticleText($article) {
		global $UPPNamespaces;
		$wg = F::app()->wg;
		$title = $article->getTitle();
		if ($title instanceof Title && in_array($title->getNamespace(), $UPPNamespaces)) {
			$user = UserProfilePageHelper::getUserFromTitle($title);
			if ( $user instanceof User && $user->getId() > 0) {
				$userIdentityBox = new UserIdentityBox( F::app(), $user, UserProfilePageController::MAX_TOP_WIKIS );
				$userData = $userIdentityBox->getFullData();
				if ( is_array( $userData ) && array_key_exists( 'showZeroStates', $userData ) ) {
					if ( !$userData['showZeroStates'] ) {
						$wg->Out->setStatusCode ( 200 );
					}
				}
			}
		}
		return true;
	}

}