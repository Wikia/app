<?php
/**
 * @author: pbablok@wikia-inc.com
 */


class EditPageLayoutHooks {
	static function onAlternateEditPageClass( &$editPage ) {
		global $wgArticle;
		$app = F::app();
		$helper = EditPageLayoutHelper::getInstance();
		// apply only for Oasis
		if ( $app->checkSkin( 'oasis' ) ) {
			$instance = $helper->setupEditPage( $wgArticle );

			// $instance will be false in read-only mode (BugId:9460)
			if ( !empty( $instance ) ) {
				$editPage = $instance;
			}
		}

		return true;
	}

	/**
	 * Add wgIsEditPage global JS variable on edit pages
	 */
	static function onMakeGlobalVariablesScript( Array &$vars ) {
		global $wgUser;

		wfRunHooks( 'EditPageMakeGlobalVariablesScript', array( &$vars ) );
		$helper = EditPageLayoutHelper::getInstance();
		$js = $helper->getJsVars();
		foreach( $js as $key => $value ) {
			$vars[$key] = $value;
		}

		// Export JS Variable to check to see if Admin Only Video Upload is enabled for this wiki
		$vars['showAddVideoBtn'] = $wgUser->isAllowed( 'videoupload' );

		return true;
	}

	/**
	 * Add CSS class to <body> element when there's an conflict edit or undo revision is about to be performed
	 */
	static function onSkinGetPageClasses( &$classes ) {
		$helper = EditPageLayoutHelper::getInstance();
		if ( $helper->editPage->isConflict || $helper->editPage->formtype == 'diff' ) {
			$classes .= ' EditPageScrollable';
		}

		if ( !empty( $helper->editPage->mHasPermissionError ) ) {
			$classes .= ' EditPagePermissionError';
		}

		return true;
	}

	/**
	 * Reverse parse wikitext when performing diff for edit conflict
	 */
	static function onEditPageBeforeConflictDiff( &$editform, &$out ) {
		$helper = EditPageLayoutHelper::getInstance();
		if ( class_exists( 'RTE' ) && $helper->getRequest()->getVal( 'RTEMode' ) == 'wysiwyg') {
			$editform->textbox2 = RTE::HtmlToWikitext( $editform->textbox2 );
		}

		return true;
	}

	/**
	 * Get warning note shown when preview mode is forced and add it to the nofitication area
	 */
	static function onEditPageGetPreviewNote( $editform, &$note ) {
		$helper = EditPageLayoutHelper::getInstance();
		if ( ( $helper->editPage instanceof EditPageLayout ) && ( $note != '' ) ) {
			$helper->editPage->addEditNotice( $note );
		}

		return true;
	}

	/**
	 * Apply user preferences changes
	 */
	static function onGetPreferences( $user, &$defaultPreferences ) {
		// modify sections for the following user options
		$prefs = array(
			// General
			'enablerichtext' => 'general',
			'disablespellchecker' => 'general',

			// Starting an edit
			'editsection' => 'starting-an-edit',
			'editsectiononrightclick' => 'starting-an-edit',
			'editondblclick' => 'starting-an-edit',
			'createpagedefaultblank' => 'starting-an-edit',
			'createpagepopupdisabled' => 'starting-an-edit',

			// Editing experience
			'minordefault' => 'editing-experience',
			'forceeditsummary' => 'editing-experience',
			'disablecategoryselect' => 'editing-experience',
			'editwidth' => 'editing-experience',
			'disablelinksuggest' => 'editing-experience', // handled in wfLinkSuggestGetPreferences()
			'disablesyntaxhighlighting' => 'editing-experience',

			// Monobook layout only
			'showtoolbar' => 'monobook-layout',
			'previewontop' => 'monobook-layout',
			'previewonfirst' => 'monobook-layout',

			// Size of editing window (Monobook layout only)
			'cols' => 'editarea-size',
			'rows' => 'editarea-size',
		);

		// move checkboxes / inputs to different section on "Editing" tab
		foreach( $prefs as $name => $section ) {
			if ( isset( $defaultPreferences[$name] ) ) {
				$defaultPreferences[$name]['section'] = 'editing/' . $section;
			}
		}

		return true;
	}

	/**
	 * Grab notices added by core via LogEventsList class
	 *
	 * @param $s String Notice to be emitted
	 * @param $types String or Array
	 * @param $page String The page title to show log entries for
	 * @param $user String The user who made the log entries
	 * @param $param array Associative Array with the following additional options:
	 * - lim Integer Limit of items to show, default is 50
	 * - conds Array Extra conditions for the query (e.g. "log_action != 'revision'")
	 * - showIfEmpty boolean Set to false if you don't want any output in case the loglist is empty
	 *   if set to true (default), "No matching items in log" is displayed if loglist is empty
	 * - msgKey Array If you want a nice box with a message, set this to the key of the message.
	 *   First element is the message key, additional optional elements are parameters for the key
	 *   that are processed with wgMsgExt and option 'parse'
	 * - offset Set to overwrite offset parameter in $wgRequest
	 *   set to '' to unset offset
	 * - wrap String: Wrap the message in html (usually something like "<div ...>$1</div>").
	 * @return boolean return false, so notice will not be emitted by core, but by EditPageLayout code
	 */
	static function onLogEventsListShowLogExtract( $s, $types, $page, $user, $param ) {
		$helper = EditPageLayoutHelper::getInstance();
		if ( $helper->editPage instanceof EditPageLayout ) {
			if ( !empty( $s ) ) {
				$helper->editPage->addEditNotice( $s, $param['msgKey'][0] );
			}

			// don't emit notices on the screen - they will be handled by addEditNotice()
			return false;
		}

		// don't touch things outside the edit page (BugId:9379)
		return true;
	}

	/**
	 * Modify HTML before edit page textarea
	 *
	 * @param $editPage EditPage edit page instance
	 * @param $hidden boolean not used
	 * @return boolean return true
	 */
	static function onBeforeDisplayingTextbox( EditPage $editPage, &$hidden ) {
		$app = F::app();
		if ( $app->checkSkin( 'oasis' ) ) {
			$app->wg->Out->addHtml( '<div id="editarea" class="editpage-editarea" data-space-type="editarea">' );
		}

		return true;
	}

	/**
	 * Modify HTML after edit page textarea
	 *
	 * @param $editPage EditPage edit page instance
	 * @param $hidden boolean not used
	 * @return boolean return true
	 */
	static function onAfterDisplayingTextbox( EditPage $editPage, &$hidden ) {
		$app = F::app();
		if ( $app->checkSkin( 'oasis') ) {
			$params = array(
				'loadingText' => wfMsg('wikia-editor-loadingStates-loading', '')
			);
			$html = $app->getView( 'EditPageLayout', 'Loader', $params )->render();
			$html .= '</div>';
			$app->wg->Out->addHtml( $html );
		}

		return true;
	}
}
