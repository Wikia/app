<?php
    function getData( $memckey )
    {
	global $wgMemc;
	$data = $wgMemc->get( $memckey );
	if( !is_array( $data ) )
	{
	    $db = &wfGetDB( DB_SLAVE );
	    $res = $db->query( "SELECT * FROM `wikicities`.`homepage_caches` WHERE memckey=\"$memckey\"" );
	    if( $obj = $db->fetchObject( $res ) )
	    {
		$data = unserialize( $obj->value );
	    }
	    else {
		$data = array();
	    }
	    $db->freeResult( $res );
	    $wgMemc->set( $memckey, $data, 60*60*24 );
	}
	return $data;
    }
    
    function langCities()
    {
	global $wgLangLimit;
	
	$retVal = array();
	$db = wfGetDB( DB_MASTER );
	$res = $db->query( 'select cv_id from `wikicities`.`city_variables_pool` where cv_name="wgLanguageCode"' );
	$cv_id = $db->fetchObject( $res );
	$cv_id = $cv_id->cv_id;
	$sql = "select cv_city_id from `wikicities`.`city_variables` where cv_variable_id=$cv_id ";
	if( is_array( $wgLangLimit ) )
	{
	    $langs = array();
	    foreach( $wgLangLimit as $l )
	    {
		$langs[] = '"' . mysql_real_escape_string( serialize( $l ) ) . '"';
	    }
	    $langs = implode( ',', $langs );
	    $sql .= "and cv_value in ($langs)";
	    $res = $db->query( $sql );
	    while( $o = $db->fetchObject( $res ) )
	    {
		$retVal[] = $o->cv_city_id;
	    }
	}
	elseif( !empty( $wgLangLimit) ) {
	    $sql .= 'and cv_value="' . mysql_real_escape_string( serialize( $wgLangLimit) ) . '"';
	    $res = $db->query( $sql );
	    while( $o = $db->fetchObject( $res ) )
	    {
		$retVal[] = $o->cv_city_id;
	    }
	}
	return $retVal;
    }
    
    function limit2langs( $fieldName = 'city_id' )
    {
	global $wgLangLimit;
	if( !empty( $wgLangLimit ) )
	{
	    $limit2lang = ' and ' . $fieldName . ' in (' . implode( ',', langCities() ) . ')';
	}
	else {
	    $limit2lang='';
	}
	return $limit2lang;
    }
?>