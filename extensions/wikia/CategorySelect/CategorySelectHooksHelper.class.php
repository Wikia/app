<?php

/**
 * CategorySelect hooks helper class.
 *
 * @author Maciej Błaszkowski <marooned@wikia-inc.com>
 * @author Lucas Garczewski <tor@wikia-inc.com>
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */

class CategorySelectHooksHelper {

	/**
	 * Embed CategorySelect on edit pages. It will be moved later via JavaScript
	 * into the right rail. See: /extensions/wikia/EditPageLayout/modules/Categories.js
	 */
	function onEditFormMultiEditForm( $rows, $cols, $ew, $textbox ) {
		global $wgRequest, $wgOut;

		$action = $wgRequest->getVal( 'action', 'view' );
		if ( $action != 'view' && $action != 'purge' ) {
			CategorySelect::SelectCategoryAPIgetData( $textbox );
			$wgOut->addHTML( F::app()->renderView( 'CategorySelect', 'editPage', array( 'formId' => 'editform' ) ) );
		}
		return true;
	}

	/**
	 * Remove hidden category box from edit page.
	 * Returning false ensures formatHiddenCategories will not be called.
	 */
	function onEditPageCategoryBox( &$editform ) {
		return false;
	}

	/**
	 * Replace content of edited article [with cut out categories]
	 */
	function onEditPageGetContentEnd( $editPage, &$text ) {
		if (!$editPage->isConflict) {
			$data = CategorySelect::SelectCategoryAPIgetData($text);
			$text = $data['wikitext'];
		}
		return true;
	}

	/**
	 * Add categories to article for DiffEngine
	 */
	function onEditPageGetDiffText( $editPage, &$newtext ) {
		global $wgCategorySelectCategoriesInWikitext;
		//add categories only for whole article editing
		if ($editPage->section == '' && isset($wgCategorySelectCategoriesInWikitext)) {
			$newtext .= $wgCategorySelectCategoriesInWikitext;
		}
		return true;
	}

	/**
	 * Concatenate categories on EditPage POST
	 *
	 * @param EditPage $editPage
	 * @param WebRequest $request
	 *
	 */
	function onEditPageImportFormData( $editPage, $request ) {
		global $wgCategorySelectCategoriesInWikitext, $wgContLang, $wgEnableAnswers;

		if ($request->wasPosted()) {
			$sourceType = $request->getVal('CategorySelectCategoriesType');
			$categories = $editPage->safeUnicodeInput($request, 'CategorySelectCategories');

			if ($sourceType == 'wikitext') {
				$categories = "\n" . trim( $categories );

			} else if ($sourceType == 'json') {
				$categories = CategorySelect::changeFormat($categories, 'json', 'wiki');
				if (trim($categories) == '') {
					$categories = '';
				}
			}

			if ($editPage->preview || $editPage->diff) {
				$data = CategorySelect::SelectCategoryAPIgetData($editPage->textbox1 . $categories);
				$editPage->textbox1 = $data['wikitext'];
				$categories = CategorySelect::changeFormat($data['categories'], 'array', 'wiki');

			// Saving article
			} else {
				if ( !empty( $wgEnableAnswers ) ) {
					// don't add categories if the page is a redirect
					$magicWords = $wgContLang->getMagicWords();
					$redirects = $magicWords['redirect'];
					array_shift( $redirects ); // first element doesn't interest us
					// check for localized versions of #REDIRECT
					foreach ($redirects as $alias) {
						if ( stripos( $editPage->textbox1, $alias ) === 0 ) {
							return true;
						}
					}
				}

				// rtrim needed because of BugId:11238
				$editPage->textbox1 .= rtrim($categories);
			}

			$wgCategorySelectCategoriesInWikitext = $categories;
		}
		return true;
	}

	/**
	 * Add hidden field with category metadata
	 *
	 * @param EditPage $editPage
	 * @param OutputPage $out
	 */
	function onEditPageShowEditFormFields( $editPage, $out ) {
		$out->addHTML( F::app()->renderView( 'CategorySelect', 'editPageMetaData' ) );
		return true;
	}

	/**
	 * Toggle CS in user preferences
	 */
	function onGetPreferences( $user, &$preferences ) {
		global $wgEnableUserPreferencesV2Ext;
		if ($wgEnableUserPreferencesV2Ext) {
			$section = 'editing/starting-an-edit';
			$message = wfMsg('tog-disablecategoryselect-v2');

		} else {
			$section = 'editing/editing-experience';
			$message = wfMsg('tog-disablecategoryselect');
		}

		$preferences['disablecategoryselect'] = array(
			'type' => 'toggle',
			'section' => $section,
			'label' => $message,
		);

		return true;
	}

	/**
	 * Determine whether or not to enable the extension
	 */
	public static function onInit( $forceInit = false ) {
		global $wgRequest, $wgUser, $wgHooks;
		wfProfileIn( __METHOD__ );

		// Don't use CategorySelect for undo edits
		$undoafter = $wgRequest->getVal( 'undoafter' );
		$undo = $wgRequest->getVal( 'undo' );
		$diff = $wgRequest->getVal( 'diff' );
		$oldid = $wgRequest->getVal( 'oldid' );
		$action = $wgRequest->getVal( 'action', 'view' );

		// Disable if usecatsel=no is passed in url params or if user is not allowed to edit and we aren't forcing init
		if ( $wgRequest->getVal( 'usecatsel', '' ) == 'no' || ( !$forceInit && !$wgUser->isAllowed( 'edit' ) ) ) {

		// Disable CategorySelect for undo edits
		} else if ( ( $undo > 0 && $undoafter > 0) || $diff || ( $oldid && $action != 'edit' && $action != 'submit' ) ) {

		// Enable CategorySelect
		} else {
			$wgHooks['GetPreferences'][] = 'CategorySelectHooksHelper::onGetPreferences';
			$wgHooks['MediaWikiPerformAction'][] = 'CategorySelectHooksHelper::onMediaWikiPerformAction';
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Set global variables for javascript
	 */
	function onMakeGlobalVariablesScript( Array &$vars ) {
		$app = F::app();

		$vars[ 'wgCategorySelect' ] = array(
			'categoryNamespaces' => 'Category|' . $app->wg->ContLang->getNsText( NS_CATEGORY ),
			'defaultSortKey' => $app->wg->Parser->getDefaultSort(),
			'defaultNamespace' => $app->wg->ContLang->getNsText( NS_CATEGORY ),
		);

		return true;
	}

	/**
	 * Add hooks for view and edit pages
	 */
	public static function onMediaWikiPerformAction( $output, $article, $title, $user, $request, $mediawiki, $force = false ) {
		global $wgHooks, $wgRequest, $wgUser, $wgContentNamespaces;
		wfProfileIn( __METHOD__ );

		$action = $wgRequest->getVal( 'action', 'view' );

		// TODO: Do we still support SkinAnswers?
		$supportedSkins = array( 'SkinAnswers', 'SkinOasis' );

		// User has disabled this extension in their preferences
		if ( $wgUser->getOption( 'disablecategoryselect' ) == true ) {

		// Skin is not supported
		} else if ( !in_array( get_class( RequestContext::getMain()->getSkin() ), $supportedSkins ) ) {

		// Namespace not supported. Supported namespaces are:
		// - For view: content
		// - For edit: content, file, user, category, video, special
		} else if ( !$force && ( ( ( $action == 'view' || $action == 'purge' ) && !in_array( $title->mNamespace, array_merge( $wgContentNamespaces, array( NS_FILE, NS_CATEGORY, NS_VIDEO ) ) ) )
			|| !in_array( $title->mNamespace, array_merge( $wgContentNamespaces, array( NS_FILE, NS_USER, NS_CATEGORY, NS_VIDEO, NS_SPECIAL ) ) )
			|| ( $title->mNamespace == NS_TEMPLATE ) ) ) {

		// Disable on CSS and JS user subpages
		} else if ( $title->isCssJsSubpage() ) {

		// Disable when user will see the source instead of the editor, see RT#25246
		} else if ( !$title->quickUserCan( 'edit' ) && ( $title->mNamespace != NS_SPECIAL ) ) {

		// Disable on non-existant article pages
		} else if ( $action == 'view' && !$title->exists() ) {

		// Disable for anon "confirm purge" page
		} else if ( $action == 'purge' && $wgUser->isAnon() && !$wgRequest->wasPosted() ) {

		// Add hooks for view/purge pages
		} else if ( $action == 'view' || $action == 'purge' ) {
			$wgHooks[ 'Skin::getCategoryLinks::begin' ][] = 'CategorySelectHooksHelper::onSkinGetCategoryLinksBegin';
			$wgHooks[ 'Skin::getCategoryLinks::end' ][] = 'CategorySelectHooksHelper::onSkinGetCategoryLinksEnd';

		// Add hooks for edit/submit pages
		} else if ( $force || $action == 'edit' || $action == 'submit' ) {
			$wgHooks[ 'EditForm::MultiEdit:Form' ][] = 'CategorySelectHooksHelper::onEditFormMultiEditForm';
			$wgHooks[ 'EditPage::CategoryBox' ][] = 'CategorySelectHooksHelper::onEditPageCategoryBox';
			$wgHooks[ 'EditPage::getContent::end' ][] = 'CategorySelectHooksHelper::onEditPageGetContentEnd';
			$wgHooks[ 'EditPage::importFormData' ][] = 'CategorySelectHooksHelper::onEditPageImportFormData';
			$wgHooks[ 'EditPage::showEditForm:fields' ][] = 'CategorySelectHooksHelper::onEditPageShowEditFormFields';
			$wgHooks[ 'EditPageGetDiffText' ][] = 'CategorySelectHooksHelper::onEditPageGetDiffText';
			$wgHooks[ 'MakeGlobalVariablesScript' ][] = 'CategorySelectHooksHelper::onMakeGlobalVariablesScript';
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Remove regular category list under article (in edit mode)
	 */
	function onSkinGetCategoryLinksBegin( &$categoryLinks ) {
		global $wgRequest, $wgOut;

		$action = $wgRequest->getVal('action', 'view');
		if (($action == 'view' || $action == 'purge') && count($wgOut->mCategoryLinks) == 0) {
			self::onSkinGetCategoryLinksEnd($categoryLinks);
			return false;
		}
		return true;
	}

	/**
	 * Add 'add category' button next to category list under article (in view mode)
	 */
	function onSkinGetCategoryLinksEnd( &$categoryLinks ) {
		global $wgRequest;

		wfProfileIn(__METHOD__);

		$action = $wgRequest->getVal( 'action', 'view' );

		//for redirected page this hook is ran twice - check for button existence and don't add second one (fixes rt#12223)
		// FIXME: there must be a better way of doing this...
		if ( wfRunHooks('CategorySelect:beforeDisplayingView', array ()) &&
			( ( $action == 'view' || $action == 'purge' ) && strpos( $categoryLinks, '<div id="csAddCategorySwitch"' ) === false ) ) {
			$categoryLinks .= F::app()->getView( 'CategorySelect', 'articlePageAddCategory' );
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}