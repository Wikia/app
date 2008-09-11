<?php
/**
 * A Special Page extension that displays Wiki Google Webtools stats.
 *
 * This page can be accessed from Special:Webtools
 *
 * @addtogroup Extensions
 *
 * @author Andrew Yasinsky <nadrewy@wikia.com>
 */

if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/Userengagement/SpecialUserengagement.php" );
EOT;
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Userengagement',
	'author' => 'Andrew Yasinsky',
	'description' => 'Assign User Message to Actions',
);

$wgAutoloadClasses['Userengagement'] = dirname( __FILE__ ) . '/SpecialUserengagement_body.php';
$wgSpecialPages['Userengagement'] = array( /*class*/ 'Userengagement', /*name*/ 'Userengagement', false, false );
$wgExtensionMessagesFiles["Userengagement"] = dirname(__FILE__) . '/SpecialUserengagement.i18n.php';

//enabled hooks array, no reason to put it outside the code, to enable/disable just addre move line and corresponding function
//hooks are processd in order of inclusion

global $ue_events;
$ue_events = array();

$wgAjaxExportList[] = 'UserengagementAjax';
function UserengagementAjax( ) {
//this function serves a message via async request

	global $wgRequest, $wgUser, $wgLanguageCode,$wgSitename;
	$mVisit = $_REQUEST['m'];
	$mResponse = array( 'response' => '' );

	//only english wikis && article
	if( ( $wgLanguageCode == 'en' ) ) {

		if( ( $mVisit == 1 ) || ( $mVisit == 2 ) || ( $mVisit == 3 ) || ( $mVisit == 6 ) || ( $mVisit == 8 ) ) {

			if( trim( wfMsg( 'Ue-VisitN' . $_SERVER['SERVER_NAME'] . $mVisit ) ) != '&lt;' . 'Ue-VisitN' . $_SERVER['SERVER_NAME'] . $mVisit . '&gt;' ){	

				$mResponse = array( 'response' => str_replace( '%SITENAME%', $wgSitename, wfMsg( 'Ue-VisitN' . $_SERVER['SERVER_NAME'] . $mVisit ) ), 'msg_id' => 'Ue-VisitN' . $_SERVER['SERVER_NAME'] . $mVisit );

			}else{

				$mResponse = array( 'response' => str_replace( '%SITENAME%', $wgSitename, wfMsg( 'Ue-VisitN' . $mVisit ) ), 'msg_id' => 'Ue-VisitN' . $mVisit );			

			}
		
		}
	}

	return new AjaxResponse( Wikia::json_encode( $mResponse ) );

}

function ue_view( $param ){
	global $wgUser, $wgContentNamespaces, $wgTitle, $wgOut, $wgExtensionsPath, $wgStyleVersion;
	
	$articleNamespace = $wgTitle->getNamespace();
	
  	$isContent = $wgTitle->getNamespace() == NS_MAIN || in_array( $articleNamespace, $wgContentNamespaces );
	
  	$isLogged = $wgUser->isLoggedIn();

  	if( ( !$isContent ) || ( $isLogged ) ){
  		return true;
  	}

    $wgOut->addScript('<link rel="stylesheet" type="text/css" href="'.$wgExtensionsPath.'/wikia/Userengagement/Userengagement.css?'.$wgStyleVersion.'" />');
	
	$skin = &$wgUser->getSkin();
	
	$skin->newuemsg = '<div id="ue_msg" class="usermessage userengagement" style="display: none"></div>';

  return true;
}


if( !empty( $wgEnableUserengagement ) ){
  $wgHooks['BeforePageDisplay'][] = array( 'ue_view', array()) ;
}  