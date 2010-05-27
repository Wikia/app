<?php

ini_set( "include_path", dirname(__FILE__)."/.." );
$IP = $GLOBALS["IP"];
require_once( "commandLine.inc" );

$dbr = wfGetDB( DB_SLAVE, 'stats', $wgExternalSharedDB );

$dbw = wfGetDB( DB_MASTER, 'stats', $wgStatsDB );

for ($i=1; $i<140000; $i++) {
	global $wgMemc;
	echo "recover $i \n";
	$key = WikiFactory::getVarsKey( $i );
	$data = $wgMemc->get( $key );
	
	if ( !empty($data) ) {
		$records = $data["data"] && is_array( $data["data"] )
			? $data["data"]
			: array ();
		
		if ( !empty($records) ) {
			/*$rows = "";
			foreach ( $records as $key => $value ) {
				$rows .= "$key:$value\n";
			}

			echo count($records) . " records found \n";*/
			
			if ( !empty($rows) ) {
				/*$f = fopen("/home/moli/recover/".$i.".data",'w+');
				fwrite($f,$rows,strlen($rows));
				fclose($f);*/
				
				$dbw->insert(
					"recover",
					array(
						"id" => $i,
						"data" => serialize($records)
					)
				);
			}
		} else {
			echo "no data found (2) \n";
		}
	} else {
		echo "no data found \n";		
	}
}
