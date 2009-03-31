<?php
/**
 * @ingroup Language
 * @ingroup SDLanguage
 * @author Yaron Koren 翻譯:張致信(Translation: Roc Michael Email:roc.no1@gmail.com) 
 */

class SD_LanguageZh_tw extends SD_Language {

/* private */ var $m_SpecialProperties = array(
        //always start upper-case
	// category properties
        SD_SP_HAS_FILTER  => '設置篩選器', //'Has filter'
	// filter properties
        SD_SP_COVERS_PROPERTY  => '涵蓋性質', //'Covers property',
        SD_SP_HAS_VALUE  => '篩選值',  //'Has value',
        SD_SP_GETS_VALUES_FROM_CATEGORY => '設分類為篩選值', //'Gets values from category',
        SD_SP_USES_TIME_PERIOD => '時間期限', //'Uses time period', 
        SD_SP_REQUIRES_FILTER => '基礎篩選器', //'Requires filter', 
        SD_SP_HAS_LABEL  => '設置標籤'  //'Has label'
);

var $m_Namespaces = array(
	SD_NS_FILTER		=> '篩選器',
	SD_NS_FILTER_TALK	=> '篩選器討論'
);

}
