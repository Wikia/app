<?php

$namespaceNames = array();

// For wikis without LiquidThreads installed.
if ( ! defined('NS_LQT_THREAD') ) {
	define( 'NS_LQT_THREAD', 90 );
	define( 'NS_LQT_THREAD_TALK', 91 );
	define( 'NS_LQT_SUMMARY', 92 );
	define( 'NS_LQT_SUMMARY_TALK', 93 );
}

$namespaceNames['en'] = array(
	NS_LQT_THREAD       => 'Thread',
	NS_LQT_THREAD_TALK  => 'Thread_talk',
	NS_LQT_SUMMARY      => 'Summary',
	NS_LQT_SUMMARY_TALK => 'Summary_talk',
);

$namespaceNames['de'] = array(
	NS_LQT_THREAD       => 'Thema',
	NS_LQT_THREAD_TALK  => 'Thema_Diskussion',
	NS_LQT_SUMMARY      => 'Themazusammenfassung',
	NS_LQT_SUMMARY_TALK => 'Themazusammenfassung_Diskussion',
);

$namespaceNames['fi'] = array(
	NS_LQT_THREAD       => 'Viestiketju',
	NS_LQT_THREAD_TALK  => 'Keskustelu_viestiketjusta',
	NS_LQT_SUMMARY      => 'Yhteenveto',
	NS_LQT_SUMMARY_TALK => 'Keskustelu_yhteenvedosta',
);

$namespaceNames['hu'] = array(
	NS_LQT_THREAD => 'Téma',
	NS_LQT_THREAD_TALK => 'Témavita',
	NS_LQT_SUMMARY => 'Összefoglaló',
	NS_LQT_SUMMARY_TALK => 'Összefoglaló-vita',
);

$namespaceNames['id'] = array(
	NS_LQT_THREAD       => 'Utas',
	NS_LQT_THREAD_TALK  => 'Pembicaraan_Utas',
	NS_LQT_SUMMARY      => 'Ringkasan',
	NS_LQT_SUMMARY_TALK => 'Pembicaraan_Ringkasan',
);

$namespaceNames['nl'] = array(
	NS_LQT_THREAD       => 'Onderwerp',
	NS_LQT_THREAD_TALK  => 'Overleg_onderwerp',
	NS_LQT_SUMMARY      => 'Samenvatting',
	NS_LQT_SUMMARY_TALK => 'Overleg_samenvatting',
);

$namespaceNames['pt'] = array(
	NS_LQT_THREAD => 'Tópico',
	NS_LQT_THREAD_TALK => 'Tópico_discussão',
	NS_LQT_SUMMARY => 'Resumo',
	NS_LQT_SUMMARY_TALK => 'Resumo_discussão',
);

$namespaceNames['sv'] = array(
	NS_LQT_THREAD => 'Tråd',
	NS_LQT_THREAD_TALK => 'Tråddiskussion',
	NS_LQT_SUMMARY => 'Summering',
	NS_LQT_SUMMARY_TALK => 'Summeringsdiskussion',
);

$namespaceNames['zh-hans'] = array(
	NS_LQT_THREAD       => '主题',
	NS_LQT_THREAD_TALK  => '主题讨论',
	NS_LQT_SUMMARY      => '摘要',
	NS_LQT_SUMMARY_TALK => '摘要讨论',
);

$namespaceNames['zh-hant'] = array(
	NS_LQT_THREAD       => '主題',
	NS_LQT_THREAD_TALK  => '主題討論',
	NS_LQT_SUMMARY      => '摘要',
	NS_LQT_SUMMARY_TALK => '摘要討論',
);
