<?php
    /* 
     * Homepage cache managing special page
     * @author Gerard Adamczewski <gerard@wikia.com>
     */
     
     if ( ! defined( 'MEDIAWIKI' ) ) {
	die();
     }
     
     require_once 'CacheFunctions.php';     
     
     $wgSpecialPages['SearchCacheEditor'] = array('SpecialPage','SearchCacheEditor','cacheedit');
     $wgAvailableRights[] = 'cacheedit';
     $wgGroupPermissions['staff']['cacheedit'] = true;
     
     function ceManageData()
     {
        global $wgMemc, $wgRequest;
	$data = explode( "\n", $wgRequest->getText( 'data' ) );
	$wgMemc->set( 'wikia:searchcachedata', $data, 60*60*24 );
	$db = wfGetDB( DB_MASTER );
	$db->replace( '`wikicities`.`homepage_caches`', array(), array(
	    'memckey' => 'wikia:searchcachedata',
	    'value' => serialize( $data ) )
	);
	return 'Current data has been saved.';
     }
     
     function ceDrawForm( $info )
     {
        global $wgOut, $wgTitle, $wgMemc;
	
	$formAction = $wgTitle->escapeLocalURL();
	$d = getData( 'wikia:searchcache' );
	$c = getData( 'wikia:searchcachedata' );
	$data = ( is_array( $d ) ) ? implode( "\n", $d ) : '';
	$curr = ( is_array( $c ) ) ? implode( "\n", $c ) : '';
	$text = "<form action='$formAction' method='POST' onSubmit='return confirm(\"Are you sure you want to update configuration?\");'>
		    <div>$info</div>
		    <div>Typed:</div>
		    <div><textarea rows='10' readonly>$data</textarea></div>
		    <div>Current:</div>
		    <div><textarea name='data' rows='10'>$curr</textarea></div>
		    <div><input type='submit' name='submit' value='Save' /></div>
		</form>";
	$wgOut->addHtml( $text );
     }
     
     function wfSpecialSearchCacheEditor()
     {
        global $wgOut, $wgRequest;
	
        $ceType = 'Search';
        $wgOut->setPageTitle("Manage $ceType Cache data");
	$wgOut->setHtmlTitle("Manage $ceType Cache data");
	$ceInfo = '';
	if( $wgRequest->getVal( 'submit' ) == 'Save' )
	{
	    $ceInfo = ceManageData();
	}
	ceDrawForm( $ceInfo );
     }
?>
