<?php

require_once(dirname(__FILE__) . '/../commandLine.inc');

$time_start = microtime(true);

if ( isset( $options['user'] ) )  $user = $options['user'];
if ( isset( $options['oldtitle'] ) ) $oldtitle = $options['oldtitle'];
if ( isset( $options['newtitle'] ) ) $newtitle = $options['newtitle'];

if ( !isset($user) && !isset($newtitle) && !isset($oldtitle) ) {
	echo "Invalid parameters \n";
	echo "Use: --user USERNAME --oldtitle OLDTITLE --newtitle NEWTITLE \n";
	exit(0);
}

$dbr = wfGetDB(DB_SLAVE);

echo "read all articles for '$oldtitle/%' \n";
$data = $dbr->select(
	array('page'),
	array("page_id", "page_namespace", "page_title", "concat('$newtitle', SUBSTRING(page_title, length('$oldtitle') + 1)) as new_page_title"),
	array("page_title like '$oldtitle/%'", "page_title like '%@comment%'"),
	__METHOD__
);
$pages = array();
while ($row = $dbr->fetchObject($data)) {
	$pages[] = array( 'ns' => $row->page_namespace, 'oldtitle' => $row->page_title, 'newtitle' => $row->new_page_title );
}
$dbr->FreeResult($data);

if ( !empty($pages) ) {
	foreach ( $pages as $page ) {
		$sCommand  = "SERVER_ID={$wgCityId} php $IP/maintenance/wikia/moveOn.php ";
		$sCommand .= "--u " . $user . " ";
		$sCommand .= "--ot " . escapeshellarg($page['oldtitle']) . " ";
		$sCommand .= "--on " . $page['ns'] . " ";
		$sCommand .= "--nt " . escapeshellarg($page['newtitle']) . " ";
		$sCommand .= "--nn " . $page['ns'] . " ";
		$sCommand .= "--conf $wgWikiaLocalSettingsPath";

		$log = wfShellExec( $sCommand, $retval );
		if ($retval) {
			echo "Error code returned: $retval, Error was: $log \n";
		}
		else {
			echo "Done: $log \n";
		}		
	}
}

$time = microtime(true) - $time_start;
echo "\n-- Execution time: $time seconds\n";
