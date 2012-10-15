<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

global $wgThriftRoot, $wgAutoloadClasses;
$GLOBALS['THRIFT_ROOT'] = $wgThriftRoot;

require_once( $GLOBALS['THRIFT_ROOT'] . '/Thrift.php' );

$thriftAutoloads = array(
	'TBinaryProtocolAccelerated' => '/protocol/TBinaryProtocol.php',
	'TProtocol' => '/protocol/TProtocol.php',
	'TProtocolFactory' => '/protocol/TProtocol.php',
	'TBinaryProtocol' => '/protocol/TBinaryProtocol.php',
	'TBufferedTransport' => '/transport/TBufferedTransport.php',
	'TFramedTransport' => '/transport/TFramedTransport.php',
	'THttpClient' => '/transport/THttpClient.php',
	'TNullTransport' => '/transport/TNullTransport.php',
	'TPhpStream' => '/transport/TPhpStream.php',
	'TSocket' => '/transport/TSocket.php',
	'TSocketPool' => '/transport/TSocketPool.php',
	'TTransport' => '/transport/TTransport.php',
	);

foreach ( $thriftAutoloads as $class => $file ) {
	$wgAutoloadClasses[$class] = $wgThriftRoot . $file;
}

require_once( dirname( __FILE__ ) . '/lib/Cassandra.php' );

class ExternalStoreCassandra {
	private $keyspace, $socket, $client;
	
	public function store( $cluster, $data ) {
		global $wgCassandraKeyPrefix, $wgCassandraWriteConsistency, $wgCassandraColumnFamily;

		try {
			$this->connect( $cluster );
			$key = $wgCassandraKeyPrefix . sha1( $data );

			$columnPath = new cassandra_ColumnPath();
			$columnPath->column = 'data';
			$columnPath->super_column = null;
			$columnPath->column_family = $wgCassandraColumnFamily;

			$this->client->insert( $this->keyspace, $key, $columnPath, $data, time(), $wgCassandraWriteConsistency );
			return "cassandra://$cluster/$key";
		} catch ( TException $e ) {
			throw new MWCassandraException( $e );
		}
	}

	function fetchFromURL( $url ) {
		global $wgCassandraReadConsistency, $wgCassandraColumnFamily;

		$this->connect( $url );

		try {
			$splitted = explode( '/', $url );
			$key = end( $splitted );

			$columnParent = new cassandra_ColumnParent();
			$columnParent->column_family = $wgCassandraColumnFamily;
			$columnParent->super_column = null;
			
			$sliceRange = new cassandra_SliceRange();
			$sliceRange->start = "";
			$sliceRange->finish = "";
			$predicate = new cassandra_SlicePredicate();
			$predicate->slice_range = $sliceRange;
			
			$result = $this->client->get_slice( $this->keyspace, $key, $columnParent, $predicate, $wgCassandraReadConsistency );
			if ( empty ( $result ) ) {
				return false;
			}
			
			return $result[0]->column->value;
		} catch ( TException $e ) {
			throw new MWCassandraException( $e );
		}
	}

	private function connect( $cluster ) {
		global $wgCassandraPort, $wgCassandraClusters;

		$cluster = str_replace( 'cassandra://', '', $cluster );
		list( $cluster, $this->keyspace ) = explode( '/', $cluster );
		
		if ( isset( $wgCassandraClusters[$cluster] ) ) {
			$hosts = $wgCassandraClusters[$cluster];
			$host = $hosts[mt_rand( 0, count( $hosts ) - 1 )];
		} else {
			$host = $cluster;
		}

		try {
			$this->socket = new TSocket( $host, $wgCassandraPort );
			$this->transport = new TBufferedTransport( $this->socket, 1024, 1024 );
			$this->protocol = new TBinaryProtocolAccelerated( $this->transport );
			$this->client = new CassandraClient( $this->protocol );
			$this->transport->open();
		} catch ( TException $e ) {
			throw new MWCassandraException( $e );
		}
	}
}

/**
 * Wrapper exception for better handling in MW
 */
class MWCassandraException extends MWException {
	public $innerException;
	
	public function __construct( TException $e ) {
		$this->innerException = $e;
		parent::__construct( 'Cassandra error ' . get_class( $e ) . ': ' . $e->getMessage()
			. "\n\nStack trace: " . $e->getTraceAsString()
		);
	}
}
