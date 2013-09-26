<?php
/**
 * VisualEditor Wikia extension hooks
 *
 * @file
 * @ingroup Extensions
 */

class VisualEditorWikiaHooks {

	public static function onResourceLoaderTestModules( array &$testModules, ResourceLoader &$resourceLoader ) {
		global $wgVisualEditorWikiaResourceTemplate;

		$testModules['qunit']['ext.visualEditor.wikiaTest'] = $wgVisualEditorWikiaResourceTemplate + array(
			'scripts' => array(
				// util
				've/test/ve.wikiaTest.utils.js',

				// dm
				've/test/dm/ve.dm.wikiaExample.js',
				've/test/dm/ve.dm.WikiaConverter.test.js',

				// ce
				've/test/ce/ve.ce.wikiaExample.js',
				've/test/ce/ve.ce.WikiaBlockImageNode.test.js',
				've/test/ce/ve.ce.WikiaBlockVideoNode.test.js',
				've/test/ce/ve.ce.WikiaInlineVideoNode.test.js',
			),
			'dependencies' => array(
				'ext.visualEditor.test',
				'ext.visualEditor.wikiaCore',
			)
		);
		return true;
	}

	public static function onGetPreferences( $user, &$preferences ) {
		unset( $preferences['visualeditor-betatempdisable'] );
		$preferences['visualeditor-enable']['label-message'] = 'visualeditor-wikiapreference-enable';

		return true;
	}
}