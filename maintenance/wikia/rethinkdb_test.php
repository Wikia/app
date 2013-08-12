<?php
/**
 * Some tests of RethinkDB
 *
 * @author moli@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set( "memory_limit", '1024M' );

ini_set('include_path',ini_get('include_path').':' . dirname( __FILE__ ) . '/../../lib/vendor/php-rql:'); 

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );
require_once( dirname( __FILE__ ) . '/../../lib/vendor/php-rql/rdb/rdb.php' );

class RethinkDBTest extends Maintenance {
	private $host = "dev-moli";
	private $port = "28015";
	private $db = "links";
	private $table = "categorylinks";
	private $datacenter = "devbox";
	private $durability = 'hard';
	private $cache_size = 1024;
	
	private $mysql_table = 'categorylinks_test';
	private $mysql_db = 'wikia';
	
	private $conn = null;
	
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Test RethinkDB performance.";
		$this->addOption( 'search', 'Search text in table', false, true, 't' );
		$this->addOption( 'insert', 'Insert data to NoSQL DB', false, false, 'i' );
		$this->addOption( 'delete', 'Delete X records from DB', false, false, 'r' );
		$this->addOption( 'update', 'Update record', false, true, 'u' );
		$this->addOption( 'drop', 'Drop table', false, false, 'd' );
		$this->addOption( 'create', 'Create table', false, false, 'c' );
		$this->addOption( 'count', 'Count documents', false, false );
		$this->addOption( 'info', 'Info about table', false, false );
		$this->addOption( 'package', 'Number of records in one package', false, true );
		$this->addOption( 'limit', 'Limit result', false, true );
		$this->addOption( 'durability', 'Hard or soft durability', false, true );
		$this->addOption( 'cache_size', 'Size of cache', false, true );
	}

	public function execute() {
		global $wgContentNamespaces;
		$insert = $this->hasOption( 'insert' );
		$delete = $this->hasOption( 'delete' );
		$update = $this->getOption( 'update', '' );
		$search = $this->getOption( 'search', '' );
		$drop = $this->hasOption( 'drop' );
		$create = $this->hasOption( 'create' );
		$count = $this->hasOption( 'count' );
		$info = $this->hasOption( 'info' );
		$package = $this->getOption( 'package', 100 );
		$limit = $this->getOption( 'limit', 100000 );
		$this->cache_size = $this->getOption( 'cache_size', $this->cache_size );
		$this->durability = $this->getOption( 'durability', 'hard' );
		
		$this->output( "Use " . r\systemInfo() . "\r\n" );
		
		if ( !empty( $insert ) ) {
			$this->output( "Read data from categorylinks and page table ...\r\n " );
			$start = microtime( true );
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'page', 'categorylinks' ),
				array( 'page_id', 'page_title', 'page_namespace', 'cl_to', 'cl_type', 'cl_timestamp', 'cl_sortkey' ),
				array(
					'page_namespace' => $wgContentNamespaces,
				),
				__METHOD__,
				array( 'LIMIT' => $limit ),
				array( 'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ) )
			);

			$data = array();
			$i = 1;
			$y = 0;
			while ( $row = $dbr->fetchObject($res) ) {
				if ( ( $i % $package ) == 0 ) {
					$y++;
				}
				$data[ $y ][] = array(
					'id'    => $i,
					'cl_to'    => $row->cl_to,
					'cl_title' => $row->page_title,
					'cl_pid'   => $row->page_id,
					'cl_ns'    => $row->page_namespace,
					'cl_type'  => $row->cl_type,
					'cl_ts'    => $row->cl_timestamp,
					'cl_sort'  => $row->cl_sortkey
				);
				$i++;
			}
			$dbr->freeResult($res);
			$delta = microtime( true ) - $start;
			$this->output( sprintf( "Loaded %d packages with %d records in %0.2f secs\r\n", count( $data ), $i, $delta ) );
			
			$this->output( "Put data to RethinkDB database\r\n" ); 
			$this->db_insert( $data );
		} elseif ( !empty( $delete ) ) {
			$this->output( "Delete data from RethinkDB\r\n" );
			$this->db_delete( );
		} elseif ( !empty( $update ) ) {
			$this->output( "Update data in RethinkDB\r\n" );
			list( $key, $value ) = explode( "=", $update );
			$this->db_update( $key, $value );
		} elseif ( !empty( $drop ) ) {
			$this->output( "Drop table {$this->table} \r\n" );
			$this->db_drop();
		} elseif ( !empty( $create ) ) {
			$this->output( "Create table {$this->table} \r\n" );
			$this->db_create();
		} elseif ( !empty( $count ) ) {
			$this->output( "Count elements in table {$this->table} \r\n" );
			$this->db_count();
		} elseif ( !empty( $info ) ) {
			$this->output( "Info about table {$this->table} \r\n" );
			$this->db_info();
		} elseif ( !empty( $search ) ) {
			$this->output( "Search {$search} data in RethinkDB table\r\n" );
			
			$operator = '=';
			if ( preg_match( '/\>/', $search ) ) {
				$operator = '>';
			} elseif( preg_match( '/\</', $search ) ) {
				$operator = '<';
			}

			list( $key, $value ) = explode( $operator, $search ); 
			$this->output( "Found key: {$key}, operator: {$operator}, value: {$value}\r\n" );
			$this->db_filter( $key, $value, $operator );
		} else {
			$this->output( "Invalid option\r\n" );
		}
	}
	
	private function db_connect() {
		$this->output("Connect to RethinkDB\r\n");
		$start = microtime( true );
		try {
			$this->conn = r\connect( $this->host, $this->port );
		} catch (RqlDriverError $e) {
			echo $e->getMessage() . "\n";
		} catch (Exception $e) { 
			echo sprintf( "Cannot connect to RDB: %s \n", $e->getMessage() ); exit(0);
		}  
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tConnected in %0.2f secs\r\n", $delta ) );
	}
	
	private function db_close() {
		$this->output("Close connection to RethinkDB\r\n");
		$start = microtime( true );
		$this->conn->close();
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tClosed in %0.2f secs\r\n", $delta ) );
	}
	
	private function db_count() {
		$this->db_connect();
		
		# count records
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->count()->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tCounted in %0.2f secs: %s\r\n", $delta, $result ) );
		
		$this->db_close();
	}
	
	private function db_insert( $data ) {
		$this->db_connect();

		# insert data
		$this->output( sprintf( "\tInsert data to RDB\r\n" ) ); 
		$global_start = microtime( true );
		foreach ( $data as $package ) {
			$start = microtime( true );
			$result = r\db( $this->db )->table( $this->table )->insert( $package, true)->run( $this->conn );
			$delta = microtime( true ) - $start;
			$this->output( sprintf( "\t\t%d records added in %0.2f secs: %s\r\n", count( $package), $delta, $result ) );
		}
		$global_delta = microtime( true ) - $global_start;
		$this->output( sprintf( "\tRDB updated in %0.2f secs\r\n", $global_delta ) ); 
		$this->db_close();
		
		# insert the same data to mysql
		$this->output( sprintf( "\tInsert data to MySQL \n" ) );
		$global_start = microtime( true );
		$dbw = wfGetDB( DB_MASTER, array(), $this->mysql_db );
		foreach ( $data as $package ) {
			$start = microtime( true );
			$dbw->insert( $this->mysql_table, $package, __METHOD__ );
			$delta = microtime( true ) - $start;
			$this->output( sprintf( "\t\t%d records added in %0.2f secs: %s\r\n", count( $package), $delta, $result ) );
		}
		$global_delta = microtime( true ) - $global_start;
		$this->output( sprintf( "\tMySQL updated in %0.2f secs\r\n", $global_delta ) ); 
	}
	
	private function db_delete() {
		$this->db_connect();
		
		# insert data
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->delete()->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tData removed in %0.2f secs: %s\r\n", $delta, $result ) );
		
		$this->db_close();
		
		$start = microtime( true );
		$dbw = wfGetDB( DB_MASTER, array(), $this->mysql_db );
		$this->output( "Remove data from MySQL database\r\n" ); 
		$dbw->delete( $this->mysql_table, '*', __METHOD__ );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "MySQL updated in %0.2f secs\r\n", $delta ) ); 
	}
	
	private function db_update( $key, $value ) {
		$this->db_connect();
		
		# insert data
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->get($key)->update( array( $key => $value ) )->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tData ($key, $value) updated in %0.2f secs: %s\r\n", $delta, $result ) );
		
		$this->db_close();
		
		# insert the same data to mysql
		$this->output( sprintf( "\tUpdate MySQL \n" ) );
		$global_start = microtime( true );
		$dbw = wfGetDB( DB_MASTER, array(), $this->mysql_db );
		$dbw->update( $this->mysql_table, array( "$key" => "$value" ), array() ,__METHOD__ );
		$global_delta = microtime( true ) - $global_start;
		$this->output( sprintf( "\tRDB updated in %0.2f secs\r\n", $global_delta ) ); 
	}
	
	private function db_drop() {
		$this->db_connect();
		
		# drop table
		$start = microtime( true );
		$result = r\db( $this->db )->tableDrop( $this->table )->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tTable dropped in %0.2f secs: %s\r\n", $delta, $result ) );		
		
		$this->db_close();
	}
	
	private function db_info() {
		$this->db_connect();
		
		#info table
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->info()->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tInfo loadeds in %0.2f secs: %s\r\n", $delta, $result ) );		
		
		$this->db_close();		
	}
	
	private function db_create() {
		$this->db_connect();
		
		# create table
		$start = microtime( true );
		$result = r\db( $this->db )->tableCreate( 
			$this->table, 
			array( 
				'datacenter' => $this->datacenter, 
				'durability' => $this->durability, 
				'cache_size' => $this->cache_size
			) 
		)->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tTable created in %0.2f secs: %s\r\n", $delta, $result ) );	
		
		# create index
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->indexCreate( 'cl_pid' )->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tIndex created in %0.2f secs: %s\r\n", $delta, $result ) );
		
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->indexCreate( 'cl_title' )->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tIndex created in %0.2f secs: %s\r\n", $delta, $result ) );	
		
		$this->db_close();
	}
	
	private function db_filter( $key, $value, $operator ) {
		$this->db_connect();
		
		$start = microtime( true );
		if ( $operator == '=' ) {
			$result = r\db( $this->db )->table( $this->table )->filter( 
				r\row( $key )->eq($value)
			)->run( $this->conn );
		} elseif ( $operator == '<' ) {
			$result = r\db( $this->db )->table( $this->table )->filter( 
				r\row( $key )->lt($value)
			)->run( $this->conn );	
		} elseif ( $operator == '>' ) {
			$result = r\db( $this->db )->table( $this->table )->filter( 
				r\row( $key )->gt($value)
			)->run( $this->conn );
		}
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\Filter ($key $operator $value) finished after %0.2f secs:\r\n", $delta ) );
		print_r($result,true);
		
		$this->db_close();
	}
}

$maintClass = "RethinkDBTest";
require_once( RUN_MAINTENANCE_IF_MAIN );

