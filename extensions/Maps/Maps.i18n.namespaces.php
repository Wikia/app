<?php

$namespaceNames = array();

// For wikis without Maps installed.
if ( !defined( 'Maps_NS_LAYER' ) ) {
	define( 'Maps_NS_LAYER', 420 );
	define( 'Maps_NS_LAYER_TALK', 421 );
}

$namespaceNames['en'] = array(
	Maps_NS_LAYER       => 'Layer',
	Maps_NS_LAYER_TALK  => 'Layer_talk',
);

$namespaceNames['de'] = array(
	Maps_NS_LAYER_TALK  => 'Layer_Diskussion',
);
