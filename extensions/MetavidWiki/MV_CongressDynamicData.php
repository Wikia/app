<?php
/*
 * MV_CongressDynamicData.php Created on Feb 9, 2008
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 * This extension has a few hooks for embedding dynamic congress related widges and content 
 * its a normal stand alone extension
 * its invoked with #cdd:type:key:
 * for example {{#cdd:bill_status:govtrack_bill_id}} //will pull up the status for bill_id from govtrack
 */
if ( !defined( 'MEDIAWIKI' ) )  die( 1 );

/**
 * Wrapper class for encapsulating EmbedVideo related parser methods
 */
class MV_CongressDynamicData {	
    //Sets up parser functions.
    function setup( ) {    
        # Setup parser hook
    	global $wgParser, $wgVersion;
    	$hook = (version_compare($wgVersion, '1.7', '<')?'#cdd':'cdd');
    	$wgParser->setFunctionHook( $hook, array($this, 'parserFunction') );    	    
        # Add system messages
    	global $wgMessageCache;
        $wgMessageCache->addMessage('cdd-missing-params', 'Congress Dynamic Data is missing a required parameter.');
    }
     //Adds magic words for parser functions.     
    function parserFunctionMagic( &$magicWords, $langCode='en' ) {
        $magicWords['cdd'] = array( 0, 'cdd' );
        return true;
    }
    function parserFunction( $parser, $service_type=null, $keyID=null) {   
    	if($service_type==null || $keyID==null){
    		return '<div class="errorbox">'.wfMsg('cdd-missing-params').'</div>';
    	}
    	$html='';
    	switch($service_type){
    		case 'bill_status':
    			$html='<script src="http://www.govtrack.us/embed/bill.xpd?bill='.$keyID.'" type="text/javascript"/>';
    		break;
    	}
        return array(
           	$html,
            noparse => "true",
            isHTML => "true"
        );
    }
}
# Create global instance and wire it up!
$wgMV_CDD = new MV_CongressDynamicData();
$wgExtensionFunctions[] = array($wgMV_CDD, 'setup');
if (version_compare($wgVersion, '1.7', '<')) {
    # Hack solution to resolve 1.6 array parameter nullification for hook args
    function wfEmbedVideoLanguageGetMagic( &$magicWords ) {
        global $wgEmbedVideo;
        $wgMV_CDD->parserFunctionMagic( $magicWords );
        return true;
    }
    $wgHooks['LanguageGetMagic'][] = 'wfEmbedVideoLanguageGetMagic';
} else {
    $wgHooks['LanguageGetMagic'][] = array($wgMV_CDD, 'parserFunctionMagic');
}








 # Define a setup function
$wgExtensionFunctions[] = 'wfCongressVidParserFunction_Setup';
# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][] = 'wfCongressVidParserFunction_Magic';

function wfCongressVidParserFunction_Setup() {
    global $wgParser;
    # Set a function hook associating the "example" magic word with our function
    $wgParser->setFunctionHook( 'gtbs', 'wfCongressVidParserFunction_Render' );
}

function wfCongressVidParserFunction_Magic( &$magicWords, $langCode ) {
    # Add the magic word
    # The first array element is case sensitivity, in this case it is not case sensitive
    # All remaining elements are synonyms for our parser function
    $magicWords['gtbs'] = array( 0, 'gtbs' );
    return true;
}

function wfCongressVidParserFunction_Render( &$parser, $param1 = '', $param2 = '' ) {
    # The parser function itself
    # The input parameters are wikitext with templates expanded
    # The output should be wikitext too
    return '<script src="http://www.govtrack.us/embed/bill.xpd?bill='.$param1.'" type="text/javascript"/>';
}
?>
