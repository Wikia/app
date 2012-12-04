<?php
/**
 * Resource loader module for certain VisualEditor messages.
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Module for user preference customizations
 */
class VisualEditorMessagesModule extends ResourceLoaderModule {

	/* Protected Members */

	protected $modifiedTime = array();

	protected $origin = self::ORIGIN_CORE_INDIVIDUAL;

	/* Methods */

	public function getScript( ResourceLoaderContext $context ) {
		$messages = array(
			'minoredit' => wfMessage( 'minoredit' )->parse(),
			'watchthis' => wfMessage( 'watchthis' )->parse(),
		);
		return 've.init.platform.addMessages(' . FormatJson::encode( $messages ) . ');';
	}

	public function getMessages() {
		// We don't actually use the i18n on the client-side, but registering the messages
		// is needed to make cache invalidation work
		return array( 'minoredit', 'watchthis' );
	}

	public function getDependencies() {
		return array( 'ext.visualEditor.base' );
	}
}
