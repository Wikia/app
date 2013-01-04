<?php
/**
 * One-off script to populate the new IP column in the Phalanx table
 *
 * @author grunny
 */
require(  __DIR__ . '/../../../../maintenance/commandLine.inc'  );

$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

$dbResult = $dbr->select(
	array( 'phalanx' ),
	array( '*' ),
	array(
		'p_type & 8 = 8',
		'p_lang IS NULL'
	),
	__METHOD__
);

$toUpdate = array();

while ( $row = $dbr->fetchObject( $dbResult ) ) {
	if ( User::isIP( $row->p_text ) ) {
		$toUpdate[$row->p_id] = IP::toHex( $row->p_text );
	}
}
$dbr->freeResult( $dbResult );
$dbr->close();

$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

$failedFilters = array();

foreach ( $toUpdate as $phalId => $ipHex ) {
	$res = (boolean)$dbw->update(
		'phalanx',
		array(
			'p_ip_hex' => $ipHex
		),
		array(
			'p_id' => $phalId
		)
	);
	if ( !$res ) {
		$failedFilters[] = $phalId;
	}
}
$dbw->close();

echo "Done\n";
echo count( $failedFilters ) . " failed to be updated!\n";

exit( 0 );
