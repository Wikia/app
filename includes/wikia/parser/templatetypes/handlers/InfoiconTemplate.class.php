<?php

class InfoiconTemplate {
	/**
	 * @desc sanitize infoicon template content, that is remove all non-images
	 * from it's wikitext. They usually contain span with 'display: none' style
	 * or other stuff we don't want on mobile.
	 *
	 * @param string $wikitext
	 *
	 * @return string wikitext with image(s) only
	 */
	public static function handle( $wikitext ) {
		global $wgContLang;

		$images = FileNamespaceSanitizeHelper::getInstance()->getFileMarkerFromWikitext( $wikitext, $wgContLang );

		if ( count( $images[0] ) > 0 ) {
			$wikitext = implode( ' ', $images[0] );
		}

		return $wikitext;
	}
}
