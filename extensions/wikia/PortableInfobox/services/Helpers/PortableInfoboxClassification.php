<?php
namespace Wikia\PortableInfobox\Helpers;

class PortableInfoboxClassification {

	/**
	 * Checks if a page contains non-portable infoboxes based on its title and content.
	 * The first check is if the title includes a word "infobox":
	 * - if yes, check for a new markup (<infobox>) in the content. If it is missing - it indicates that
	 *   the template contains a non-portable infobox
	 * - if no, check for an occurrence of a word "infobox" inside all class HTML attributes
	 *
	 * Returns true if a page may consist a non-portable infobox
	 *
	 * @param string $titleText
	 * @param string $contentText
	 * @return bool
	 */
	public static function isTitleWithNonportableInfobox( $titleText, $contentText ) {
		// ignore docs pages
		if ( stripos( $titleText, '/doc' ) ) {
			return false;
		}

		$titleNeedle = 'infobox';
		if ( strripos( $titleText, $titleNeedle ) !== false ) {
			$portableInfoboxNeedle = '<infobox';

			// if a portable infobox was not found
			// it means that the template has a non-portable one
			return strpos( $contentText, $portableInfoboxNeedle ) === false;
		} else {
			$nonportableInfoboxRegEx = '/class=\"[^\"]*infobox[^\"]*\"/i';
			$nonportableInfoboxRegExMatch = preg_match( $nonportableInfoboxRegEx, $contentText );

			// If a non-portable infobox markup was found
			// the $nonportableInfoboxRegExMatch is not empty
			return !empty( $nonportableInfoboxRegExMatch );
		}
	}
}

