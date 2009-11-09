<?php
  
/**
 * Initialization file for the Semantic Maps extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 *
 * @file SemanticMaps.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw 
 */

/**
 * This documenation group collects source code files belonging to Semantic Maps.
 *
 * Please do not use this group name for other code. If you have an extension to 
 * Semantic Maps, please use your own group defenition.
 * 
 * @defgroup SemanticMaps Semantic Maps
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define('SM_VERSION', '0.4 RC1');

$smgScriptPath 	= $wgScriptPath . '/extensions/SemanticMaps';
$smgIP 			= $IP . '/extensions/SemanticMaps';

// Include the settings file
require_once($smgIP . '/SM_Settings.php');

$wgExtensionFunctions[] = 'smfSetup'; 

$wgHooks['AdminLinks'][] = 'smfAddToAdminLinks';

$wgExtensionMessagesFiles['SemanticMaps'] = $smgIP . '/SemanticMaps.i18n.php';

// Add the services
$egMapsServices['googlemaps']['qp'] = array('class' => 'SMGoogleMapsQP', 'file' => 'SemanticMaps/GoogleMaps/SM_GoogleMapsQP.php', 'local' => false);
$egMapsServices['googlemaps']['fi'] = array('class' => 'SMGoogleMapsFormInput', 'file' => 'SemanticMaps/GoogleMaps/SM_GoogleMapsFormInput.php', 'local' => false);

$egMapsServices['yahoomaps']['qp'] = array('class' => 'SMYahooMapsQP', 'file' => 'SemanticMaps/YahooMaps/SM_YahooMapsQP.php', 'local' => false);
$egMapsServices['yahoomaps']['fi'] = array('class' => 'SMYahooMapsFormInput', 'file' => 'SemanticMaps/YahooMaps/SM_YahooMapsFormInput.php', 'local' => false);

$egMapsServices['openlayers']['qp'] = array('class' => 'SMOpenLayersQP', 'file' => 'SemanticMaps/OpenLayers/SM_OpenLayersQP.php', 'local' => false);
$egMapsServices['openlayers']['fi'] = array('class' => 'SMOpenLayersFormInput', 'file' => 'SemanticMaps/OpenLayers/SM_OpenLayersFormInput.php', 'local' => false);

/**
 * 'Initialization' function for the Semantic Maps extension. 
 * The only work done here is creating the extension credits for
 * Semantic Maps. The actuall work in done via the Maps hooks.
 */
function smfSetup() {
	global $wgExtensionCredits, $wgLang, $egMapsServices;
	
	// Creation of a list of internationalized service names
	$services = array();
	foreach (array_keys($egMapsServices) as $name) $services[] = wfMsg('maps_'.$name);
	$services_list = $wgLang->listToText($services);	
	
	// TODO: split for feature hook system?
	wfLoadExtensionMessages( 'SemanticMaps' );
	
	$wgExtensionCredits['other'][]= array(
		'path' => __FILE__,
		'name' => wfMsg('semanticmaps_name'),
		'version' => SM_VERSION,
		'author' => array('[http://bn2vs.com Jeroen De Dauw]', 'Yaron Koren', 'Robert Buzink'),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Semantic_Maps',
		'description' => wfMsgExt( 'semanticmaps_desc', 'parsemag', $services_list ),
		'descriptionmsg' => wfMsgExt( 'semanticmaps_desc', 'parsemag', $services_list ),
	);
	
	return true;	
}

/**
 * Returns html for an html input field with a default value that will automatically dissapear when
 * the user clicks in it, and reappers when the focus on the field is lost and it's still empty.
 *
 * @author Jeroen De Dauw
 *
 * @param string $id
 * @param string $value
 * @param string $args
 * @return html
 */ // TODO: move to FI feature code
function smfGetDynamicInput($id, $value, $args='') {
	return '<input id="'.$id.'" '.$args.' value="'.$value.'" onfocus="if (this.value==\''.$value.'\') {this.value=\'\';}" onblur="if (this.value==\'\') {this.value=\''.$value.'\';}" />';
}

/**
 * Adds a link to Admin Links page
 */
function smfAddToAdminLinks(&$admin_links_tree) {
    $displaying_data_section = $admin_links_tree->getSection(wfMsg('smw_adminlinks_displayingdata'));
    
    // Escape if SMW hasn't added links
    if (is_null($displaying_data_section)) return true;
    
    $smw_docu_row = $displaying_data_section->getRow('smw');
    
    $sm_docu_label = wfMsg('adminlinks_documentation', wfMsg('semanticmaps_name'));
    $smw_docu_row->addItem(AlItem::newFromExternalLink("http://www.mediawiki.org/wiki/Extension:Semantic_Maps", $sm_docu_label));
    
    return true;
}

