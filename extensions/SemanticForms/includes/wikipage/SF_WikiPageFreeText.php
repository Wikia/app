<?php
/**
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * Represents the "free text" in a wiki page, i.e. the text not in
 * pre-defined template calls and sections.
 */
class SFWikiPageFreeText {
	private $mText;

	function setText( $text ) {
		$this->mText = $text;
	}

	function getText() {
		return $this->mText;
	}
}
