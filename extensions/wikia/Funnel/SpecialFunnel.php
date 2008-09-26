<?php
/**
 * This extension will funnel all content pages and their derivatives that requested via index.php back into /wiki/Page_Name.
 * Author Andrew Yasinky andrewy at wikia.com
 */

if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/Funnel/SpecialFunnel.php" );
EOT;
    exit( 1 );
}

$wgExtensionFunctions[] = 'wfSpecialFunnel';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Funnel',
	'author' => 'Andrew Yasinsky',
	'description' => 'Funnel Redirects',
);

function wfSpecialFunnel() {
  //init
}

function wfFunnel(){
  global $IP, $wgMessageCache, $wgAutoloadClasses, $wgSpecialPages, $wgOut, $wgRequest, $wgTitle, $wgLanguageCode;
 
  $prefix = '/wiki/';
  
  $isContent = $wgTitle->getNamespace() == NS_MAIN;

  $params = array();

  parse_str( $_SERVER['QUERY_STRING'], $params );  
  
  if( isset($_REQUEST['action']) ) return true; //don't redirect on action=edit and the like
  
  if( ( $_SERVER['REQUEST_METHOD'] == 'GET' ) && ( $_SERVER['PHP_SELF'] == '/index.php' ) && ( trim( $params['title'] ) != '' ) && ( $isContent ) ){ 
		
		$page = $params['title'];
		
		unset( $params['title'] );
		
		$query = '';
		
		if( count($params) > 0 ) return true; // we only care to rewrite content not its permutation
		
		$url = 'http://'.$_SERVER['SERVER_NAME'].$prefix.$page;
	  	header( "Location: {$url}", true, 301);
		exit(0);
		
  }
 
 return true;	 
}

if( !empty( $wgEnableSpecialFunnel ) ){
	$wgHooks['BeforePageDisplay'][] = array( 'wfFunnel', array() );
}