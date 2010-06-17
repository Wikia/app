<?php

/**
 * @author Owen Davis
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

$USAGE =
	"Usage:\tphp getDatabase.php [-f [dbname] | -i [filename] | -?]\n" .
	"\toptions:\n" .
	"\t\t--help      show this message\n" .
	"\t\t--fetch     get a new database dump from s3\n" .
	"\t\t--import    import a downloaded file to dev db\n";

$opts = getopt ("?::i:f:");

if( count($opts) == 0 || in_array( 'help', $opts )) die( $USAGE );

// Grind through s3 for a bit and figure out what the most recent dump is
if (array_key_exists( 'f', $opts )) {
	$dbname = $opts['f'];
	echo "Fetching $dbname...\n";
	// first check to make sure s3cmd is available
	$response = shell_exec("s3cmd ls s3://database/fulldump*");
	if (preg_match('/ERROR/', $response) || preg_match ('/command not found/', $response)) {
		// some kind of error, print and die
		echo $response;
		die();
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
			echo "this does not look like a database directory: $dir\n";
			die();
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
			$response = shell_exec("s3cmd ls s3://database/$dirname/");
			//print_r($response);
			$file_list = explode("\n", $response);
			echo "Found " . count($file_list) . " items...\n";
			foreach ($file_list as $file) {
				preg_match("/.*\/(".$dbname."_.*)/", $file, $matches);
				if (count($matches) == 2) {
					$filename = $matches[1];
					echo "Found a match: $filename\n";
					echo "Saving to local filesystem...\n";
					shell_exec ("s3cmd get --skip-existing s3://database/$dirname/$filename");
				} 
			}
			// check to see if we found something after scanning the whole directory, because we might have multipart files
			if ($filename != null) exit();
			echo "Database file not found...\n";
		}
	}
}

if (array_key_exists( 'i', $opts )) {

	$filename = $opts['f'];
	preg_match("/^(.*)_.*.sql.gz/", $filename, $matches);
	if (count($matches) == 2) {
		$dbname = $matches[1];
	}
	if (! file_exists($dbname)) { echo "file not found\n"; exit(); }

	/*
	print "mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxServer -e \"SELECT city_cluster from wikicities.city_list where city_id = ' . $cityId;
\" 2>&1";

	print "mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxServer -e \"CREATE DATABASE IF NOT EXISTS $dbname\" 2>&1";
	if(trim($response) != ""){
		print "<div class='devbox-error'>CREATE DATABASE attempt returned the error:\n<em>$response</em></div>\n";
	} else {
		print "\"$wgDBname\" created on \"$wgDBdevboxServer\".<br/>\n";
	}
	print "<br/>";

	print "Loading \"$wgDBname\" into \"$wgDBdevboxServer\"...<br/>\n";
	//$response = `cat $tmpFile | mysql -u $wgDBdevboxUser -p$wgDBdevboxPassword -h $wgDBdevboxServer $wgDBname 2>&1`;
	print "cat $tmpFile | mysql -u $wgDBdevboxUser -p$wgDBdevboxPassword -h $wgDBdevboxServer $wgDBname 2>&1";
	if(trim($response) != ""){
		print "<div class='devbox-error'>Error loading the database dump into $wgDBdevboxServer:\n<em>$response</em></div>\n";
	} else {
		print "<div class='devbox-success'>Database loaded successfully!</div>\n";
	}
*/

}



