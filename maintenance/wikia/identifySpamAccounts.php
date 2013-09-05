<?php
/** 
 * @author Kenneth Kouot <kenneth@wikia-inc.com>
 * @description Job that queries the database to produce a list of all account ids associated with spamming
 * @usage SERVER_ID=177 php maintenance/wikia/identifySpamAccounts.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php
 */

ini_set( 'include_path', dirname(__FILE__) . '/../' );
require( 'commandLine.inc' );

// TODO: allow cli specification of output filename
$outputFilename = 'spamAccountIds.txt';
$output = fopen($outputFilename, 'w');
$stdOut = fopen('php://stdout', 'w');

fwrite($stdOut, "Running job to identify spam emails. Output will be logged in " . $outputFilename . ".\n");

// Connect to db containing wikicities table
$db = wfGetDb( DB_SLAVE, array(), $wgExternalSharedDB);

/*
 * Find all email accounts associated with over 700 emails
 * TODO: the number should not be hardcoded, but rather read in from an argv argument
 */
$res = $db->select(
 '`user`',
 array( 'user_email', 'user_real_name', 'count(*)' ),
 '',
 __METHOD__,
 array('HAVING count(*) > 700') // TODO: do not hardcore this value
);

$spammerEmails = array();

foreach($res as $row) {
 array_push($spammerEmails, $row->user_email);
}

// for each offending email account, find all the associated emails
foreach($spammerEmails as $email) {
 $res = $db->select(
	'`user`',
	array( 'user_id', 'user_email'),
	"user_email = '" . $email . "'",
	__METHOD__,
	array()
 );
}

$data = '';
foreach($res as $row) {
 $data .= $row->user_id. "\n"; 
}

fwrite($output, $data);
fwrite($stdOut, "Thank you, good bye.\n");
fclose($output);
fclose($stdOut);
