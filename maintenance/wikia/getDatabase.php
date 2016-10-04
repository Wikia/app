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

define('S3CMD_CONFIG', '/etc/s3cmd/amazon_ro.cfg');

$dirName = dirname(__FILE__);

require_once( $dirName . "/../commandLine.inc" );

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
		$wgDBdevboxServer = 'master.db-dev-db.service.poz-dev.consul';
		break;
	case WIKIA_DC_SJC:
		$wgDBdevboxServer = 'master.db-dev-db.service.sjc-dev.consul';
		break;
	default:
		die("unknown data center: {$opts['p']}\n$USAGE");
}

// Get db credentials from production. This is pretty gross. :)
if ( file_exists( $dirName . "/../../../config/DB.php" ) ) {
	require_once( $dirName . "/../../../config/DB.php" );
}

if ( isset( $wgDBbackenduser, $wgDBbackendpassword, $wgDBdevboxUser, $wgDBdevboxPass ) ) {
	$prod = new mysqlwrapper($wgDBbackenduser, $wgDBbackendpassword, 'slave.db-sharedb.service.sjc.consul');
	$dev = new mysqlwrapper($wgDBdevboxUser, $wgDBdevboxPass, $wgDBdevboxServer);
} else {
	print "Error loading production database configuration\n";
	exit;
}

$hostname = $opts['h'] ? $opts['h'] : $opts['f'];
$filedir = $opts['h'] ? sys_get_temp_dir() . '/' : "";

// Step 1) Scrape production host to get the dbname and cluster
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
		if ( preg_match($pattern, $page, $matches) ) {
			$city_id = $matches[1];
			$clusterNumberParam = $matches[2];
		} else {
			echo "Wiki not found.\n";
			exit;
		}
		if ( $clusterNumberParam > 26 ) {
			echo "Clusters higher than 26 (Z letter) are not yet operated by this script. Time to update the script.\n";
			exit;
		}
		/* Map cluster numbers to letters
		 * 1->a, 2->b
		 * chr(65)=='A' */
		$clusterLetter = chr( 64 + $clusterNumberParam );
		$databaseDirectory = 'database-' . strtolower( $clusterLetter );
		// just being lazy - easier to do this as a separate regex
		$pattern = '/wgDBname="(.*)"/';
		preg_match($pattern, $page, $matches);
		$dbname = $matches[1];

	} else {
		print_r("curl failed\n");
	}

	echo "Found city_id: $city_id dbname: $dbname cluster: $clusterLetter\n";
	echo "Press enter to continue or Ctrl-C to abort.\n";
	$line = trim(fgets(STDIN));

}

// Step 2: Fetch the backup from s3

if ( array_key_exists('h', $opts) || array_key_exists ('f', $opts) ) {
	echo "Fetching $dbname...\n";
	// first check to make sure s3cmd is available

	function getFile($databaseDirectory, $dbname, $filedir) {
		$response = shell_exec("s3cmd --config=" . S3CMD_CONFIG . " ls s3://".$databaseDirectory."/fulldump* 2>&1");
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
				$response = shell_exec("s3cmd --config=" . S3CMD_CONFIG . " ls s3://".$databaseDirectory."/$dirname/".$dbname."_$date".".sql.gz");
				$file_list = explode("\n", $response);
				$file_list_count = count( $file_list ) - 1;
				echo "Found " . $file_list_count . " items...\n";
				if ( $file_list_count == 0 ) {
					continue;
				}
				foreach ($file_list as $file) {
					$regs = array();
					$file = preg_split('/\s+/' ,$file);
					$file = $file[3];
					if(strpos($file, $dbname.".sql.gz") > 0 || strpos($file, $dbname."_") > 0 ) {
						$filename = $filedir.$dbname.".sql.gz";

						echo "Found a match: $file\n";
								echo "Saving to local filesystem:".$filename."\n";
						shell_exec("s3cmd --config=" . S3CMD_CONFIG . " get --skip-existing ".$file." ".$filename);
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

	// Step 3: import wikicities variables from production database.
	// copy tables city_list, city_domains, city_variables_pool and city_variables
	$file = "/tmp/city_list.csv";
	$prod->csv("SELECT * from city_list where city_id = $city_id", $file);
	$dev->import($file);

	$file = "/tmp/city_domains.csv";
	$prod->csv("SELECT * from city_domains where city_id = $city_id", $file);
	$dev->import($file);

	$fileprod = "/tmp/city_variables_pool-prod.csv";
	$prod->csv("SELECT * from city_variables_pool where cv_id in (select cv_variable_id from city_variables where cv_city_id = $city_id)", $fileprod);

	$filedev = "/tmp/city_variables_pool-dev.csv";
	$dev->csv("SELECT * from city_variables_pool", $filedev);

	$file = "/tmp/city_variables_pool.csv";
	(new variablediff())->diff($fileprod, $filedev, $file);
	$dev->import($file);
	unlink($fileprod);
	unlink($filedev);
	unlink($file);

	$file = "/tmp/city_variables.csv";
	$prod->csv("SELECT * from city_variables where cv_city_id = $city_id", $file);
	$dev->import($file);

}

if ( array_key_exists('h', $opts) || array_key_exists ('i', $opts) ) {
	// If .sql.gz file was specified on command line, use that
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

	echo "That database is supposed to live on server:" . $wgDBdevboxServer . "\n";

	// Step 4: Now we create the database on the relevant server
	$dev->sql("CREATE DATABASE IF NOT EXISTS $dbname");
	if(trim($dev->response) != ""){
		print "CREATE DATABASE attempt returned the error:\n$dev->response\n";
	} else {
		print "\"$dbname\" created on \"$wgDBdevboxServer\".\n";
	}

	print "Loading \"$fullpath\" into \"$wgDBdevboxServer\"...\n";
	$dev->zcat($fullpath, $dbname);
	if(trim($dev->response) != ""){
		print "Error loading the database dump into $wgDBdevboxServer:\n$dev->response\n";
	} else {
		print "Database loaded successfully!\n";
	}
	unlink($fullpath);

}

// Simple mysql commandline wrapper helper
class mysqlwrapper {
	public $response;
	function __construct($dbuser, $dbpass, $dbserver) {
		$this->creds = "-u {$dbuser} -p{$dbpass} -h {$dbserver}";
	}
	// invoke mysql command line to run arbitrary sql statement
	function sql($sql) {
		$this->response = `mysql {$this->creds} -e "$sql" 2>&1`;
	}
	// invoke mysql and pipe to csv file
	function csv($sql, $filename) {
		$prepareCsv = "sed 's/\"/\\\\\"/g;s/\\t/\",\"/g;s/^/\"/;s/$/\"/;s/\\n//g'";
		$this->response = `mysql {$this->creds} --database wikicities -ss -e "$sql" | $prepareCsv > $filename`;
		print "Dump $filename\n";
	}
	// mysqlimport from csv file to mysql
	function import($filename) {
		$this->response = `mysqlimport {$this->creds} --replace --fields-enclosed-by=\\" --fields-terminated-by=, --local wikicities $filename`;
		print "Import {$this->response}";
		unlink ($filename);
	}
	// cat from SQL gz file to mysql
	function zcat($fullpath, $dbname) {
		$source = "zcat $fullpath";
		if (is_executable("/usr/bin/bar"))
			$source = "cat $fullpath | bar | zcat";
		$this->response = `$source | mysql {$this->creds} $dbname 2>&1`;

		$this->response = trim(str_replace('Warning: Using a password on the command line interface can be insecure.', '', $this->response));

	}
}


class variablediff {
	function diff( $prod_csv, $dev_csv, $out_csv ) {
		$prodvars = $this->loadcsv($prod_csv);
		$devvars = $this->loadcsv($dev_csv);

		$diff = [];
		foreach ($prodvars as $k => $prodvar){
			// ...[1] = var name
			if ( !isset($devvars[$k]) || $devvars[$k][1] != $prodvar[1] ) {
				$diff[] = $prodvar;
			}
		}

		$this->savecsv($out_csv, $diff);
	}
	private function loadcsv( $filename ) {
		$fp = fopen($filename,'rb');
		$out = [];
		while ($row = fgetcsv($fp,0,',','"')) {
			$out[$row[0]] = $row;
		}
		fclose($fp);
		return $out;
	}

	private function savecsv( $filename, $data ) {
		$fp = fopen($filename,'wb');
		foreach ($data as $row) {
			fputcsv($fp, $row, ',', '"');
		}
		fclose($fp);
	}

}
