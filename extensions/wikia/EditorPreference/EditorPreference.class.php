<?php
/**
 * Allows user to set preference of editor
 *
 * @author Matt Klucsarits <mattk@wikia-inc.com>
 */

class EditorPreference {
	const OPTION_EDITOR_DEFAULT = 0;
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
		$preferences[PREFERENCE_EDITOR] = array(
			'type' => 'select',
			'label-message' => 'editor-preference',
			'section' => 'editing/editing-experience',
			'options' => array(
				wfMessage( 'option-default-editor' )->text() => self::OPTION_EDITOR_DEFAULT,
				wfMessage( 'option-visual-editor' )->text() => self::OPTION_EDITOR_VISUAL,
				wfMessage( 'option-ck-editor' )->text() => self::OPTION_EDITOR_CK,
				wfMessage( 'option-source-editor' )->text() => self::OPTION_EDITOR_SOURCE,
			),
		);
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
		global $wgUser, $wgEnableRTEExt;

		if ( !isset( $links['views']['edit'] ) || !self::shouldShowVisualEditorLink( $skin ) ) {
			// There's no edit link OR the Visual Editor cannot be used, so there's no change to make
			return true;
		}

		$primaryEditor = self::getPrimaryEditor();
		$title = $skin->getRelevantTitle();
		// Rebuild the 'views' links in this array
		$newViews = array();

		foreach ( $links['views'] as $action => $data ) {
			if ( $action === 'edit' ) {
				$pageExists = $title->exists() || $title->getDefaultMessageText() !== false;
				$veParams = $editParams = $skin->editUrlOptions();

				// Message keys for VE tab and regular Edit tab
				if ( $primaryEditor === self::OPTION_EDITOR_VISUAL ) {
					if ( $pageExists ) {
						$veMessageKey = 'edit';
					} else {
						$veMessageKey = 'create';
					}

					if ( !$wgEnableRTEExt ) {
						$editMessageKey = 'visualeditor-ca-editsource';
					} else {
						$editMessageKey = 'visualeditor-ca-classiceditor';
					}
				} else {
					$veMessageKey = 'visualeditor-ca-ve-edit';
					$editMessageKey = $pageExists ? 'edit' : 'create';
				}

				// Create the Visual Editor tab
				unset( $veParams['action'] );
				$veParams['veaction'] = 'edit';
				$veTab = array(
					'href' => $title->getLocalURL( $veParams ),
					'text' => wfMessage( $veMessageKey )->setContext( $skin->getContext() )->text(),
					'class' => '',
					// Visual Editor is main Edit tab if...
					'main' => $primaryEditor === self::OPTION_EDITOR_VISUAL
				);

				// Alter the edit tab
				$editTab = $data;
				$editTab['text'] = wfMessage( $editMessageKey )->setContext( $skin->getContext() )->text();
				$editTab['main'] = !$veTab['main'];

				$newViews['edit'] = $editTab;
				$newViews['ve-edit'] = $veTab;
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
		$vars['wgVisualEditorPreferred'] = self::getPrimaryEditor() === self::OPTION_EDITOR_VISUAL;
		return true;
	}

	/**
	 * Gets the primary editor by checking user preferences.
	 *
	 * @return integer The editor option value
	 */
	public static function getPrimaryEditor() {
		global $wgUser, $wgEnableVisualEditorUI, $wgEnableRTEExt, $wgForceVisualEditor;
		$selectedOption = (int)$wgUser->getOption( PREFERENCE_EDITOR );

		if ( $selectedOption === self::OPTION_EDITOR_VISUAL ) {
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
			if ( $wgEnableVisualEditorUI || ( $wgUser->isAnon() && $wgForceVisualEditor ) ) {
				return self::OPTION_EDITOR_VISUAL;
			}
			elseif ( !$wgEnableVisualEditorUI && $wgEnableRTEExt ) {
				return self::OPTION_EDITOR_CK;
			}
			else {
				// Both VE and CK editor are disabled
				return self::OPTION_EDITOR_SOURCE;
			}
		}
	}

	/**
	 * Checks whether the VisualEditor link should be shown.
	 *
	 * @param Skin Current skin object
	 * @return boolean
	 */
	public static function shouldShowVisualEditorLink( $skin ) {
		global $wgTitle, $wgEnableVisualEditorExt, $wgVisualEditorNamespaces, $wgUser;
		return $skin->getSkinName() === 'oasis' &&
			!$wgUser->isBlockedFrom( $skin->getRelevantTitle() ) &&
			!$wgTitle->isRedirect() &&
			$wgEnableVisualEditorExt &&
			( is_array( $wgVisualEditorNamespaces ) ?
				in_array( $wgTitle->getNamespace(), $wgVisualEditorNamespaces ) : false );
	}

	/**
	 * Set the editor preference for newly-registered users.
	 *
	 * @param User $user The current user
	 * @return boolean
	 */
	public static function onAddNewAccount( User $user ) {
		global $wgForceVisualEditor;
		if ( $wgForceVisualEditor ) {
			// Force new users to set VE as preference
			$user->setOption( PREFERENCE_EDITOR, self::OPTION_EDITOR_VISUAL );
			$user->saveSettings();
		}
		// If the editor preference is not set here, the default preference
		// is set in CommonSettings.
		return true;
	}
}
