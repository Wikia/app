<?php
/**
 * @package MediaWiki
 * @subpackage img2esi
 * @author Andrew Yasinsky <andrewy@wikia.com> for Wikia.com
 * @version: $Id$
 */

$wgExtensionCredits['parserhook'][] = array(
        'name' => 'img2esi',
        'author' => 'Andrew Yasinsky',
        'description' => 'This extension replaces img src=url to esi:include src=handler?url=url format',
        'version'=>'0.1'
);
 
$wgHooks['BeforePageDisplay'][] = 'img2esi';
 
function img2esi( &$out )
{		
	$matches = array();
		
	if( img2esi_pattern( $out->mBodytext, $matches ) ){

		$r = str_replace( $matches[0],$matches[1], $out->mBodytext);

	}
		
		print_r($matches);
		
		die;
					
    return true;
}

function img2esi_pattern( &$txt, &$matches ){   

	$ztxt = preg_match_all("'<img(.*?)\/>'si", $txt, $matches);
	//find all img patterns and put in arrays arrays
	$ts  = time();
	if( count( $matches > 0 ) ){
	  foreach( $matches[1] as $key => $value ){
	    $estr = base64_encode( serialize( trim( $value ) ) ) ;
		$matches[2][$key] = $matches[1][$key]; //keep a copy
		$matches[1][$key] = '<esi:include src="img2esi.php?src=' . $estr . '&ts=' . $ts . '" />' ;	
	  }
	}else{
	  return false;
	}
	//replace
	return true;
}