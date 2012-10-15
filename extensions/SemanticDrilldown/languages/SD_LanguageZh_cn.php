<?php
/**
 * @ingroup Language
 * @ingroup SDLanguage
 *@author Yaron Koren 翻译:张致信 本档系以电子字典译自繁体版，请自行修订(Translation: Roc Michael Email:roc.no1@gmail.com. This file is translated from Tradition Chinese by useing electronic dictionary. Please correct the file by yourself.) 
 */

class SD_LanguageZh_cn extends SD_Language {

/* private */ var $m_SpecialProperties = array(
        //always start upper-case
	// category properties
        SD_SP_HAS_FILTER  => '设置筛选器', //'Has filter'
	// filter properties
        SD_SP_COVERS_PROPERTY  => '涵盖性质', //'Covers property',
        SD_SP_HAS_VALUE  => '筛选值',  //'Has value',
        SD_SP_GETS_VALUES_FROM_CATEGORY => '设分类为筛选值', //'Gets values from category',
        SD_SP_USES_TIME_PERIOD => '时间期限', //'Uses time period', 
        SD_SP_REQUIRES_FILTER => '基础筛选器', //'Requires filter', 
        SD_SP_HAS_LABEL  => '设置标签'  //'Has label'
);

var $m_Namespaces = array(
	SD_NS_FILTER		=> '筛选器',
	SD_NS_FILTER_TALK	=> '筛选器讨论'
);

}

