<?php
/**
 * @ingroup Language
 * @ingroup SDLanguage
 * @author Yaron Koren
 */

/**
 * Base class for all language classes - heavily based on Semantic MediaWiki's
 * 'SMW_Language' class
 */
abstract class SD_Language {

	protected $m_SpecialProperties;
	protected $m_Namespaces;

	// By default, every language has English-language aliases for
	// special properties and namespaces
	protected $m_SpecialPropertyAliases = array(
		// category properties
		'Has filter' => SD_SP_HAS_FILTER,
		'Has drilldown title' => SD_SP_HAS_DRILLDOWN_TITLE,
		// filter properties
		'Covers property' => SD_SP_COVERS_PROPERTY,
		'Has value' => SD_SP_HAS_VALUE,
		'Gets values from category' => SD_SP_GETS_VALUES_FROM_CATEGORY,
		'Uses time period' => SD_SP_USES_TIME_PERIOD,
		'Has input type' => SD_SP_HAS_INPUT_TYPE,
		'Requires filter' => SD_SP_REQUIRES_FILTER,
		'Has label' => SD_SP_HAS_LABEL,
		// display properties
		'Has display parameters' => SD_SP_HAS_DISPLAY_PARAMETERS,
	);

	protected $m_NamespaceAliases = array(
		'Filter'	=> SD_NS_FILTER,
		'Filter_talk'	=> SD_NS_FILTER_TALK
	);

	/**
	 * Function that returns an array of namespace identifiers.
	 */
	function getNamespaces() {
		return $this->m_Namespaces;
	}

	/**
	 * Function that returns an array of namespace aliases, if any.
	 */
	function getNamespaceAliases() {
		return $this->m_NamespaceAliases;
	}

	/**
	 * Function that returns the labels for the special properties.
	 */
	function getPropertyLabels() {
		return $this->m_SpecialProperties;
	}

	/**
	 * Aliases for special properties, if any.
	 */
	function getPropertyAliases() {
		return $this->m_SpecialPropertyAliases;
	}

}
