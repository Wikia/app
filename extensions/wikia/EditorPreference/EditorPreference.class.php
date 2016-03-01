<?php
/**
 * Allows user to set preference of editor
 *
 * @author Matt Klucsarits <mattk@wikia-inc.com>
 */

class EditorPreference {
	const OPTION_EDITOR_SOURCE = 1;
	const OPTION_EDITOR_VISUAL = 2;
	const OPTION_EDITOR_CK = 3;

	/**
	 * Adds the editor dropdown to the top of Editing preferences.
	 *
	 * @static
	 * @param User $user
	 * @param array $preferences
	 * @return bool
	 */
	public static function onEditingPreferencesBefore( $user, &$preferences ) {
		global $wgVisualEditorNeverPrimary;
		$preferences[PREFERENCE_EDITOR] = array(
			'type' => 'select',
			'label-message' => 'editor-preference',
			'section' => 'editing/editing-experience',
			'options' => array(
				wfMessage( 'option-visual-editor' )->text() => self::OPTION_EDITOR_VISUAL,
				wfMessage( 'option-ck-editor' )->text() => self::OPTION_EDITOR_CK,
				wfMessage( 'option-source-editor' )->text() => self::OPTION_EDITOR_SOURCE,
			),
		);
		if ( $wgVisualEditorNeverPrimary ) {
			$preferences[PREFERENCE_EDITOR]['help-message'] = 'editor-preference-help';
		}
		return true;
	}

	/**
	 * Changes the Edit button and dropdown to account for user's editor preference.
	 * This is attached to the MediaWiki 'SkinTemplateNavigation' hook.
	 *
	 * @param SkinTemplate $skin
	 * @param array $links Navigation links
	 * @return bool true
	 */
	public static function onSkinTemplateNavigation( &$skin, &$links ) {
		global $wgUser;

		if ( !isset( $links['views']['edit'] ) || !self::shouldShowVisualEditorLink( $skin ) ) {
			// There's no edit link OR the Visual Editor cannot be used, so there's no change to make
			return true;
		}

		$isVisualEditorPrimaryEditor = self::isVisualEditorPrimary();
		$title = $skin->getRelevantTitle();
		// Rebuild the 'views' links in this array
		$newViews = array();

		foreach ( $links['views'] as $action => $data ) {
			if ( $action === 'edit' ) {
				$pageExists = $title->exists() || $title->getDefaultMessageText() !== false;

				// Message keys for VisualEditor tab and regular Edit tab
				if ( $isVisualEditorPrimaryEditor ) {
					if ( $pageExists ) {
						$visualEditorMessageKey = 'edit';
					} else {
						$visualEditorMessageKey = 'create';
					}

					$editMessageKey = self::getDropdownEditMessageKey();
				} else {
					$visualEditorMessageKey = 'visualeditor-ca-ve-edit';
					$editMessageKey = $pageExists ? 'edit' : 'create';
				}

				// Create the Visual Editor tab
				$visualEditorTab = array(
					'href' => self::getVisualEditorEditUrl(),
					'text' => wfMessage( $visualEditorMessageKey )->setContext( $skin->getContext() )->text(),
					'class' => '',
					// Visual Editor is main Edit tab if...
					'main' => $isVisualEditorPrimaryEditor
				);

				// Alter the edit tab
				$editTab = $data;
				$editTab['text'] = wfMessage( $editMessageKey )->setContext( $skin->getContext() )->text();
				$editTab['main'] = !$visualEditorTab['main'];

				if ( $isVisualEditorPrimaryEditor ) {
					$visualEditorTab['accesskey'] = 'e';
					$editTab['accesskey'] = 's';
				} else {
					$visualEditorTab['accesskey'] = 's';
					$editTab['accesskey'] = 'e';
				}

				$newViews['edit'] = $editTab;
				$newViews['ve-edit'] = $visualEditorTab;
			} else {
				// Just pass through
				$newViews[$action] = $data;
			}
		}
		$links['views'] = $newViews;
		return true;
	}

	/**
	 * Adds extra variable to the page config.
	 *
	 * @param array $vars
	 * @param OutputPage $out
	 * @return bool true
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		global $wgUser, $wgTitle;
		$vars['wgVisualEditorPreferred'] = ( self::getPrimaryEditor() === self::OPTION_EDITOR_VISUAL &&
			!$wgUser->isBlockedFrom( $wgTitle ) );
		return true;
	}

	/**
	 * Gets the primary editor by checking user preferences.
	 *
	 * @return integer The editor option value
	 */
	public static function getPrimaryEditor() {
		global $wgUser, $wgEnableVisualEditorUI, $wgEnableRTEExt, $wgVisualEditorNeverPrimary;
		$selectedOption = (int)$wgUser->getGlobalPreference( PREFERENCE_EDITOR );

		if ( !$wgVisualEditorNeverPrimary && $selectedOption === self::OPTION_EDITOR_VISUAL ) {
			return self::OPTION_EDITOR_VISUAL;
		}
		elseif ( $selectedOption === self::OPTION_EDITOR_SOURCE ) {
			return self::OPTION_EDITOR_SOURCE;
		}
		elseif ( $selectedOption === self::OPTION_EDITOR_CK ) {
			return self::OPTION_EDITOR_CK;
		}
		else {
			// Default option based on other settings
			if ( !$wgVisualEditorNeverPrimary && ( $wgEnableVisualEditorUI || $wgUser->isAnon() ) ) {
				return self::OPTION_EDITOR_VISUAL;
			}
			elseif ( !$wgEnableVisualEditorUI && $wgEnableRTEExt ) {
				return self::OPTION_EDITOR_CK;
			}
			else {
				// Both VisualEditor and CK editor are disabled
				return self::OPTION_EDITOR_SOURCE;
			}
		}
	}

	/**
	 * Checks whether VisualEditor is the primary editor.
	 *
	 * @return boolean True if VisualEditor is primary and false otherwise
	 */
	public static function isVisualEditorPrimary() {
		return self::getPrimaryEditor() === self::OPTION_EDITOR_VISUAL;
	}

	/**
	 * Checks whether the VisualEditor link should be shown.
	 *
	 * @param Skin Current skin object
	 * @return boolean
	 */
	public static function shouldShowVisualEditorLink( $skin ) {
		global $wgTitle, $wgEnableVisualEditorExt, $wgVisualEditorNamespaces, $wgVisualEditorSupportedSkins, $wgUser;
		return in_array( $skin->getSkinName(), $wgVisualEditorSupportedSkins ) &&
			!$wgUser->isBlockedFrom( $wgTitle ) &&
			!$wgTitle->isRedirect() &&
			$wgEnableVisualEditorExt &&
			( is_array( $wgVisualEditorNamespaces ) ?
				in_array( $wgTitle->getNamespace(), $wgVisualEditorNamespaces ) : false );
	}

	/**
	 * Add a VisualEditor edit link to the user profile action dropdown.
	 *
	 * @param array $actionButtonArray
	 * @param integer $namespace
	 * @param boolean $canRename
	 * @param boolean $canProtect
	 * @param boolean $canDelete
	 * @param boolean $isUserPageOwner
	 * @return boolean
	 */
	public static function onUserProfilePageAfterGetActionButtonData( &$actionButtonArray, $namespace, $canRename,
		$canProtect, $canDelete, $isUserPageOwner ) {
		global $wgTitle;
		// If namespace is not User namespace
		if ( $namespace !== NS_USER ) {
			return true;
		}

		if ( $actionButtonArray['name'] === 'editprofile' ) {
			if ( self::isVisualEditorPrimary() ) {
				// Switch main edit button to use VisualEditor
				$actionButtonArray['action']['href'] = self::getVisualEditorEditUrl();
				$actionButtonArray['action']['id'] = 'ca-ve-edit';

				// Append link to action dropdown for editing in CK or source editor
				$actionButtonArray['dropdown'] = array( 'edit' => array(
					'href' => self::getEditUrl(),
					'text' => wfMessage( self::getDropdownEditMessageKey() )->text(),
					'id'   => 'ca-edit'
				) ) + $actionButtonArray['dropdown'];

			} else {
				// Prepend a VisualEditor link to the action dropdown
				$actionButtonArray['dropdown'] = array( 've-edit' => array(
					'href' => self::getVisualEditorEditUrl(),
					'text' => wfMessage( 'visualeditor-ca-ve-edit' )->text(),
					'id'   => 'ca-ve-edit'
				) ) + $actionButtonArray['dropdown'];

				$actionButtonArray['action']['id'] = 'ca-edit';
			}
		}

		return true;
	}

	/**
	 * Get the message key for a non-VisualEditor edit link in the actions dropdown.
	 *
	 * @return string
	 */
	private static function getDropdownEditMessageKey() {
		global $wgEnableRTEExt;
		return empty( $wgEnableRTEExt ) ? 'visualeditor-ca-editsource' : 'visualeditor-ca-classiceditor';
	}

	/**
	 * Get the current page's edit URL for CK or source editor.
	 *
	 * @return string
	 */
	private static function getEditUrl() {
		global $wgTitle, $wgUser;
		return $wgTitle->getLocalURL( $wgUser->getSkin()->editUrlOptions() );
	}

	/**
	 * Get the current page's edit URL for VisualEditor.
	 *
	 * @return string
	 */
	private static function getVisualEditorEditUrl() {
		global $wgTitle, $wgUser;
		$params = $wgUser->getSkin()->editUrlOptions();
		unset( $params['action'] );
		$params['veaction'] = 'edit';
		return $wgTitle->getLocalURL( $params );
	}
}
