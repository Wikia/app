<?php

/**
 * Utility class for 'edit with form' tab and page
 *
 * @author Yaron Koren
 */
class SFFormEditTab {

	/**
	 * Adds an "action" (i.e., a tab) to edit the current article with
	 * a form
	 */
	static function displayTab( $obj, &$content_actions ) {
		// make sure that this is not a special page, and
		// that the user is allowed to edit it
		// - this function is almost never called on special pages,
		// but before SMW is fully initialized, it's called on
		// Special:SMWAdmin for some reason, which is why the
		// special-page check is there
		if ( isset( $obj->mTitle ) &&
		( $obj->mTitle->getNamespace() != NS_SPECIAL ) ) {
			$form_names = SFLinkUtils::getFormsForArticle( $obj );
			if ( count( $form_names ) > 0 ) {
				global $wgRequest, $wgUser;
				global $sfgRenameEditTabs, $sfgRenameMainEditTab;

				wfLoadExtensionMessages( 'SemanticForms' );

				$user_can_edit = $wgUser->isAllowed( 'edit' ) && $obj->mTitle->userCan( 'edit' );
				// create the form edit tab, and apply whatever
				// changes are specified by the edit-tab global
				// variables
				if ( $sfgRenameEditTabs ) {
					$form_edit_tab_text = $user_can_edit ? wfMsg( 'edit' ) : wfMsg( 'sf_viewform' );
					if ( array_key_exists( 'edit', $content_actions ) ) {
						$content_actions['edit']['text'] = $user_can_edit ? wfMsg( 'sf_editsource' ) : wfMsg( 'viewsource' );
					}
				} else {
					if ( $user_can_edit )
						$form_edit_tab_text = $obj->mTitle->exists() ? wfMsg( 'formedit' ) : wfMsg( 'sf_formcreate' );
					else
						$form_edit_tab_text = wfMsg( 'sf_viewform' );
					// check for renaming of main edit tab
					// only if $sfgRenameEditTabs is off
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
					'href' => $obj->mTitle->getLocalURL( 'action=formedit' )
				);

				// find the location of the 'edit' tab, and add
				// 'edit with form' right before it.
				// this is a "key-safe" splice - it preserves
				// both the keys and the values of the array,
				// by editing them separately and then
				// rebuilding the array.
				// based on the example at
				// http://us2.php.net/manual/en/function.array-splice.php#31234
				$tab_keys = array_keys( $content_actions );
				$tab_values = array_values( $content_actions );
				$edit_tab_location = array_search( 'edit', $tab_keys );
				// if there's no 'edit' tab, look for the
				// 'view source' tab instead
				if ( $edit_tab_location == null )
					$edit_tab_location = array_search( 'viewsource', $tab_keys );
				// this should rarely happen, but if there was
				// no edit *or* view source tab, set the
				// location index to -1, so the tab shows up
				// near the end
				if ( $edit_tab_location == null )
					$edit_tab_location = - 1;
				array_splice( $tab_keys, $edit_tab_location, 0, 'form_edit' );
				array_splice( $tab_values, $edit_tab_location, 0, array( $form_edit_tab ) );
				$content_actions = array();
				for ( $i = 0; $i < count( $tab_keys ); $i++ )
					$content_actions[$tab_keys[$i]] = $tab_values[$i];

				global $wgUser;
				if ( ! $wgUser->isAllowed( 'viewedittab' ) ) {
					// the tab can have either of those two actions
					unset( $content_actions['edit'] );
					unset( $content_actions['viewsource'] );
				}

				return true;
			}
		}
		return true; // always return true, in order not to stop MW's hook processing!
	}

	/**
	 * Function currently called only for the 'Vector' skin, added in
	 * MW 1.16 - will possibly be called for additional skins later
	 */
	static function displayTab2( $obj, &$links ) {
		// the old '$content_actions' array is thankfully just a
		// sub-array of this one
		$views_links = $links['views'];
		self::displayTab( $obj, $views_links );
		$links['views'] = $views_links;
		return true;
	}

	/**
	 * The function called if we're in index.php (as opposed to one of the
	 * special pages)
	 */
	static function displayForm( $action, $article ) {
		global $sfgIP, $sfgUseFormEditPage;

		// return "true" if the call failed (meaning, pass on handling
		// of the hook to others), and "false" otherwise
		if ( $action != 'formedit' ) {
			return true;
		}

		// @todo: This looks like bad code. If we can't find a form, we
		// should be showing an informative error page rather than
		// making it look like an edit form page does not exist.
		$form_names = SFLinkUtils::getFormsForArticle( $article );
		if ( count( $form_names ) == 0 ) {
			return true;
		}
		if ( count( $form_names ) > 1 ) {
			wfLoadExtensionMessages( 'SemanticForms' );
			$warning_text = '    <div class="warningMessage">' . wfMsg( 'sf_formedit_morethanoneform' ) . "</div>\n";
			global $wgOut;
			$wgOut->addHTML( $warning_text );
		}
		$form_name = $form_names[0];

		if ( $sfgUseFormEditPage ) {
			# Experimental new feature extending from the internal
			# EditPage class
			$editor = new SFFormEditPage( $article, $form_name );
			$editor->submit();
			return false;
		}

		$target_title = $article->getTitle();
		$target_name = SFLinkUtils::titleString( $target_title );
		SFFormEdit::printForm( $form_name, $target_name );
		return false;
	}

}
