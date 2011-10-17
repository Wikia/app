<?php
/**
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFLanguage
 */
class SF_LanguageHe extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'משתמש בטופס',
		SF_SP_HAS_ALTERNATE_FORM  => 'משתמש בטופס'
	);
	
	var $m_Namespaces = array(
		SF_NS_FORM           => 'Form',
		SF_NS_FORM_TALK      => 'Form_talk'
	);

}

