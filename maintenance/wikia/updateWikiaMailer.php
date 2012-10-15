<?php

/**
 * Test email
 */

require_once( dirname(__FILE__)."/../commandLine.inc" );

$dbw = wfGetDB( DB_MASTER, array(), 'wikia_mailer' );
$dbr = wfGetDB( DB_SLAVE, array(), 'wikia_mailer' );

echo "== Selecting rows where 'subj' is not set ... ";
$res = $dbr->select( 'mail',
					 array( 'id', 'hdr' ),
					 array( 'subj IS NULL' ),
					 '',
					 array()
				   );
echo "done\n";

echo "== Updating rows with subject ";
while ($row = $dbr->fetchObject($res)) {
	echo ".";

	$hdr = $row->hdr;
	preg_match('/Subject: (.+)/', $hdr, $matches);
	$subj = $matches[1];
	if (!isset($subj)) next;

	$dbw->update( 'mail',
				  array( 'subj' => $subj ),
				  array( 'id' => $row->id )
				);
}

echo " done\n";