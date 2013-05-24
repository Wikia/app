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
	private $host = "dev-eloy";
	private $port = "28016";
	private $db = "links";
	private $table = "categorylinks";
	private $datacenter = "devbox";
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
	}

	public function execute() {
		global $wgContentNamespaces;
		$insert = $this->hasOption( 'insert' );
		$delete = $this->hasOption( 'delete' );
		$update = $this->getOption( 'update', '' );
		$search = $this->hasOption( 'search', '' );
		$drop = $this->hasOption( 'drop' );
		$create = $this->hasOption( 'create' );
		$count = $this->hasOption( 'count' );
		$info = $this->hasOption( 'info' );
		
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
				array(),
				array( 'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ) )
			);

			$data = array();
			$i = 1;
			while ( $row = $dbr->fetchObject($res) ) {
				$data[] = array(
					'id'       => $i,
					'to'       => $row->cl_to,
					'title'    => $row->page_title,
					'pid' 	   => $row->page_id,
					'ns'       => $row->page_namespace,
					'cl_type'  => $row->cl_type,
					'cl_ts'    => $row->cl_timestamp,
					'sort'     => $row->cl_sortkey
				);
				$i++;
			}
			$dbr->freeResult($res);
			$delta = microtime( true ) - $start;
			$this->output( sprintf( "Loaded %d records in %0.2f secs\n", count( $data ), $delta ) );
			
			$this->db_insert( $data );
			
			$this->output( "Put data to RethinkDB database\r\n" ); 
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
			$this->output( "Search data in RethinkDB table\r\n" );
			
			$operator = '=';
			if ( preg_match( '/\>/', $search ) ) {
				$operator = '>';
			} elseif( preg_match( '/\</', $search ) ) {
				$operator = '<';
			}
			
			list( $key, $value ) = explode( $operator, $search ); 
			$this->db_filter( $key, $value, $operator );
		} else {
			$this->output( "Invalid option\r\n" );
		}
	}
	
	private function db_connect() {
		$this->output("Connect to RethinkDB\r\n");
		$start = microtime( true );
		$this->conn = r\connect( $this->host, $this->port );
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
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->insert( $data, true )->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tData inserted in %0.2f secs: %s\r\n", $delta, $result ) );
		
		$this->db_close();
	}
	
	private function db_delete() {
		$this->db_connect();
		
		# insert data
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->delete()->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tData removed in %0.2f secs: %s\r\n", $delta, $result ) );
		
		$this->db_close();
	}
	
	private function db_update( $key, $value ) {
		$this->db_connect();
		
		# insert data
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->get($key)->update( array( $key => $value ) )->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tData ($key, $value) updated in %0.2f secs: %s\r\n", $delta, $result ) );
		
		$this->db_close();
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
		$result = r\db( $this->db )->tableCreate( $this->table, array( 'datacenter' => $this->datacenter ) )->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tTable created in %0.2f secs: %s\r\n", $delta, $result ) );	
		
		# create index
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->indexCreate( 'pid' )->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tIndex created in %0.2f secs: %s\r\n", $delta, $result ) );
		
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->indexCreate( 'title' )->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\tIndex created in %0.2f secs: %s\r\n", $delta, $result ) );	
		
		$this->db_close();
	}
	
	private function db_filter( $key, $value, $operator ) {
		$this->db_connect();
		
		$start = microtime( true );
		$result = r\db( $this->db )->table( $this->table )->filter( 
			function( $table ) {
				$data = array();
				if ( $operator == '=' ) {
					$data = $table( $key )->eq( $value );
				} elseif( $operator == '<' ) {
					$data = $table( $key )->lt( $value );
				} elseif( $operator == '>' ) {
					$data = $table( $key )->gt( $value );
				}
				
				return $data;
			}
		)->run( $this->conn );
		$delta = microtime( true ) - $start;
		$this->output( sprintf( "\Filter ($key $operator $value) finished after %0.2f secs: %s\r\n", $delta, $result ) );
		
		$this->db_close();
	}
}

$maintClass = "RethinkDBTest";
require_once( RUN_MAINTENANCE_IF_MAIN );

