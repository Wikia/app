<?php
/**
 * Maintenance script for syncing events_local_users table (ListUsers)
 * Usage: php syncListUsers.php --wiki_id=12345
 */

	require_once('../commandLine.inc');

	$usage = "Usage: php syncListUsers.php --wiki_id=12345\n";

	if (!isset($options['wiki_id']) || (isset($options['wiki_id']) && !is_numeric($options['wiki_id'])))
		die("Error: Invalid format.\n".$usage);

	if (!empty($wgDevelEnvironment))
		die("Sorry. production only.\n");

	$wiki_id = $options['wiki_id'];
	$wiki = WikiFactory::getWikiById($wiki_id);
	if (!$wiki)
		die("Wiki $wiki_id not found.\n");

	// update events_local_users
	$dbname = $wiki->city_dbname;
	echo "Wiki: id=$wiki_id, dbname=$dbname\n";
	$cmd = sprintf( "perl /usr/wikia/backend/bin/scribe/events_local_users.pl --usedb={$dbname} " );
	echo "Running {$cmd}\n";
	$retval = wfShellExec($cmd, $status);
	echo "$retval\n";

	 // clear cache
	$wgMemc = wfGetMainCache();
	$memKey = WikiFactory::getVarsKey($wiki_id);
	echo "Clearing cache ($memKey).\n";
	$wgMemc->delete($memKey);
	echo "Successfully update list users (events_local_users table).\n";
