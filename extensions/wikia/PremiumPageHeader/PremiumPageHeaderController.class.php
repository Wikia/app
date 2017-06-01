<?php

class PremiumPageHeaderController extends WikiaController {

	public function articleHeader() {
		global $wgRequest, $wgTitle;

		$skinVars = $this->app->getSkinTemplateObj()->data;
		$this->content_actions = $skinVars['content_actions'];

		// edit button preparation
		// action button (edit / view soruce) and dropdown for it
		$this->prepareActionButton();
		// dropdown actions
		$this->dropdown = $this->getDropdownActions();

		$this->applyEditButtonLoginAction();

		// comments/talk button
		$commentsEnabled = $this->checkArticleComments();
		$this->commentButtonMsg = $commentsEnabled ? 'oasis-page-header-comments' : 'oasis-page-header-talk';
		$this->commentsLink = $this->getCommentsLink();

		$this->setVal( 'displaytitle', $skinVars['displaytitle'] );
		if ( WikiaPageType::isMainPage() ) {
			// change page title to just "Home"
			$title = wfMessage( 'oasis-home' )->escaped();
		} else {
			$title = $skinVars['title'];
		}

		$action = $wgRequest->getVal( 'action', 'view' );
		$isEdit = in_array( $action, [ 'edit', 'submit' ] );
		$isSectionEdit = is_numeric( $wgRequest->getVal( 'section' ) );
		$isPreview = $wgRequest->getCheck( 'wpPreview' ) || $wgRequest->getCheck( 'wpLivePreview' );
		$isShowChanges = $wgRequest->getCheck( 'wpDiff' );
		$isDiff = !is_null( $wgRequest->getVal( 'diff' ) ); // RT #69931
		$isHistory = $action == 'history';

		// choose header message
		$titleMsg = '';
		if ( $isPreview ) {
			$titleMsg = 'oasis-page-header-preview';
		} else {
			if ( $isShowChanges ) {
				$titleMsg = 'oasis-page-header-changes';
			} else {
				if ( $isDiff ) {
					$titleMsg = 'oasis-page-header-diff';
				} else {
					if ( $isSectionEdit ) {
						$titleMsg = 'oasis-page-header-editing-section';
					} else {
						if ( $isHistory ) {
							$titleMsg = 'oasis-page-header-history';
						} else {
							if ( $isEdit ) {
								$titleMsg = 'oasis-page-header-editing';
							}
						}
					}
				}
			}
		}

		$title = empty( $titleMsg ) ? $title : wfMsg( $titleMsg, htmlspecialchars( $wgTitle->getPrefixedText() ) );

		$categoryLinks = $this->getContext()->getOutput()->getCategoryLinks();
		$normalCategoryLinks = $categoryLinks['normal'] ?? [];

		$visibleCategoriesLimit = 4;
		if ( count( $normalCategoryLinks ) > 4 ) {
			$visibleCategoriesLimit = 3;
		}
		$categories = array_slice( $normalCategoryLinks, 0, $visibleCategoriesLimit );
		$visibleCategories = $this->extendWithTrackingAttribute( $categories, 'categories-top' );
		$extendedCategories = array_slice( $normalCategoryLinks, $visibleCategoriesLimit );
		$moreCategories = $this->extendWithTrackingAttribute( $extendedCategories, 'categories-top-more' );

		$this->setVal( 'title', $title );
		$this->setVal( 'inCategoriesText', wfMessage( 'pph-in-categories' )->escaped() );
		$this->setVal( 'visibleCategories', $visibleCategories );
		$this->setVal( 'moreCategoriesText', wfMessage( 'pph-categories-more' )->numParams( count( $moreCategories ) )->text() );
		$this->setVal( 'moreCategoriesSeparator', wfMessage( 'pph-categories-more-separator' )->text() );
		$this->setVal( 'moreCategoriesLength', count( $moreCategories ) );
		$this->setVal( 'moreCategories', $moreCategories );
		$this->setVal( 'curatedContentButton', $this->getEditMainPage() );
		$this->setVal( 'languageList', $this->getLanguages() );
	}

	public function navigation() {
		$this->setVal( 'data',
			( new NavigationModel() )->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE ) );
		$this->setVal( 'explore', $this->getExplore() );
		$this->setVal( 'discuss', $this->getDiscuss() );
	}

	public function wikiHeader() {
		global $wgCityId, $wgSitename, $wgUser;

		$backgroundImageUrl = ( new SiteAttributeService() )
				->getApiClient()
				->getAttribute( $wgCityId, 'pageHeaderImage' )
				->getValue() ?? '';

		$this->setVal( 'backgroundImageUrl', $backgroundImageUrl );
		$this->setVal( 'wordmarkText', $wgSitename );
		$this->setVal( 'tallyMsg', wfMessage( 'pph-total-articles', SiteStats::articles() )->parse() );

		$this->setVal( 'addNewPageHref', SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL() );
		$this->setVal( 'addNewPageLabel', wfMessage( 'oasis-button-add-new-page' )->escaped() );
		$this->setVal( 'mainPageURL', Title::newMainPage()->getLocalURL() );

		if ( $wgUser->isLoggedIn() ) {
			$title = Title::newFromText( 'WikiActivity', NS_SPECIAL );

			if ( isset( $title ) ) {
				$this->setVal( 'addNewPageLabel', wfMessage( 'pph-add' )->escaped() );
				$this->setVal( 'addNewPageTitle', wfMessage( 'oasis-button-add-new-page' )->escaped() );
				$this->setVal( 'adminToolsWikiActivity', [
					'href' => $title->getLocalURL(),
					'title' => wfMessage( 'oasis-activity-header' )->escaped()
				] );
			}
		}
	}

	/**
	 * Use MW core variable to generate action button
	 * Copied from PageHeaderController.class.php
	 */
	private function prepareActionButton() {

		global $wgTitle, $wgUser, $wgRequest;

		wfRunHooks( 'BeforePrepareActionButtons', [ $this, &$this->content_actions ] );

		$isDiff = !is_null( $wgRequest->getVal( 'diff' ) );

		// "Add topic" action
		if ( isset( $this->content_actions['addsection'] ) ) {
			// remove on diff pages (RT #72666)
			if ( $isDiff ) {
				unset( $this->content_actions['addsection'] );
			}
		}

		// handle protected pages (they should have viewsource link and lock icon) - BugId:9494
		if ( isset( $this->content_actions['viewsource'] ) &&
			!$wgTitle->isProtected() &&
			!$wgTitle->isNamespaceProtected( $wgUser ) &&
			!$wgUser->isLoggedIn() /* VOLDEV-74: logged in users should see the viewsource button, not edit */
		) {
			// force login to edit page that is not protected
			$this->content_actions['edit'] = $this->content_actions['viewsource'];
			$this->content_actions['edit']['text'] = wfMessage( 'edit' )->text();
			unset( $this->content_actions['viewsource'] );
		}

		// If cascade protected, show viewsource button - BugId:VE-89
		if ( isset( $this->content_actions['edit'] ) && $wgTitle->isCascadeProtected() ) {
			$this->content_actions['viewsource'] = $this->content_actions['edit'];
			$this->content_actions['viewsource']['text'] = wfMessage( 'viewsource' )->text();
			unset( $this->content_actions['edit'] );
		}

		// "Add topic"
		if ( isset( $this->content_actions['addsection'] ) ) {
			$action = $this->content_actions['addsection'];
			$action['text'] = wfMsg( 'oasis-page-header-add-topic' );
			$this->action = $action;

			$this->actionImage = MenuButtonController::ADD_ICON;
			$this->actionName = 'addtopic';
		}  // ve-edit
		else {
			if ( isset( $this->content_actions['ve-edit'] ) && $this->content_actions['ve-edit']['main'] ) {
				$this->action = $this->content_actions['ve-edit'];
				$this->actionImage = MenuButtonController::EDIT_ICON;
				$this->actionName = 've-edit';
				unset( $this->content_actions['ve-edit'] );
			} // edit
			else {
				if ( isset( $this->content_actions['edit'] ) ) {
					$this->action = $this->content_actions['edit'];
					$this->actionImage = MenuButtonController::EDIT_ICON;
					$this->actionName = 'edit';
					unset( $this->content_actions['edit'] );
				} // view source
				else {
					if ( isset( $this->content_actions['viewsource'] ) ) {
						$this->action = $this->content_actions['viewsource'];
						$this->actionImage = MenuButtonController::LOCK_ICON;
						$this->actionName = 'source';
						unset( $this->content_actions['ve-edit'], $this->content_actions['edit'] );
					}
				}
			}
		}
	}

	private function applyEditButtonLoginAction() {
		global $wgTitle, $wgUser;

		$this->actionButtonClass = '';

		// modify edit URL if the action is edit
		if ( $this->actionName == 'edit' && isset( $this->action['href'] ) /* BugId:12613 */ &&
		     !$wgTitle->userCan( 'edit' ) && !$wgUser->isBlocked( true, false ) /* CE-18 */ &&
		     !$wgUser->isLoggedIn() /* VOLDEV-74 */
		) {
			$signUpTitle = SpecialPage::getTitleFor( 'SignUp' );
			$loginUrl = $this->createLoginURL( !empty( $this->dropdown ) ? 'action=edit' : '' );
			$this->action['href'] = $signUpTitle->getLocalUrl( $loginUrl );
			$this->actionButtonClass .= ' loginToEditProtectedPage';
		}
	}

	/**
	 * @param extraReturntoquery is a string which will be urlencoded and appended to the returntoquery. eg: "action=edit".
	 */
	private function createLoginURL( $extraReturntoquery = '' ) {
		/** create login URL **/
		$returnto = wfGetReturntoParam(null, $extraReturntoquery);

		$signUpHref = $returnto;
		$signUpHref .= "&type=login";
		return $signUpHref;
	}

	/**
	 * Get content actions for dropdown
	 */
	private function getDropdownActions() {
		$ret = [];

		$editActions = [];
		if ( isset( $this->content_actions['edit'] ) ) {
			array_push( $editActions, 'edit' );
		}
		if ( isset( $this->content_actions['ve-edit'] ) ) {
			if ( $this->content_actions['ve-edit']['main'] ) {
				array_unshift( $editActions, 've-edit' );
			} else {
				array_push( $editActions, 've-edit' );
			}
		}
		if ( isset( $this->content_actions['formedit'] ) ) {
			array_push( $editActions, 'formedit' ); // SUS-533
		}

		// items to be added to "edit" dropdown
		$actions = array_merge( $editActions,
			[ 'history', 'move', 'protect', 'unprotect', 'delete', 'undelete', 'replace-file' ] );

		// Enable to modify actions list on dropdown
		wfRunHooks( 'PageHeaderDropdownActions', [ &$actions ] );

		foreach ( $actions as $action ) {
			if ( isset( $this->content_actions[$action] ) ) {
				$ret[$action] = $this->content_actions[$action];
			}
		}

		return $ret;
	}

	/**
	 * Copied from CommentsLikesController.class.php
	 * Are article comments enabled for context title?
	 */
	private function checkArticleComments() {
		global $wgTitle;
		$this->isArticleComments = class_exists( 'ArticleComment' ) && ArticleCommentInit::ArticleCommentCheckTitle( $wgTitle );
		return $this->isArticleComments;
	}

	/**
	 * Get URL of the page comments button should be linking to
	 */
	private function getCommentsLink() {
		wfProfileIn( __METHOD__ );
		global $wgTitle, $wgRequest;

		$isHistory = $wgRequest->getVal( 'action' ) == 'history';

		if ( $this->checkArticleComments() ) {
			// link to article comments section
			if ( $isHistory ) {
				$commentsLink = $wgTitle->getLocalUrl() . '#WikiaArticleComments';
			} else {
				// fix for redirected articles
				$commentsLink = '#WikiaArticleComments';
			}
		} else {
			// link to talk page
			if ( $wgTitle->canTalk( $wgTitle->getNamespace() ) ) {
				$commentsLink = $wgTitle->getTalkPage()->getLocalUrl();
			} else {
				// This case shouldn't happen other than Special:ThemeDesignerPreview
				// We're faking some comments to show a user what an article would look like
				$commentsLink = '';
			}
		}

		wfProfileOut( __METHOD__ );
		return $commentsLink;
	}

	private function getEditMainPage() {
		global $wgEnableCuratedContentExt;

		if ( !empty( $wgEnableCuratedContentExt ) && CuratedContentHelper::shouldDisplayToolButton() ) {
			return [
				'href' => '/main/edit?useskin=wikiamobile',
				'text' => wfMessage( 'wikiacuratedcontent-edit-mobile-main-page' )->text(),
				'id' => 'PremiumPageHeaderCuratedContentTool'
			];
		}
		return [];
	}

	private function getLanguages() {
		global $wgContLanguageCode, $wgTitle;

		$language_urls = $this->app->getSkinTemplateObj()
			? $this->app->getSkinTemplateObj()->data['language_urls']
			: [];

		$request_language_urls = $this->request->getVal( 'request_language_urls' );
		if ( !empty( $request_language_urls ) ) {
			$language_urls = $request_language_urls;
		}

		$this->currentLangName = Language::getLanguageName( $wgContLanguageCode );
		$language_urls["interwiki-{$wgContLanguageCode}"] = [
			'href' => $wgTitle->getFullURL(),
			'text' => $this->currentLangName,
			'class' => "interwiki-{$wgContLanguageCode}",
		];

		$languages = [];
		foreach ( $language_urls as $val ) {
			$languages[$val["class"]] = [
				'href' => $val['href'],
				'name' => $val['text'],
				'class' => $val['class'],
			];
		}

		ksort( $languages );

		return $languages;
	}

	private function getExplore(): array {
		global $wgEnableDiscussions, $wgEnableForumExt;

		//TODO: when productizing, please translate as crowdin messages or fix aliases of these special pages
		$explore = [
			[ 'title' => 'WikiActivity', 'tracking' => 'explore-activity', 'key' => 'oasis-button-wiki-activity' ],
			[ 'title' => 'Random', 'tracking' => 'explore-random', 'key' => 'randompage' ],
			[ 'title' => 'Community', 'tracking' => 'explore-community' ],
			[ 'title' => 'Videos', 'tracking' => 'explore-videos' ],
			[ 'title' => 'Images', 'tracking' => 'explore-images' ]
		];

		if ( !empty( $wgEnableForumExt ) && !empty( $wgEnableDiscussions ) ) {
			$explore[] = [ 'title' => 'Forum', 'tracking' => 'explore-forum' ];
		}

		$children = array_map( function ( $page ) {
			$title = Title::newFromText( $page['title'], NS_SPECIAL );
			if ( $title && $title->isKnown() ) {
				return [
					'text' => isset( $page['key'] )
						? wfMessage( $page['key'] )->inContentLanguage()->escaped()
						: $title->fixSpecialName()->getText(),
					'href' => $title->getLocalURL(),
					'tracking' => $page['tracking']
				];
			}
			return [];
		}, $explore );

		return [
			'text' => wfMessage( 'pph-explore' )->inContentLanguage()->escaped(),
			'children' => array_filter( $children, function ( $child ) {
				return !empty( $child );
			} )
		];
	}

	private function getDiscuss(): array {
		global $wgEnableDiscussions, $wgEnableForumExt;

		if ( !empty( $wgEnableDiscussions ) ) {
			return [
				'text' => wfMessage( 'pph-discuss' )->inContentLanguage()->escaped(),
				'href' => '/d/f'
			];
		} elseif ( !empty( $wgEnableForumExt ) ) {
			$title = Title::newFromText( 'Forum', NS_SPECIAL )->fixSpecialName();
			return [
				'text' => $title->getText(),
				'href' => $title->getLocalURL()
			];
		} else {
			return [];
		}
	}

	private function extendWithTrackingAttribute( $categories, $prefix ): array {
		return array_map( function ( $link, $key ) use ( $prefix ) {
			$domLink = HtmlHelper::createDOMDocumentFromText( $link );
			$link = $domLink->getElementsByTagName( 'a' );
			if ( $link->length >= 1 ) {
				$link->item( 0 )->setAttribute( 'data-tracking', "{$prefix}-{$key}" );
			}

			return HtmlHelper::getBodyHtml( $domLink );
		}, $categories, array_keys( $categories ) );
	}
}
