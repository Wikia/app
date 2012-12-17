<?php

require(  __DIR__ . '/../../../../maintenance/commandLine.inc'  );

$dbr = wfGetDB( DB_SLAVE );

$messageId = $args[0];

$sqlValues = array();

$dbResult = $dbr->select(
	array( 'revision' ),
	array( 'rev_user' ),
	'',
	__METHOD__,
	array( 'GROUP BY' => 'rev_user' )
);

while ( $row = $dbr->fetchObject( $dbResult ) ) {
	$sqlValues[] = array(
		'msg_wiki_id' => $wgCityId,
		'msg_recipient_id' => $row->rev_user,
		'msg_id' => $messageId,
		'msg_status' => 0
	);
}
$dbr->freeResult( $dbResult );

$insertResult = false;

if ( count( $sqlValues ) ) {
	$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
	$insertResult = (boolean)$dbw->insert(
		'messages_status',
		$sqlValues
	);
} else {
	print "No active users found on wiki.\n";
	exit( 1 );
}

if ( $insertResult ) {
	print "Insert succeeded\n";
} else {
	print "Insert failed\n";
	exit( 1 );
}
exit( 0 );