<?php
/**
 * @author Melos
 */

class SF_LanguageIt extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'Usa il modulo predefinito',
		SF_SP_HAS_ALTERNATE_FORM  => 'Usa il modulo alternativo',
		SF_SP_CREATES_PAGES_WITH_FORM => 'Crea pagine con modulo',
		SF_SP_PAGE_HAS_DEFAULT_FORM   => 'La pagina ha il modulo predefinito',
		SF_SP_HAS_FIELD_LABEL_FORMAT  => 'Usa il formato del campo etichetta',
	);

	var $m_Namespaces = array(
		SF_NS_FORM           => 'Modulo',
		SF_NS_FORM_TALK      => 'Discussione_modulo'
	);

}
