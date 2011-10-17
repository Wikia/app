<?php
/**
 * @ingroup Language
 * @ingroup SDLanguage
 * @author Yaron Koren
 */

class SD_LanguageEn extends SD_Language {

/* private */ var $m_SpecialProperties = array(
	//always start upper-case
	// category properties
	SD_SP_HAS_FILTER  => 'Has filter',
	SD_SP_HAS_DRILLDOWN_TITLE  => 'Has drilldown title',
	// filter properties 	 
	SD_SP_COVERS_PROPERTY  => 'Covers property',
	SD_SP_HAS_VALUE  => 'Has value',
	SD_SP_GETS_VALUES_FROM_CATEGORY => 'Gets values from category',
	SD_SP_USES_TIME_PERIOD => 'Uses time period',
	SD_SP_HAS_INPUT_TYPE => 'Has input type',
	SD_SP_REQUIRES_FILTER => 'Requires filter',
	SD_SP_HAS_LABEL  => 'Has label',
	// display properties
	SD_SP_HAS_DISPLAY_PARAMETERS => 'Has display parameters',
);

var $m_Namespaces = array(
	SD_NS_FILTER		=> 'Filter',
	SD_NS_FILTER_TALK	=> 'Filter_talk'
);

}
