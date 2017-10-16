<?php
/**
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * Represents a single parameter (name and value) within a template call
 * in a wiki page.
 */
class SFWikiPageTemplateParam {
	private $mName;
	private $mValue;

	function __construct( $name, $value ) {
		$this->mName = $name;
		$this->mValue = $value;
	}

	function getName() {
		return $this->mName;
	}

	function getValue() {
		return $this->mValue;
	}

	function setValue( $value ) {
		$this->mValue = $value;
	}
}
