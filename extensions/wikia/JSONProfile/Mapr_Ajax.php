<?php

$wgAjaxExportList [] = 'wfGetGMapKey';
$wgAjaxExportList [] = 'wfGetEventStream';
$wgAjaxExportList [] = 'wfGeolocateIP';

function wfGetGMapKey($callback){
	global $GOOGLE_MAPS_KEY;
	return ' var head = document.getElementsByTagName("body")[0];
		// Create object 
		oScript = document.createElement("script");
	
		oScript.setAttribute("src","http://maps.google.com/maps?file=api&amp;v=2&amp;key=' . $GOOGLE_MAPS_KEY . '"); 
		oScript.setAttribute("id","googleMapsCode"); 
		head.appendChild(oScript);';
}

function wfGeolocateIP($addr){
	global $wgMemc, $IP;
	
	require_once($IP . "/extensions/wikia/JSONProfile/ipgeo/geoipcity.inc");
	
	// try our cache first since itll be faster
	$IPDataKey = wfMemcKey( 'wikiasearch' , 'mapfun' , 'IPGeoDataX' );
	$IPGeoData = $wgMemc->get($IPDataKey);
	
	
	if($IPGeoData && array_key_exists($addr, $IPGeoData)){
		return $IPGeoData[$addr];
	}
	
	if(!is_array($IPGeoData)){
		$IPGeoData = array();
	}
	
	$IPGeo = geoip_open($IP . "/extensions/wikia/JSONProfile/ipgeo/GeoLiteCity.dat", GEOIP_STANDARD);
	$record = geoip_record_by_addr($IPGeo, $addr);
	$location["name"] = $record->city . ", " . $record->country_name;
	$location["lat"] =  $record->latitude;
	$location["long"] =  $record->longitude;
	$location["country"] = $record->country_code;
		
	// lets cache it so its FAST
	$IPGeoData[$addr] = $location;
	$wgMemc->set( $IPDataKey, $IPGeoData );
	
	return $location;
}

function getKTStream(){
	
	// http://search.isc.swlabs.org/kttest
	$swLabsURL = "http://search.isc.swlabs.org/kttest/tuple.js?max=20&t=%type"; 
	$urlTypes = array("edit", "add", "spot", "del", "stars", "sug", "com", "bg", "selection");
	
	$theFeed = array();
	
	foreach($urlTypes as $t){
		$fetchURL = str_replace("%type", $t, $swLabsURL);
		$data = file_get_contents($fetchURL, 0, $ctx);
			
		$sourceArray = unjsonify($data);
			
		foreach($sourceArray as $arr){
		
			$uid = User::idFromName($arr->user);
			$myData = array();
			$myData["type"] = $t;
			$myData["isUser"] = false;
			$myData["location"] = "";
			$myData["needGeocode"] = true;
			
			// grab a picture for this user
			$p = new ProfilePhoto( $uid );
			list($url, $rand) = explode("?", $p->getProfileImageURL("p"));
			$myData["picUrl"] = $url;
				
			if($uid > 0){
				$p = new ProfilePrivacy();
				$p->loadPrivacyForUser($arr->user);
				$wgUserProfileDisplay["personal"] = $p->getPrivacyCheckForUser("VIEW_PERSONAL_PROFILE");
					
				// check profile permissions
				if ($wgUserProfileDisplay['personal'] != false){
						$myData["isUser"] = true;
						
						$profile = new UserProfile($arr->user);
						$profile_data = $profile->getProfile();
						
						if(strlen($profile_data["location_city"]) + strlen($profile_data["location_state"]) + strlen($profile_data["location_country"]) < 5)
							$myData["isUser"] = false;
							
						$location = $profile_data["location_city"] . ", " . $profile_data["location_state"] . ", " . $profile_data["location_country"];
						$myData["location"] = $location;
				}
										
			}else{
				$loc = wfGeolocateIP($arr->user);
				
				if($loc["lat"] != null){
					$myData["isUser"] = true;
					$myData["location"] = $loc["name"];
					$myData["countryCode"] = $loc["country"];
					$myData["lat"] = $loc["lat"];
					$myData["long"] = $loc["long"];
					$myData["needGeocode"] = false;
				}
			}
			
			$myData["id"] = (int) ($arr->id / 1000);
			$myData["user"] = $arr->user;
			$myData["keyword"] = $arr->keyword;
				
			if($t != "sug" && $t != "bg"){
				$myData["url"] = $arr->url;
			}
				
			if($t == "bg"){
				$myData["bg"] = $arr->bg;
			}
				
			if($t == "selection"){
				$myData["newUrl"] = $arr->form->action;
			}
				
			// if we can map it add it
			if($myData["isUser"]){
				$theFeed[] = $myData;
			}
		}
	}
	
	usort($theFeed, "feedSorter");
	// $theFeed = array_splice($theFeed, count($theFeed)/2);
	
	return $theFeed;
}
    
function wfGetEventStream($time, $showStream){
	global $wgMemc;
	
	$key = wfMemcKey( 'wikiasearch' , 'mapfun' , 'dataxx');
	$feed = $wgMemc->get($key);
	
	$jsImages = "";
	
	if(!$feed){
		$feed = getKTStream();
		$wgMemc->set( $key, $feed, 10 );
	}
	
	// figure out what time it is now
	
	$i=0;
	do{
		$data = file_get_contents("http://search.isc.swlabs.org/kttest/now.js");
		$arr = unjsonify($data);
		$offset = time() - ($arr->now/1000);
		$i++;
	}while($offset > 10000 && $i < 5); // get the right kt time stamp
	
	$now = (int) $arr->now / 1000;
	
	if($time == -1){
		$time = $feed[count($feed)-1]["id"] - 300;
	}
	
	$lastTime = 0;
	$freshFeed = array();
	$loadedImages = array();
	
	for($i=count($feed)-1; $i > 0; $i--){
		$t = $feed[$i];
		
		if($t["id"] > $time){
			
			$t["age"] = (int)($now - $t["id"]);
			
			$freshFeed[] = $t;
			$lastTime = ($t["id"] > $lastTime) ? $t["id"] : $lastTime;
			
			if(!array_key_exists($t["picUrl"], $loadedImages)){
				$jsImages = "if(jsImages['" . $t["picUrl"] . "'] != null){" . 
				    " var m = new Image();
				      m.src = '" . $t["picUrl"] . "';
				      jsImages['" . $t["picUrl"] . "'] = true;
				     }";
			}
		}else{
			break;
		}
		
		if(count($freshFeed) > 100){
			break;
		}
		
	}
	
	$freshFeed = array_reverse($freshFeed);
	
	if($lastTime == 0){
		$lastTime = $time;
	}
	
	return $jsImages . '
	isQuerying=false; lastTime = ' . $lastTime . ';' .
	'var newData=' . jsonify($freshFeed) . ';' .
	'workingStream=workingStream.concat(newData); ' . 
	($showStream ? "showStream();" : "");
}

function feedSorter($a, $b){
	if($a["id"] == $b["id"]){
		return 0;
	}
	return ($a["id"] < $b["id"]) ? -1 : 1;
}

?>
