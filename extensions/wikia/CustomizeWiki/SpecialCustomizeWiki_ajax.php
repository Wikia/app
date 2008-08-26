<?php

/**
 * @package MediaWiki
 * @subpackage CustomizeWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 */
global $wgAutoloadClasses;
$wgAutoloadClasses["AjaxUploadForm"] = dirname(__FILE__)."/AjaxUploadForm.php";


global $wgAjaxExportList;
$wgAjaxExportList[] = "axUploadLogo";

function axUploadLogo()
{
    wfProfileIn( __METHOD__ );
    global $wgRequest;

    $iSize = $wgRequest->getFileSize("wpUploadFile");
    $sDstName = $wgRequest->getVal("wpDestFile", null);
    
    error_log( __METHOD__ );
    if ( empty($iSize) || is_null($sDstName) ) {
        return Wikia::json_encode( array( "error" => 0, "msg" => "&nbsp;" ));
    }
    
    #--- process upload here
    $oUploadForm = new AjaxUploadForm( $wgRequest );
    $aResponse = $oUploadForm->execute();
    error_log( print_r( $aResponse, 1) );

    if ( empty( $aResponse["error"] ) ) {
        #-- should be success, return link to image
        $oLogo = $oImage = Image::newFromName( $sDstName );
        $aResponse["img"] = sprintf("%s?%d",$oLogo->getURL(), wfRandom()*100000);
    }

    wfProfileOut( __METHOD__ );
    return Wikia::json_encode( $aResponse );
}
