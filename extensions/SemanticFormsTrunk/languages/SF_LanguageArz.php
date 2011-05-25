<?php
/**
 * @author Meno25
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFLanguage
 */
class SF_LanguageArz extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'لديه استمارة افتراضية',// Has default form
		SF_SP_HAS_ALTERNATE_FORM  => 'لديه استمارة بديلة'// Has alternate form
	);

	var $m_Namespaces = array(
		SF_NS_FORM           => 'استمارة',// Form
		SF_NS_FORM_TALK      => 'نقاش_الاستمارة'// Form_talk
	);

}

