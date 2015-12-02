<?php
/**
 * @author Dominik Rodler
 * @author Karsten Hoffmeyer (kghbln)
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFLanguage
 */
class SF_LanguageDe extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM => 'Hat Standardformular',
		SF_SP_PAGE_HAS_DEFAULT_FORM => 'Seite Hat Standardformular',
		SF_SP_HAS_ALTERNATE_FORM => 'Hat Alternativformular',
		SF_SP_CREATES_PAGES_WITH_FORM => 'Erstellt Seiten mit Formular',
		SF_SP_HAS_FIELD_LABEL_FORMAT  => 'Hat Feldbezeichnungsformat',
	);

}
