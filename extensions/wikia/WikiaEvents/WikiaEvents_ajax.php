<?php

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

/* AJAX functions */

function wfwkCheckUserOptions()
{
	global $wgUser;
	wfProfileIn( __METHOD__ );
	
	if ( $wgUser->isBlocked() ) {
		return false;
	}
	if ( !$wgUser->isAllowed( 'systemevents' ) ) {
		return false;
	}

	if (!in_array('systemevents', $wgUser->getRights() )) {
		return false;
	}
	
	wfProfileOut( __METHOD__ );
	return true;
}

function wfwkGetEventTypes($et_id)
{
	wfProfileIn( __METHOD__ );
	
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	#---
	if (!$et_id) {
		return false;
	}
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::getEventTypes';
	#---
	$sql = "SELECT et_id, et_name, et_desc, et_active FROM ".SYSTEM_EVENTS_TYPES." where et_id = {$et_id}";
	#---
	$res = $dbr->query($sql);

	$row = $dbr->fetchObject($res);
	$dbr->freeResult($res);

	$aResponse = array('id' => $row->et_id, 'name' => $row->et_name, 'desc' => $row->et_desc, 'active' => $row->et_active);
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }

	wfProfileOut( __METHOD__ );
	return $row;
}

function wfwkSetEventTypes($et_name, $et_id, $et_desc)
{
	wfProfileIn( __METHOD__ );
	
	#---
	if (empty($et_name) || empty($et_id)) {
		return false;		
	}
	
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::setEventTypes';
	#---
	$updateSet = "et_name=".$dbr->addQuotes($et_name).", et_desc=".$dbr->addQuotes($et_desc);
	$sql = "UPDATE ".SYSTEM_EVENTS_TYPES." set {$updateSet} where et_id = {$et_id}";
	#---
	$res = $dbr->query($sql);

	if ($res) 
	{
		$aResponse = array('id' => $et_id, 'name' => $et_name, 'desc' => $et_desc);
		if (!function_exists('json_encode'))  {
			$oJson = new Services_JSON();
			return $oJson->encode($aResponse);
		}
		else {
			return json_encode($aResponse);
		}
	}
	
	wfProfileOut( __METHOD__ );
	return false;	
}

function wfwkGetEvents($ev_id)
{
	wfProfileIn( __METHOD__ );
	
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::getEvent';
	#---
	$sql = "SELECT ev_id, ev_name, ev_desc, ev_active, ev_hook, ev_hook_values FROM ".SYSTEM_EVENTS." where ev_id = {$ev_id}";
	#---
	$res = $dbr->query($sql);

	$row = $dbr->fetchObject($res);
	$dbr->freeResult($res);

	$hook_list = array();
	$aResponse = array(	'id' => $row->ev_id, 
						'name' => $row->ev_name, 
						'desc' => $row->ev_desc, 
						'active' => $row->ev_active, 
						'hook' => $row->ev_hook, 
						'hook_values' => $row->ev_hook_values
					);
    if (!function_exists('json_encode'))  
    {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else 
    {
        return json_encode($aResponse);
    }

	wfProfileOut( __METHOD__ );
	return $row;
}

function wfwkSetEvents($ev_name, $ev_id, $ev_desc, $ev_hook)
{
	wfProfileIn( __METHOD__ );
	
	if (empty($ev_name) || empty($ev_id) || empty($ev_hook)) {
		return false;		
	}
	
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::setEvent';
	#---
	
	// serialize params
	
	#---
	$updateSet = "ev_name=".$dbr->addQuotes($ev_name).", ev_desc=".$dbr->addQuotes($ev_desc).", ev_hook=".$dbr->addQuotes($ev_hook);
	$sql = "UPDATE ".SYSTEM_EVENTS." set {$updateSet} where ev_id = {$ev_id}";
	#---
	$res = $dbr->query($sql);

	if ($res) 
	{
		$aResponse = array('id' => $ev_id, 'name' => $ev_name, 'desc' => $ev_desc, 'hook' => $ev_hook);
		if (!function_exists('json_encode'))  {
			$oJson = new Services_JSON();
			return $oJson->encode($aResponse);
		}
		else {
			return json_encode($aResponse);
		}
	}
	
	wfProfileOut( __METHOD__ );
	return false;	
}

function wfwkSetActiveEvent($ev_id)
{
	global $wgMemc;
	#---
	wfProfileIn( __METHOD__ );
	
	if (empty($ev_id)) {
		return false;		
	}
	
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::setActiveEvent';

	$sql = "SELECT ev_active FROM ".SYSTEM_EVENTS." where ev_id = {$ev_id}";
	#---
	$res = $dbr->query($sql);
	$row = $dbr->fetchObject($res);
	$dbr->freeResult ($res);
	#---
	$active = (empty($row->ev_active))?1:0;
	$updateSet = "ev_active=".$dbr->addQuotes($active);
	$sql = "UPDATE ".SYSTEM_EVENTS." set {$updateSet} where ev_id = {$ev_id}";
	#---
	$res = $dbr->query($sql);

	if ($res) 
	{
		$wgMemc->delete(MEMC_SITE_WIDE_EVENTS_KEY);
		$wgMemc->delete(MEMC_SETUP_KEY);
		$aResponse = array('id' => $ev_id, 'active' => $active);
		if (!function_exists('json_encode'))  {
			$oJson = new Services_JSON();
			return $oJson->encode($aResponse);
		}
		else {
			return json_encode($aResponse);
		}
	}
	
	wfProfileOut( __METHOD__ );
	return false;	
}

function wfwkSetActiveEventType($et_id)
{
	wfProfileIn( __METHOD__ );
	
	if (empty($et_id)) {
		return false;		
	}
	
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::setActiveEventType';

	$sql = "SELECT et_active FROM ".SYSTEM_EVENTS_TYPES." where et_id = {$et_id}";
	#---
	$res = $dbr->query($sql);
	$row = $dbr->fetchObject($res);
	$dbr->freeResult ($res);
	#---
	$active = (empty($row->et_active))?1:0;
	$updateSet = "et_active=".$dbr->addQuotes($active);
	$sql = "UPDATE ".SYSTEM_EVENTS_TYPES." set {$updateSet} where et_id = {$et_id}";
	#---
	$res = $dbr->query($sql);

	if ($res) 
	{
		$aResponse = array('id' => $et_id, 'active' => $active);
		if (!function_exists('json_encode'))  {
			$oJson = new Services_JSON();
			return $oJson->encode($aResponse);
		}
		else {
			return json_encode($aResponse);
		}
	}
	
	wfProfileOut( __METHOD__ );
	return false;	
}

function wfwkGetEventTmpl ($ev_id)
{
	wfProfileIn( __METHOD__ );

	if (empty($ev_id)) {
		return false;		
	}
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::getEventTmpl';

	$sql = "SELECT et_id, et_name, et_desc, et_active, te_id, te_ev_id, te_title, te_content FROM ".SYSTEM_EVENTS_TYPES." ";
	$sql .= "left join ".SYSTEM_EVENTS_TEXT." on te_et_id = et_id and te_ev_id = {$ev_id}";
	#---
	$res = $dbr->query($sql);
	#---
	while ( $row = $dbr->fetchObject( $res ) ) 
	{
		$aResponse[] = array(
							'type_id' 		=> $row->et_id, 
							'type_name'		=> $row->et_name, 
							'type_desc'		=> $row->et_desc, 
							'type_active' 	=> $row->et_active,
							'text_id'		=> $row->te_id,
							'event_id'		=> $ev_id,
							'title'			=> $row->te_title,
							'content'		=> $row->te_content,
						);
	}
	$dbr->freeResult ($res);

	if (!empty($aResponse)) 
	{
		if (!function_exists('json_encode'))  {
			$oJson = new Services_JSON();
			return $oJson->encode($aResponse);
		}
		else {
			return json_encode($aResponse);
		}
	}
	
	wfProfileOut( __METHOD__ );
	return "";
}

function wfwkSetTextEvent($div, $ev_id, $type_id, $textValue) 
{
	global $wgMessageCache;
	
	wfProfileIn( __METHOD__ );
	
	if (empty($ev_id) || empty($type_id)) {
		return false;		
	}
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::setEventText';
	#---
	$sql = "SELECT te_id from ".SYSTEM_EVENTS_TEXT." where te_ev_id = {$ev_id} and te_et_id = {$type_id}";

	$res = $dbr->query($sql);
	#---
	$rowSelect = $dbr->fetchObject( $res ); 
	$dbr->freeResult ($res);
	
	if ( !empty($rowSelect) ) // update
	{
		if ($div == 'title') 
		{
			$updateSet = "te_title=".$dbr->addQuotes($textValue);
		}
		if ($div == 'content') 
		{
			$updateSet = "te_content=".$dbr->addQuotes($textValue);
		}
		if (!empty($updateSet)) 
		{
			$sql = "UPDATE ".SYSTEM_EVENTS_TEXT." set {$updateSet} where te_id = '".$rowSelect->te_id."'";
			#---
			$res = $dbr->query($sql);
			#---
			if ($res) 
			{
				//$wgMessageCache->addMessages( array($textValue => ''), "en");
				$aResponse = array('event_id' => $ev_id, 'type_id' => $type_id, 'value' => $textValue);
				if (!function_exists('json_encode')) {
					$oJson = new Services_JSON();
					return $oJson->encode($aResponse);
				}
				else {
					return json_encode($aResponse);
				}
			}
		}
	}
	else //insert
	{
    	#---
		$dbr =& wfGetDB( DB_MASTER );
		#---
		$title = ($div == 'title') ? $textValue : "";
		$content = ($div == 'content') ? $textValue : "";
		#---
		$sql = "INSERT INTO ".SYSTEM_EVENTS_TEXT." (te_id, te_ev_id, te_user_id, te_et_id, te_title, te_content, te_timestamp) values ";
		$sql .= "(null, ".$dbr->addQuotes($ev_id).", ".$dbr->addQuotes($GLOBALS['wgUser']->getID()).", ".$dbr->addQuotes($type_id).", ".$dbr->addQuotes($title).", ".$dbr->addQuotes($content).",".$dbr->addQuotes(wfTimestampNow()).")";
		#---
		$res = $dbr->query($sql);
		if ($res)
		{
			//if ($content) $wgMessageCache->addMessages( array($content => ''), "en");
			//if ($title) $wgMessageCache->addMessages( array($title => ''), "en");
			$aResponse = array('event_id' => $ev_id, 'type_id' => $type_id, 'value' => $textValue);
			if (!function_exists('json_encode')) {
				$oJson = new Services_JSON();
				return $oJson->encode($aResponse);
			}
			else {
				return json_encode($aResponse);
			}
		}
	}

	wfProfileOut( __METHOD__ );
	return null;
}

function wfwkAddEventInfo($ev_id, $ev_type, $ev_field_id) 
{
	global $wgSharedDB, $wgUser, $wgCityId;
	wfProfileIn( __METHOD__ );

    function getIdFromDomain( $domain ) 
    {
    	global $wgSharedDB;
    	$dbr =& wfGetDB( DB_MASTER );
    	$dbr->selectDB($wgSharedDB);
    	
    	$sth = $dbr->select( "city_domains","city_id, city_domain",array("city_domain" => $domain), array("limit" => 1) );
    	$row = $dbr->fetchObject( $sth );
    	$dbr->freeResult( $sth );
    	return $row->city_id;
    }
    
    function getDomainFromCache( $domain ) 
    {
        return WikiFactory::DomainToID( $domain );
	}

	if ( empty($ev_id) || empty($ev_type) || empty($ev_field_id) ) {
		return 0;		
	}

	if ( is_numeric($wgCityId) ) {
		$city_id = $wgCityId;
	}
	else {
		$city_id = getDomainFromCache($domain);
		if ( (empty($city_id)) || (is_numeric($city_id)) ) 
		{
			$city_id = getIdFromDomain( $domain );
			if (empty($city_id))
			{
				$city_id = 0;
			}
		}
	}

	$user_id = $wgUser->getID();
	$user_id = (!empty($user_id))?$user_id:0;
	$ip = wfGetIP();
	#---
	$dbr =& wfGetDB( DB_MASTER );
	#---
	$sql = "INSERT INTO ".SYSTEM_EVENTS_DATA." (ed_id, ed_ev_id, ed_et_id, ed_user_id, ed_user_ip, ed_field_id, ed_timestamp, ed_city_id) values ";
	$sql .= "(null, ".$dbr->addQuotes($ev_id).", ".$dbr->addQuotes($ev_type).", ".$dbr->addQuotes($user_id).", ".$dbr->addQuotes($ip).", ".$dbr->addQuotes($ev_field_id).", ".$dbr->addQuotes(wfTimestampNow()).", ".$dbr->addQuotes($city_id).")";
	#---
	$res = $dbr->query($sql);
	$id = ($res) ? $dbr->insertId() : false;
	
	$whereUser = "";
	if (empty($user_id))
	{
		$whereUser = " and eu_user_ip = ".$dbr->addQuotes($ip);
	}
	else
	{
		$whereUser = " and eu_user_id = ".$dbr->addQuotes($user_id);
	}
	
	$sql = "UPDATE ".SYSTEM_EVENTS_USERS." SET eu_visible_count = eu_visible_count + 1, eu_timestamp = ".$dbr->addQuotes(wfTimestampNow()).", eu_active = 0 ";
	$sql .= " WHERE eu_ev_id = ".$dbr->addQuotes($ev_id)." and ";
	$sql .= " eu_et_id = ".$dbr->addQuotes($ev_type)." {$whereUser} ";
	if (!empty($CityId)) 
	{
		$sql .= " and eu_city_id = ".$dbr->addQuotes($CityId);
	}

	#---
	$res = $dbr->query($sql);
	$dbr->commit();

	wfProfileOut( __METHOD__ );
	$aResponse = array('insert_id' => $id);
	if (!function_exists('json_encode')) {
		$oJson = new Services_JSON();
		return $oJson->encode($aResponse);
	}
	else {
		return json_encode($aResponse);
	}
}

function wfwkSetEventParamSetup($ep_id, $ep_value = "", $ep_desc_value = "") 
{
	global $wgMemc;
	#---
	wfProfileIn( __METHOD__ );

	if (empty($ep_id)) {
		return false;		
	}
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::setEventParamSetup';
	#---
	$updateSet = array();
	if ( $ep_value !== "" )
	{
		$updateSet[] = "ep_value=".$dbr->addQuotes(htmlspecialchars($ep_value));
	}
	if ( $ep_desc_value !== "" )
	{
		$updateSet[] = "ep_desc=".$dbr->addQuotes(htmlspecialchars($ep_desc_value));
	}
	#--
	if (!empty($updateSet)) 
	{
		$toUpdate = implode(",", $updateSet);
		$sql = "UPDATE ".SYSTEM_EVENTS_PARAMS." set {$toUpdate} where ep_id = ".$dbr->addQuotes($ep_id);
		#---
		$res = $dbr->query($sql);
		#---
		if ($res) 
		{
			#---
			$wgMemc->delete(MEMC_SETUP_KEY);
			#---
			$aResponse = array('ep_id' => $ep_id, 'value' => htmlspecialchars($ep_value), 'desc_value' => htmlspecialchars($ep_desc_value));
			if (!function_exists('json_encode')) {
				$oJson = new Services_JSON();
				return $oJson->encode($aResponse);
			}
			else {
				return json_encode($aResponse);
			}
		}
	}

	wfProfileOut( __METHOD__ );
	return null;
}

function wfwkSetActiveEventParam($ep_id)
{
	global $wgMemc;
	#---
	wfProfileIn( __METHOD__ );
	
	if (empty($ep_id)) {
		return false;		
	}
	
	#---
	if (!wfwkCheckUserOptions()) {
		return false;
	}
	#---
	$dbr =& wfGetDB( DB_MASTER );
	$fname = 'Special:WikiEvents::setActiveEventParam';

	$sql = "SELECT ep_active FROM ".SYSTEM_EVENTS_PARAMS." where ep_id = {$ep_id}";
	#---
	$res = $dbr->query($sql);
	$row = $dbr->fetchObject($res);
	$dbr->freeResult ($res);
	#---
	$active = (empty($row->ep_active)) ? 1 : 0;
	$updateSet = "ep_active=".$dbr->addQuotes($active);
	$sql = "UPDATE ".SYSTEM_EVENTS_PARAMS." set {$updateSet} where ep_id = {$ep_id}";
	#---
	$res = $dbr->query($sql);

	if ($res) 
	{
		#---
		$wgMemc->delete(MEMC_SITE_WIDE_EVENTS_KEY);
		$wgMemc->delete(MEMC_SETUP_KEY);
	#---
		$aResponse = array('id' => $ep_id, 'active' => $active);
		if (!function_exists('json_encode'))  {
			$oJson = new Services_JSON();
			return $oJson->encode($aResponse);
		}
		else {
			return json_encode($aResponse);
		}
	}
	
	wfProfileOut( __METHOD__ );
	return false;	
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "wfwkGetEventTypes";
$wgAjaxExportList[] = "wfwkSetEventTypes";
$wgAjaxExportList[] = "wfwkGetEvents";
$wgAjaxExportList[] = "wfwkSetEvents";
$wgAjaxExportList[] = "wfwkSetActiveEvent";
$wgAjaxExportList[] = "wfwkSetActiveEventType";
$wgAjaxExportList[] = "wfwkGetEventTmpl";
$wgAjaxExportList[] = "wfwkSetTextEvent";
$wgAjaxExportList[] = "wfwkAddEventInfo";
$wgAjaxExportList[] = "wfwkSetEventParamSetup";
$wgAjaxExportList[] = "wfwkSetActiveEventParam";
