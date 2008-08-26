<?php
//	ini_set('mysql.default_socket','/var/run/mysqld/mysqld.sock');
	define('MEDIAWIKI',true);
	require_once('../../../../LocalSettings.php');
	require_once('ProfilerStub.php');
	require_once('Setup.php');
	# Which dataset to generate page titles for
	$dc='sp';
	ob_end_flush();

	global $wgCommandLineMode;
	$wgCommandLineMode = true;

	$dbr =& wfGetDB(DB_MASTER);
	echo("Inserting page titles for expressions ...\n");
	$sql = 'select spelling from '.$dc.'_expression_ns';
	$res=$dbr->query($sql);
	while ($row = $dbr->fetchObject($res)) {
		$page=$row->spelling;
		$page=trim($page);
		$page=str_replace(" ","_",$page);		
		$isql='insert ignore into page(page_title,page_namespace) values("'.addslashes($page).'",16);';
		$res2=$dbr->query($isql);

	}
	$dbr->freeResult($res);
	
	echo("Inserting page titles for DefinedMeanings ...\n");
	$sql = "select spelling,defined_meaning_id from {$dc}_defined_meaning, {$dc}_expression_ns where {$dc}_defined_meaning.expression_id={$dc}_expression_ns.expression_id";
	$res=$dbr->query($sql);
	while ($row = $dbr->fetchObject($res)) {
		$page=$row->spelling;
		$page=trim($page);
		$page=str_replace(" ","_",$page);		
		$page.="_(".$row->defined_meaning_id.")";
		$isql='insert ignore into page(page_title,page_namespace) values("'.addslashes($page).'",24);';
		$res2=$dbr->query($isql);

	}
	$dbr->freeResult($res);
				

?>