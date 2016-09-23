<?php

class ProtectSiteJS {
	public static function handler() {
		global $wgTitle, $wgUser, $wgOut;

		if ( empty( $wgTitle ) ) {
			return true;
		}

		if ( strtoupper( substr( $wgTitle->getText(), -3 ) ) === '.JS' ) {
			$groups = $wgUser->getEffectiveGroups();
			if (
				!in_array( 'staff', $groups )
				&& !$wgUser->isAllowed( 'editinterfacetrusted' )
				// Talk pages have always been editable by all, and are not script pages
				&& !$wgTitle->isTalkPage()
				&& !self::isUserSkinJS( $wgTitle, $wgUser )
				&& !self::isAllowedForContentReview( $wgTitle )
			) {
				$wgOut->addHTML( '<div class="errorbox" style="width:92%;">' );
				$wgOut->addWikiMsg( 'actionthrottledtext' );
				$wgOut->addHTML( '</div>' );
				return false;
			}
		}

		return true;
	}

	/**
	 * Check if the page is one of the approved personal JS pages
	 * for the given user that are loaded by ResourceLoader.
	 *
	 * @param  Title   $title The title to check.
	 * @param  User    $user  The user to check the page against.
	 * @return boolean
	 */
	private static function isUserSkinJS( Title $title, User $user ) {
		global $wgCityId;
		$allowedJsSubpages = [
			'chat',
			'common',
			'monobook',
			'wikia',
			'uncyclopedia',
		];

		if ( $wgCityId == Wikia::COMMUNITY_WIKI_ID ) {
			$allowedJsSubpages[] = 'global';
		}

		$allowedJsSubpages = implode( '|', $allowedJsSubpages );
		$regex = '/^' . preg_quote( $user->getName(), '/' ) . '\/(' . $allowedJsSubpages . ')\.js$/';

		if (
			$title->isJsSubpage()
			&& preg_match( $regex, $title->getText() )
		) {
			return true;
		}

		return false;
	}

	/**
	 * Allow moving js pages to Mediawiki or User namespace only for staff users
	 *
	 * @param Title $title
	 * @param User $user
	 * @param string $action
	 * @param array $result
	 * @return bool
	 */
	public static function onGetUserPermissionsErrors( \Title $title, \User $user, $action, &$result ) {
		if ( $action === 'move' && ( $title->isJsPage() || $title->isJsSubpage() ) && !$user->isStaff() ) {
			$result = [ 'badaccess-groups', \User::getGroupName( 'staff' ), 1 ];
			return false;
		}

		return true;
	}

	/**
	 * Check if a JS page is allowed to pass through due to
	 * Content Review being enabled, and the wikia has site
	 * JS enabled.
	 *
	 * @param  Title   $title The title to check.
	 * @return boolean
	 */
	private static function isAllowedForContentReview( Title $title ) {
		return Wikia::isUsingSafeJs() && $title->inNamespace( NS_MEDIAWIKI );
	}
}
