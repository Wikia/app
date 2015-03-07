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

		// For option tracking whether a user viewed the editor preference transition dialog
		$preferences['showVisualEditorTransitionDialog'] = array(
			'type' => 'hidden'
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
				've/test/dm/ve.dm.WikiaTemplateModel.test.js',

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
		global $wgMaxUploadSize, $wgEnableVisualEditorUI, $wgEnableWikiaInteractiveMaps, $wgIntMapConfig, $wgUser, $wgUploadPath, $wgReCaptchaPublicKey;
		$vars[ 'wgMaxUploadSize' ] = $wgMaxUploadSize;
		$vars[ 'wgEnableVisualEditorUI' ] = !empty( $wgEnableVisualEditorUI );
		$vars[ 'wgEnableWikiaInteractiveMaps' ] = !empty( $wgEnableWikiaInteractiveMaps );
		if ( !empty( $wgIntMapConfig ) ) {
			$vars[ 'interactiveMapsApiURL' ] =
				$wgIntMapConfig[ 'protocol' ]
				. '://'
				. $wgIntMapConfig[ 'hostname' ]
				. ':'
				. $wgIntMapConfig[ 'port' ]
				. '/api/'
				. $wgIntMapConfig[ 'version' ];
		}
		// Note: even if set as integer, option value is retrieved as string
		if ( $wgUser->getOption( 'showVisualEditorTransitionDialog' ) === '1' ) {
			$vars[ 'showVisualEditorTransitionDialog' ] = 1;
		}
		$vars[ 'VignettePathPrefix' ] = VignetteRequest::parsePathPrefix( $wgUploadPath );
		$vars[ 'reCaptchaPublicKey' ] = $wgReCaptchaPublicKey;
		return true;
	}

}
