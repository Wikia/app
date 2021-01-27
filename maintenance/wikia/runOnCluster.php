<?php
/**
 * NAME
 *
 *   runOnCluster.php
 *
 * USAGE
 *
 *   php runOnCluster --conf PATH_TO_CONF \
 *                    --cluster DB_CLUSTER \
 *                    [--file YOUR_CODE.php] \
 *                    --class SOME_CLASS \
 *                    --method SOME_METHOD \
 *                    [--test] \
 *                    [--verbose] \
 *                    [--dbname DBNAME]
 *
 *
 * DESCRIPTION
 *
 * This script can be used to run code against multiple wiki DBs from within the same PHP
 * process for a single cluster.  This has the advantage of not restarting the PHP interpreter
 * once for every wiki.  For code that has to work on every wiki, this speeds up completion time
 * dramatically.
 *
 * The downside is that there is no attempt to set wiki context done here.  Any code that requires
 * specific WikiFactory settings unique to a wiki should not be used.  Any code that uses wiki
 * specific functions should not be used (e.g. loading an image file object will not work as
 * the code will not have the right context to find it).
 *
 * The primary use for this script, therefore, is running database queries against all wikis.
 *
 * You must pass this script a --class and --method which is the code it will run for each wiki db.  The
 * prototype for this method should be:
 *
 *   public static function yourMethod ( $db, $test, $verbose = false, $params ) { }
 *
 * The $db argument is a Database object that is already connected to the DB name given as the second
 * argument, $dbname.  The third argument determines whether to display verbose messages or not. The fourth
 * argument is a boolean flag that determines if the method should operate in test mode or not.  Test mode
 * typically means "no writes" but can be whatever you want in your application.
 *
 * This class and method can be given in a separate file, named by the --file argument, or any existing
 * code in the Wikia code base can be given, as long as it obeys the above rules and method prototype.
 *
 * NOTE: This script sets the (required) CityID to 177 internally, so there is no need to set SERVER_ID on
 * the commandline unless there is a very specific reason to do so.
 *
 * OPTIONS
 *
 * --cluster : [REQUIRED] An integer : The cluster number this script should connect to.
 *
 *    --file : [OPTIONAL] A file name : A file that includes your class and method to run on each wiki.
 *
 *   --class : [REQUIRED] A class name : The class that contains the method to run on each wiki.
 *
 *  --method : [REQUIRED] A method name : The method in the class given to run on each wiki.
 *
 *  --dbname : [OPTIONAL] If given the code will only be run against this dbname.  The --cluster argument must be
 *                        correct for this dbname; runOnCluster will not figure it out for you.
 *
 *    --test : [OPTIONAL] A flag to run in test mode.  Your class::method must support this.
 *
 * --verbose : [OPTIONAL] A flag to output more verbose messages.
 */

// Eliminate the need to set this on the command line
if ( !getenv( 'SERVER_ID' ) ) {
	putenv( "SERVER_ID=2393201" );
}

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Class Filters
 *
 * An enum for the filter parameter to RunOnCluster
 */
abstract class Filters {
	const Public = 0;
	const Private = 1;
	const All = 2;
}

/**
 * Class RunOnCluster
 */
class RunOnCluster extends Maintenance {

	const PARAM_SITE_ID = 'siteId';
	const PARAM_DB_NAME = 'dbName';
	const PARAM_DB_MISSING = 'dbMissing';

	// The default method to call in the class given by --file or --class
	const DEFAULT_METHOD = "run";
	// The default cluster to use when none is given by --cluster
	const DEFAULT_CLUSTER = 1;
	// Default class to use if none is given by --file or --class
	const DEFAULT_CLASS = ClusterTestClass::class;

	protected $verbose = false;
	protected $test    = false;
	protected $cluster = '1';
	protected $class;
	protected $method;
	protected $filter;
	protected $file;
	protected $singleDBname;
	protected $dbCheck = true;
	protected $dbMissing = false;

	/** @var DatabaseBase */
	protected $db;
	protected $master;

	/**
	 * Define available options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Run generic code on a single cluster from on PHP process";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'master' , 'Connect to the master DB rather than the slave', false, false, 'a' );
		$this->addOption( 'cluster', 'Which cluster to run on', false, true, 'c' );
		$this->addOption( 'class', 'The class with code to run', false, true, 'l' );
		$this->addOption( 'method', 'Which method to run', false, true, 'm' );
		$this->addOption( 'file' , 'File containing code to run', false, true, 'f' );
		$this->addOption( 'filter' , 'Filter wikis from the input; public, private or all', false,
			true );
		$this->addOption( 'no-db-check', "Don't verify the DB connection (useful if just using wikicities tables)",
			false, false );
		$this->addOption( 'db-name' , 'A single dbname to run against', false, true, 'i' );
	}

	/**
	 * Execute the script
	 */
	public function execute() {
		// Collect options
		$this->readOptions();
		$this->validateOptions();

		$startTime = time();

		$this->notifyOnSpecialOptions();

		$this->loadCodeToRun();
		$this->verifyCodeToRun();

		// Get all the wiki's on the current cluster
		$clusterWikis = $this->getClusterWikis();

		// Connect to the cluster we will operate on and set $this->db
		if ( !$this->initDBHandle() ) {
			die( "Could not connect to cluster ".$this->cluster."\n" );
		}

		echo "Running ".$this->class.'::'.$this->method.' on cluster '.$this->cluster."\n";

		// Loop through each dbName and run our code
		foreach ( $clusterWikis as $cityId => $dbName ) {
			if ( !$this->useSchema( $dbName ) ) {
				// Skip this wiki if we can't connect to its schema on this DB
				continue;
			}

			$this->runCodeOn( $cityId, $dbName );
		}

		$delta = F::app()->wg->Lang->formatTimePeriod( time() - $startTime );
		fwrite( STDERR, "Finished in $delta\n" );
	}

	private function readOptions() {
		$this->test = $this->hasOption( 'test' );
		$this->verbose = $this->hasOption( 'verbose' );
		$this->master = $this->hasOption( 'master' );
		$this->cluster = $this->getOption( 'cluster', self::DEFAULT_CLUSTER );
		$this->class = $this->getOption( 'class' );
		$this->method = $this->getOption( 'method', self::DEFAULT_METHOD );

		$filter = $this->getOption( 'filter', 'public' );
		if ( strtolower( $filter ) == 'all' ) {
			$this->filter = Filters::All;
		} else if ( strtolower( $filter ) == 'public' ) {
			$this->filter = Filters::Public;
		} else if ( strtolower( $filter ) == 'private' ) {
			$this->filter = Filters::Private;
		}

		$this->singleDBname = $this->getOption( 'db-name', '' );

		// The --no-db-check is useful on the command line, but negate it here so we don't have
		// the possibility of double negatives in a conditional
		$this->dbCheck = ! $this->getOption( 'no-db-check', false );

		$this->file = $this->getOption( 'file' );
	}

	private function validateOptions() {
		if ( !$this->file && $this->class ) {
			die( "Error: Argument --class given without --file; this is probably not correct\n" );
		}

		// Basic cluster sanity check
		if ( !preg_match( '/^[0-9]+$/', $this->cluster ) ) {
			die( "Argument to --cluster must be an integer\n" );
		}
	}

	private function notifyOnSpecialOptions() {
		if ( $this->test ) {
			echo "== TEST MODE ==\n";
		}
		$this->debug( "(debugging output enabled)\n" );

		if ( $this->master ) {
			echo "-- RUNNING ON MASTER --\n";
		}
	}

	private function loadCodeToRun() {
		$this->loadFile();

		// If a specific class has already been given, use that.
		if ( !empty( $this->class ) ) {
			return;
		}

		// Otherwise, try to figure it out by looking through each declared class
		foreach ( get_declared_classes() as $class ) {
			$reflector = new ReflectionClass( $class );
			if ( realpath( $this->file ) == $reflector->getFileName() ) {
				// If the class is defined in the filename given to use, this is the class to use.
				$this->class = $class;
				break;
			}
		}
	}

	private function loadFile() {
		// If there's no file given, use the default test class
		if ( !$this->file ) {
			$this->class = self::DEFAULT_CLASS;
			return;
		}

		if ( !file_exists( $this->file ) ) {
			die( "File '" . $this->file . "' does not exist\n" );
		}

		require_once( $this->file );
	}

	private function verifyCodeToRun() {
		// Make sure the class and method we're using exist
		if ( !class_exists( $this->class ) ) {
			die( "Class '" . $this->class . "' does not exist\n" );
		}

		if ( !method_exists( $this->class, $this->method ) ) {
			die( "Method '" . $this->method . "' does not exist in class '" . $this->class . "'\n" );
		}
	}

	/**
	 * Get the list of dbnames that exist on our cluster
	 *
	 * @return array An array of database names
	 */
	private function getClusterWikis() {
		$db = wfGetDB( DB_SLAVE, [], 'wikicities' );

		if ( empty( $this->singleDBname ) ) {
			$sqlWhere = 'city_cluster = '.$db->addQuotes( 'c'.$this->cluster );
		} else {
			$sqlWhere = 'city_dbname = '.$db->addQuotes( $this->singleDBname );
		}

		if ( $this->filter == Filters::Public ) {
			$sqlWhere .= ' AND city_public = 1';
		} else if ( $this->filter == Filters::Private ) {
			$sqlWhere .= ' AND city_public = 0';
		}

		$sql = "SELECT city_dbname, city_id
		 		FROM city_list
				WHERE $sqlWhere
				ORDER BY city_dbname";

		$result = $db->query( $sql, __METHOD__ );

		$wikis = [];
		while ( $row = $db->fetchObject( $result ) ) {
			$wikis[$row->city_id] = $row->city_dbname;
		}

		return $wikis;
	}

	/**
	 * Connect to our cluster.  We'll "use $DBNAME" later to connect to individual DBs
	 *
	 * @return bool
	 */
	private function initDBHandle() {
		$target = $this->master ? DB_MASTER : DB_SLAVE;

		$name = 'wikicities_c'.$this->cluster;
		$this->db = wfGetDB( $target, [], $name );

		return $this->db ? true : false;
	}

	private function useSchema( $dbName ) {
		// Catch connection errors and log them
		try {
			$result = $this->db->selectDB( $dbName );
		} catch ( Exception $e ) {
			fwrite( STDERR, "ERROR: ".$e->getMessage()."\n" );
		}

		$this->dbMissing = empty( $result );

		// If the db can't be found and we care about that, return now.
		if ( $this->dbMissing && $this->dbCheck ) {
			$this->debug( "Could not find DB to use\n" );
			return false;
		}

		$this->debug( "Processing: $dbName\n" );

		return true;
	}

	private function runCodeOn( $cityId, $dbName ) {
		// Call our method passing the connected DB handle and test flag
		$class = $this->class;
		$method = $this->method;
		$params = [
			self::PARAM_DB_NAME => $dbName,
			self::PARAM_SITE_ID => $cityId,
			self::PARAM_DB_MISSING => $this->dbMissing,
		];

		try {
			$class::$method( $this->db, $this->test, $this->verbose, $params );
		} catch ( Exception $e ) {
			fwrite(
				STDERR,
				"Could not run $class::$method for $dbName: " .
				$e->getMessage() . "\n" .
				$e->getTraceAsString() . "\n"
			);
		}
	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg - The message text to echo to STDOUT
	 */
	private function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg;
		}
	}
}

class ClusterTestClass {
	public static function run( DatabaseBase $db, $test = false, $verbose = false, $params = [] ) {
		echo "Default code : Running ".__METHOD__."\n";
		$sql = 'SELECT database() as db';
		$result = $db->query( $sql, __METHOD__ );
		while ( $row = $db->fetchObject( $result ) ) {
			echo "\tOperating on ".$row->db."\n";
		}
	}
}

$maintClass = "RunOnCluster";
require_once( RUN_MAINTENANCE_IF_MAIN );
