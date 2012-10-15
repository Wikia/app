<?php

$namespaceNames = array();

// For wikis without QPoll installed.
if ( ! defined( 'NS_QP_INTERPRETATION' ) ) {
	define( 'NS_QP_INTERPRETATION', 800 );
	define( 'NS_QP_INTERPRETATION_TALK', 801 );
}

$namespaceNames['en'] = array(
	NS_QP_INTERPRETATION      => 'Interpretation',
	NS_QP_INTERPRETATION_TALK => 'Interpretation_talk',
);

$namespaceNames['ru'] = array(
	NS_QP_INTERPRETATION      => 'Интерпретация',
	NS_QP_INTERPRETATION_TALK => 'Обсуждение_интерпретации',
);
