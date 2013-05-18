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
	public static function onEditFormMultiEditForm( $rows, $cols, $ew, $textbox ) {
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
	public static function onEditPageCategoryBox( &$editform ) {
		return false;
	}

	/**
	 * Replace content of edited article [with cut out categories]
	 */
	public static function onEditPageGetContentEnd( $editPage, &$wikitext ) {
		if ( !$editPage->isConflict ) {
			$data = CategorySelect::extractCategoriesFromWikitext( $wikitext );
			$wikitext = $data[ 'wikitext' ];
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
	public static function onEditPageImportFormData( $editPage, $request ) {
		$app = F::app();

		if ( $request->wasPosted() ) {
			$categories = $editPage->safeUnicodeInput( $request, 'categories' );
			$categories = CategorySelect::changeFormat( $categories, 'json', 'array' );

			// Concatenate categories to article wikitext (if there are any).
			if ( !empty( $categories ) ) {
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

				// Extract categories from the article, merge them with those passed in, weed out
				// duplicates and finally append them back to the article (BugId:99348).
				$data = CategorySelect::extractCategoriesFromWikitext( $editPage->textbox1, true );
				$categories = CategorySelect::getUniqueCategories( $data[ 'categories' ], $categories );
				$categories = CategorySelect::changeFormat( $categories, 'array', 'wikitext' );

				// Remove trailing whitespace (BugId:11238)
				$editPage->textbox1 = $data[ 'wikitext' ] . rtrim( $categories );
			}
		}

		return true;
	}

	/**
	 * Add hidden field with category metadata
	 *
	 * @param EditPage $editPage
	 * @param OutputPage $out
	 */
	public static function onEditPageShowEditFormFields( $editPage, $out ) {
		$out->addHTML( F::app()->renderView( 'CategorySelect', 'editPageMetadata' ) );
		return true;
	}

	/**
	 * Allow toggling CategorySelect in user preferences
	 */
	public static function onGetPreferences( $user, &$preferences ) {
		$app = F::app();

		if ( $app->wg->EnableUserPreferencesV2Ext ) {
			$section = 'editing/starting-an-edit';
			$message = $app->wf->Message( 'tog-disablecategoryselect-v2' )->text();

		} else {
			$section = 'editing/editing-experience';
			$message = $app->wf->Message( 'tog-disablecategoryselect' )->text();
		}

		$preferences[ 'disablecategoryselect' ] = array(
			'type' => 'toggle',
			'section' => $section,
			'label' => $message,
		);

		return true;
	}

	/**
	 * Set global variables for javascript
	 */
	public static function onMakeGlobalVariablesScript( Array &$vars ) {
		$app = F::app();

		$vars[ 'wgCategorySelect' ] = array(
			'defaultNamespace' => $app->wg->ContLang->getNsText( NS_CATEGORY ),
			'defaultNamespaces' => CategorySelect::getDefaultNamespaces(),
			'defaultSeparator' => trim( $app->wf->Message( 'colon-separator' )->escaped() ),
			'defaultSortKey' => $app->wg->Parser->getDefaultSort() ?: $app->wg->Title->getText()
		);

		return true;
	}

	/**
	 * Add hooks for view and edit pages
	 */
	public static function onMediaWikiPerformAction( $output, $article, $title, $user, $request, $mediawiki, $force = false ) {
		wfProfileIn( __METHOD__ );

		if ( $force || CategorySelect::isEnabled() ) {
			$app = F::app();
			$action = $app->wg->Request->getVal( 'action', 'view' );

			F::build( 'JSMessages' )->enqueuePackage( 'CategorySelect', JSMessages::INLINE );

			$app->registerHook( 'MakeGlobalVariablesScript', 'CategorySelectHooksHelper', 'onMakeGlobalVariablesScript' );

			// Add hooks for edit pages
			if ( $action == 'edit' || $action == 'submit' || $force ) {
				$app->registerHook( 'EditForm::MultiEdit:Form', 'CategorySelectHooksHelper', 'onEditFormMultiEditForm' );
				$app->registerHook( 'EditPage::CategoryBox', 'CategorySelectHooksHelper', 'onEditPageCategoryBox' );
				$app->registerHook( 'EditPage::getContent::end', 'CategorySelectHooksHelper', 'onEditPageGetContentEnd' );
				$app->registerHook( 'EditPage::importFormData', 'CategorySelectHooksHelper', 'onEditPageImportFormData' );
				$app->registerHook( 'EditPage::showEditForm:fields', 'CategorySelectHooksHelper', 'onEditPageShowEditFormFields' );
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}