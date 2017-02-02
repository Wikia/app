<?php
/**
 * Handles the formedit action.
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SF
 */

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

		global $wgRequest;
		global $sfgRenameEditTabs, $sfgRenameMainEditTab;

		$user_can_edit = $title->userCan( 'edit' );
		// Create the form edit tab, and apply whatever changes are
		// specified by the edit-tab global variables.
		if ( $sfgRenameEditTabs ) {
			$form_edit_tab_msg = $user_can_edit ? 'edit' : 'sf_viewform';
			if ( array_key_exists( 'edit', $content_actions ) ) {
				$msg = $user_can_edit ? 'sf_editsource' : 'viewsource';
				$content_actions['edit']['text'] = wfMessage( $msg )->text();
			}
		} else {
			if ( $user_can_edit ) {
				$form_edit_tab_msg = $title->exists() ? 'formedit' : 'sf_formcreate';
			} else {
				$form_edit_tab_msg = 'sf_viewform';
			}
			// Check for renaming of main edit tab only if
			// $sfgRenameEditTabs is off.
			if ( $sfgRenameMainEditTab ) {
				if ( array_key_exists( 'edit', $content_actions ) ) {
					$msg = $user_can_edit ? 'sf_editsource' : 'viewsource';
					$content_actions['edit']['text'] = wfMessage( $msg )->text();
				}
			}
		}

		$class_name = ( $wgRequest->getVal( 'action' ) == 'formedit' ) ? 'selected' : '';
		$form_edit_tab = array(
			'class' => $class_name,
			'text' => wfMessage( $form_edit_tab_msg )->text(),
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
		array_splice( $tab_keys, $edit_tab_location, 0, 'formedit' );
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
	 * called for the 'Vector' skin, and some others.
	 */
	static function displayTab2( $obj, &$links ) {
		// the old '$content_actions' array is thankfully just a
		// sub-array of this one
		return self::displayTab( $obj, $links['views'] );
	}

	static function displayFormChooser( $output, $title ) {
		$output->addModules( 'ext.semanticforms.main' );

		$targetName = $title->getPrefixedText();
		$output->setPageTitle( wfMessage( "creating", $targetName )->text() );

		$output->addHTML( Html::element( 'p', null, wfMessage( 'sf-formedit-selectform' )->text() ) );
		$formNames = SFUtils::getAllForms();
		$fe = SpecialPageFactory::getPage( 'FormEdit' );
		$text = '';
		foreach( $formNames as $i => $formName ) {
			if ( $i > 0 ) {
				$text .= " &middot; ";
			}

			// Special handling for forms whose name contains a slash.
			if ( strpos( $formName, '/' ) !== false ) {
				$url = $fe->getTitle()->getLocalURL( array( 'form' => $formName, 'target' => $targetName ) );
			} else {
				$url = $fe->getTitle( "$formName/$targetName" )->getLocalURL();
			}
			$text .= Html::element( 'a', array( 'href' => $url ), $formName );
		}
		$output->addHTML( Html::rawElement( 'div', array( 'class' => 'infoMessage' ), $text ) );

		// We need to call linkKnown(), not link(), so that SF's
		// edit=>formedit hook won't be called on this link.
		$noFormLink = Linker::linkKnown( $title, wfMessage( 'sf-formedit-donotuseform' )->escaped(), array(), array( 'action' => 'edit', 'redlink' => true ) );
		$output->addHTML( Html::rawElement( 'p', null, $noFormLink ) );
	}

	/**
	 * The function called if we're in index.php (as opposed to one of the
	 * special pages)
	 */
	static function displayForm( $action, $article ) {
		$output = $action->getOutput();
		$title = $article->getTitle();
		$form_names = SFFormLinker::getDefaultFormsForPage( $title );
		if ( count( $form_names ) == 0 ) {
			// If no form is set, display an interface to let the
			// user choose out of all the forms defined on this wiki
			// (or none at all).
			self::displayFormChooser( $output, $title );
			return true;
		}

		if ( count( $form_names ) > 1 ) {
			$warning_text = "\t" . '<div class="warningbox">' . wfMessage( 'sf_formedit_morethanoneform' )->text() . "</div>\n";
			$output->addWikiText( $warning_text );
		}
		
		$form_name = $form_names[0];
		$page_name = SFUtils::titleString( $title );

		$sfFormEdit = new SFFormEdit();
		$sfFormEdit->printForm( $form_name, $page_name );

		return false;
	}
}
