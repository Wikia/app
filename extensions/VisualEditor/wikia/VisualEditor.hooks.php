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

				//ui
				've/tests/ui/ve.ui.wikiaExample.js',
				've/tests/ui/ve.ui.WikiaInfoboxInsertDialog.test.js',
			),
			'dependencies' => array(
				'ext.visualEditor.test',
				'ext.visualEditor.wikia.core',
			)
		);
		return true;
	}

	/**
	 * Adds extra variables to the page config.
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		global $wgMaxUploadSize, $wgEnableVisualEditorUI, $wgEnableWikiaInteractiveMaps, $wgIntMapConfig, $wgUploadPath, $wgReCaptchaPublicKey;
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
		$vars[ 'VignettePathPrefix' ] = VignetteRequest::parsePathPrefix( $wgUploadPath );
		$vars[ 'reCaptchaPublicKey' ] = $wgReCaptchaPublicKey;
		return true;
	}

	/**
	 * If the user has specified that they want to create a page with VE, add Inspectlet script.
	 * @param Title $title Title being used for request
	 * @param Article|null $article
	 * @param OutputPage $output
	 * @param User $user
	 * @param WebRequest $request
	 * @param MediaWiki $mediaWiki
	 * @return bool Always true
	 */
	public static function onBeforeInitialize(
		Title $title, $article, OutputPage $output,
		User $user, WebRequest $request, MediaWiki $mediaWiki
	) {
		if ( $request->getVal( 'veaction' ) === 'edit' && !$title->exists() ) {
			$output->addScript( ( new InspectletService( InspectletService::ADD_NEW_PAGE ) )->getInspectletCode() );
		}
		return true;
	}
}
