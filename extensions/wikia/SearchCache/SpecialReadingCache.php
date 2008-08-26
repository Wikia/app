<?php
    /* 
     * Homepage cache managing special page
     * @author Gerard Adamczewski <gerard@wikia.com>
     */
     
     if ( ! defined( 'MEDIAWIKI' ) ) {
	die();
     }
     
     require_once 'CacheFunctions.php';

     $wgSpecialPages['ReadingCacheEditor'] = array('SpecialPage','ReadingCacheEditor','cacheedit');
     $wgAvailableRights[] = 'cacheedit';
     $wgGroupPermissions['staff']['cacheedit'] = true;
     
     function rceManageData()
     {
        global $wgMemc, $wgRequest;
	$data = explode( "\n", $wgRequest->getText( 'data' ) );
	$wgMemc->set( 'wikia:readingcachedata', $data, 60*24*60 );
	$db = wfGetDB( DB_MASTER );
	$db->replace( '`wikicities`.`homepage_caches`', array(), array(
	    'memckey' => 'wikia:readingcachedata',
	    'value' => serialize( $data ) )
	);
	return 'Current data has been saved.';
     }
     
     function rceDrawForm( $info )
     {
        global $wgOut, $wgTitle, $wgMemc, $wgDBuser, $wgDBpassword, $wgSharedDB, $wgLangLimit;

	$cnt = 100;
	$formAction = $wgTitle->escapeLocalURL();
	$d = array();
	$db =&wfGetDB( DB_MASTER );
	$dbstats = 'dbstats';
	$db = Database::newFromParams( 'sayid.sjc.wikia-inc.com', $wgDBuser, $wgDBpassword, $dbstats );
	$res = $db->query( "select article_id, timestamp, request_uri from $dbstats.webstats where 1=1 " . limit2langs() . "group by article_id order by timestamp desc limit $cnt" );;
	while( $o = $db->fetchObject( $res ) )
	{
    	    $title = $o->request_uri;
	    $title = substr( $title, 7 );
	    if( ( $p = strstr( $title, '/wiki/' ) ) === false )
	    {
		$title = str_replace( '_', ' ', strstr( $title, '/' ) );
	    }
	    else {
		$title = str_replace( '_', ' ', substr( $p, 6) );
	    }
	    $d[] = $o->request_uri . ' ' . $title;
	}
	$db->freeResult( $res );
	$c = getData( 'wikia:readingcachedata' );
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
     
     function wfSpecialReadingCacheEditor()
     {
        global $wgOut, $wgRequest;
	
        $ceType = 'Reading';
        $wgOut->setPageTitle("Manage $ceType Cache data");
	$wgOut->setHtmlTitle("Manage $ceType Cache data");
	$ceInfo = '';
	if( $wgRequest->getVal( 'submit' ) == 'Save' )
	{
	    $ceInfo = rceManageData();
	}
	rceDrawForm( $ceInfo );
     }
?>
