<?php
/**
 * VisualEditor extension hooks
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class VisualEditorHooks {
	/** List of skins VisualEditor integration supports */
	protected static $supportedSkins = array( 'vector', 'apex', 'monobook' );

	/**
	 * Adds VisualEditor JS to the output if in the correct namespace.
	 *
	 * This is attached to the MediaWiki 'BeforePageDisplay' hook.
	 *
	 * @param $output OutputPage
	 * @param $skin Skin
	 */
	public static function onBeforePageDisplay( &$output, &$skin ) {
		global $wgVisualEditorNamespaces;
		if (
			// HACK ignoring hidden-ness so we can do dark launches
			$skin->getUser()->getOption( 'visualeditor-enable',
				/*default=*/ false, /*ignoreHidden=*/true
			) &&
			in_array( $skin->getSkinName(), self::$supportedSkins ) &&
			(
				// Article in the VisualEditor namespace
				in_array( $skin->getTitle()->getNamespace(), $wgVisualEditorNamespaces ) ||
				// Special page action for an article in the VisualEditor namespace
				in_array( $skin->getRelevantTitle()->getNamespace(), $wgVisualEditorNamespaces )
			)
		) {
			$output->addModules( array( 'ext.visualEditor.viewPageTarget' ) );
		}
		return true;
	}

	public static function onGetPreferences( $user, &$preferences ) {
		$preferences['visualeditor-enable'] = array(
			'type' => 'toggle',
			'label-message' => 'visualeditor-preference-enable',
			'section' => 'editing/beta'
		);
		return true;
	}

	/**
	 * Adds extra variables to the page config.
	 *
	 * This is attached to the MediaWiki 'MakeGlobalVariablesScript' hook.
	 */
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgUser, $wgTitle;
		$vars['wgVisualEditor'] = array(
			'isPageWatched' => $wgUser->isWatched( $wgTitle )
		);
		return true;
	}

	public static function onResourceLoaderTestModules( array &$testModules, ResourceLoader &$resourceLoader ) {
		$testModules['qunit']['ext.visualEditor.test'] = array(
			'scripts' => array(
				// QUnit plugin
				've.qunit.js',
				// VisualEditor Tests
				've.test.js',
				've.example.js',
				've.Document.test.js',
				've.Node.test.js',
				've.BranchNode.test.js',
				've.LeafNode.test.js',
				've.Factory.test.js',
				// VisualEditor DataModel Tests
				'dm/ve.dm.example.js',
				'dm/ve.dm.NodeFactory.test.js',
				'dm/ve.dm.Node.test.js',
				'dm/ve.dm.Converter.test.js',
				'dm/ve.dm.BranchNode.test.js',
				'dm/ve.dm.LeafNode.test.js',
				'dm/nodes/ve.dm.TextNode.test.js',
				'dm/ve.dm.Document.test.js',
				'dm/ve.dm.DocumentSynchronizer.test.js',
				'dm/ve.dm.Transaction.test.js',
				'dm/ve.dm.TransactionProcessor.test.js',
				'dm/ve.dm.Surface.test.js',
				'dm/ve.dm.SurfaceFragment.test.js',
				'dm/ve.dm.AnnotationFactory.test.js',
				// VisualEditor ContentEditable Tests
				'ce/ve.ce.test.js',
				'ce/ve.ce.Document.test.js',
				'ce/ve.ce.NodeFactory.test.js',
				'ce/ve.ce.Node.test.js',
				'ce/ve.ce.BranchNode.test.js',
				'ce/ve.ce.LeafNode.test.js',
				'ce/nodes/ve.ce.TextNode.test.js',
			),
			'dependencies' => array(
				'ext.visualEditor.core',
				'ext.visualEditor.viewPageTarget',
			),
			'localBasePath' => dirname( __FILE__ ) . '/modules/ve/test',
			'remoteExtPath' => 'VisualEditor/modules/ve/test',
		);

		return true;
	}
}
