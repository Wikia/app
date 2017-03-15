<?php

class PremiumPageHeaderController extends WikiaController {

	public function articleHeader() {
		$skinVars = $this->app->getSkinTemplateObj()->data;
		$this->content_actions = $skinVars['content_actions'];

		// edit button preparation
		// action button (edit / view soruce) and dropdown for it
		$this->prepareActionButton();
		// dropdown actions
		$this->dropdown = $this->getDropdownActions();

		// comments/talk button
		$commentsEnabled = $this->checkArticleComments();
		$this->commentButtonMsg = $commentsEnabled ? 'oasis-page-header-comments' : 'oasis-page-header-talk';
		$this->commentsLink = $this->getCommentsLink();

		$this->setVal( 'displaytitle', $skinVars['displaytitle'] );
		$this->setVal( 'title', $skinVars['title'] );

		$categoryLinks = $this->getContext()->getOutput()->getCategoryLinks();
		$normalCategoryLinks = $categoryLinks['normal'] ?? [];

		$visibleCategoriesLimit = 4;
		if ( count( $normalCategoryLinks ) > 4 ) {
			$visibleCategoriesLimit = 3;
		}
		$categories = array_slice( $normalCategoryLinks, 0, $visibleCategoriesLimit );
		$visibleCategories = $this->extendWithTrackingAttribute( $categories, 'categories' );
		$extendedCategories = array_slice( $normalCategoryLinks, $visibleCategoriesLimit );
		$moreCategories = $this->extendWithTrackingAttribute( $extendedCategories, 'categories-more' );

		$this->setVal( 'inCategoriesText', wfMessage( 'pph-in-categories' )->plain() );
		$this->setVal( 'visibleCategories', $visibleCategories );
		$this->setVal( 'moreCategoriesLength', count( $moreCategories ) );
		$this->setVal( 'moreCategories', $moreCategories );
		$this->setVal( 'curatedContentButton', $this->getEditMainPage() );

		if ( $this->app->getSkinTemplateObj() ) {
			$this->language_urls = $this->app->getSkinTemplateObj()->data['language_urls'];
		} else {
			$this->language_urls = [];
		}
		$this->language_list = null;
		$this->widgetLanguages();
	}

	public function navigation() {
		$this->setVal( 'data',
			( new NavigationModel() )->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE ) );
		$this->setVal( 'explore', $this->getExplore() );
		$this->setVal( 'discuss', $this->getDiscuss() );
	}

	public function wikiHeader() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->setVal( 'wordmarkText', $settings['wordmark-text'] );
		$this->setVal( 'tallyMsg',
			wfMessage( 'pph-total-articles', SiteStats::articles() )->parse() );
		$this->setVal( 'addNewPageHref', SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL() );
		$this->setVal( 'mainPageURL', Title::newMainPage()->getLocalURL() );
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

		// action button
		# print_pre($this->content_actions);

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

		# print_pre($this->action); print_pre($this->actionImage); print_pre($this->actionName);
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
			if ( $wgTitle != $wgTitle || $isHistory ) {
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

	private function widgetLanguages() {
		global $wgContLanguageCode, $wgTitle;

		$request_language_urls = $this->request->getVal( 'request_language_urls' );
		if ( !empty( $request_language_urls ) ) {
			$this->language_urls = $request_language_urls;
		}

		$this->currentLangName = Language::getLanguageName( $wgContLanguageCode );

		$language_urls = $this->language_urls;

		$language_urls[] = [
			'href' => $wgTitle->getFullURL(),
			'text' => $this->currentLangName,
			'class' => "interwiki-{$wgContLanguageCode}",
		];

		$langSortBy = [];

		// only display the interlang links if there are interlanguage links
		if ( !empty( $language_urls ) && is_array( $language_urls ) ) {
			$lang_index = [];

			// language order
			$langSortBy = [
				"interwiki-en" => 1,
				"interwiki-de" => 2,
				"interwiki-es" => 3,
				"interwiki-ru" => 4,
				"interwiki-pl" => 5,
				"interwiki-fr" => 6,
				"interwiki-it" => 7,
				"interwiki-pt" => 8
			];

			foreach ( $language_urls as $val ) {
				if ( !in_array( $val['href'], $lang_index ) ) {
					if ( !isset( $langSortBy[$val["class"]] ) ) {
						$langSortBy[$val["class"]] = true;
					}

					$langSortBy[$val["class"]] = [
						'href' => $val['href'],
						'name' => $val['text'],
						'class' => $val['class'],
					];
				}
			}
			//	ordering the languages
			foreach ( $langSortBy as $key => $value ) {
				if ( !is_array( $value ) ) {
					unset( $langSortBy[$key] );
				}
			}
		}
		if ( !empty( $langSortBy ) ) {
			$this->language_list = $langSortBy;
		}
	}

	private function getExplore(): array {
		$explore = [
			[ 'title' => 'WikiActivity', 'tracking' => 'explore-activity' ],
			[ 'title' => 'Random', 'tracking' => 'explore-random' ],
			[ 'title' => 'Community', 'tracking' => 'explore-community' ],
			[ 'title' => 'Videos', 'tracking' => 'explore-videos' ],
			[ 'title' => 'Images', 'tracking' => 'explore-images' ]
		];

		$children = array_map( function ( $page ) {
			$title = Title::newFromText( $page['title'], NS_SPECIAL );
			if ( $title && $title->isKnown() ) {
				return [
					'text' => $title->getText(),
					'href' => $title->getLocalURL(),
					'tracking' => $page['tracking']
				];
			}
			return [];
		}, $explore );

		return [
			'text' => wfMessage( 'pph-explore' )->escaped(),
			'children' => array_filter( $children, function ( $child ) {
				return !empty( $child );
			} )
		];
	}

	private function getDiscuss(): array {
		global $wgEnableDiscussionsNavigation, $wgEnableDiscussions, $wgEnableForumExt;

		$href =
			!empty( $wgEnableDiscussionsNavigation ) && !empty( $wgEnableDiscussions ) &&
			empty( $wgEnableForumExt )
				? '/d'
				: Title::newFromText( 'Forum', NS_SPECIAL )
				->getLocalURL();

		return [
			'text' => wfMessage( 'pph-discuss' )->escaped(),
			'href' => $href
		];
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
