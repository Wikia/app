<?php
/**
 * @author Inez Korczynski <inez@wikia.com>
 * @author Tomasz Klim <tomek@wikia.com>
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetWikiaMessages'] = array(
	'callback' => 'WidgetWikiaMessages',
	'title' => array(
		'en' => 'Wikia messages',
		'pl' => 'Komunikaty Wikii'
	),
	'desc' => array(
		'en' => 'Wikia messages'
    ),
    'closeable' => false,
    'editable' => false,
    'listable' => false
);

function WidgetWikiaMessages($id, $params) {

    wfProfileIn( __METHOD__ );

    global $wgOut;
    
    $ret = ( is_object( $wgOut ) ? $wgOut->parse( wfMsg( 'shared-News_box' ) ) : '' );

    wfProfileOut(__METHOD__);

    return $ret;
}
