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

		if (
			// Param usecatsel=no is not present
			$request->getVal( 'usecatsel', '' ) != 'no'
			// User is allowed to edit or we are forcing init
			&& ( $forceInit || $app->wg->User->isAllowed( 'edit' ) )
			// Not an undo edit
			&& !( ( $undo > 0 && $undoafter > 0) || $diff || ( $oldid && $action != 'edit' && $action != 'submit' ) )
		) {
			$app->registerHook( 'GetPreferences', 'CategorySelectHooksHelper', 'onGetPreferences' );
			$app->registerHook( 'MediaWikiPerformAction', 'CategorySelectHooksHelper', 'onMediaWikiPerformAction' );

		} else {
			$app->wg->EnableCategorySelectExt = false;
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
			'defaultSortKey' => $app->wg->Parser->getDefaultSort() ?: $app->wg->Title->getText(),
			'defaultNamespace' => $app->wg->ContLang->getNsText( NS_CATEGORY ),
			'defaultNamespaces' => CategorySelect::getDefaultNamespaces(),
		);

		return true;
	}

	/**
	 * Add hooks for view and edit pages
	 */
	public static function onMediaWikiPerformAction( $output, $article, $title, $user, $request, $mediawiki, $force = false ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$action = $app->wg->Request->getVal( 'action', 'view' );

		// TODO: Do we still support SkinAnswers?
		$supportedSkins = array( 'SkinAnswers', 'SkinOasis' );

		if (
			// Not disabled by user preferences
			!$app->wg->User->getOption( 'disablecategoryselect' )
			// Skin is supported
			&& in_array( get_class( RequestContext::getMain()->getSkin() ), $supportedSkins )
			// Namespace is supported
			&& ( $force || (
				( ( $action == 'view' || $action == 'purge' ) && in_array( $title->mNamespace, array_merge( $app->wg->ContentNamespaces, array( NS_FILE, NS_CATEGORY, NS_VIDEO ) ) ) )
				|| in_array( $title->mNamespace, array_merge( $app->wg->ContentNamespaces, array( NS_FILE, NS_USER, NS_CATEGORY, NS_VIDEO, NS_SPECIAL ) ) )
				|| ( $title->mNamespace == NS_TEMPLATE )
			) )
			// Not a CSS or JavaScript page
			&& !$title->isCssJsSubpage()
			// Is an article page and the article exists
			&& !( $action == 'view' && !$title->exists() )
			// Is a page the user can edit, see RT#25246
			&& ( $title->mNamespace != NS_SPECIAL && $title->quickUserCan( 'edit' ) )
			// Is not a 'confirm purge' page for anon users
			&& !( $action == 'purge' && $app->wg->User->isAnon() && !$app->wg->Request->wasPosted() )
		) {
			F::build( 'JSMessages' )->enqueuePackage( 'CategorySelect', JSMessages::INLINE );

			$app->registerHook( 'MakeGlobalVariablesScript', 'CategorySelectHooksHelper', 'onMakeGlobalVariablesScript' );

			// Add hooks for edit pages
			if ( $force || $action == 'edit' || $action == 'submit' ) {
				$app->registerHook( 'EditForm::MultiEdit:Form', 'CategorySelectHooksHelper', 'onEditFormMultiEditForm' );
				$app->registerHook( 'EditPage::CategoryBox', 'CategorySelectHooksHelper', 'onEditPageCategoryBox' );
				$app->registerHook( 'EditPage::getContent::end', 'CategorySelectHooksHelper', 'onEditPageGetContentEnd' );
				$app->registerHook( 'EditPage::importFormData', 'CategorySelectHooksHelper', 'onEditPageImportFormData' );
				$app->registerHook( 'EditPage::showEditForm:fields', 'CategorySelectHooksHelper', 'onEditPageShowEditFormFields' );
				$app->registerHook( 'EditPageGetDiffText', 'CategorySelectHooksHelper', 'onEditPageGetDiffText' );
			}

		} else {
			$app->wg->EnableCategorySelectExt = false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}