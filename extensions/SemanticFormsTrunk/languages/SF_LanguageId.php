<?php
/**
 * @author Ivan Lanin
 */

class SF_LanguageId extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'Memiliki formulir bawaan',
		SF_SP_HAS_ALTERNATE_FORM  => 'Memiliki formulir alternatif',
		SF_SP_CREATES_PAGES_WITH_FORM => 'Membuat halaman dengan formulir',
		SF_SP_PAGE_HAS_DEFAULT_FORM   => 'Halaman memiliki formulir bawaan',
		SF_SP_HAS_FIELD_LABEL_FORMAT  => 'Memiliki format label bidang',
	);

	var $m_Namespaces = array(
		SF_NS_FORM           => 'Formulir',
		SF_NS_FORM_TALK      => 'Pembicaraan_Formulir'
	);

}
