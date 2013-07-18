<?

/**
 * Tweaks to file page for mobile
 * @author Liz Lee
 */

class WikiaMobileFilePage extends WikiaFilePage {
	/**
	 * TOC override so Wikia File Page does not return any TOC
	 *
	 * @param $metadata Boolean - doesn't matter
	 * @return String - will return empty string to add
	 */
	protected function showTOC( $metadata ) {
		return '';
	}
}