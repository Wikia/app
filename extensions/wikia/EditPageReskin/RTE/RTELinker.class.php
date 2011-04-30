<?php

class RTELinker extends Linker {

	/**
	 * Don't render TOC table for RTE wysiwyg mode
	 */
	function tocList($toc) {
		return '';
	}

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
	* @return string HTML headline
	*/
	public function makeHeadline( $level, $attribs, $anchor, $text, $link, $legacyAnchor = false ) {
		wfProfileIn(__METHOD__);

		//RTE::log(__METHOD__, $text);

		// count spaces before and after header content
		$spacesAfter = strspn(strrev($text), ' ');
		$spacesBefore = strspn($text, ' ');

		// add extra attributes to store number of spaces
		if ($spacesAfter > 0) {
			$attribs = " data-rte-spaces-after=\"{$spacesAfter}\"{$attribs}";
		}
		if ($spacesBefore > 0) {
			$attribs = " data-rte-spaces-before=\"{$spacesBefore}\"{$attribs}";
		}

		// render HTMl
		$ret = "<h$level$attribs"
			. $link
			. $text
			. "</h$level>";

		wfProfileOut(__METHOD__);

		return $ret;
	}

	public function makeExternalLink( $url, $text, $escape = true, $linktype = '', $attribs = array() ) {
		$dataIdx = RTEMarker::getDataIdx(RTEMarker::EXTERNAL_DATA, $text);
		$ret = parent::makeExternalLink($url, $text, $escape, $linktype, $attribs);
		return RTEData::addIdxToTag($dataIdx, $ret);
	}

	public function makeBrokenLinkObj( $title, $text = '', $query = '', $trail = '', $prefix = '' ) {
		$dataIdx = RTEMarker::getDataIdx(RTEMarker::INTERNAL_DATA, $text);
		$ret = parent::makeBrokenLinkObj($title, $text, $query, $trail, $prefix);
		return RTEData::addIdxToTag($dataIdx, $ret);
	}

	public function makeColouredLinkObj( $nt, $colour, $text = '', $query = '', $trail = '', $prefix = '' ) {
		$dataIdx = RTEMarker::getDataIdx(RTEMarker::INTERNAL_DATA, $text);
		$ret = parent::makeColouredLinkObj($nt, $colour, $text, $query, $trail, $prefix);
		return RTEData::addIdxToTag($dataIdx, $ret);
	}

	/**
	 * Returns placeholder for broken image link
	 */
	public function makeBrokenImageLinkObj( $title, $text = '', $query = '', $trail = '', $prefix = '', $time = false, $wikitextIdx = null ) {
		// try to resolve internal links in broken image caption (RT #90616)
		$wikitext = RTEData::get('wikitext', $wikitextIdx);
		if (RTEData::resolveLinksInMediaCaption($wikitext)) {
			// update wikitext data
			$wikitextIdx = RTEData::put('wikitext', $wikitext);
		}

		$dataIdx = RTEData::put('placeholder', array('type' => 'broken-image', 'wikitextIdx' => $wikitextIdx, 'title' => $title->getDBkey()));
		return RTEMarker::generate(RTEMarker::PLACEHOLDER, $dataIdx);
	}

	public function link( $target, $text = null, $customAttribs = array(), $query = array(), $options = array() ) {
		$dataIdx = RTEMarker::getDataIdx(RTEMarker::INTERNAL_DATA, $text);
		$ret = parent::link($target, $text, $customAttribs, $query, $options);
		return RTEData::addIdxToTag($dataIdx, $ret);
	}
}
