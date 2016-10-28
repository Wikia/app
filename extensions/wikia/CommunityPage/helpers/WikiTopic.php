<?php

class WikiTopic {
	public static function getWikiTopic() {
		global $wgSitename, $wgWikiTopic;

		return $wgWikiTopic ? $wgWikiTopic : self::prepareWikiTopic( $wgSitename );
	}

	private static function prepareWikiTopic( $siteName ) {
		$siteName = preg_replace( '/^the\s/i', '', $siteName );
		return trim( preg_replace( '/(^wikia?)(?=\s)|(?<=\s)(wikia?$)|(?<=\s)(Вики$)/iu', '', $siteName ) );
	}
}
