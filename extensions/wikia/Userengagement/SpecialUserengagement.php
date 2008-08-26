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

#---important this hook needs to be executing last!!!
$ue_events[] = array('handle'=>'ue_view',	'params'=>array('status'=>'on',),	'on_hook'=>'BeforePageDisplay',	'description'=>"system hook do not remove!");
#---important

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


function ue_ChkHandleValue( $id, $str ){
//checks 1/0 in string on pos $id

	if( $str == '' ){
		return 0;
	}else{
 		$arr = str_split( $str );
 		if( $id < count( $arr ) ) {
 			return $arr[$id];
 		}else{
 			return 0;
 		}
	}
}

function ue_AddToHandle( $id = '', $str = '', $val = '0' ){
// adds 1/0 at position $id of a string we only use latest and greatest to key
	global $ue_events;

	$arr = str_split( $str );
	$r = array();

 	foreach( $ue_events as $key => $value ) {
    	if( !empty( $arr[$key] ) ) {
    		$r[$key] = $arr[$key];
      	}else{
       		$r[$key] = '0';

      	}

      	if( $key == $id ) {
      		$r[$key] = $val;
      	}
    }

  return implode( $r );
}

//add defined event to the hook
foreach( $ue_events as $key => $value ) {
	if( $value['params']['status'] == 'on' ) {
    $wgHooks[$value['on_hook']][] = array( $value['handle'], array_merge( array( 'id' => $key ), $value['params'] ) );
 	}
}

function ue_view( $param ){
//this executed just prior to view of a page
global $ue_events, $wgUser, $wgEnableUserengagementExt, $wgCookiePath, $wgCookieDomain, $wgCookieSecure, $wgContentNamespaces, $wgTitle;

	$articleNamespace = $wgTitle->getNamespace();
  	$isContent = $wgTitle->getNamespace() == NS_MAIN || in_array( $articleNamespace, $wgContentNamespaces );
  	$isLogged = $wgUser->isLoggedIn();

  	if( ( !$isContent ) || ( $isLogged ) ){
  		return true;
  	}

    if ( !empty( $wgEnableUserengagementExt ) && $param['status'] == 'on' )
	{
		// include external CSS (#2784)
        global $wgOut, $wgExtensionsPath, $wgStyleVersion;
        $wgOut->addScript('<link rel="stylesheet" type="text/css" href="'.$wgExtensionsPath.'/wikia/Userengagement/Userengagement.css?'.$wgStyleVersion.'" />');
		$skin = &$wgUser->getSkin();
		$skin->newuemsg = '<div id="ue_msg" class="usermessage userengagement" style="display: none"></div>';

		if( !empty( $_SESSION[md5($_SERVER['REMOTE_ADDR']) . '_ue_id'])) {
			$msg = unserialize($_SESSION[md5($_SERVER['REMOTE_ADDR']) . '_ue_id']);
		} else {
			$msg = null;
		}

	if( is_array( $msg ) && !empty( $msg['id'] ) ) {
	//if message stored in session,
	//good to use this method if user is logged in and not cached
	//displayed directly via html inclusion, no rownd trip
		if( $msg['shown'] >= $ue_events[$msg['id']]['params']['pagestostay'] ) {
			$_SESSION[md5( $_SERVER['REMOTE_ADDR']) . '_ue_id'] = '';
			return true;
		}

		$txt = wfMsg( str_replace( 'ue_', 'Ue-', $ue_events[$msg['id']]['handle'] ) );
		$skin->newuemsg = '<div id="ue_msg" class="usermessage userengagement">' . $txt . '</div>';
		$skin->newuemsgjs = "";
		$val = $_COOKIE['wgWikiaUserEngagement'];

    	if( $_REQUEST['action'] == "purge" ) {
    		setcookie( 'wgWikiaUserEngagement', '0', time() + ( 30 * 24 * 60 * 60 ), $wgCookiePath, $wgCookieDomain, $wgCookieSecure );
    	  	$_SESSION[md5( $_SERVER['REMOTE_ADDR'] ) . '_ue_id'] = '';
    	}else{
    		setcookie( 'wgWikiaUserEngagement', $val, time() + ( 30 * 24 * 60 * 60 ), $wgCookiePath, $wgCookieDomain, $wgCookieSecure );
    	  	$msg['shown'] = $msg['shown'] + 1;
		  	$_SESSION[md5( $_SERVER['REMOTE_ADDR'] ) . '_ue_id'] = serialize( $msg );
		}
	 }else{
	//if cookies used to store user event data and ajax to display it.
		$val = 0;
		if( isset( $_COOKIE['wgWikiaUserEngagement'] ) ) {
	 	 $visit = ue_ChkHandleValue( 0, $_COOKIE['wgWikiaUserEngagement'] );
		  if( $visit < 9 ){
		 	 $val = ue_AddToHandle( 0, $_COOKIE['wgWikiaUserEngagement'], $visit + 1 );
		   }else{
		     $val = $_COOKIE['wgWikiaUserEngagement'];
		  }
		}


    	  //set cookie back to a browser
    	 if( isset($_REQUEST['action'] ) && ( $_REQUEST['action'] == "purge" ) ) {
    	  setcookie( 'wgWikiaUserEngagement', '0', time() + ( 30 * 24 * 60 * 60 ), $wgCookiePath, $wgCookieDomain, $wgCookieSecure );
    	 }else{
    	  setcookie( 'wgWikiaUserEngagement', $val, time() + ( 30 * 24 * 60 * 60 ), $wgCookiePath, $wgCookieDomain, $wgCookieSecure );
    	 }
	 	$_SESSION[md5( $_SERVER['REMOTE_ADDR'] ) . '_ue_id'] = '';
		return true;
	 }
	}

  return true;
}
