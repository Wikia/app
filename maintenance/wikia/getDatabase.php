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

// include chef generated variables: $wgWikiaDatacenter
require_once('/usr/wikia/devbox/DevBoxVariables.php');

switch($wgWikiaDatacenter) {
	case 'poz':
		$wgDBdevboxServer1 = 'dev-db-a1-p1';
		$wgDBdevboxServer2 = 'dev-db-a1-p1';
		$wgDBdevboxCentral = 'dev-db-central-p1';
		break;
	case 'sjc':
	default:
		$wgDBdevboxServer1 = 'dev-db-a1';
		$wgDBdevboxServer2 = 'dev-db-b1';
		$wgDBdevboxCentral = 'dev-db-central';
		break;

}

$wgDBdevboxUser = 'devbox';
$wgDBdevboxPass = 'devbox';
$databaseDirectories = array ("database_A", "database_B", "database_C", "database_D");

$USAGE =
	"Usage:\tphp getDatabase.php -c [cluster A,B,C,D] [ -l [config] ] [[-f [dbname] | -d [dbname] ]| -i [filename] | -?]\n" .
	"\toptions:\n" .
	"\t\t-c          cluster the wiki is on\n" .
	"\t\t--help      show this message\n" .
	"\t\t-f          Fetch a new database dump from s3\n" .
	"\t\t-d          Fetch and import to dev db\n" .
	"\t\t-i          Import a downloaded file to dev db\n" .
	"\t\t-l          Read settings from external file\n" .
	"\n" .
	"Or use " . __DIR__ . "/getDatabase.sh host\n";

$opts = getopt ("l:i:d:f:c:?::");
if( empty( $opts ) ) die( $USAGE );

// Grind through s3 for a bit and figure out what the most recent dump is

$HOME=trim(`echo ~`,"\n");
$defaultConfig = "$HOME/.getDatabase.conf.php";
if (array_key_exists( 'l', $opts )) {
	if ($opts['l'] == '-') {
		// do nothing
	} else if (is_readable($opts['l'])) {
		echo "loading configuration file: {$opts['l']}\n";
		include_once $opts['l'];
	} else {
		echo "error: configuration file could not be read: {$opts['l']}\n";
		die();
	}
} else if (is_readable($defaultConfig)) {
	echo "loading configuration file: $defaultConfig\n";
	include_once $defaultConfig;
}

if(array_key_exists( 'c', $opts )) {
	$databaseDirectories = array("database_".trim($opts['c']));
} else {
	echo PHP_EOL . PHP_EOL;
	echo 'No -c passed. Use ' . __DIR__ . '/getDatabase.sh if you want auto cluster discovery.' . PHP_EOL;
	echo 'We\'ll now go through all cluster to see if there\'s a backup, but this can result in old backup' . PHP_EOL;
	echo PHP_EOL . PHP_EOL;
	echo 'Ctr-C to break, wait 4 second to continue' . PHP_EOL;
	sleep(4);
	echo 'Going on...'. PHP_EOL;
};


$filedir = "";
if(array_key_exists( 'd', $opts )) {
	$opts['f'] = $opts['d'];
	$filedir = sys_get_temp_dir() . '/';
};


if (array_key_exists( 'f', $opts )) {
	$dbname = $opts['f'];
	echo "Fetching $dbname...\n";
	// first check to make sure s3cmd is available

	function getFile($databaseDirectories, $dbname, $filedir) {
		foreach ($databaseDirectories as $databaseDirectory) {
			$response = shell_exec("s3cmd ls s3://".$databaseDirectory."/fulldump* 2>&1");
			if (preg_match('/ERROR/', $response) || preg_match ('/command not found/', $response)) {
				// some kind of error, print and die
				exit($response);
			}
			// otherwise, find out if we got some directories that look like database dumps
			$dir_list = explode("\n", $response);
			echo "Found " . count($dir_list) . " backup directories in $databaseDirectory...\n";

			$date_list = array();
			foreach ($dir_list as $dir) {
				if ($dir == "") continue;
				//print_r("dir = $dir \n");
				preg_match('/.*fulldump_(\d+)\.(\d+)\.(\d+).*/', $dir, $matches);
				if (count($matches) == 4) {
					$spacer = ".";
				} else {
					// how did C backup names end up with dashes?
					$spacer = "-";
					preg_match('/.*fulldump_(\d+)-(\d+)-(\d+).*/', $dir, $matches);
				}
				if (count($matches) != 4) {
					exit ("this does not look like a database directory: $dir\n");
				}
				// order of date in filenames changed in 2011 from DMY to YMD
				list($unused, $day, $month, $year) = $matches;
				if ($day > 2000) {
					list ($unused, $year, $month, $day) = $matches;
					$day_of_year = date('z', mktime('0','0','0', $month, $day, $year));
					$date_list[$year][$day_of_year] = "$year$spacer$month$spacer$day";
				} else {
					$day_of_year = date('z', mktime('0','0','0', $month, $day, $year));
					$date_list[$year][$day_of_year] = "$day$spacer$month$spacer$year";
				}
			}
			krsort($date_list, SORT_NUMERIC);
			foreach ($date_list as &$arr) {
				krsort($arr, SORT_NUMERIC);
			}
			//print_r($date_list);

			// now we have a sorted list of directories by most recent date.  how many dumps are in there?
			echo "THIS STEP CAN TAKE A WHILE...\n";
			foreach ($date_list as $year => $day_of_year) {
				foreach ($day_of_year as $date) {
					$dirname = "fulldump_" . $date;
					echo "Searching $dirname...\n";
					$filename = $databaseDirectory."/$dirname/".$dbname."_$date".".sql.gz" ;
					echo "Searching for $filename...\n";
					$response = shell_exec("s3cmd ls s3://".$databaseDirectory."/$dirname/".$dbname."_$date".".sql.gz");
					$file_list = explode("\n", $response);
					echo "Found " . count($file_list) . " items...\n";
					foreach ($file_list as $file) {
						$regs = array();
						$file = preg_split('/\s+/' ,$file);
						$file = $file[3];
						if(strpos($file, $dbname.".sql.gz") > 0 || strpos($file, $dbname."_") > 0 ) {
							$filename = $filedir.$dbname.".sql.gz";

							echo "Found a match: $file\n";
									echo "Saving to local filesystem:".$filename."\n";
							shell_exec("s3cmd get --skip-existing ".$file." ".$filename);
							return $filename;
						}
					}
					// check to see if we found something after scanning the whole directory, because we might have multipart files
					if ($filename == null) {
						echo "Database file not found...\n";
						return false;
					}

				}
			}
		}
	}

	$filename = getFile($databaseDirectories, $dbname, $filedir);
	if(empty($filename)) {
		exit;
	}
}



if(array_key_exists( 'd', $opts )) {
	$opts['i'] = $filename;
};

if (array_key_exists( 'i', $opts )) {
	if (! file_exists($opts['i'])) { die ("file not found\n"); }
	$fullpath = $opts['i'];
	$filename = basename($opts['i']);
	preg_match("/^(.*).*.sql.gz/", $filename, $matches);
	if (count($matches) == 2) {
		$dbname = $matches[1];
	}

	// Figure out which cluster we need to load this into by connecting to central directly

	if ($dbname == 'wikicities') {
		$wgDBdevboxServer = $wgDBdevboxServer1;
	} else {
		$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxCentral -s -N -e "SELECT city_cluster from wikicities.city_list where city_dbname = '$dbname';" 2>&1`;
		if (trim($response) != "" && substr($response, 0, 5) != 'ERROR') {
			$cluster_name = trim($response);
		} else {
			if ($response == "") {
				die ("Database error: $dbname not found in city_list.");
			} else {
				die ("Database error: " . $response);
			}
		}
		if ( $cluster_name == 'c1' ) {
			$wgDBdevboxServer = $wgDBdevboxServer1;
		} else if ( $cluster_name != null ) {
			$wgDBdevboxServer = $wgDBdevboxServer2;
		} else {
			print "Cluster was NULL in wikicities, aborting.";
			exit();
		}
	}

	echo "That database is supposed to live on server:" . $wgDBdevboxServer . "\n";

	// Now we create the database on the relevant server

	$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxServer -e "CREATE DATABASE IF NOT EXISTS $dbname" 2>&1`;
	if(trim($response) != ""){
		print "CREATE DATABASE attempt returned the error:\n$response\n";
	} else {
		print "\"$dbname\" created on \"$wgDBdevboxServer\".\n";
	}

	print "Loading \"$fullpath\" into \"$wgDBdevboxServer\"...\n";
	$source = "zcat $fullpath";
	if (is_executable("/usr/bin/bar"))
		$source = "cat $fullpath | bar | zcat";
	$response = `$source | mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxServer $dbname 2>&1`;
	if(trim($response) != ""){
		print "Error loading the database dump into $wgDBdevboxServer:\n$response\n";
	} else {
		print "Database loaded successfully!\n";
		unlink($fullpath);
	}

}
