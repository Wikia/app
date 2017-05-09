<?php
/**
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * Represents a section (header and contents) in a wiki page.
 */
class SFWikiPageSection {
	private $mHeader, $mHeaderLevel, $mText;

	function __construct( $sectionName, $headerLevel, $sectionText ) {
		$this->mHeader = $sectionName;
		$this->mHeaderLevel = $headerLevel;
		$this->mText = $sectionText;
	}

	function getHeader() {
		return $this->mHeader;
	}

	function getHeaderLevel() {
		return $this->mHeaderLevel;
	}

	function getText() {
		return $this->mText;
	}
}
