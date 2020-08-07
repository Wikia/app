<?php

class ArchiveWikiForumController extends WikiaController {

	const ARCHIVED_FORUM_NOTIFICATION = "archivedForumNotification";

	/**
	 * Render HTML for notification to user that old style wiki forums
	 * have been archived on this wiki.
	 */
	public function archivedForumNotification() {
		$this->response->addAsset( 'extensions/wikia/ArchiveWikiForum/css/archivedForumNotification.scss' );

		global $wgEnableForumExt;
		if ( !empty( $wgEnableForumExt ) ) {
			$messageKey = 'archive-wiki-forums-button-to-new-forums';
			$forumTitle = SpecialPage::getTitleFor( 'Forum' );
			$url = $forumTitle->getLocalURL();
		} else {
			global $wgScriptPath;

			$messageKey = 'archive-wiki-forums-button-to-discussions';
			$url = "$wgScriptPath/f";
		}

		$this->response->setValues( [
			'messageKey' => $messageKey,
			'url' => $url,
		] );
	}
}
