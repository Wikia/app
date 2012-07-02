<?php
/**
 * @ingroup Maintenance
 */
if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname(__FILE__).'/../../..';
}

require_once( "$IP/maintenance/Maintenance.php" );

class PopulateCache extends Maintenance {
	public $isOK = 0;
	public $isBad = 0;
	protected $dbr;
	
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Prepopulate caches with zipcode queries";

		$this->addOption( 'url', 'The base URL for zipcode lookup.', true, true );
		$this->addOption( 'limit', 'The amount of values to return during a db query.', false, false );
		$this->addOption( 'cache_warmup', 'If this is used, the script will attempt to hit all of the possible URLs for you to warm up the cache.', false, false );
		$this->addOption( 'path', 'The file path to output all possible zip code URLs. If this option is specified, this script will NOT attempt to hit the URLs for you.', false, false );
		
	}

	public function execute() {
		$this->dbr = wfGetDB( DB_SLAVE );
		$path = $this->getOption( 'path', null );
		if ( $path ) {
			$this->writeUrlsToFile( $path );
		}
		if ( $this->getOption( 'cache_warmup', null )) {
			$this->warmUpCache();
		}
	}
	
	public function warmUpCache() {
		$this->output( "Populating caches...\n" );
		
		$limit = $this->getOption( 'limit', 1000 );
		$offset = 0;
		$keepGoing = true;
		
		while( $keepGoing ) {
			$result = $this->dbr->select(
				'cl_zip5',
				'clz5_zip',
				array(),
				__METHOD__,
				array(
					'LIMIT' => $limit,
					'OFFSET' => $offset,
				)
			);
			
			if ( !$result->numRows() ) {
				$keepGoing = false;
			}
			
			foreach ( $result as $row ) {
				$this->hitUrl( $row->clz5_zip );
			}
			
			$offset += $limit;
			$this->output( "...Attempted $offset URLs so far.\n" );
			$this->output( "...OK so far: " . $this->isOK . "\n" );
			$this->output( "...Bad so far: " . $this->isBad . "\n" );
			sleep( 1 ); // rate limit		
		}
		$this->ouput( "Done!\n" );
	}
	
	public function writeUrlsToFile( $path ) {
		$this->output( "Preparing to write URLs to file...\n" );
		$limit = $this->getOption( 'limit', 1000 );
		$offset = 0;
		$keepGoing = true;
		$fh = fopen( $path, 'w' );
		
		while( $keepGoing ) {
			$result = $this->dbr->select(
				'cl_zip5',
				'clz5_zip',
				array(),
				__METHOD__,
				array(
					'LIMIT' => $limit,
					'OFFSET' => $offset,
				)
			);

			if ( !$result->numRows() ) {
				$keepGoing = false;
			}
			
			foreach ( $result as $row ) { 
				$url = $this->makeUrl( $row->clz5_zip );
				fwrite( $fh, $url ."\n" );
			}
			$offset += $limit;
		}
		fclose( $fh );
		$this->output( "Done!\n" );
	}
	
	public function hitUrl( $zip, $attempt=0 ) {
		$url = $this->makeUrl( $zip );
		//$this->output( "*Trying to hit $url\n" );
		$req = MWHttpRequest::factory( $url, array( 
				'method'        => 'GET',
				'timeout'       => 2,
				'sslVerifyHost' => false, // just check if it can be reached
				'sslVerifyCert' => false, // just check if it can be reached
		) );
		if ( $req->execute()->isOK()) {
			$this->isOK++;
		} else {
			sleep( 2 );
			$attempt++;
			if ( $attempt < 3 ) { 
				$this->hitUrl( $zip, $attempt );
			} else {
				$this->isBad++;
			}
		}
	}
	
	public function makeUrl( $zip ) {
		$zip = intval( $zip );
		if ( $zip < 10000 ) { // make sure there are 5 digits
			$zip = sprintf( "%05d", $zip );
		}
		$url = $this->getOption( 'url' ) . "?zip=" . $zip . "&submit=Look+up";
		return $url;
	}
}

$maintClass = "PopulateCache";
require_once( DO_MAINTENANCE );