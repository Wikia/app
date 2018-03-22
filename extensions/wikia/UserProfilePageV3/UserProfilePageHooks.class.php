<?php
class UserProfilePageHooks {

	/**
	 * @brief remove User:: from back link
	 *
	 * @author Tomek Odrobny
	 *
	 * @param Title $title
	 * @param String $ptext
	 *
	 * @return Boolean
	 */
	static public function onSkinSubPageSubtitleAfterTitle( $title, &$ptext ) {
		if ( !empty( $title ) && $title->getNamespace() == NS_USER ) {
			$ptext = $title->getText();
		}

		return true;
	}

	/**
	 * @brief adds wiki id to cache and fav wikis instantly
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onArticleSaveComplete(
		WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis,
		$sectionanchor, $flags, $revision, Status &$status, $baseRevId
	): bool {
		global $wgCityId;
		if ( $revision !== NULL ) { // do not count null edits
			$wikiId = intval( $wgCityId );

			if ( $user instanceof User && $wikiId > 0 ) {
				$userIdentityBox = new UserIdentityBox( $user );
				$userIdentityBox->addTopWiki( $wikiId );
			}
		}
		return true;
	}

	/**
	 * @brief WikiaMobile hook to add assets so they are minified and concatenated
	 *
	 * @param array $jsStaticPackages
	 * @param array $jsExtensionPackages
	 * @param array $scssPackages
	 *
	 * @return Boolean
	 */
	static public function onWikiaMobileAssetsPackages( &$jsStaticPackages, &$jsExtensionPackages, &$scssPackages ) {
		$wg = F::app()->wg;
		if ( $wg->Title->getNamespace() === NS_USER ) {
			$scssPackages[] = 'userprofilepage_scss_wikiamobile';
		}
		return true;
	}

	/**
	 * @brief hook handler
	 * @param Skin $skin
	 * @param QuickTemplate $template
	 * @return bool true
	 */
	static public function onSkinTemplateOutputPageBeforeExec( Skin $skin, QuickTemplate $template ): bool {
		return self::addToUserProfile( $skin, $template );
	}

	/**
	 * @brief Monobook fallback for UUP
	 *
	 * @param Skin $skin
	 * @param QuickTemplate $tpl
	 *
	 * @return Boolean
	 */
	static function addToUserProfile( Skin $skin, QuickTemplate $tpl ): bool {
		wfProfileIn( __METHOD__ );

		// don't output on Oasis
		if ( $skin->getSkinName() === 'oasis' ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$title = $skin->getTitle();
		$action = $skin->getRequest()->getVal( 'action', 'view' );

		if ( !$title->inNamespace( NS_USER ) || ( $action != 'view' && $action != 'purge' ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		// construct object for the user whose page were' on
		$user = User::newFromName( $title->getDBKey() );

		// sanity check
		if ( !is_object( $user ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$user->load();

		// abort if user has been disabled
		if ( defined( 'CLOSED_ACCOUNT_FLAG' ) && $user->mRealName == CLOSED_ACCOUNT_FLAG ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		// abort if user has been disabled (v2, both need to be checked for a while)
		$disabledOpt = $user->getGlobalFlag( 'disabled' );
		if ( !empty( $disabledOpt ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$outputPage = $skin->getOutput();

		if ( $skin->getSkinName() === 'oasis' && !$user->isAnon() ) {
			$outputPage->prependHTML( F::app()->renderView( 'UserProfilePage', 'index' ) );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$html = '';

		$out = array();
		Hooks::run( 'AddToUserProfile', array( &$out, $user ) );

		if ( count( $out ) > 0 ) {
			global $wgExtensionsPath;
			$outputPage->addExtensionStyle( "{$wgExtensionsPath}/wikia/UserProfilePageV3/css/UserprofileMonobook.css" );

			$html .= "<div id='profile-content'>";
			$html .= "<div id='profile-content-inner'>";
			$html .= $tpl->data['bodytext'];
			$html .= "</div>";
			$html .= "</div>";

			$outputPage->addStyle( "common/article_sidebar.css" );

			$html .= '<div class="article-sidebar">';
			if ( isset( $out['UserProfile1'] ) ) {
				$html .= $out['UserProfile1'];
			}
			if ( isset( $out['achievementsII'] ) ) {
				$html .= $out['achievementsII'];
			}
			if ( isset( $out['followedPages'] ) ) {
				$html .= $out['followedPages'];
			}
			$html .= '</div>';

			$tpl->data['bodytext'] = $html;
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

}
