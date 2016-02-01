<?php
/**
 * Hooks for WikiaNewFiles
 */

class WikiaNewFilesHooks {
	/**
	 * Add a button to upload an image on Special:NewFiles
	 *
	 * @param array $extraButtons An array of strings to add extra buttons to
	 * @return bool true
	 */
	public static function onPageHeaderIndexExtraButtons( array &$extraButtons ) {
		$app = F::app();

		if (
			!empty( $app->wg->EnableUploads ) &&
			$app->wg->Title->isSpecial( 'Newimages' )
		) {
			$extraButtons[] = Wikia::specialPageLink(
				'Upload',
				'oasis-add-photo',
				'wikia-button upphotos',
				'blank.gif',
				'oasis-add-photo-to-wiki',
				'sprite photo'
			);
		}

		return true;
	}
}
