<?php

class WikiTopic {
	public static function getWikiTopic() {
		global $wgSitename, $wgWikiTopic;

		return $wgWikiTopic ? $wgWikiTopic : self::prepareWikiTopic( $wgSitename );
	}

	private static function prepareWikiTopic( $siteName ) {
		return trim( preg_replace( '/wikia?$/i', '', $siteName ) );
	}
}
