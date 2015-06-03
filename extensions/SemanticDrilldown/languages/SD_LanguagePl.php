<?php
/**
 * @ingroup Language
 * @ingroup SDLanguage
 */

class SD_LanguagePl extends SD_Language {

	public $m_SpecialProperties = [
		// category properties
		SD_SP_HAS_FILTER  => 'Ma filtr',
		SD_SP_HAS_DRILLDOWN_TITLE  => 'Ma tytuł semantyczny',
		// filter properties
		SD_SP_COVERS_PROPERTY  => 'Pokrywa właściwość',
		SD_SP_HAS_VALUE  => 'Ma wartość',
		SD_SP_GETS_VALUES_FROM_CATEGORY => 'Pobiera wartości z kategorii',
		SD_SP_USES_TIME_PERIOD => 'Używa okresu czasu',
		SD_SP_HAS_INPUT_TYPE => 'Ma określony typ',
		SD_SP_REQUIRES_FILTER => 'Wymaga filtra',
		SD_SP_HAS_LABEL  => 'Ma etykietę',
		// display properties
		SD_SP_HAS_DISPLAY_PARAMETERS => 'Ma parametry wyświetlania',
	];

	var $m_Namespaces = array(
		SD_NS_FILTER		=> 'Filtr',
		SD_NS_FILTER_TALK	=> 'Dyskusja_filtru',
	);

}
