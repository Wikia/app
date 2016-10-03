<?php

class FlowTrackingHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'flow_tracking_js' );

		return true;
	}

	/**
	 * @param WikiPage $page
	 * @param Revision $revision
	 * @param $parentRevisionId
	 * @param User $user
	 * @return bool
	 */
	public static function onNewRevisionFromEditComplete( $page, $revision, $parentRevisionId, $user ) {
		$title = $revision->getTitle();
		if ( !$parentRevisionId && $title && $title->inNamespace( NS_MAIN ) ) {
			// transforms "a=1&b=2&c=3" into [ 'a' => 1, 'b' => 2, 'c' => 3 ]
			parse_str( parse_url( getallheaders()[ 'Referer' ], PHP_URL_QUERY ), $params );
			Track::event( 'trackingevent', $params );
			Track::eventGA( 'create-flow', 'impression', 'flow-end' );
		}
		return false;
	}
}
