<?php
/**
 * @author Yaron Koren
 */

/**
 * Base class for all language classes - heavily based on Semantic MediaWiki's
 * 'SMW_Language' class
 */
abstract class SC_Language {

	protected $m_SpecialProperties;

	// By default, every language has English-language aliases for
	// special properties and namespaces
	protected $m_SpecialPropertyAliases = array(
	);

	/**
	 * Function that returns the labels for the special properties.
	 */
	function getSpecialPropertiesArray() {
		return $this->m_SpecialProperties;
	}

	/**
	 * Aliases for special properties, if any.
	 */
	function getSpecialPropertyAliases() {
		return $this->m_SpecialPropertyAliases;
	}

}
