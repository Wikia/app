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
			$data = CategoryHelper::extractCategoriesFromWikitext( $wikitext );
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
	 * @return Boolean because it's a hook
	 */
	public static function onEditPageImportFormData( $editPage, $request ) {
		$app = F::app();

		if ( $request->wasPosted() ) {
			$categories = $editPage->safeUnicodeInput( $request, 'categories' );
			$categories = CategoryHelper::changeFormat( $categories, 'json', 'array' );

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
				$data = CategoryHelper::extractCategoriesFromWikitext( $editPage->textbox1, true );
				$categories = CategoryHelper::getUniqueCategories( $data[ 'categories' ], $categories );
				$categories = CategoryHelper::changeFormat( $categories, 'array', 'wikitext' );

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
	 *
	 * @return Boolean because it's a hook
	 */
	public static function onEditPageShowEditFormFields( $editPage, $out ) {
		CategoryHelper::extractCategoriesFromWikitext( $editPage->textbox1 );
		$out->addHTML( F::app()->renderView( 'CategorySelect', 'editPageMetadata' ) );
		return true;
	}

	/**
	 * Allow toggling CategorySelect in user preferences
	 */
	public static function onGetPreferences( $user, &$preferences ) {
		global $wgEnableUserPreferencesV2Ext;

		if ( $wgEnableUserPreferencesV2Ext ) {
			$section = 'editing/starting-an-edit';
			$message = wfMessage( 'tog-disablecategoryselect-v2' )->text();

		} else {
			$section = 'editing/editing-experience';
			$message = wfMessage( 'tog-disablecategoryselect' )->text();
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
		$wg = F::app()->wg;

		$vars[ 'wgCategorySelect' ] = array(
			'defaultNamespace' => $wg->ContLang->getNsText( NS_CATEGORY ),
			'defaultNamespaces' => CategoryHelper::getDefaultNamespaces(),
			'defaultSeparator' => trim( wfMessage( 'colon-separator' )->escaped() ),
			'defaultSortKey' => $wg->Parser->getDefaultSort() ?: $wg->Title->getText()
		);

		return true;
	}

	/**
	 * Add hooks for view and edit pages
	 */
	public static function onMediaWikiPerformAction( $output, $article, $title, $user, $request, $mediawiki, $force = false ) {
		global $wgHooks;

		wfProfileIn( __METHOD__ );

		if ( $force || CategorySelectHelper::isEnabled() ) {
			$app = F::app();
			$action = $app->wg->Request->getVal( 'action', 'view' );

			JSMessages::enqueuePackage( 'CategorySelect', JSMessages::INLINE );

			$wgHooks[ 'MakeGlobalVariablesScript' ][] = 'CategorySelectHooksHelper::onMakeGlobalVariablesScript';

			// Add hooks for edit pages
			if ( $action == 'edit' || $action == 'submit' || $force ) {
				$wgHooks[ 'EditForm::MultiEdit:Form' ][] = 'CategorySelectHooksHelper::onEditFormMultiEditForm';
				$wgHooks[ 'EditPage::CategoryBox' ][] = 'CategorySelectHooksHelper::onEditPageCategoryBox';
				$wgHooks[ 'EditPage::getContent::end' ][] = 'CategorySelectHooksHelper::onEditPageGetContentEnd';
				$wgHooks[ 'EditPage::importFormData' ][] = 'CategorySelectHooksHelper::onEditPageImportFormData';
				$wgHooks[ 'EditPage::showEditForm:fields' ][] = 'CategorySelectHooksHelper::onEditPageShowEditFormFields';
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
