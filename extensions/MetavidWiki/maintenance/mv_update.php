<?
//eventually should fix to use mediaWiki format 
//for now just has little scripts for doing database operations 

//include commandLine.inc from the mediaWiki maintance dir: 
require_once ('../../../maintenance/commandLine.inc');

$dbclass = 'Database' . ucfirst( $wgDBtype ) ;
# Attempt to connect to the database as a privileged user
# This will vomit up an error if there are permissions problems
$wgDatabase = new $dbclass( $wgDBserver, $wgDBadminuser, $wgDBadminpassword, $wgDBname, 1 );


//do mvd_index text removal update:
//check if mvd_index has text field
$page_id_added=false; 
if(!$wgDatabase->fieldExists($mvIndexTableName, 'page_id')){
	print "$mvIndexTableName missing `page_id`...adding\n ";
	$page_id_added=true;
	//add page_id 
	$wgDatabase->query("ALTER TABLE `$mvIndexTableName` ADD `mv_page_id` INT( 10 ) UNSIGNED NOT NULL AFTER `id`");
}
//if we added do lookups 
if($page_id_added){
	$sql = "SELECT SQL_CALC_FOUND_ROWS `id`, `wiki_title` FROM `$mvIndexTableName`";
	$result = $wgDatabase->query($sql);
	echo 'updating '.$wgDatabase->numRows($result) . " mvd rows \n";
	$c = $wgDatabase->numRows($result);
	$i=$j=0;
	$page_table =  $wgDatabase->tableName( 'page' );
	while($mvd_row = $wgDatabase->fetchObject( $result )){		
		$sql_pid = "SELECT `page_id` FROM $page_table " .
			"WHERE `page_title`='{$mvd_row->wiki_title}' " .
			"AND `page_namespace`=".MV_NS_MVD.' LIMIT 1';
		$pid_res = 	$wgDatabase->query($sql_pid);
		if($wgDatabase->numRows($pid_res)!=0){
			$pid_row = 	 $wgDatabase->fetchObject($pid_res);
			$upSql = "UPDATE `$mvIndexTableName` SET `mv_page_id`=$pid_row->page_id " .
					"WHERE `id`={$mvd_row->id} LIMIT 1";
			$wgDatabase->query($upSql);
		}else{
			print "ERROR: mvd row:{$mvd_row->wiki_title} missing page (removed)\n ";
			$wgDatabase->query("DELETE FROM `$mvIndexTableName` WHERE `id`=".$mvd_row->id.' LIMIT 1');
			//die;
		}
		//status updates:
		if($i==100){
			print "on $j of  $c mvd rows\n";
			$i=0;
		}
		$i++;
		$j++;					 	
	}
	//now we can drop id and add PRIMARY to mv_page_id
	print "DROP id COLUMN from $mvIndexTableName ...";	
	$wgDatabase->query("ALTER TABLE `$mvIndexTableName` DROP PRIMARY KEY, DROP COLUMN `id`, DROP COLUMN `text`");
	print "done\n";
	
	//now add UNIQUE to mv_mvd_index
	print "ADD PRIMARY to mv_page_id ..."; 
	$wgDatabase->query("ALTER TABLE `$mvIndexTableName` ADD PRIMARY KEY(`mv_page_id`)");
	print "done\n";
	
}

?>