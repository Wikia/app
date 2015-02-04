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

		$testModules['qunit']['ext.visualEditor.wikia.test'] = $wgVisualEditorWikiaResourceTemplate + array(
			'scripts' => array(
				've/tests/ve.wikiaTest.utils.js',

				// dm
				've/tests/dm/ve.dm.wikiaExample.js',
				've/tests/dm/ve.dm.WikiaConverter.test.js',

				// ce
				've/tests/ce/ve.ce.wikiaExample.js',
				've/tests/ce/ve.ce.WikiaBlockVideoNode.test.js',
				've/tests/ce/ve.ce.WikiaBlockImageNode.test.js',
				've/tests/ce/ve.ce.WikiaInlineVideoNode.test.js',
			),
			'dependencies' => array(
				'ext.visualEditor.test',
				'ext.visualEditor.wikia.core',
			)
		);
		return true;
	}



}
