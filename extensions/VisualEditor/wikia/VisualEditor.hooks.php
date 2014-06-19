<?php
/**
 * VisualEditor Wikia extension hooks
 *
 * @file
 * @ingroup Extensions
 */

class VisualEditorWikiaHooks {

	public static function onGetPreferences( $user, &$preferences ) {
		// Remove core VisualEditor preferences
		unset(
			$preferences['visualeditor-enable'],
			$preferences['visualeditor-betatempdisable']
		);

		return true;
	}

	public static function onResourceLoaderTestModules( array &$testModules, ResourceLoader &$resourceLoader ) {
		global $wgVisualEditorWikiaResourceTemplate;

		$testModules['qunit']['ext.visualEditor.wikiaTest'] = $wgVisualEditorWikiaResourceTemplate + array(
			'scripts' => array(
				// util
				've/test/ve.wikiaTest.utils.js',

				// dm
				've/test/dm/ve.dm.wikiaExample.js',
				've/test/dm/ve.dm.WikiaConverter.test.js',
				've/test/dm/ve.dm.WikiaCart.test.js',

				// ce
				've/test/ce/ve.ce.wikiaExample.js',
				've/test/ce/ve.ce.WikiaBlockImageNode.test.js',
				've/test/ce/ve.ce.WikiaBlockVideoNode.test.js',
				've/test/ce/ve.ce.WikiaInlineVideoNode.test.js'
			),
			'dependencies' => array(
				'ext.visualEditor.test',
				'ext.visualEditor.wikiaCore',
			)
		);
		return true;
	}

	/**
	 * Adds extra variables to the page config.
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		global $wgMaxUploadSize, $wgEnableVisualEditorUI;
		$vars[ 'wgMaxUploadSize' ] = $wgMaxUploadSize;
		$vars[ 'wgEnableVisualEditorUI' ] = !empty( $wgEnableVisualEditorUI );
		return true;
	}

	/**
	 * Sets VisualEditor to be the default editor on a new wiki for anonymous and new users.
	 * This hook should be temporary until the wgForceVisualEditor variable is retired.
	 *
	 * @param array $wikiData Some wiki details passed from the CreateNewWikiTask class
	 * @return boolean
	 */
	public static function onCreateNewWiki( $wikiData ) {
		WikiFactory::setVarByName( 'wgForceVisualEditor', $wikiData['city_id'], true );
		return true;
	}
}
