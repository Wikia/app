<?php

namespace Wikia\ContentReview;

class ProfileTags {
	const MODULE_ENTRYPOINT = 'ProfileTags';

	/**
	 * Check if given page is MediaWiki:ProfileTags page
	 *
	 * @param \Title $title
	 * @return bool
	 */
	static public function isProfileTagsPage( \Title $title ) {
		return $title->inNamespace( NS_MEDIAWIKI ) && $title->getText() === self::MODULE_ENTRYPOINT;
	}

	/**
	 * Get description how to manage profile tags
	 *
	 * @return \Message
	 */
	static public function getProfileTagsDescriptionMessage() {
		return wfMessage( 'content-review-profile-tags-description' );
	}
}
