<?php

/**
 * Class LookupContribsHooks
 */
class LookupContribsHooks {

	/**
	 * Clear all caches created in LookupContribsCore.  Note that there is one other cache used in that
	 * class but it includes limit and offset values as part of the key and can't be cleared without implementing
	 * a shared key system.  For now that cache has a TTL so the data will clear eventually.
	 *
	 * @param $article
	 * @param User $user
	 *
	 * @return bool
	 */
	static public function ArticleSaveComplete ( $article, User $user ) {
		if ( $user->isLoggedIn() ) {
			$lc = new LookupContribsCore( $user );
			$lc->clearUserActivityCache();
		}

		return true;
	}

	/**
	 * @param $id
	 * @param Title $nt
	 * @param $links
	 * @return bool
	 */
	static public function ContributionsToolLinks( $id, $nt, &$links ) {
		global $wgUser;
		if ( $id != 0 && $wgUser->isAllowed( 'lookupcontribs' ) ) {
			$lcTitle = GlobalTitle::newFromText( 'LookupContribs', NS_SPECIAL, WikiFactory::COMMUNITY_CENTRAL );
			$url = $lcTitle->getFullURL( [
				'target' => $nt->getText(),
			] );
			$attribs = [
				'href' => $url,
				'title' => wfMsg( 'right-lookupcontribs' )
			];
			$links[] = Xml::openElement( 'a', $attribs ) . wfMsg( 'lookupcontribs' ) . Xml::closeElement( 'a' );
		}
		return true;
	}
}
