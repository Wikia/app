<?php
/**
 * @author Yaron Koren
 */

class SF_LanguageEs extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'Usa el formulario por defecto', // Has default form
		SF_SP_HAS_ALTERNATE_FORM  => 'Usa el formulario alternativo'// Has alternate form
	);

	var $m_Namespaces = array(
		SF_NS_FORM           => 'Formulario',// Form
		SF_NS_FORM_TALK      => 'Discusión_formulario'// Form_talk
	);

}

