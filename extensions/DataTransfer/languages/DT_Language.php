<?php
/**
 * @author Yaron Koren
 */

/**
 * Base class for all language classes - heavily based on Semantic MediaWiki's
 * 'SMW_Language' class
 */
abstract class DT_Language {

	protected $m_SpecialProperties;

	// By default, every language has English-language aliases for
	// special properties
	protected $m_SpecialPropertyAliases = array(
		'Has XML grouping' => DT_SP_HAS_XML_GROUPING,
		'Excluded from XML' => DT_SP_IS_EXCLUDED_FROM_XML,
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
