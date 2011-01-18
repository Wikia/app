<?php
/**
 * @author Yaron Koren
 */

class SF_LanguageFr extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'Utilise le formulaire',
		SF_SP_HAS_ALTERNATE_FORM  => 'Utilise le formulaire alternatif'
	);
	
	var $m_Namespaces = array(
		SF_NS_FORM           => 'Formulaire',
		SF_NS_FORM_TALK      => 'Discussion_formulaire'
	);

}

