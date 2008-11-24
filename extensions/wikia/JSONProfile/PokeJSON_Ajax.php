<?php

$wgAjaxExportList [] = 'wfPokeJSON';
function wfPokeJSON($user_name=false, $is_pokeback, $callback="handlePoked"){
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgRequest, $wgSiteView, $wgMemc;

	require_once("$IP/extensions/wikia/Poke/PokeClass.php");
	
	if ($wgUser->isLoggedIn()) {
		$poke = new Poke();
		$poked = $poke->poke($user_name, $is_pokeback);
		if ($poked) {
			$user_id = User::idFromName($user_name);
			$key = wfMemcKey( 'user', 'profile', 'notifupdated', $user_id );
			$wgMemc->set($key,false);
			
			$poke_obj = array("user_name"=>$user_name, "user_name_display"=>user_name_display($user_id, $user_name), "user_id"=>$user_id, "poke_id"=>$is_pokeback, "email_sent"=>$poked);
			$text = "//poked\n\nvar poke_obj=" . jsonify($poke_obj) . ";\n\n{$callback}(poke_obj);";
		}
		else {
			$text = "//NOT POKED!!!!!";
		}
	}
	else {
		$text = "// not poked";
	}
	
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

$wgAjaxExportList [] = 'wfRemovePokeJSON';
function wfRemovePokeJSON($poke_id=0, $callback="handlePokeRemoved"){
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgRequest, $wgSiteView;

	require_once("$IP/extensions/wikia/Poke/PokeClass.php");
	
	if ($wgUser->isLoggedIn() && $poke_id) {
		$poke = new Poke();
		$poked = $poke->remove_poke($poke_id);
		if ($poked) {
			$text = "//pokeremove\n\n" . $callback."({$poke_id});";
		}else {
			$text = "//POKE NOT REMOVED!!!!!";
		}
	}
	else {
		$text = "// not removed";
	}
	
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

$wgAjaxExportList [] = 'wfGetOutstandingPokesJSON';
function wfGetOutstandingPokesJSON($user_name=false, $callback="showPokes"){
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgRequest, $wgSiteView;

	require_once("$IP/extensions/wikia/Poke/PokeClass.php");
	$user = User::newFromName($user_name);
	if ($user) {
		$pokes = wfOutstandingPokesJSON($user_name);
	}else {
		$pokes = array();
	}
	
	$text = "var pokes=" . jsonify($pokes) . ";\n\n{$callback}(pokes);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

function wfOutstandingPokesJSON($user_name, $r_user_name=false){
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgRequest, $wgSiteView;

	if($r_user_name && $user_name==$r_user_name) {
		$r_user_name=false;
	}
	
	require_once("$IP/extensions/wikia/Poke/PokeClass.php");
	$user = User::newFromName($user_name);
	if ($user) {
		$poke = new Poke();
		$pokes = $poke->getOutstanding($user_name, $r_user_name);
		if ($pokes) {
			return $pokes;
		}
		else {
			return array();
		}
	}
	else {
		return array();
	}
}

?>
