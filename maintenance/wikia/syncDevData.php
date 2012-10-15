<?php

/**
 * @author Garth Webb
 *
 * This is an internal use only script for syncing database backups from Amazon S3
 * Its based on the getDatabase.php script that Owen and Tomasz wrote.
 *
 */
 
$wgDBdevboxUser = 'devbox';
$wgDBdevboxPass = 'devbox';
$wgDBdevboxServer1 = 'dev-db-a1';
$wgDBdevboxServer2 = 'dev-db-b1';
$wgControlPageID = 6741;
$wgDatabaseDirectories = array ("database_A", "database_B", "database_C");

$USAGE = "Usage:\tphp syncDevData.php\n";

$wikis = what_to_sync();

find_dumps(&$wikis);

foreach ($wikis as $name => $detail) {
	echo "\n== Importing new content for $name ==\n";

	// See if the dump is newer and if not skip it
	if (!needs_update($name, $detail)) continue;

	$file = save_dump($name, $detail);
	import_dump($name, $detail, $file);
}

/******************************************************************************/

function what_to_sync () {
	global $wgDBdevboxServer2, $wgDBdevboxUser, $wgDBdevboxPass, $wgControlPageID;

	// DBs to sync are reprented as links from page $wgControlPageID.  The
	// pages don't have exist and just have to be named Sync:DBNAME
	$response = `mysql -h$wgDBdevboxServer2 -u$wgDBdevboxUser -p$wgDBdevboxPass devbox -s -N -e "select pl_title from pagelinks where pl_from = $wgControlPageID"`;
	
	// Skip any links that don't start with Sync: and strip the Sync: off the
	// links that do match
	$dbnames = array();
	foreach (explode("\n", $response) as $name) {
		if (preg_match('/^Sync:(.+)$/', $name, $matches)) {
			$dbnames[$matches[1]] = array();
		}
	}

	return $dbnames;
}

function find_dumps (&$wikis) {
	global $wgDatabaseDirectories;
	
	// Search for the most recent dump files in the top level buckets
	foreach ($wgDatabaseDirectories as $databaseDirectory) {
		echo "== Searching $databaseDirectory ...\n";
	
		$response = shell_exec("s3cmd ls s3://".$databaseDirectory."/fulldump* 2>&1");
		if (preg_match('/ERROR/', $response) || preg_match ('/command not found/', $response)) {
			// some kind of error, print and die
			exit($response);
		}
		
		// Get the directory list
		$dir_list = explode("\n", $response);
		
		// Iterate through each dump directory in this bucket
		foreach ($dir_list as $dir_entry) {
			if (!preg_match('/^\s+DIR\s+(\S+)/', $dir_entry, $matches)) continue;
			$dir = $matches[1];
		
			echo "\tSearching dir '$dir'\n";
			
			if (preg_match('/fulldump_(\d+)\.(\d+)\.(\d+)/', $dir, $matches)) {
				$dir_date = '20'.$matches[3].'-'.$matches[2].'-'.$matches[1].' 00:00:00';
			} else if (preg_match('/fulldump_((\d+)-(\d+)-(\d+))/', $dir, $matches)) {
				$dir_date = $matches[4].' 00:00:00';
			} else {
				// The far future!
				$dir_date = '3000-01-01 00:00:00';
			}
		
			// In each dump directory see if our dbname exists
			foreach (array_keys($wikis) as $dbname) {
				# Skip checking here if we've already found a dump from a later date
				if ($wikis[$dbname]["ts"] && strcmp($wikis[$dbname]["ts"], $dir_date) > 0) continue;
			
				$path = $dir.$dbname."*";
				
				echo "\t\tChecking for $path\n";
				
				$response = shell_exec("s3cmd ls $path");

				// If we have a response it means it found a dump for our dbname
				if ($response) {
					foreach (explode("\n", $response) as $line) {
						// Looks like:
						// 2010-08-31 02:03     74744   s3://database_A/fulldump_30.08.10/superheros.sql.gz
						preg_match("!^(\d+-\d+-\d+\s+\d+:\d+)\s+(\d+)\s+(${dir}${dbname}[\._].+)$!", $line, $matches);
						
						$time = $matches[1];
						$size = $matches[2];
						$file = $matches[3];

						// If the above didn't find us file, skip this one
						if (trim($file) == "") continue;

						// See if this file is the most recent and if so use it
						if (!$wikis[$dbname]["ts"] || strcmp($time, $wikis[$dbname]["ts"]) == 1) {
							echo "\t\t*** FOUND: $time / $file / $size  ***\n";
							$wikis[$dbname]["ts"]   = $time;
							$wikis[$dbname]["file"] = $file;
							$wikis[$dbname]["size"] = $size;
						}
					}
				}
			}
		}
	}
}

function needs_update ($dbname, $detail) {
	global $wgDBdevboxServer2, $wgDBdevboxUser, $wgDBdevboxPass;
	
	$cluster = find_cluster($dbname);
	$response = `mysql -h$cluster -u$wgDBdevboxUser -p$wgDBdevboxPass $dbname -sNe "select file from _dev_last_update order by ts desc limit 1" 2>&1`;
	
	// If there's any problem with this table just assume it hasn't been created and we need an update
	if (preg_match('/ERROR/', $response)) return true;

	if (strcmp(trim($response), $detail["file"]) == 0) {
		return false;
	} else {
		return true;
	}
}

function save_dump ($dbname, $detail) {
	echo "\tSaving dump file\n";
	echo "\t\tFile: ".$detail["file"]."\n";
	echo "\t\tSize: ".$detail["size"]."\n";
	echo "\t\tTime: ".$detail["ts"]."\n";
	
	$dump_file = "/tmp/$dbname.sql.gz";
	
	$start_time = time();
	echo "\tDownloading dump ... ";
	shell_exec('s3cmd get --skip-existing '.$detail['file'].' '.$dump_file);
	$end_time = time();
	
	echo "done (".($end_time - $start_time)."s)\n";

	return $dump_file;
}

function import_dump ($dbname, $detail, $file) {
	global $wgDBdevboxUser, $wgDBdevboxPass;

	echo "\n\tImporting dump file $file\n";

	$cluster = find_cluster($dbname);
	
	$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $cluster -e "CREATE DATABASE IF NOT EXISTS $dbname" 2>&1`;
	if (trim($response) != ""){
		print "\t\tCREATE DATABASE attempt returned the error:\n$response\n";
		return;
	} else {
		print "\t\tCreated '$dbname' on '$cluster'\n";
	}

	print "\n\tLoading '$file' into '$cluster'...\n";
	
	$response = `zcat $file | mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $cluster $dbname 2>&1`;
	if (trim($response) != ""){
		print "\t\tError loading the database dump into $cluster:\n$response\n";
		return;
	} else {
		print "\t\tDatabase loaded successfully!\n";
	}
	
	$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $cluster $dbname -e "create table if not exists _dev_last_update (file varchar(255), ts timestamp default current_timestamp)"`;
	
	$s3file = $detail["file"];
	$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $cluster $dbname -e "insert into _dev_last_update set file = '$s3file'"`;
}

function find_cluster ($dbname) {
	global $wgDBdevboxServer1, $wgDBdevboxServer2, $wgDBdevboxUser, $wgDBdevboxPass;
	
	$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPass -h $wgDBdevboxServer1 -sNe "SELECT city_cluster from wikicities.city_list where city_dbname = '$dbname';" 2>&1`;
	
	if (trim($response) != "" && substr($response, 0, 5) != 'ERROR') {
		$cluster_name = trim($response);
	} else {
		die ("Database error: " . $response);
	}

	if (!$cluster_name || $cluster_name == "NULL") {
		return $wgDBdevboxServer1;
	} else {
		return $wgDBdevboxServer2;
	}
}

// Compare dates in dmy format, descending
function cmp_dmy ($a, $b) {
	preg_match('/(\d+)\.(\d+)\.(\d+)/', $a, $match_a);
	preg_match('/(\d+)\.(\d+)\.(\d+)/', $b, $match_b);
	
	$cmp = strcmp($match_b[3], $match_a[3]);
	if ($cmp == 0) {
		$cmp = strcmp($match_b[2], $match_a[2]);
		if ($cmp == 0) {
			$cmp = strcmp($match_b[1], $match_a[1]);
		}
	}
	
	return $cmp;
}
