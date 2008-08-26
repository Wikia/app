<?php
/** \file
* \brief Contains setup code for the Stale Pages Extension.
*/

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "Stale pages extension";
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Stale pages',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Stale_Pages',
	'author'         => 'Tim Laqua',
	'description'    => 'Generates a list of pages that have not been edited recently',
	'descriptionmsg' => 'stalepages-desc',
	'version'        => '0.7'
);

if( version_compare( $wgVersion, '1.11', '>=' ) ) {    
	$wgExtensionMessagesFiles['Stalepages'] = $dirname(__FILE__) . '/StalePages.i18n.php';
} else {
	$wgExtensionFunctions[] = 'efStalepages';
}

$wgAutoloadClasses['Stalepages'] = dirname(__FILE__) . '/StalePages_body.php';

$wgSpecialPages['Stalepages'] = 'Stalepages';


///Message Cache population for versions that did not support $wgExtensionFunctions
function efStalePages() {
	global $wgMessageCache;   
	
	#Add Messages   
	require( dirname( __FILE__ ) . '/StalePages.i18n.php' );   
	foreach( $messages as $key => $value ) {   
		  $wgMessageCache->addMessages( $messages[$key], $key );   
	}   
} 
