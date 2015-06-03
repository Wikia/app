<?php
/**
 * @ingroup Language
 * @ingroup SDLanguage
 * @author Yaron Koren (Translation:Ghassem Tofighi Email:[MyFamily]@gmail.com, HomePage:http://ght.ir)
 */

class SD_LanguageFa extends SD_Language {

/* private */ var $m_SpecialProperties = array(
        //always start upper-case
	// category properties
        SD_SP_HAS_FILTER  => 'فیلتر دارد',//Has filter
        SD_SP_IS_EXCLUDED_FROM_DRILLDOWN  => 'از drilldown مستثنی شده است',//Is excluded from drilldown
	// filter properties
        SD_SP_COVERS_PROPERTY  => 'ویژگی را شامل می‌شود',//Covers property
        SD_SP_HAS_VALUE  => 'مقدار دارد',//Has value
		SD_SP_GETS_VALUES_FROM_CATEGORY => 'مقادیر را از رده می‌گیرد',//Gets values from category
	    SD_SP_USES_TIME_PERIOD => 'استفاده از پریود زمانی',//Uses time period
        SD_SP_REQUIRES_FILTER => 'به فیلتر نیاز دارد',//Requires filter
        SD_SP_HAS_LABEL  => 'برچسب دارد'//Has label
);

var $m_Namespaces = array(
	SD_NS_FILTER		=> 'فیلتر',//Filter
	SD_NS_FILTER_TALK	=> 'بحث_فیلتر'//Filter_talk
);

}
