<?php
/**
 * Amazon S3 commandline tool wrapper
 *
 * This class is a singleton and doesn't include all the S3 possible commands as constants or methods,
 * that's why a genering run method is included which can run any command passed in as a string.
 *
 * This class is not listed in DefaultSettings.php due to the limited usage, so if you need to
 * use it remember to include it in your code using require_once.
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @see http://s3tools.org/s3cmd
 */
class S3Command extends WikiaObject{
	const CLI_COMMAND = 's3cmd';

	/**
	 * regular expressions
	 */
	const REGEX_ERROR = '/^ERROR: (.*)$/m';
	const REGEX_RESOURCE = '/s3:\/\/[^\s]+/';
	const REGEX_PUBLIC_URL = '/http:\/\/[^\s]+/m';

	/**
	 * actions
	 */
	const ACTION_LIST = 'ls';
	const ACTION_GET = 'get';
	const ACTION_DELETE = 'del';
	const ACTION_PUT = 'put';
	const ACTION_MAKE_BUCKET = 'mb';
	const ACTION_REMOVE_BUCKET = 'mb';
	
	private $command;
	private $parameters;
	private $options;

	private static $instance;

	function __construct(){
		$this->resetCommonOptions();
	}

	/**
	 * Returns the singleton instance
	 *
	 * @return S3Command singleton instance
	 */
	public static function getInstance(){
		$class = get_called_class();

		if ( empty( static::$instance ) ) {
			static::$instance = new $class;
		}
		
		return static::$instance;
	}

	/**
	 * Returns a well formed s3cmd commandline
	 *
	 * @param string $action the action to execute
	 * @param Array $params an array of parameters for the action
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 *
	 * @return string the commandline
	 */
	public function getCommandLine( $action, Array $params = array(), Array $options = array() ){
		$components = array( self::CLI_COMMAND, $action );
		
		foreach ( array_merge( $this->getCommonOptions(), $options ) as $name => $value ) {
			$components[] = ( ( strlen( $name ) == 1 ) ? "-" : "--" ) . "{$name}" . ( ( !empty( $value ) ) ? ' ' : null ) . $value;
		}
		
		if ( !empty( $params ) ) {
			$components = array_merge( $components, $params );
		}
		
		return implode( ' ', $components );
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

	/**
	 * Runs a command against the S3 servers
	 *
	 * @param string $action the action to execute
	 * @param Array $params an array of parameters for the action
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 *
	 * @return string the command's output
	 * @throws S3CommandException
	 */
	public function run( $action, Array $params = array(), Array $options = array() ){
		wfProfileIn( __METHOD__ );
		
		$output = shell_exec( $this->getCommandLine( $action, $params, $options ) );
		$matches = array();
		$errorFound = preg_match( self::REGEX_ERROR, $output, $matches );
		
		wfProfileOut( __METHOD__ );
		
		if ( !empty( $errorFound ) ) {
			throw new S3CommandException( $matches[1] );
		}
		
		return $output;
	}

	/**
	 * Retrieves the list of contents in a given bucket
	 *
	 * @param string $bucket the bucket's path
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 *
	 * @return Array the list of contents
	 */
	public function listBucketContents( $bucket, Array $options = array() ){
		$output = $this->run( self::ACTION_LIST, array( $bucket ), $options );
		$matches = null;
		$count = preg_match_all( self::REGEX_RESOURCE, $output, $matches );
		
		return ( !empty( $count ) ) ? $matches[0] : array();
	}

	/**
	 * Retrieves a file from a bucket
	 *
	 * @param string $bucketFilePath the S3 path to the file
	 * @param string $destPath the path where to save the loaded file
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 */
	public function loadFile( $bucketFilePath, $destPath, Array $options = array() ){
		return $this->run( self::ACTION_GET, array( $bucketFilePath, $destPath ), $options );
	}

	/**
	 * Retrieves all the files from a bucket
	 *
	 * @param string $bucket the bucket's path
	 * @param string $destPath the path where to save the loaded files
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 */
	public function loadAllFiles( $bucket, $destPath, Array $options = array() ){
		return $this->run( self::ACTION_GET, array( $bucket, $destPath ), array_merge( array( 'recursive' ), $options ) );
	}

	/**
	 * Deletes a file from a bucket
	 *
	 * @param string $bucketFilePath the S3 path to the file
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 */
	public function deleteFile( $bucketFilePath, Array $options = array() ){
		return $this->run( self::ACTION_DELETE, array( $bucketFilePath ), $options );
	}

	/**
	 * Sends a file to an S3 bucket
	 *
	 * @param string $filePath the path to the file to send, or a space separated list of files
	 * @param string $destBucket the path to the destination bucket
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 */
	public function sendFile( $filePath, $destBucket, Array $options = array() ){
		return $this->run( self::ACTION_PUT, array( $filePath, $destBucket ), $options );
	}

	/**
	 * Sends a file to an S3 bucket and assigns to it a public URL
	 *
	 * @param string $filePath the path to the file to send, or a space separated list of files
	 * @param string $destBucket the path to the destination bucket
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 *
	 * @return Array the list of public URLs, one per each file in $filePath
	 */
	public function publishFile( $filePath, $destBucket, Array $options = array() ){
		$output = $this->run( self::ACTION_PUT, array( $filePath, $destBucket ), array_merge( array( 'acl-public', 'guess-mime-type' ), $options ) );
		$matches = null;
		$count = preg_match_all( self::REGEX_PUBLIC_URL, $output, $matches);
		
		return ( !empty( $count ) ) ? $matches : array();
	}

	/**
	 * Creates a bucket on S3 servers
	 *
	 * @param string $bucket the bucket's path
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 */
	public function createBucket( $bucket, Array $options = array() ){
		return $this->run( self::ACTION_MAKE_BUCKET, array( $bucket ), $options );
	}

	/**
	 * Deletes a bucket from S3 servers, the bucket must be empty
	 *
	 * @param string $bucket the bucket's path
	 * @param Array $options an array of options for the command, overrides any matching option set via setCommonOptions
	 */
	public function deleteBucket( $bucket, Array $options = array() ){
		return $this->run( self::ACTION_REMOVE_BUCKET, array( $bucket ), $options );
	}
}

class S3CommandException extends WikiaException {
	function __construct( $msg ) {
		parent::__construct( $msg );
	}
}