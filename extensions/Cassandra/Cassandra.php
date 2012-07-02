<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point\n" );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Cassandra',
	'version' => 0.1,
	'author' => 'Max Semenik',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Cassandra',
	'descriptionmsg' => 'cassandra-desc',
);
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Cassandra'] =  $dir . 'Cassandra.i18n.php';

$wgAutoloadClasses['ExternalStoreCassandra'] = $wgAutoloadClasses['MWCassandraException']
	= $dir . 'Cassandra_body.php';

if ( is_array( $wgExternalStores ) ) {
	$wgExternalStores[] = 'cassandra';
} else {
	$wgExternalStores = array( 'cassandra' );
}

/**
 * Extension settings
 */

// Directory where Thrift bindings for PHP reside
$wgThriftRoot = '/usr/share/php/Thrift';

// Port used for communicating with Cassandra. Must match <ThriftPort>
// in Cassandra's storage-conf.xml
$wgCassandraPort = 9160;

// Mapping of cluster names to lists of server IPs
// Example:
// $wgCassandraClusters = array( 
//     'foo' => array( '192.168.1.1', '192.168.1.2', ),
//     'bar' => array( 'somehostname' ),
// );
$wgCassandraClusters = array();

// String prepended to saved key names, can be used to distinct between
// different wikis, etc. Does not affect the already saved revisions.
$wgCassandraKeyPrefix = $wgDBname;

/**
 * Read and write consistencies, see http://wiki.apache.org/cassandra/API#ConsistencyLevel
 * for details.
 * Avoid using cassandra_ConsistencyLevel here to prevent large parts
 * of Cassandra and Thrift from being loaded on every request. Shouldn't
 * matter much for real-world setups with byte code cache though.
 */
$wgCassandraReadConsistency = 1;  // cassandra_ConsistencyLevel::ONE
$wgCassandraWriteConsistency = 1; // cassandra_ConsistencyLevel::ONE

// Column family to be used for storing data
$wgCassandraColumnFamily = 'Standard1';