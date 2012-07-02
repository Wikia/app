<?php
/**
 * Hooks for WikiEditor extension
 *
 * @file
 * @ingroup Extensions
 */

class WikiEditorHooks {

	/* Protected Static Members */

	protected static $features = array(

		/* Beta Features */

		'toolbar' => array(
			'preferences' => array(
				// Ideally this key would be 'wikieditor-toolbar'
				'usebetatoolbar' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-toolbar-preference',
					'section' => 'editing/beta',
				),
			),
			'requirements' => array(
				'usebetatoolbar' => true,
			),
			'modules' => array(
				'ext.wikiEditor.toolbar',
			),
			'configurations' => array(
				'wgWikiEditorToolbarClickTracking',
			),
		),
		'dialogs' => array(
			'preferences' => array(
				// Ideally this key would be 'wikieditor-toolbar-dialogs'
				'usebetatoolbar-cgd' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-toolbar-dialogs-preference',
					'section' => 'editing/beta',
				),
			),
			'requirements' => array(
				'usebetatoolbar-cgd' => true,
				'usebetatoolbar' => true,
			),
			'modules' => array(
				'ext.wikiEditor.dialogs',
			),
		),
		'hidesig' => array(
			'preferences' => array(
				'wikieditor-toolbar-hidesig' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-toolbar-hidesig',
					'section' => 'editing/beta',
				),
			),
			'requirements' => array(
				'wikieditor-toolbar-hidesig' => true,
				'usebetatoolbar' => true,
			),
			'modules' => array(
				'ext.wikiEditor.toolbar.hideSig',
			),
		),

		/* Labs Features */

		'templateEditor' => array(
			'preferences' => array(
				'wikieditor-template-editor' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-template-editor-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-template-editor' => true,
			),
			'modules' => array(
				'ext.wikiEditor.templateEditor',
			),
		),
		'templates' => array(
			'preferences' => array(
				'wikieditor-templates' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-templates-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-templates' => true,
			),
			'modules' => array(
				'ext.wikiEditor.templates',
			),
		),
		'preview' => array(
			'preferences' => array(
				'wikieditor-preview' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-preview-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-preview' => true,
			),
			'modules' => array(
				'ext.wikiEditor.preview',
			),
		),
		'previewDialog' => array(
			'preferences' => array(
				'wikieditor-previewDialog' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-previewDialog-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-previewDialog' => true,
			),
			'modules' => array(
				'ext.wikiEditor.previewDialog',
			),
		),
		'publish' => array(
			'preferences' => array(
				'wikieditor-publish' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-publish-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-publish' => true,
			),
			'modules' => array(
				'ext.wikiEditor.publish',
			),
		),
		'toc' => array(
			'preferences' => array(
				// Ideally this key would be 'wikieditor-toc'
			 	'usenavigabletoc' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-toc-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'usenavigabletoc' => true,
			),
			'modules' => array(
				'ext.wikiEditor.toc',
			),
		),
	);

	/* Static Methods */

	/**
	 * Checks if a certain option is enabled
	 *
	 * This method is public to allow other extensions that use WikiEditor to use the
	 * same configuration as WikiEditor itself
	 *
	 * @param $name string Name of the feature, should be a key of $features
	 * @return bool
	 */
	public static function isEnabled( $name ) {
		global $wgWikiEditorFeatures, $wgUser;

		// Features with global set to true are always enabled
		if ( !isset( $wgWikiEditorFeatures[$name] ) || $wgWikiEditorFeatures[$name]['global'] ) {
			return true;
		}
		// Features with user preference control can have any number of preferences to be specific values to be enabled
		if ( $wgWikiEditorFeatures[$name]['user'] ) {
			if ( isset( self::$features[$name]['requirements'] ) ) {
				foreach ( self::$features[$name]['requirements'] as $requirement => $value ) {
					// Important! We really do want fuzzy evaluation here
					if ( $wgUser->getOption( $requirement ) != $value ) {
						return false;
					}
				}
			}
			return true;
		}
		// Features controlled by $wgWikiEditorFeatures with both global and user set to false are awlways disabled
		return false;
	}

	/**
	 * EditPage::showEditForm:initial hook
	 *
	 * Adds the modules to the edit form
	 *
	 * @param $toolbar array list of toolbar items
	 * @return bool
	 */
	public static function editPageShowEditFormInitial( &$toolbar ) {
		global $wgOut;

		// Add modules for enabled features
		foreach ( self::$features as $name => $feature ) {
			if ( isset( $feature['modules'] ) && self::isEnabled( $name ) ) {
				$wgOut->addModules( $feature['modules'] );
			}
		}
		return true;
	}

	/**
	 * EditPageBeforeEditToolbar hook
	 *
	 * Disable the old toolbar if the new one is enabled
	 *
	 * @param $toolbar html
	 * @return bool
	 */
	public static function EditPageBeforeEditToolbar( &$toolbar ) {
		if ( self::isEnabled( 'toolbar' ) ) {
			$toolbar = Html::rawElement(
				'div', array(
					'class' => 'wikiEditor-oldToolbar',
					'style' => 'display:none;'
				),
				$toolbar
			);
		}
		return true;
	}

	/**
	 * GetPreferences hook
	 *
	 * Adds WikiEditor-releated items to the preferences
	 *
	 * @param $user User current user
	 * @param $defaultPreferences array list of default user preference controls
	 * @return bool
	 */
	public static function getPreferences( $user, &$defaultPreferences ) {
		global $wgWikiEditorFeatures;

		foreach ( self::$features as $name => $feature ) {
			if (
				isset( $feature['preferences'] ) &&
				( !isset( $wgWikiEditorFeatures[$name] ) || $wgWikiEditorFeatures[$name]['user'] )
			) {
				foreach ( $feature['preferences'] as $key => $options ) {
					$defaultPreferences[$key] = $options;
				}
			}
		}
		return true;
	}

	/**
	 * MakeGlobalVariablesScript hook
	 *
	 * Adds enabled/disabled switches for WikiEditor modules
	 * @param $vars array
	 * @return bool
	 */
	public static function resourceLoaderGetConfigVars( &$vars ) {
		global $wgWikiEditorFeatures;

		$configurations = array();
		foreach ( self::$features as $name => $feature ) {
			if (
				isset( $feature['configurations'] ) &&
				( !isset( $wgWikiEditorFeatures[$name] ) || self::isEnabled( $name ) )
			) {
				foreach ( $feature['configurations'] as $configuration ) {
					global $$configuration;
					$configurations[$configuration] = $$configuration;
				}
			}
		}
		if ( count( $configurations ) ) {
			$vars = array_merge( $vars, $configurations );
		}
		return true;
	}

	/**
	 * @param $vars array
	 * @return bool
	 */
	public static function makeGlobalVariablesScript( &$vars ) {
		// Build and export old-style wgWikiEditorEnabledModules object for back compat
		$enabledModules = array();
		foreach ( self::$features as $name => $feature ) {
			$enabledModules[$name] = self::isEnabled( $name );
		}

		$vars['wgWikiEditorEnabledModules'] = $enabledModules;
		return true;
	}
}
