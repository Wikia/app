<?php

/**
 * This class contains hook handlers used to override MW Linker functionality
 */
class RTELinkerHooks extends Linker {

	/**
	* Create a headline for content
	*
	* @param int    $level   The level of the headline (1-6)
	* @param string $attribs Any attributes for the headline, starting with a space and ending with '>'
	*                        This *must* be at least '>' for no attribs
	* @param string $anchor  The anchor to give the headline (the bit after the #)
	* @param string $text    The text of the header
	* @param string $link    HTML to add for the section edit link
	* @param mixed  $legacyAnchor A second, optional anchor to give for
	*   backward compatibility (false to omit)
	*
	* @return boolean it's a hook
	*/
	public static function onMakeHeadline( $skin, $level, $attribs, $anchor, $html, $link, $legacyAnchor, &$ret ) {
		global $wgRTEParserEnabled;
		if (empty($wgRTEParserEnabled)) {
			return true;
		}

		wfProfileIn(__METHOD__);

		// count spaces before and after header content
		$spacesAfter = strspn(strrev($html), ' ');
		$spacesBefore = strspn($html, ' ');

		// add extra attributes to store number of spaces
		if ($spacesAfter > 0) {
			$attribs = " data-rte-spaces-after=\"{$spacesAfter}\"{$attribs}";
		}
		if ($spacesBefore > 0) {
			$attribs = " data-rte-spaces-before=\"{$spacesBefore}\"{$attribs}";
		}

		// render HTML
		$ret = "<h$level$attribs"
			. $html
			. "</h$level>";

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Render an internal link for edit mode
	 *
	 * @return boolean it's a hook
	 */
	public static function onLinkEnd(DummyLinker $skin, Title $target, array $options, &$text, array &$attribs, &$ret) {
		global $wgRTEParserEnabled;
		if (!empty($wgRTEParserEnabled)) {
			$attribs = self::addDataIdxAttributes($text, $attribs, RTEMarker::INTERNAL_DATA);
		}
		return true;
	}

	/**
	 * Render an internal link for edit mode
	 *
	 * @return boolean it's a hook
	 */
	public static function onLinkerMakeExternalLink(&$url, &$text, &$link, array &$attribs) {
		global $wgRTEParserEnabled;
		if (!empty($wgRTEParserEnabled)) {
			$attribs = self::addDataIdxAttributes($text, $attribs, RTEMarker::EXTERNAL_DATA);
		}
		return true;
	}

	/**
	 * Helper method adding _rte_dataidx attribute based on RTE marker stored in text
	 *
	 * @param $text string link content
	 * @param $attribs array attributes
	 * @param $markerType integer see RTEMarker class for constants definition
	 * @return array attributes
	 */
	private static function addDataIdxAttributes(&$text, array $attribs, $markerType) {
		wfProfileIn(__METHOD__);

		// get link metadata entry ID and remove RTE marker from link text
		$dataIdx = RTEMarker::getDataIdx($markerType, $text);

		if (is_null($dataIdx)) {
			wfDebug(__METHOD__ . " - dataIdx is empty!\n");
		}
		else {
			// add internal RTE attribute pointing to link metadata entry
			// it has to be the first one - use array_merge()
			$attribs = array_merge(
				array('_rte_dataidx' => sprintf('%04d', $dataIdx)),
				$attribs
			);
		}

		wfProfileOut(__METHOD__);
		return $attribs;
	}

	/**
	 * Returns placeholder for broken image link
	 *
	 * This one is called directly by RTEParser::makeImage()
	 *
	 */
	public static function makeBrokenImageLinkObj( $title, $html = '', $query = '', $trail = '', $prefix = '', $time = false, $wikitextIdx = null ) {
		wfProfileIn(__METHOD__);

		if( !$title instanceof Title ) {
			throw new \Exception( '$title is not Title class instance' );
		}

		// try to resolve internal links in broken image caption (RT #90616)
		$wikitext = RTEData::get('wikitext', $wikitextIdx);
		if (RTEData::resolveLinksInMediaCaption($wikitext)) {
			// update wikitext data
			$wikitextIdx = RTEData::put('wikitext', $wikitext);
		}

		$ret = RTEMarker::generate(RTEMarker::PLACEHOLDER, RTEData::put('placeholder', array(
			'type' => 'broken-image',
			'wikitextIdx' => $wikitextIdx,
			'title' => $title->getDBkey()
		)));

		wfProfileOut(__METHOD__);
		return $ret;
	}
}
