<?php
    /* 
     * Homepage cache managing special page
     * @author Gerard Adamczewski <gerard@wikia.com>
     */
     
     if ( ! defined( 'MEDIAWIKI' ) ) {
	die();
     }
     
     require_once 'CacheFunctions.php';

     $wgSpecialPages['DiscussingCacheEditor'] = array('SpecialPage','DiscussingCacheEditor', 'cacheedit');
     $wgAvailableRights[] = 'cacheedit';
     $wgGroupPermissions['staff']['cacheedit'] = true;
     
     function dceManageData()
     {
        global $wgMemc, $wgRequest;
	$data = explode( "\n", $wgRequest->getText( 'data' ) );
	$wgMemc->set( 'wikia:discusscachedata' , $data, 60*24*60 );
	$db = wfGetDB( DB_MASTER );
	$db->replace( '`wikicities`.`homepage_caches`', array(), array(
	    'memckey' => 'wikia:discusscachedata',
	    'value' => serialize( $data ) )
	);
	return 'Current data has been saved.';
     }
     
     function dceDrawForm( $info )
     {
        global $wgOut, $wgTitle, $wgMemc, $wgSharedDB, $wgDBuser, $wgDBpassword;

	$cnt = 100;	
	$formAction = $wgTitle->escapeLocalURL();
	$dbstats = 'dbstats';
	$db = wfGetDBExt(DB_SLAVE);
	$d = array();
	$res = $db->query( "select rc_timestamp, rc_title, rc_namespace, rc_type, rc_city_id from $dbstats.city_recentchanges_3_days where mod( rc_namespace, 2 ) = 1  and rc_namespace!=" . NS_USER_TALK  . limit2langs('rc_city_id')  . " group by rc_title order by rc_timestamp desc limit $cnt" );
	$db = wfGetDB( DB_SLAVE );
	while( $o = $db->fetchObject( $res ) )
	{
		$r = $db->query( 'select city_url from `wikicities`.`city_list` where city_id='.$o->rc_city_id );
		$u = $db->fetchObject( $r );
		$title = Title::makeTitleSafe( $o->rc_namespace, $o->rc_title );
		$url = substr( $u->city_url, 0, -1 ) . $title->getLocalURL();
        	$d[] = $url . ' ' . str_replace( '_', ' ', $o->rc_title );
		$db->freeResult( $r );
	}
	$db->freeResult( $res );
	$c = getData( 'wikia:discusscachedata' );
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
     
     function wfSpecialDiscussingCacheEditor()
     {
        global $wgOut, $wgRequest;
	
        $ceType = 'Discussing';
        $wgOut->setPageTitle("Manage $ceType Cache data");
	$wgOut->setHtmlTitle("Manage $ceType Cache data");
	$ceInfo = '';
	if( $wgRequest->getVal( 'submit' ) == 'Save' )
	{
	    $ceInfo = dceManageData();
	}
	dceDrawForm( $ceInfo );
     }
?>
