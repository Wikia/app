<?php
/**
 * Data source abstraction for Path Finder
 * the current implementation uses OneDot's Amazon S3 archive as a back-end
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PathFinderDataSource extends WikiaObject{
	/**
	 * paths
	 */
	const S3_ARCHIVE = "s3://one_dot_archive/";

	/**
	 * options
	 */
	const OPTION_BUCKET_NAME = 'bucketName';
	const OPTION_CONFIG_FILE_PATH = 'configFilePath';

	static private $instance;
	private $logger;
	private $options;
	private $s3Cmd;
	private $items = array();
	private $isLoaded = false;

	function __construct(){
		$this->logger = PathFinderLogger::getInstance();
		$this->s3Cmd = S3Command::getInstance();
	}

	/**
	 * Returns the singleton instance
	 *
	 * @return PathFinderDataSource singleton instance
	 */
	public static function getInstance(){
		$class = get_called_class();

		if ( empty( static::$instance ) ) {
			static::$instance = new $class;
		}

		return static::$instance;
	}

	/**
	 * Attaches options to the singleton instance
	 * those will persist between calls to getInstance and
	 * will be overridden when any matching one will be passed as an argument to
	 * the run method
	 *
	 * @param Array $options a map of options name (without trailing dashes) and value
	 */
	public function setCommonOptions( Array $options = array() ){
		foreach ( $options as $name => $value ){
			$this->options[$name] = $value;
		}
	}

	/**
	 * Retrieves the options attached via setCommonOptions to the singleton instance
	 *
	 * @return Array a map of options name (without trailing dashes) and value
	 */
	public function getCommonOptions(){
		return $this->options;
	}

	/**
	 * Clears out the array of options attached to the singleton instance
	 */
	public function resetCommonOptions(){
		$this->options = array();
	}

	public function countDataSets(){
		$this->load();
		return count( $this->items );
	}

	public function listDataSets() {
		$this->load();
		return $this->items;
	}

	public function getDataSet( $indexOrName = 0 ){
		wfProfileIn( __METHOD__ );

		$this->load();
		$item = null;

		if ( is_string( $indexOrName ) ) {
			foreach ( $this->items as $index => $name ) {
				if ( $name === $indexOrName ) {
					$item = $name;
					break;
				}
			}
		} elseif ( is_int( $indexOrName ) && $indexOrName < $this->countDataSets() ) {
			$item = $this->items[$indexOrName];
		}

		wfProfileOut( __METHOD__ );

		if ( !empty( $item ) ) {
			return new PathFinderDataSet( $item );
		} else {
			throw new PathFinderDataSourceNoDataException( "No dataset corresponding to '{$indexOrName}'" );
		}
	}

	public function load(){
		if ( !$this->isLoaded ) {
			wfProfileIn( __METHOD__ );

			$params = array();

			if ( !empty( $this->options[self::OPTION_CONFIG_FILE_PATH] ) ) {
				$params[] = '-c ' . $this->options[self::OPTION_CONFIG_FILE_PATH];
			}

			$params[] = ( !empty( $this->options[self::OPTION_BUCKET_NAME] ) ) ? self::S3_ARCHIVE : self::S3_ARCHIVE . $this->options[self::OPTION_BUCKET_NAME] . '/';

			$cmd = "s3cmd ls " . implode( ' ', $params );

			$this->logger->log( "Running \"{$cmd}\" ..." );
			$commandOutput = shell_exec( $cmd );
			$this->logger->log( "Done, command output: {$commandOutput}." );

			$matches = array();

			if ( $result = preg_match( '#^[0-9 :-]+(' . str_replace( '/', '\/', self::S3_ARCHIVE ) . '.*)$#m', $commandOutput, $matches ) ) {
				$this->items = $matches[1];
				$this->isLoaded = true;
			} else {
				wfProfileOut( __METHOD__ );
				throw new PathFinderDataSourceNoDataException();
			}

			wfProfileOut( __METHOD__ );
		}
	}

	public function clean(){
		//remove the temp directory if empty
		rmdir( self::RAW_DATA_PATH );
	}
}

class PathFinderDataSourceNoDataException extends WikiaException {
	function __construct( $msg = 'No data' ){
		parent::__construct( $msg );
	}
}
