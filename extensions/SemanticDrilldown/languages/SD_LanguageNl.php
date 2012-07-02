<?php
/**
 * @ingroup Language
 * @ingroup SDLanguage
 * @author Siebrand Mazeland
 */

class SD_LanguageNl extends SD_Language {
	/* private */ var $m_SpecialProperties = array(
		//always start upper-case
		// category properties
		SD_SP_HAS_FILTER          => 'Heeft filter',
		SD_SP_HAS_DRILLDOWN_TITLE => 'Heeft drilldownnaam',

		// filter properties
		SD_SP_COVERS_PROPERTY           => 'Omvat eigenschap',
		SD_SP_HAS_VALUE                 => 'Heeft waarde',
		SD_SP_GETS_VALUES_FROM_CATEGORY => 'Haalt waarden uit categorie',
		SD_SP_USES_TIME_PERIOD          => 'Gebruikt periode',
		SD_SP_HAS_INPUT_TYPE            => 'Heeft invoertype',
		SD_SP_REQUIRES_FILTER           => 'Benodigt filter',
		SD_SP_HAS_LABEL                 => 'Heeft label'
	);

	var $m_Namespaces = array(
		SD_NS_FILTER      => 'Filter',
		SD_NS_FILTER_TALK => 'Overleg_filter'
	);
}
