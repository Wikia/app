<?php
/**
 * @usage: SERVER_ID=177 php videoPostmigrate.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoPostmigrate.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */
ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../commandLine.inc' );
global $IP, $wgCityId, $wgExternalDatawareDB;
$IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
echo( "$IP\n" );
echo( "Premigration script running for $wgCityId\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php videoPremigrate.php\n" );
	exit( 0 );
}

//include( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );

$tables = array(
	'archive' => array('ns'=>'ar_namespace','id'=>'ar_page_id'),
	'cu_changes' => array('ns'=>'cuc_namespace','id'=>'cuc_id'),
	'hidden' => array('ns'=>'hidden_namespace','id'=>'hidden_page'),
	'logging' => array('ns'=>'log_namespace','id'=>'log_id'),
	'page' => array('ns'=>'page_namespace','id'=>'page_id'),
	'pagelinks' => array('ns'=>'pl_namespace','id'=>'pl_from'),
	'protected_titles' => array('ns'=>'pt_namespace','id'=>'title'),
	'recentchanges' => array('ns'=>'rc_namespace','id'=>'rc_id'),
);



foreach( $tables as $tableName => $tableData ) {
	echo( "Processing $tableName\n" );

	$rows = $dbw->select($tableName, 
			array( $tableData['id'] ),
			array( $tableData['ns'] => 400 ),
			__METHOD__
	);
		
	while( $row = $dbw->fetchObject($rows) ) {
		$idField = $tableData['id'];
		$id = $row->$idField;
		echo "  row $idField => $id\n";
		$dbw->update($tableName,
			array( $tableData['ns'] => 6 ),
			array( $tableData['id'] => $id ),
			__METHOD__
		);
	}

	$dbw->freeResult($rows);
}

echo "Done updating tables\n";
echo "Flipping the switch\n";

#WikiFactory::setVarByName('wgVideoHandlersVideosMigrated', $wgCityId, true);

echo "Done\n";


?>
