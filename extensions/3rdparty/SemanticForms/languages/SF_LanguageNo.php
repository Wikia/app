<?php
/**
 * @author Jon Harald Søby
 */

class SF_LanguageNo extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'Har standardskjema',
		SF_SP_HAS_ALTERNATE_FORM  => 'Har alternativt skjema'
	);

	var $m_Namespaces = array(
		SF_NS_FORM           => 'Skjema',
		SF_NS_FORM_TALK      => 'Skjemadiskusjon'
	);

}

