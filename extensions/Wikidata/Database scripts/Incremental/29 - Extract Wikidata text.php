<?php
	define('MEDIAWIKI',true);
	require_once('../../../../LocalSettings.php');
	require_once('ProfilerStub.php');
	require_once('Setup.php');

	echo "try";

	ob_end_flush();

	global $wgCommandLineMode;
	$wgCommandLineMode = true;

	$dbr =& wfGetDB(DB_MASTER);


	$sql = 'select old_id,old_text from text,uw_translated_content where uw_translated_content.text_id=text.old_id';
	$res=$dbr->query($sql);
	while ($row = $dbr->fetchObject($res)) {
		$qt=$dbr->addQuotes($row->old_text);
		$isql='insert into uw_text(text_id,text_text) values('.$row->old_id.','.$qt.');';
		$res2=$dbr->query($isql);
	}
	$dbr->freeResult($res);

	$dbr->query('INSERT INTO script_log (time, script_name) ' .
				'VALUES ('. wfTimestampNow() . ',' . $dbr->addQuotes('29 - Extract Wikidata text.php') . ')');
