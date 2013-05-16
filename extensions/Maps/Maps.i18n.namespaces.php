<?php

$namespaceNames = array();

// For wikis without LiquidThreads installed.
if ( !defined( 'Maps_NS_LAYER' ) ) {
	define( 'Maps_NS_LAYER', 420 );
	define( 'Maps_NS_LAYER_TALK', 421 );
}

$namespaceNames['en'] = array(
	Maps_NS_LAYER       => 'Layer',
	Maps_NS_LAYER_TALK  => 'Layer_talk',
);
