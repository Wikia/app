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

		$images = FileNamespaceSanitizeHelper::getInstance()->getCleanFileMarkersFromWikitext( $wikitext, $wgContLang );

		if ( $images ) {
			$sizedImages = array_map( function( $img ) {
				return '[[' . $img . '|30px]]';
			}, $images );

			$wikitext = implode( ' ', $sizedImages );
		}

		return $wikitext;
	}
}
