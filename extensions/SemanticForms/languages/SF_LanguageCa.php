<?php
/**
 * @author Yaron Koren
 */

class SF_LanguageCa extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'Fa servir el formulari per defecte', // Has default form
		SF_SP_HAS_ALTERNATE_FORM  => 'Fa servir el formulari alternatiu'// Has alternate form
	);

	var $m_Namespaces = array(
		SF_NS_FORM           => 'Formulari',// Form
		SF_NS_FORM_TALK      => 'Discussió_formulari'// Form_talk
	);

}

