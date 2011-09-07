<?php

/**
 * The current version of this script when used with parameter '-c' clears database with data for FogBugzDiagrams. 
 * When run without any parameters it gets cases updated within last 15 mins to update data in database and data
 * that was updated within current day to update cache. 
 */
echo "Script start...\n";

if( file_exists('/../../../../maintenance/commandLine.inc') ) {
	require_once ( '/../../../../maintenance/commandLine.inc' );
} else {
	require_once ('/usr/wikia/source/wiki/maintenance/commandLine.inc');
}

global $wgRequest, $wgHTTPProxy, $wgFogbugzAPIConfig, $wgMemc;

$key = wfSharedMemcKey( 'FogbugzService', 'LastUpdate');

if ($argc > 4 || ($argc == 4 && $argv[2] != '-c') ) { // if number of parameters wasn't correct or parameters were wrong
	die("Usage:\tphp FogbugzCache.php [ -c [ clear ] ]\n".
		"no options: \n\tupdates data about Fogbugz cases:\n\tin cache (old version)/database(current version)\n".
		"options:\n".
		"\t-c      clear database\n"); // I see name should be probably changed
}

else if ($argc == 4 && $argv[2] == '-c') { 
	echo "Yupie! We are clearing the database!\n";
	wfGetDB( DB_MASTER )->delete('fogbugz_cases', '*');
	$wgMemc->set( $key, null );
	echo "Database clear!\n";
}

else {
	//$command = $wgRequest->getText('cmd');
	$myFBService = new FogbugzService( $wgFogbugzAPIConfig['apiUrl'], $wgFogbugzAPIConfig['username'],
		$wgFogbugzAPIConfig['password'], $wgHTTPProxy
	);
	$LastUpdated = $wgMemc->get( $key ); // we've got dtLastUpdated value
	echo "Date of last updated case:\n";
	print_r($LastUpdated);
	echo "\n";
	if ($LastUpdated != null) {
		echo "Getting cases updated in last 15 mins...\n";
		$results = $myFBService->logon()->findAndSaveCasesToMemc('category:"Bug" lastupdated:"-15m.."', false);
		$DBconnMSTR = wfGetDB( DB_MASTER );
		$DBconnSLV = wfGetDB( DB_SLAVE );
		$totalLastUpdate = ''; // value that should be written in memc after adding/updating data
		foreach ($results as $res ) {
			if (strtotime($res['dtLastUpdated']) > strtotime($LastUpdated)) {
				echo "Updating/inserting case ".$res['ixBug']." in database...\n";
				$DBconnMSTR->replace('fogbugz_cases', $res['ixBug'],array(
					'sTitle' => $res['sTitle'],
					'ixBug' => $res['ixBug'],
					'sStatus' => $res['sStatus'],
					'ixBugChildren' => implode(",", $res['ixBugChildren']),
					'ixBugParent' => $res['ixBugParent'],
					'ixPriority' => $res['ixPriority'],
					'ixProject' => $res['ixProject'],
					'ixCategory' => $res['ixCategory'],
					'dtOpened' => $res['dtOpened'],
					'dtResolved' => $res['dtResolved'],
					'dtClosed' => $res['dtClosed'],
					'dtLastUpdated' => $res['dtLastUpdated'],
					'OpenedYW' => !empty($res['dtOpened']) ? date('YW', strtotime($res['dtOpened'])) : null,
					'ResolvedYW' => !empty($res['dtResolved']) ? date('YW', strtotime($res['dtResolved'])) : null,
					'ClosedYW' => !empty($res['dtClosed']) ? date('YW', strtotime($res['dtClosed'])) : null
				));
				$totalLastUpdate = $res['dtLastUpdated'];
			}
		}
		if ($totalLastUpdate != '') {
			$LastUpdated = $totalLastUpdate;
		}
		$wgMemc->set( $key, $LastUpdated );
	}
	else {
		echo "Updating whole database...\n";
		$results = array();
		$dateToday = new DateTime();
		//$dateToday->format('n/j/Y');
		$dateBegin = new DateTime('2011-01-01');
		//$dateBegin->format('n/j/Y');
		$dateEnd = new DateTime('2011-01-01');
		$dateEnd->modify('+1 month');
		//$dateEnd->format('n/j/Y');
		while ($dateEnd < $dateToday) {
			echo "Getting cases since ".$dateBegin->format('d-m-Y')." to ".$dateEnd->format('d-m-Y')."...\n";
			$results = array_merge($results, $myFBService->logon()->findAndSaveCasesToMemc('category:"Bug" opened:"'.$dateBegin->format('n/j/Y').'..'.
			$dateEnd->format('n/j/Y').'"', false)); // we have to get all cases since february
			$dateBegin->modify('+1 month');
			$dateEnd->modify('+1 month');	
		}
		if ($dateBegin < $dateToday) {
			echo "Getting cases since ".$dateBegin->format('d-m-Y')." to ".$dateToday->format('d-m-Y')."...\n";
			$results = array_merge($results, $myFBService->logon()->findAndSaveCasesToMemc('category:"Bug" opened:"'.$dateBegin->format('n/j/Y').'..today"', false));
		}
		//var_dump(array_slice($results,0,3));
		$DBconn = wfGetDB( DB_MASTER );
		echo "Putting data in database...\n";
		foreach ($results as $res ) {
			$DBconn->replace('fogbugz_cases', $res['ixBug'], array(
				'sTitle' => $res['sTitle'],
				'ixBug' => $res['ixBug'],
				'sStatus' => $res['sStatus'],
				'ixBugChildren' => implode(",", $res['ixBugChildren']),
				'ixBugParent' => $res['ixBugParent'],
				'ixPriority' => $res['ixPriority'],
				'ixProject' => $res['ixProject'],
				'ixCategory' => $res['ixCategory'],
				'dtOpened' => !empty($res['dtOpened']) ? $res['dtOpened'] : null,
				'dtResolved' => !empty($res['dtResolved']) ? $res['dtResolved'] : null,
				'dtClosed' => !empty($res['dtClosed']) ? $res['dtClosed'] : null,
				'dtLastUpdated' => $res['dtLastUpdated'],
				'OpenedYW' => !empty($res['dtOpened']) ? date('YW', strtotime($res['dtOpened'])) : null,
				'ResolvedYW' => !empty($res['dtResolved']) ? date('YW', strtotime($res['dtResolved'])) : null,
				'ClosedYW' => !empty($res['dtClosed']) ? date('YW', strtotime($res['dtClosed'])) : null
			));
			if ($LastUpdated == null || strtotime($res['dtLastUpdated']) > strtotime($LastUpdated)) {
				$LastUpdated = $res['dtLastUpdated'];
			}
		}
		$wgMemc->set( $key, $LastUpdated );
	}
	
	echo "Updating cache...\n";
	$myFBService->findAndSaveCasesToMemc("lastupdated:\"Today\"");
	$myFBService->logoff();
}



echo "Done.\n";

?>