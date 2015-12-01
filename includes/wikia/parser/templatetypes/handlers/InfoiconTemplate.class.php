<?php

class InfoiconTemplate {
	/**
	 * @desc sanitize infoicon template content, that is remove all non-images
	 * from it's wikitext. They usually contain span with 'display: none' style.
	 *
	 * @param string $wikitext
	 *
	 * @return string wikitext with image(s) only
	 */
	public static function handle( $wikitext ) {
		global $wgContLang;
		$wikitext = FileNamespaceSanitizeHelper::getInstance()->getFileMarkerFromWikitext( $wikitext, $wgContLang );

		return $wikitext;
	}
}