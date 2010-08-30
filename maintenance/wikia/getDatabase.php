<?php

/**
 * @author Owen Davis, Tomasz Odrobny
 *
 * This is an internal use only script for pulling a database backup from Amazon S3
 * It requires an external script called s3cmd which uses a config file only available to root
 * To use this, sudo -i to root first then: php getDatabase.php -f muppet
 * TODO: You must use the database name.  This does NOT always match the wiki domain name.
 * TODO: Importing section is not finished yet
 */

$wgDBdevboxUser = 'devbox';
$wgDBdevboxPass = 'devbox';
$wgDBdevboxServer1 = 'dev-db-a1';
$wgDBdevboxServer2 = 'dev-db-b1';
$databaseDirectory = "database_A";

$USAGE =
	"Usage:\tphp getDatabase.php -c [cluser A,B,C] [-f [dbname] | -i [filename] | -?]\n" .
	"\toptions:\n" .
	"\t\t--help      show this message\n" .
	"\t\t-f          Fetch a new database dump from s3\n" .
	"\t\t-i          Import a downloaded file to dev db\n";

$opts = getopt ("?::i:f:c:");

if( count($opts) == 0 || in_array( 'help', $opts )) die( $USAGE );
// Grind through s3 for a bit and figure out what the most recent dump is

if(array_key_exists( 'c', $opts )) {
	$databaseDirectory = "database_".trim($opts['c']);
};

if (array_key_exists( 'f', $opts )) {
	$dbname = $opts['f'];
	echo "Fetching $dbname...\n";
	// first check to make sure s3cmd is available
	
	$response = shell_exec("s3cmd ls s3://".$databaseDirectory."/fulldump* 2>&1");
	if (preg_match('/ERROR/', $response) || preg_match ('/command not found/', $response)) {
		// some kind of error, print and die
		exit($response);
	}
	// otherwise, find out if we got some directories that look like database dumps
	$dir_list = explode("\n", $response);
	echo "Found " . count($dir_list) . " backup directories...\n";

	$date_list = array();
	foreach ($dir_list as $dir) {
		if ($dir == "") continue;
		//print_r("dir = $dir \n");
		preg_match('/.*fulldump_(\d+)\.(\d+)\.(\d+).*/', $dir, $matches);
		if (count($matches) != 4) {
			exit ("this does not look like a database directory: $dir\n");
		}
		list($unused, $day, $month, $year) = $matches;
		$day_of_year = date('z', mktime('0','0','0', $month, $day, $year));
		$date_list[$year][$day_of_year] = "fulldump_$day.$month.$year";
	}
	foreach ($date_list as &$arr) {
		krsort($arr);
	}
	//print_r($date_list);

	// now we have a sorted list of directories by most recent date.  how many dumps are in there?
	echo "THIS STEP CAN TAKE A WHILE...\n";
	foreach ($date_list as $year => $day_of_year) {
		foreach ($day_of_year as $dirname) {
			echo "Searching $dirname...\n";
			$filename = null;
			$response = shell_exec("s3cmd ls s3://".$databaseDirectory."/$dirname/".$dbname."*");
//			print_r($response);
			$file_list = explode("\n", $response);
			echo "Found " . count($file_list) . " items...\n";
			foreach ($file_list as $file) {
				$regs = array();
				$file = preg_split('/\s+/' ,$file);
				$file = $file[3];
				if(strpos($file, $dbname.".sql.gz") > 0 || strpos($file, $dbname."_") > 0 ) {
					$filename = $dbname.".sql.gz";	        
					echo "Found a match: $file\n";
			               	echo "Saving to local filesystem:".$filename."\n";
					shell_exec("s3cmd get --skip-existing ".$file." ".$filename);
					$filename = $dbname.".sql.gz";	
					break;
				}
			}
			// check to see if we found something after scanning the whole directory, because we might have multipart files
			if ($filename != null) exit();
			echo "Database file not found...\n";
		}
	}
}

if (array_key_exists( 'i', $opts )) {

	if (! file_exists($opts['i'])) { die ("file not found\n"); }
	$fullpath = basename($opts['i']);
	$filename = basename($opts['i']);
	preg_match("/^(.*).*.sql.gz/", $filename, $matches);
	if (count($matches) == 2) {
		$dbname = $matches[1];
	}

	// Figure out which cluster we need to load this into	$response =  `mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxServer1 -s -N -e "SELECT city_cluster from wikicities.city_list where city_dbname = '$dbname';" 2>&1`;

	$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxServer1 -s -N -e "SELECT city_cluster from wikicities.city_list where city_dbname = '$dbname';" 2>&1`;
	if (trim($response) != "" && substr($response, 0, 5) != 'ERROR') {
		$cluster_name = trim($response);
	} else {
		die ("Database error: " . $response);
	}
	if ($cluster_name == "NULL") $cluster_name = null;  // whee!
	if ($cluster_name == null) {
		$wgDBdevboxServer = $wgDBdevboxServer1;
	} else {
		$wgDBdevboxServer = $wgDBdevboxServer2;
	}

	echo "That database is supposed to live on server:" . $wgDBdevboxServer . "\n";

	// Now we create the database on the relevant server

	$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxServer -e "CREATE DATABASE IF NOT EXISTS $dbname" 2>&1`;
	if(trim($response) != ""){
		print "CREATE DATABASE attempt returned the error:\n$response\n";
	} else {
		print "\"$dbname\" created on \"$wgDBdevboxServer\".<br/>\n";
	}

	print "Loading \"$fullpath\" into \"$wgDBdevboxServer\"...<br/>\n";
	$response = `zcat $fullpath | mysql -u $wgDBdevboxUser -p$wgDBdevboxPassword -h $wgDBdevboxServer $dbname 2>&1`;
	if(trim($response) != ""){
		print "Error loading the database dump into $wgDBdevboxServer:\n$response\n";
	} else {
		print "Database loaded successfully!\n";
	}

}



