<?php

class WikiTopic {
	public static function prepareWikiTopic( $siteName ) {
		return trim( preg_replace( '/Wiki$/i', '', $siteName ) );
	}
}
