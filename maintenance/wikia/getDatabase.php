<?php

/**
 * @author Owen Davis
 *
 * This is an internal use only script for pulling a database backup from Amazon S3
 * It requires an external script called s3cmd which should be in your home dir
 * This script uses the hostname of the wiki to figure out which database to import
 * It also imports WikiFactory variables from the production database
 */

putenv ("SERVER_ID=177");

$dirName = dirname(__FILE__);

require_once( $dirName . "/../commandLine.inc" );

$wgDBdevboxUser = 'devbox';
$wgDBdevboxPass = 'devbox';

$USAGE =
	"Usage:\tphp getDatabase.php [[-h [hostname] | [-f [hostname] | -i [filename] | [ -p [env] ]  | -?]\n" .
	"\toptions:\n" .
	"\t\t--help      show this message\n" .
	"\t\t-h          Fetch and import to dev db by hostname (short name or fully qualified name ok)\n" .
	"\t\t-f          Fetch a new database file from s3\n" .
	"\t\t-i          Import a downloaded file to dev db\n" .
	"\t\t-p          Which dev database to use for target: sjc or poz (optional, defaults to WIKIA_DATACENTER) \n".
	"\n";

$opts = getopt ("h:i:f:p:?::");
if( empty( $opts ) ) die( $USAGE );

if (array_key_exists('p', $opts)) {
	$wgWikiaDatacenter = $opts['p'];
} else {
	$wgWikiaDatacenter = getenv('WIKIA_DATACENTER');
}
switch($wgWikiaDatacenter) {
	case WIKIA_DC_POZ:
		$wgDBdevboxServer1 = 'dev-db-a1-p2';
		$wgDBdevboxServer2 = 'dev-db-a1-p2';
		$wgDBdevboxCentral = 'dev-db-central-p2';
		break;
	case WIKIA_DC_SJC:
		$wgDBdevboxServer1 = 'dev-db-a1';
		$wgDBdevboxServer2 = 'dev-db-b1';
		$wgDBdevboxCentral = 'dev-db-central';
		break;
	default:
		die("unknown data center: {$opts['p']}\n$USAGE");
}

$hostname = $opts['h'] ? $opts['h'] : $opts['f'];
$filedir = $opts['h'] ? sys_get_temp_dir() . '/' : "";

// Step 1) Hit production to get the dbname and cluster
if ( array_key_exists('h', $opts) || array_key_exists ('f', $opts) ) {
	if (stripos($hostname, "wikia.com") > 0) {
		// use full hostname given by user
		$url="http://$hostname/wiki/Special:Version";
	} else {
		// assume short name
		$url="http://$hostname.wikia.com/wiki/Special:Version";
	}
	print_r("Getting $url\n");
	$page = file_get_contents($url);
	if ($page) {
		$pattern = '/city_id: (\d+), cluster: c([1-9])/';
		preg_match($pattern, $page, $matches);
		$city_id = $matches[1];
		$cluster = strtr($matches[2], '123456', 'ABCDEF');
		$databaseDirectory = "database_$cluster";
		if ($cluster == 'F') {
			// FIXME
			$databaseDirectory = "database-f";
		}
		// just being lazy - easier to do this as a separate regex
		$pattern = '/wgDBname="(.*)"/';
		preg_match($pattern, $page, $matches);
		$dbname = $matches[1];

	} else {
		print_r("curl failed\n");
	}

	echo "Found city_id: $city_id dbname: $dbname cluster: $cluster\n";
	echo "Press enter to continue or Ctrl-C to abort.\n";
	$line = trim(fgets(STDIN));

}

// Fetch the backup from s3

if ( array_key_exists('h', $opts) || array_key_exists ('f', $opts) ) {
	echo "Fetching $dbname...\n";
	// first check to make sure s3cmd is available

	function getFile($databaseDirectory, $dbname, $filedir) {
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
				if (count($file_list) == 1) continue;
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

	$fullpath = getFile($databaseDirectory, $dbname, $filedir);
	$filename = basename($fullpath);
	if(empty($fullpath)) {
		exit;
	}

	// update wikicities variables from production database.  This is pretty gross. :)
	if ( file_exists( $dirName . "/../../../config/DB.php" ) ) {
		require_once( $dirName . "/../../../config/DB.php" );
	}

	if ( isset( $wgDBbackenduser, $wgDBbackendpassword, $wgLBFactoryConf['hostsByName']['sharedb-s4'] ) ) {
		// prepare raw output for consumption as csv. changes " => \"; \t => ","; beginning of line => ", end of line => "
		$prepareCsv = "sed 's/\"/\\\\\"/g;s/\\t/\",\"/g;s/^/\"/;s/$/\"/;s/\\n//g'";

		$dbhost = $wgLBFactoryConf['hostsByName']['sharedb-s4'];
	    // dump city_list row to local CSV file and import into local database
		$response = `mysql -u $wgDBbackenduser -p$wgDBbackendpassword --database wikicities -h $dbhost -ss -e "SELECT * from city_list where city_id = $city_id " | $prepareCsv > /tmp/city_list.csv`;
		print "city_list dump ok\n";
		$response = `mysqlimport -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxCentral --replace --fields-enclosed-by=\\" --fields-terminated-by=, --local wikicities /tmp/city_list.csv`;
		print $response;
		unlink ("/tmp/city_list.csv");
		// dump city_domains rows to local CSV file and improt into local database
		$response = `mysql -u $wgDBbackenduser -p$wgDBbackendpassword --database wikicities -h $dbhost -ss -e "SELECT * from city_domains where city_id = $city_id " | $prepareCsv > /tmp/city_domains.csv`;
		print "city_domains dump ok\n";
		$response = `mysqlimport -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxCentral --replace --fields-enclosed-by=\\" --fields-terminated-by=, --local wikicities /tmp/city_domains.csv`;
		print $response;
		unlink ("/tmp/city_domains.csv");
		// dump city_vars rows to local CVS file and import into local database
		$response = `mysql -u $wgDBbackenduser -p$wgDBbackendpassword --database wikicities -h $dbhost -ss -e "SELECT * from city_variables where cv_city_id = $city_id " | $prepareCsv > /tmp/city_variables.csv`;
		print "city_vars dump ok\n";
		$response = `mysqlimport -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxCentral --replace --fields-enclosed-by=\\" --fields-terminated-by=, --local wikicities /tmp/city_variables.csv`;
		print $response;
		unlink ("/tmp/city_variables.csv");

	} else {
		print "Error loading production database configuration\n";
	}

}

if ( array_key_exists('h', $opts) || array_key_exists ('i', $opts) ) {
	if (array_key_exists('i', $opts) && file_exists($opts['i'])) {
		$fullpath = $opts['i'];
		$filename = basename($opts['i']);
		preg_match("/^(.*).*.sql.gz/", $filename, $matches);
		if (count($matches) == 2) {
			$dbname = $matches[1];
		}
	}

	print("filename = $filename\n");
	print("fullpath = $fullpath\n");

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
	}
	unlink($fullpath);

}
