<?php

namespace Wikia\ContentReview;

class UserBadges {
	const MODULE_ENTRYPOINT = 'UserBadges';

	/**
	 * Check if given page is MediaWiki:UserBadges page
	 *
	 * @param \Title $title
	 * @return bool
	 */
	static public function isUserBadgesPage( \Title $title ) {
		return $title->inNamespace( NS_MEDIAWIKI ) && $title->getText() === self::MODULE_ENTRYPOINT;
	}

	/**
	 * Get description how to manage user badges
	 *
	 * @return \Message
	 */
	static public function getUserBadgesDescriptionMessage() {
		return wfMessage( 'content-review-user-badges-description' );
	}
}
