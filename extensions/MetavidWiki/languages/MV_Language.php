<?php
/*
 * MV_Language.php Created on Jan 8, 2008
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
 /**
 * Base class for all language classes - a truncated version of Semantic
 * MediaWiki's 'SMW_Language' class
 */
abstract class MV_Language {

	// arrays for the names of special properties and namespaces -
	// all messages are stored in MV_Messages.php
	protected $m_SpecialProperties;
	protected $m_Namespaces;

	// By default, every language has English-language aliases for
	// special properties and namespaces
	/*protected $m_SpecialPropertyAliases = array(
		'Has default form'	=> SF_SP_HAS_DEFAULT_FORM,
		'Has alternate form'	=> SF_SP_HAS_ALTERNATE_FORM
	);*/

	protected $m_NamespaceAliases = array(
		'Stream'		=> MV_NS_STREAM,
		'Stream_talk'	=> MV_NS_STREAM_TALK,
		'Sequence'		=> MV_NS_SEQUENCE,
		'Sequence_talk'	=> MV_NS_SEQUENCE_TALK,
		'MVD'			=> MV_NS_MVD,
		'MVD_talk'		=> MV_NS_MVD_TALK
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
?>