<?php

/**
 * CategorySelect hooks helper class.
 *
 * @author Maciej Błaszkowski <marooned@wikia-inc.com>
 * @author Lucas Garczewski <tor@wikia-inc.com>
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */

class CategorySelectHooksHelper {
	private static $categoriesWikitext;

	/**
	 * Embed CategorySelect on edit pages. It will be moved later via JavaScript
	 * into the right rail. See: /extensions/wikia/EditPageLayout/modules/Categories.js
	 */
	function onEditFormMultiEditForm( $rows, $cols, $ew, $textbox ) {
		$app = F::app();
		$action = $app->wg->Request->getVal( 'action', 'view' );

		if ( $action != 'view' && $action != 'purge' ) {
			$app->wg->Out->addHTML( $app->renderView( 'CategorySelect', 'editPage' ) );
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
	function onEditPageGetContentEnd( $editPage, &$wikitext ) {
		if ( !$editPage->isConflict ) {
			$data = CategorySelect::extractCategoriesFromWikitext( $wikitext );
			$wikitext = $data[ 'wikitext' ];
		}

		return true;
	}

	/**
	 * Add categories to article for DiffEngine (when editing entire article)
	 */
	function onEditPageGetDiffText( $editPage, &$newtext ) {
		if ( $editPage->section == '' && isset( self::$categoriesWikitext ) ) {
			$newtext .= self::$categoriesWikitext;
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
		$app = F::app();

		if ( $request->wasPosted() ) {
			$categories = $editPage->safeUnicodeInput( $request, 'categories' );
			$categories = CategorySelect::changeFormat( $categories, 'json', 'wikitext' );

			// Prevents whitespace being added when no categories are present
			if ( trim( $categories ) == '' ) {
				$categories = '';
			}

			if ( $editPage->preview || $editPage->diff ) {
				$data = CategorySelect::extractCategoriesFromWikitext( $editPage->textbox1 . $categories );
				$editPage->textbox1 = $data[ 'wikitext' ];
				$categories = CategorySelect::changeFormat( $data[ 'categories' ], 'array', 'wikitext' );

			// Saving article
			} else if ( !empty( $categories ) ) {
				// TODO: still necessary?
				if ( !empty( $app->wg->EnableAnswers ) ) {
					// don't add categories if the page is a redirect
					$magicWords = $app->wg->ContLang->getMagicWords();
					$redirects = $magicWords[ 'redirect' ];

					// first element doesn't interest us
					array_shift( $redirects );

					// check for localized versions of #REDIRECT
					foreach ( $redirects as $alias ) {
						if ( stripos( $editPage->textbox1, $alias ) === 0 ) {
							return true;
						}
					}
				}

				// rtrim needed because of BugId:11238
				$editPage->textbox1 .= rtrim( $categories );
			}

			self::$categoriesWikitext = $categories;
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
		$out->addHTML( F::app()->renderView( 'CategorySelect', 'editPageMetadata' ) );
		return true;
	}

	/**
	 * Toggle CS in user preferences
	 */
	function onGetPreferences( $user, &$preferences ) {
		if ( F::app()->wg->EnableUserPreferencesV2Ext ) {
			$section = 'editing/starting-an-edit';
			$message = wfMsg( 'tog-disablecategoryselect-v2' );

		} else {
			$section = 'editing/editing-experience';
			$message = wfMsg( 'tog-disablecategoryselect' );
		}

		$preferences[ 'disablecategoryselect' ] = array(
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
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$request = $app->wg->Request;

		// Don't use CategorySelect for undo edits
		$undoafter = $request->getVal( 'undoafter' );
		$undo = $request->getVal( 'undo' );
		$diff = $request->getVal( 'diff' );
		$oldid = $request->getVal( 'oldid' );
		$action = $request->getVal( 'action', 'view' );

		// Disable if usecatsel=no is passed in url params or if user is not allowed to edit and we aren't forcing init
		if ( $request->getVal( 'usecatsel', '' ) == 'no' || ( !$forceInit && !$app->wg->User->isAllowed( 'edit' ) ) ) {

		// Disable CategorySelect for undo edits
		} else if ( ( $undo > 0 && $undoafter > 0) || $diff || ( $oldid && $action != 'edit' && $action != 'submit' ) ) {

		// Enable CategorySelect
		} else {
			$app->registerHook( 'GetPreferences', 'CategorySelectHooksHelper', 'onGetPreferences' );
			$app->registerHook( 'MediaWikiPerformAction', 'CategorySelectHooksHelper', 'onMediaWikiPerformAction' );
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
			'defaultSortKey' => $app->wg->Parser->getDefaultSort(),
			'defaultNamespace' => $app->wg->ContLang->getNsText( NS_CATEGORY ),
			'defaultNamespaces' => CategorySelect::getDefaultNamespaces(),
		);

		return true;
	}

	/**
	 * Add hooks for view and edit pages
	 */
	public static function onMediaWikiPerformAction( $output, $article, $title, $user, $request, $mediawiki, $force = false ) {
		global $wgHooks, $wgRequest, $wgUser, $wgContentNamespaces;
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$action = $app->wg->Request->getVal( 'action', 'view' );

		// TODO: Do we still support SkinAnswers?
		$supportedSkins = array( 'SkinAnswers', 'SkinOasis' );

		// Disabled by user preferences preferences
		if ( $app->wg->User->getOption( 'disablecategoryselect' ) == true ) {

		// Disabled for skin (not supported)
		} else if ( !in_array( get_class( RequestContext::getMain()->getSkin() ), $supportedSkins ) ) {

		// Disabled for namespace (not supported)
		} else if ( !$force
			&& ( ( ( $action == 'view' || $action == 'purge' )
			&& !in_array( $title->mNamespace, array_merge( $app->wg->ContentNamespaces, array( NS_FILE, NS_CATEGORY, NS_VIDEO ) ) ) )
			|| !in_array( $title->mNamespace, array_merge( $app->wg->ContentNamespaces, array( NS_FILE, NS_USER, NS_CATEGORY, NS_VIDEO, NS_SPECIAL ) ) )
			|| ( $title->mNamespace == NS_TEMPLATE ) ) ) {

		// Disabled for CSS and JS user subpages
		} else if ( $title->isCssJsSubpage() ) {

		// Disabled for user if they will see the source instead of the editor, see RT#25246
		} else if ( !$title->quickUserCan( 'edit' ) && ( $title->mNamespace != NS_SPECIAL ) ) {

		// Disable for non-existant article pages
		} else if ( $action == 'view' && !$title->exists() ) {

		// Disable for anon "confirm purge" page
		} else if ( $action == 'purge' && $app->wg->User->isAnon() && !$app->wg->Request->wasPosted() ) {

		// Enabled
		} else {
			F::build( 'JSMessages' )->enqueuePackage( 'CategorySelect', JSMessages::INLINE );

			// Add hooks for view/purge pages
			if ( $action == 'view' || $action == 'purge' ) {
				$app->registerHook( 'Skin::getCategoryLinks::begin', 'CategorySelectHooksHelper', 'onSkinGetCategoryLinksBegin' );
				$app->registerHook( 'Skin::getCategoryLinks::end', 'CategorySelectHooksHelper', 'onSkinGetCategoryLinksEnd' );

			// Add hooks for edit/submit pages
			} else if ( $force || $action == 'edit' || $action == 'submit' ) {
				$app->registerHook( 'EditForm::MultiEdit:Form', 'CategorySelectHooksHelper', 'onEditFormMultiEditForm' );
				$app->registerHook( 'EditPage::CategoryBox', 'CategorySelectHooksHelper', 'onEditPageCategoryBox' );
				$app->registerHook( 'EditPage::getContent::end', 'CategorySelectHooksHelper', 'onEditPageGetContentEnd' );
				$app->registerHook( 'EditPage::importFormData', 'CategorySelectHooksHelper', 'onEditPageImportFormData' );
				$app->registerHook( 'EditPage::showEditForm:fields', 'CategorySelectHooksHelper', 'onEditPageShowEditFormFields' );
				$app->registerHook( 'EditPageGetDiffText', 'CategorySelectHooksHelper', 'onEditPageGetDiffText' );
				$app->registerHook( 'MakeGlobalVariablesScript', 'CategorySelectHooksHelper', 'onMakeGlobalVariablesScript' );
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Remove regular category list under article (in edit mode)
	 */
	function onSkinGetCategoryLinksBegin( &$categoryLinks ) {
		$app = F::app();
		$action = $app->wg->Request->getVal( 'action', 'view' );

		if ( ( $action == 'view' || $action == 'purge' ) && count( $app->wg->Out->mCategoryLinks ) == 0 ) {
			self::onSkinGetCategoryLinksEnd( $categoryLinks );
			return false;
		}

		return true;
	}

	/**
	 * Add 'add category' button next to category list under article (in view mode)
	 */
	function onSkinGetCategoryLinksEnd( &$categoryLinks ) {
		wfProfileIn(__METHOD__);

		$app = F::app();
		$action = $app->wg->Request->getVal( 'action', 'view' );

		//for redirected page this hook is ran twice - check for button existence and don't add second one (fixes rt#12223)
		// FIXME: there must be a better way of doing this...
		if ( wfRunHooks('CategorySelect:beforeDisplayingView', array ()) &&
			( ( $action == 'view' || $action == 'purge' ) && strpos( $categoryLinks, '<div id="csAddCategorySwitch"' ) === false ) ) {
			$categoryLinks .= $app->getView( 'CategorySelect', 'articlePageAddCategory' );
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}
