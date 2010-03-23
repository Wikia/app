<?php
/**
 * @author Yaron Koren
 */

/**
 * Base class for all language classes - a truncated version of Semantic
 * MediaWiki's 'SMW_Language' class
 */
abstract class SF_Language {

	// arrays for the names of special properties and namespaces -
	// all messages are stored in SF_Messages.php
	protected $m_SpecialProperties;
	protected $m_Namespaces;

	// By default, every language has English-language aliases for
	// special properties and namespaces
	protected $m_SpecialPropertyAliases = array(
		'Has default form'	=> SF_SP_HAS_DEFAULT_FORM,
		'Has alternate form'	=> SF_SP_HAS_ALTERNATE_FORM,
		'Creates pages with form'	=> SF_SP_CREATES_PAGES_WITH_FORM,
	);

	protected $m_NamespaceAliases = array(
		'Form'		=> SF_NS_FORM,
		'Form_talk'	=> SF_NS_FORM_TALK
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
