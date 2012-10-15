<?php

/**
 * The current version of this script when used with parameter '-c' clears database with data for FogBugzDiagrams. 
 * When run without any parameters it gets cases updated within last 15 mins to update data in database and data
 * that was updated within current day to update cache. 
 */
function replaceCase( $connection, $case ) {
	$connection->replace( 'fogbugz_cases', $case['ixBug'],array(
		'sTitle' => $case['sTitle'],
		'ixBug' => $case['ixBug'],
		'sStatus' => $case['sStatus'],
		'ixBugChildren' => implode( ",", $case['ixBugChildren'] ),
		'ixBugParent' => $case['ixBugParent'],
		'ixPriority' => $case['ixPriority'],
		'ixProject' => $case['ixProject'],
		'ixCategory' => $case['ixCategory'],
		'dtOpened' => !empty( $case['dtOpened'] ) ? $case['dtOpened'] : null,
		'dtResolved' => !empty( $case['dtResolved'] ) ? $case['dtResolved'] : null,
		'dtClosed' => !empty( $case['dtClosed'] ) ? $case['dtClosed'] : null,
		'dtLastUpdated' => !empty( $case['dtLastUpdated'] ) ? $case['dtLastUpdated'] : null,
		'OpenedYW' => !empty( $case['dtOpened'] ) ? date( 'YW', strtotime( $case['dtOpened'] ) ) : null,
		'ResolvedYW' => !empty( $case['dtResolved'] ) ? date( 'YW', strtotime( $case['dtResolved'] ) ) : null,
		'ClosedYW' => !empty( $case['dtClosed'] ) ? date( 'YW', strtotime( $case['dtClosed'] ) ) : null
	) );
}

echo "Script start...\n";

require_once ( __DIR__ . '/../../../../maintenance/commandLine.inc' );

global $wgRequest, $wgHTTPProxy, $wgFogbugzAPIConfig, $wgMemc;

$key = wfSharedMemcKey( 'FogbugzService', 'LastUpdate');

if ( in_array('-h', $argv) ) { // if number of parameters wasn't correct or parameters were wrong
	die("Usage:\tphp FogbugzCache.php [ -c [ clear ] ]\n".
		"no options: \n\tupdates data about Fogbugz cases:\n\tin cache (old version)/database(current version)\n".
		"options:\n".
		"\t-c      clear database\n".
		"\t-h      shows this screen\n"); // I see name should be probably changed
}

else if ( in_array('-c', $argv) ) { 
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
	$DBconnMSTR = wfGetDB( DB_MASTER );
	$dateToday = new DateTime();
	if ( $LastUpdated != null ) {
		echo "Getting cases updated in last 15 mins...\n";
		$results = $myFBService->logon()->findAndSaveCasesToMemc( 'category:"Bug" lastupdated:"-15m.."', false );
		$totalLastUpdate = ''; // value that should be written in memc after adding/updating data
		foreach ( $results as $res ) {
			if ( strtotime( $res['dtLastUpdated'] ) > strtotime( $LastUpdated ) ) {
				echo "Updating/inserting case ".$res['ixBug']." in database...\n";
				replaceCase( $DBconnMSTR, $res );
				$totalLastUpdate = $res['dtLastUpdated'];
			}
		}
		if ( $totalLastUpdate != '' ) {
			$LastUpdated = $totalLastUpdate;
		}
		$wgMemc->set( $key, $LastUpdated );
	}
	else {
		echo "Updating whole database...\n";
		$results = array();
		//$dateToday->format('n/j/Y');
		$dateBegin = new DateTime( '2011-01-01' );
		//$dateBegin->format('n/j/Y');
		$dateEnd = new DateTime( '2011-01-01' );
		$dateEnd->modify( '+1 month' );
		//$dateEnd->format('n/j/Y');
		while ( $dateEnd < $dateToday ) {
			echo "Getting cases since ".$dateBegin->format( 'd-m-Y' )." to ".$dateEnd->format( 'd-m-Y' )."...\n";
			$results = $myFBService->logon()->findAndSaveCasesToMemc( 'category:"Bug" opened:"'.$dateBegin->format( 'n/j/Y' ).'..'.
			$dateEnd->format( 'n/j/Y' ).'"', false );
			echo "Putting cases in the database ...\n";
			foreach ( $results as $res ) {
				replaceCase( $DBconnMSTR, $res );
				if ( $LastUpdated == null || strtotime( $res['dtLastUpdated'] ) > strtotime( $LastUpdated ) ) {
					$LastUpdated = $res['dtLastUpdated'];
				}
			}
			$dateEnd->format( 'n/j/Y' ); // we have to get all cases since february
			$dateBegin->modify( '+1 month' );
			$dateEnd->modify( '+1 month' );
			$results = array();	
		}
		if ( $dateBegin < $dateToday ) {
			echo "Getting cases since ".$dateBegin->format( 'd-m-Y' )." to ".$dateToday->format( 'd-m-Y' )."...\n";
			$results = array_merge( $results, $myFBService->logon()->findAndSaveCasesToMemc( 'category:"Bug" opened:"'.
				$dateBegin->format( 'n/j/Y' ).'..today"', false ) );
			echo "Putting cases in the database ...";
			foreach ( $results as $res ) {
				replaceCase( $DBconnMSTR, $res );
				if ( $LastUpdated == null || strtotime( $res['dtLastUpdated'] ) > strtotime( $LastUpdated ) ) {
					$LastUpdated = $res['dtLastUpdated'];
				}
			}
		}
		//var_dump(array_slice($results,0,3));		
		$wgMemc->set( $key, $LastUpdated );
	}	
	echo "Updating cache...\n";
	$myFBService->findAndSaveCasesToMemc("lastupdated:\"Today\"");
	
	echo "Operations report.\n";
	
	$key = wfSharedMemcKey( 'FogbugzService', 'operations_report' , $dateToday->format( "Y-d-m" ) );
	
	//$wgMemc->set( $key, null ); //pawelrychly
	
	if ( $wgMemc->get( $key ) == null ) {
		$operations = array();
		//pawelrychly - changing sTags on tags - becouse of fact that sTags doesnt work properly
 		$operations['OPEN'] = $myFBService->logon()->findAndSaveCasesToMemc( 'project:"Operations"status:"open"', 
			false, 'ixBug,sTitle,sStatus,sCategory,sPriority,sArea,sPersonAssignedTo,ixPersonOpenedBy,ixPersonResolvedBy,'.
			'ixPersonClosedBy,dtOpened,dtLastUpdated,dtResolved,dtClosed,tags'
		);
		
		$operations['RESOLVED'] = $myFBService->logon()->findAndSaveCasesToMemc( 'project:"Operations"status:"resolved"', 
			false, 'ixBug,sTitle,sStatus,sCategory,sPriority,sArea,sPersonAssignedTo,ixPersonOpenedBy,ixPersonResolvedBy,'.
			'ixPersonClosedBy,dtOpened,dtLastUpdated,dtResolved,dtClosed,tags'
		);
		
		$operations['CLOSED48h'] = $myFBService->logon()->findAndSaveCasesToMemc( 'project:"Operations"closed:"-2d.."status:"closed"', 
			false, 'ixBug,sTitle,sStatus,sCategory,sPriority,sArea,sPersonAssignedTo,ixPersonOpenedBy,ixPersonResolvedBy,'.
			'ixPersonClosedBy,dtOpened,dtLastUpdated,dtResolved,dtClosed,tags'
		);
		
		$namesTable = array(); 
		foreach ( $operations as &$operation ) {
			foreach ( $operation as &$case ) {
				$case['sTags'] = $case['tags'];
				unset( $case['tags'] );
				changeIdOnName( $case, "PersonOpenedBy", $myFBService, $namesTable );
				changeIdOnName( $case, "PersonResolvedBy", $myFBService, $namesTable );
				changeIdOnName( $case, "PersonClosedBy", $myFBService, $namesTable );
			} 			
		}

		if ( ( count ( $operations['OPEN'] ) + count( $operations['CLOSED48h'] ) + count( $operations['RESOLVED'] ) ) > 50 ) {
			
			$attachment_dirs = array();
			foreach ( $operations as $name => $dataType ) {
				//$outputData .= $name."\r\n"; 
				$outputData = '';
				$line = implode( ',', array_keys(  $dataType[0] ) ) . "\r\n";
				$outputData .= $line;
				foreach ( $dataType as $record ) {
					$line = '"' . implode( '","',  $record ) . '"' . "\r\n";
					$outputData .= $line;
				}
				$file = '/tmp/operations-'.$dateToday->format( 'Ymd-His' ) . "-" . $name .'.csv';
				$fp = fopen($file, "a");
				flock( $fp, 2 );
				fwrite( $fp, $outputData );
				flock( $fp, 3 );
				fclose( $fp ); 	
				$attachment_dirs[] = '/tmp/operations-'.$dateToday->format( 'Ymd-His' ) . "-" . $name .'.csv';
			}

			$emails = array();
			$emails[] = new MailAddress( 'ops-automatic-l@wikia-inc.com' );		
			$subject = $body = 'FogBugz Operations Daily Report '.$dateToday->format( 'Y-m-d H:i:s' );	
			UserMailer::send( $emails, 'ops-automatic-l@wikia-inc.com', $subject, $body, null, null, 'FogbugzCache', 0, $attachment_dirs );
			foreach ( $attachment_dirs as $dir ) {
				unlink( $dir );	
			}
			$wgMemc->set( $key, 1 );
		}
	}
	
	$myFBService->logoff();
}
echo "Done.\n";



function changeIdOnName( &$case, $key, $myFBService, &$namesTable ) {
	$ix = 'ix' . $key;
	$s = 's' . $key;
	if ( array_key_exists( $case[$ix], $namesTable ) ) {
		$personName = $namesTable[$case[$ix]];
	} else {
		$namesTable[$case[$ix]] = $myFBService->logon()->getPersonInfo( intval( $case[$ix] ), "sFullName" );
		$personName = $namesTable[$case[$ix]]; 
	
	}
	if ( !empty( $personName ) ) {
		$case[$s] = $personName['sFullName'];	
	} else {
		$case[$s] = '';
	}
	unset( $case[$ix] );
}
