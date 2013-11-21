<?php
/**
 * @usage: sudo -u www-data SERVER_ID=177 php videoPostmigrateUndo.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: sudo -u www-data SERVER_ID=177 php videoPostmigrateUndo.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */
ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
global $IP, $wgCityId, $wgExternalDatawareDB;
#$IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
#echo( "$IP\n" );

echo( "Postmigration undo script running for $wgCityId\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php videoPostmigrateUndo.php\n" );
	exit( 0 );
}

//include( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );


$rows = $dbw_dataware->select(
	'video_postmigrate_undo',
	array('id','entry_id','entry_id_field','entry_ns_field','entry_table'),
	array('wiki_id'=>$wgCityId),
	__METHOD__
);

	
while( $row = $dbw_dataware->fetchObject($rows) ) {
	$table = $row->entry_table;
	$id = $row->entry_id;
	$idField = $row->entry_id_field;
	$nsField = $row->entry_ns_field;
	echo "	Undo on\t$table\tid:\t$id\n";
	$dbw->update($table,
		array( $nsField => 400 ),
		array( $idField => $id ),
		__METHOD__
	);
	$dbw_dataware->delete(
		'video_postmigrate_undo',
		array('id' => $row->id),
		__METHOD__
	);

}

$dbw->freeResult($rows);


echo "Done updating tables\n";
echo "Flipping the switch\n";

WikiFactory::setVarByName('wgVideoHandlersVideosMigrated', $wgCityId, false);

echo "Done\n";


?>
