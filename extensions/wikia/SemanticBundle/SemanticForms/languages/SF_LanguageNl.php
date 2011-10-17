<?php
/**
 * @author Siebrand Mazeland
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFLanguage
 */
class SF_LanguageNl extends SF_Language {
	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM   => 'Heeft standaard formulier',
		SF_SP_HAS_ALTERNATE_FORM => 'Heeft alternatief formulier',
		SF_SP_CREATES_PAGES_WITH_FORM => 'Maakt pagina\'s aan via formulier',
		SF_SP_PAGE_HAS_DEFAULT_FORM   => 'Pagina heeft standaard formulier',
		SF_SP_HAS_FIELD_LABEL_FORMAT  => 'Heeft veldlabelopmaak',
	);
	
	var $m_Namespaces = array(
		SF_NS_FORM      => 'Formulier',
		SF_NS_FORM_TALK => 'Overleg_formulier'
	);
}
