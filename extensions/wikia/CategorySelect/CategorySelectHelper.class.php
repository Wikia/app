<?php
class CategorySelectHelper {
	private static $isEditable;
	private static $isEnabled;

	/**
	 * Whether the current user can edit categories for the current request.
	 * @return Boolean
	 */
	public static function isEditable() {
		wfProfileIn( __METHOD__ );

		if ( !isset( self::$isEditable ) ) {
			$app = F::app();

			$request = $app->wg->Request;
			$title = $app->wg->Title;
			$user = $app->wg->User;

			$isEditable = true;

			if (
				// Disabled if user is not allowed to edit
				!$user->isAllowed( 'edit' )
				// Disabled on pages the user can't edit, see RT#25246
				|| ( $title->mNamespace != NS_SPECIAL && !$title->quickUserCan( 'edit' ) )
				// Disabled for diff pages
				|| $request->getVal( 'diff' )
				// Disabled for older revisions of articles
				|| $request->getVal( 'oldid' )
			) {
				$isEditable = false;
			}

			self::$isEditable = $isEditable;
		}

		wfProfileOut( __METHOD__ );

		return self::$isEditable;
	}

	/**
	 * Whether CategorySelect should be used for the current request.
	 * @return Boolean
	 */
	public static function isEnabled() {
		wfProfileIn( __METHOD__ );

		if ( !isset( self::$isEnabled ) ) {
			$app = F::app();

			$request = $app->wg->Request;
			$title = $app->wg->Title;
			$user = $app->wg->User;

			$action = $request->getVal( 'action', 'view' );
			$undo = $request->getVal( 'undo' );
			$undoafter = $request->getVal( 'undoafter' );

			$viewModeActions = array( 'view', 'purge' );
			$editModeActions = array( 'edit', 'submit' );
			$supportedActions = array_merge( $viewModeActions, $editModeActions );
			$supportedSkins = array( 'SkinOasis' );

			$isViewMode = in_array( $action, $viewModeActions );
			$isEditMode = in_array( $action, $editModeActions );
			$extraNamespacesOnView = array( NS_FILE, NS_CATEGORY );
			$extraNamespacesOnEdit = array( NS_FILE, NS_CATEGORY, NS_USER, NS_SPECIAL );

			$isEnabled = true;

			if (
				// Disabled if usecatsel=no is present
				$request->getVal( 'usecatsel', '' ) == 'no'
				// Disabled by user preferences
				|| $user->getGlobalPreference( 'disablecategoryselect' )
				// Disabled for unsupported skin
				|| !in_array( get_class( RequestContext::getMain()->getSkin() ), $supportedSkins )
				// Disabled for unsupported action
				|| !in_array( $action, $supportedActions )
				// Disabled on CSS or JavaScript pages
				|| $title->isCssJsSubpage()
				// Disabled on non-existent article pages
				|| ( $action == 'view' && !$title->exists() )
				// Disabled on 'confirm purge' page for anon users
				|| ( $action == 'purge' && $user->isAnon() && !$request->wasPosted() )
				// Disabled for undo edits
				|| ( $undo > 0 && $undoafter > 0 )
				// Disabled for unsupported namespaces
				|| ( $title->mNamespace == NS_TEMPLATE )
				// Disabled for unsupported namespaces in view mode
				|| ( $isViewMode && !in_array( $title->mNamespace, array_merge( $app->wg->ContentNamespaces, $extraNamespacesOnView ) ) )
				// Disabled for unsupported namespaces in edit mode
				|| ( $isEditMode && !in_array( $title->mNamespace, array_merge( $app->wg->ContentNamespaces, $extraNamespacesOnEdit ) ) )
			) {
				$isEnabled = false;
			}

			self::$isEnabled = $isEnabled;
		}

		wfProfileOut( __METHOD__ );

		return self::$isEnabled;
	}

}
