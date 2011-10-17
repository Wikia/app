<?php
/**
 * @author Yaron Koren (Translation:Ghassem Tofighi Email:[MyFamily]@gmail.com, HomePage:http://ght.ir)
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFLanguage
 */
class SF_LanguageFa extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'فرم پیش‌فرض دارد',// Has default form
		SF_SP_HAS_ALTERNATE_FORM  => 'فرم مشابه دارد'// Has alternate form
	);
	
	var $m_Namespaces = array(
		SF_NS_FORM           => 'فرم',// Form
		SF_NS_FORM_TALK      => 'بحث_فرم'// Form_talk
	);

}

