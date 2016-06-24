<?php

class WikiTopic {
	public static function getWikiTopic() {
		global $wgSitename, $wgWikiTopic;

		return $wgWikiTopic ? $wgWikiTopic : WikiTopic::prepareWikiTopic( $wgSitename );
	}

	public static function prepareWikiTopic( $siteName ) {
		return trim( preg_replace( '/wikia?$/i', '', $siteName ) );
	}
}
