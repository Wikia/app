<?php
/**
 * @author Leonardo Costa
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFLanguage
 */
class SF_LanguagePt_br extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'Has default form',
		SF_SP_HAS_ALTERNATE_FORM  => 'Has alternate form'
	);

	var $m_Namespaces = array(
		SF_NS_FORM           => 'Form',
		SF_NS_FORM_TALK      => 'Form_talk'
	);

}

