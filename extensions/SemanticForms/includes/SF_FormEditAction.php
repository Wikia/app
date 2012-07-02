<?php
/**
 * Handles the formedit action.
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SF
 */

// TODO: Action class did not exist until MW 1.18
if ( ! class_exists( 'Action') ) {
	class Action{}
}

class SFFormEditAction extends Action 
{
	/**
	 * Return the name of the action this object responds to
	 * @return String lowercase
	 */
	public function getName(){
		return 'formedit';
	}
	
	/**
	 * The main action entry point.  Do all output for display and send it to the context
	 * output.  Do not use globals $wgOut, $wgRequest, etc, in implementations; use
	 * $this->getOutput(), etc.
	 * @throws ErrorPageError
	 */
	public function show(){
		return self::displayForm($this, $this->page);
	}

	/**
	 * Execute the action in a silent fashion: do not display anything or release any errors.
	 * @return Bool whether execution was successful
	 */
	public function execute(){
		return true;
	}

	/**
	 * Adds an "action" (i.e., a tab) to edit the current article with
	 * a form
	 */
	static function displayTab( $obj, &$content_actions ) {
		if ( method_exists ( $obj, 'getTitle' ) ) {
			$title = $obj->getTitle();
		} else {
			$title = $obj->mTitle;
		}
		// Make sure that this is not a special page, and
		// that the user is allowed to edit it
		// - this function is almost never called on special pages,
		// but before SMW is fully initialized, it's called on
		// Special:SMWAdmin for some reason, which is why the
		// special-page check is there.
		if ( !isset( $title ) ||
			( $title->getNamespace() == NS_SPECIAL ) ) {
			return true;
		}

		$form_names = SFFormLinker::getDefaultFormsForPage( $title );
		if ( count( $form_names ) == 0 ) {
			return true;
		}

		global $wgRequest, $wgUser;
		global $sfgRenameEditTabs, $sfgRenameMainEditTab;

		$user_can_edit = $wgUser->isAllowed( 'edit' ) && $title->userCan( 'edit' );
		// Create the form edit tab, and apply whatever changes are
		// specified by the edit-tab global variables.
		if ( $sfgRenameEditTabs ) {
			$form_edit_tab_text = $user_can_edit ? wfMsg( 'edit' ) : wfMsg( 'sf_viewform' );
			if ( array_key_exists( 'edit', $content_actions ) ) {
				$content_actions['edit']['text'] = $user_can_edit ? wfMsg( 'sf_editsource' ) : wfMsg( 'viewsource' );
			}
		} else {
			if ( $user_can_edit ) {
				$form_edit_tab_text = $title->exists() ? wfMsg( 'formedit' ) : wfMsg( 'sf_formcreate' );
			} else {
				$form_edit_tab_text = wfMsg( 'sf_viewform' );
			}
			// Check for renaming of main edit tab only if
			// $sfgRenameEditTabs is off.
			if ( $sfgRenameMainEditTab ) {
				if ( array_key_exists( 'edit', $content_actions ) ) {
					$content_actions['edit']['text'] = $user_can_edit ? wfMsg( 'sf_editsource' ) : wfMsg( 'viewsource' );
				}
			}
		}

		$class_name = ( $wgRequest->getVal( 'action' ) == 'formedit' ) ? 'selected' : '';
		$form_edit_tab = array(
			'class' => $class_name,
			'text' => $form_edit_tab_text,
			'href' => $title->getLocalURL( 'action=formedit' )
		);

		// Find the location of the 'edit' tab, and add 'edit
		// with form' right before it.
		// This is a "key-safe" splice - it preserves both the keys
		// and the values of the array, by editing them separately
		// and then rebuilding the array. Based on the example at
		// http://us2.php.net/manual/en/function.array-splice.php#31234
		$tab_keys = array_keys( $content_actions );
		$tab_values = array_values( $content_actions );
		$edit_tab_location = array_search( 'edit', $tab_keys );

		// If there's no 'edit' tab, look for the 'view source' tab
		// instead.
		if ( $edit_tab_location == null ) {
			$edit_tab_location = array_search( 'viewsource', $tab_keys );
		}

		// This should rarely happen, but if there was no edit *or*
		// view source tab, set the location index to -1, so the
		// tab shows up near the end.
		if ( $edit_tab_location == null ) {
			$edit_tab_location = - 1;
		}
		array_splice( $tab_keys, $edit_tab_location, 0, 'form_edit' );
		array_splice( $tab_values, $edit_tab_location, 0, array( $form_edit_tab ) );
		$content_actions = array();
		for ( $i = 0; $i < count( $tab_keys ); $i++ ) {
			$content_actions[$tab_keys[$i]] = $tab_values[$i];
		}

		global $wgUser;
		if ( ! $wgUser->isAllowed( 'viewedittab' ) ) {
			// The tab can have either of these two actions.
			unset( $content_actions['edit'] );
			unset( $content_actions['viewsource'] );
		}

		return true; // always return true, in order not to stop MW's hook processing!
	}

	/**
	 * Like displayTab(), but called with a different hook - this one is
	 * called for the 'Vector' skin, and others.
	 */
	static function displayTab2( $obj, &$links ) {
		// the old '$content_actions' array is thankfully just a
		// sub-array of this one
		return self::displayTab( $obj, $links['views'] );
	}

	/**
	 * The function called if we're in index.php (as opposed to one of the
	 * special pages)
	 */
	static function displayForm( $action, $article ) {
		global $sfgUseFormEditPage;

		// TODO: This function will be called as a hook handler and $action will
		//  be a string before MW 1.18. From 1.18 onwards this function will#
		//  only be called for formedit actions, i.e. the if statement can be
		//  removed then.

		// return "true" if the call failed (meaning, pass on handling
		// of the hook to others), and "false" otherwise
		if ( is_string( $action ) && $action !== 'formedit' ) {
			return true;
		}

		// @todo: This looks like bad code. If we can't find a form, we
		// should be showing an informative error page rather than
		// making it look like an edit form page does not exist.
		$title = $article->getTitle();
		$form_names = SFFormLinker::getDefaultFormsForPage( $title );
		if ( count( $form_names ) == 0 ) {
			return true;
		}

		// For backward-compatibility
		if ( is_string( $action ) ) {
			global $wgOut;
			$output = $wgOut;
		} else {
			$output = $action->getOutput();
		}

		if ( count( $form_names ) > 1 ) {
			$warning_text = "\t" . '<div class="warningbox">' . wfMsg( 'sf_formedit_morethanoneform' ) . "</div>\n";
			$output->addWikiText( $warning_text );
		}
		$form_name = $form_names[0];

		if ( $sfgUseFormEditPage ) {
			# Experimental new feature extending from the internal
			# EditPage class
			$editor = new SFFormEditPage( $article, $form_name );
			$editor->edit();
			return false;
		}

		$page_name = SFUtils::titleString( $title );

		$msg = SFFormEdit::printForm( $form_name, $page_name );

		if ( $msg ) {
			// Some error occurred - display it.
			$msgdata = null;
			if ( is_array( $msg ) ) {
				if ( count( $msg ) > 1 ) {
					$msgdata = $msg[1];
				}
				$msg = $msg[0];
			}

			$output->addHTML( Html::element( 'p', array( 'class' => 'error' ), wfMsg( $msg, $msgdata ) ) );

		}

		return false;
	}

	/**
	 * A dummy method - this is needed for MediaWiki 1.18, where
	 * Action::getRestriction() is abstract and needs to be implemented.
	 */
	public function getRestriction() {
	}
}
