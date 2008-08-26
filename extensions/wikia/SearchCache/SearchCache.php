<?php
    /* 
     * Search cache managing extension
     * @author Gerard Adamczewski <gerard@wikia.com>
     */
     
     if ( ! defined( 'MEDIAWIKI' ) ) {
	die();
     }
     
     $wgHooks[ 'SearchCache' ][] = 'wfSearchCache';
     
     function wfSearchCache( $search )
     {
        global $wgMemc;
	
	$data = $wgMemc->get( 'wikia:searchcache' );
	if( ! is_array( $data ) )
	{
	    $data = array();
	}
	if( !empty($search) && !in_array( $search, $data ) )
	{
	    $data[] = $search;
	    $data = array_slice( array_reverse( $data ), 0, 500 );
	    $wgMemc->set( 'wikia:searchcache', $data, 60*60*24 );
	}
	return true;
     }
?>