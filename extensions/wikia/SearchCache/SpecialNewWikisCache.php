<?php
    /* 
     * Homepage cache managing special page
     * @author Gerard Adamczewski <gerard@wikia.com>
     */
     
     if ( ! defined( 'MEDIAWIKI' ) ) {
	die();
     }
     
     require_once 'CacheFunctions.php';
     
     $wgSpecialPages['NewWikisCacheEditor'] = array('SpecialPage','NewWikisCacheEditor','cacheedit');
     $wgAvailableRights[] = 'cacheedit';
     $wgGroupPermissions['staff']['cacheedit'] = true;
     
     function nwceManageData()
     {
        global $wgMemc, $wgRequest;
	$data = explode( "\n", $wgRequest->getText( 'data' ) );
	$wgMemc->set( 'wikia:newwikiscachedata', $data, 60*24*60 );
	$db = wfGetDB( DB_MASTER );
	$db->replace( '`wikicities`.`homepage_caches`', array(), array(
	    'memckey' => 'wikia:newwikiscachedata',
	    'value' => serialize( $data ) )
	);
	return 'Current data has been saved.';
     }
     
     function nwceDrawForm( $info )
     {
        global $wgOut, $wgTitle, $wgMemc, $wgSharedDB;
	
	$formAction = $wgTitle->escapeLocalURL();
	$d = array();
	$dbstats = 'dbstats';
	$db = &wfGetDB( DB_SLAVE );
	$res = $db->query( "select city_title, city_url from $wgSharedDB.city_list where 1=1" . limit2langs()  . " order by city_id desc limit 50" );
	while( $o = $db->fetchObject( $res ) )
	{
	    $d[] = $o->city_url . ' ' . $o->city_title;
	}
	$db->freeResult( $res );
	$c = getData( 'wikia:newwikiscachedata' );
	$data = implode( "\n", $d );
	$curr = ( is_array( $c ) ) ? implode( "\n", $c ) : '';
	$text = "<form action='$formAction' method='POST' onSubmit='return confirm(\"Are you sure you want to update configuration?\");'>
		    <div>$info</div>
		    <div>From database:</div>
		    <div><textarea rows='10' readonly>$data</textarea></div>
		    <div>Current:</div>
		    <div><textarea name='data' rows='10'>$curr</textarea></div>
		    <div><input type='submit' name='submit' value='Save' /></div>
		</form>";
	$wgOut->addHtml( $text );
     }
     
     function wfSpecialNewWikisCacheEditor()
     {
        global $wgOut, $wgRequest;
	
        $ceType = 'NewWikis';
        $wgOut->setPageTitle("Manage $ceType Cache data");
	$wgOut->setHtmlTitle("Manage $ceType Cache data");
	$ceInfo = '';
	if( $wgRequest->getVal( 'submit' ) == 'Save' )
	{
	    $ceInfo = nwceManageData();
	}
	nwceDrawForm( $ceInfo );
     }
?>
