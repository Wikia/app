<?php
/**
 * This extension will funnel all content pages and their derivatives that requested via index.php back into /wiki/Page_Name.
 * Author Andrew Yasinky andrewy at wikia.com
 */

if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/Userengagement/SpecialFunnel.php" );
EOT;
    exit( 1 );
}

$wgExtensionFunctions[] = 'wfSpecialFunnel';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Funnel',
	'author' => 'Andrew Yasinsky',
	'description' => 'Funnel Redirects',
);

$wgSpecialPages['Funnel'] = array( /*class*/ 'Funnel', /*name*/ 'Funnel', false, false );

function wfSpecialFunnel() {
  //init
}

function wfFunnel(){
  global $IP, $wgMessageCache, $wgAutoloadClasses, $wgSpecialPages, $wgOut, $wgRequest, $wgTitle, $wgLanguageCode;
 
  $prefix = '/wiki/';
  
  $isContent = $wgTitle->getNamespace() == NS_MAIN;

  $params = array();

  parse_str( $_SERVER['QUERY_STRING'], $params );  

  if( ( $_SERVER['REQUEST_METHOD'] == 'GET' ) && ( $_SERVER['PHP_SELF'] == '/index.php' ) && ( trim( $params['title'] ) != '' ) && ( $isContent ) ){ 
		
		$page = $params['title'];
		
		unset( $params['title'] );
		
		$query = '';
		
		if( count($params) > 0 ){
			$query = '?' . http_build_query( $params );
		}
		
		$url = 'http://'.$_SERVER['SERVER_NAME'].$prefix.$page.$query;
	  	header( "Location: {$url}", true, 301);
		exit(0);
		
  }
 
 return true;	 
}

if( !empty( $wgEnableSpecialFunnel ) ){
	$wgHooks['BeforePageDisplay'][] = array( 'wfFunnel', array() );
}