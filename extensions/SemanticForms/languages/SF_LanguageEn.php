<?php
/**
 * @author Yaron Koren
 */

class SF_LanguageEn extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'Has default form',
		SF_SP_HAS_ALTERNATE_FORM  => 'Has alternate form',
		SF_SP_CREATES_PAGES_WITH_FORM => 'Creates pages with form',
		SF_SP_PAGE_HAS_DEFAULT_FORM   => 'Page has default form',
		SF_SP_HAS_FIELD_LABEL_FORMAT  => 'Has field label format',
	);

	var $m_Namespaces = array(
		SF_NS_FORM           => 'Form',
		SF_NS_FORM_TALK      => 'Form_talk'
	);

}

