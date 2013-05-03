<?php
/**
 * Path Finder log utility
 * This is not being implemented as a Controller/Service to speed up the calls to the log function as
 * it is called thousands times when parsing/analyzing onedot data
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 */

class PathFinderLogger extends WikiaObject{

	static private $instance;

	/**
	 * paths
	 */
	const LOG_PATH_TEMPLATE = '/tmp/PathFinder%s.log';
	
	/**
	 * log data types
	 */
	const LOG_TYPE_INFO = 'INFO';
	const LOG_TYPE_WARNING = 'WARNING';
	const LOG_TYPE_ERROR = 'ERROR';
	
	private $logPath;
	
	function __construct(){
		$this->logPath = sprintf( self::LOG_PATH_TEMPLATE, date( 'Ymd' ) );
	}
	
	/**
	 * Returns the singleton instance
	 *
	 * @return PathFinderLogger singleton instance
	 */
	public static function getInstance(){
		$class = get_called_class();

		if ( empty( static::$instance ) ) {
			static::$instance = new $class;
		}

		return static::$instance;
	}
	
	/**
	 * @brief sets the path to the log file
	 * 
	 * @param string $filePath the path to the log file
	 */
	public function setLogPath( $filePath ){
		$this->logPath = $filePath;
	}
	
	/**
	 * @brief retrieves the path to the log file
	 *
	 * @return string the log file path
	 */
	public function getLogPath(){
		return $this->logPath;
	}
	
	/**
	 * @brief logs debugging statement on dev environments
	 * 
	 * @param mixed $msg the value to log
	 * @param string $type the log type, one of LOG_TYPE_INFO, LOG_TYPE_WARNING, LOG_TYPE_ERROR
	 */
	public function log( $msg, $type = self::LOG_TYPE_INFO ) {
		wfProfileIn( __METHOD__ );
		
		if ( $this->wg->DevelEnvironment ) {
			if ( isset( $msg ) ) {
				file_put_contents( $this->logPath, '[' . date("H:i:s") . "] {$type}: " . var_export( $msg, true ) . "\n", FILE_APPEND );
			}
		}
		
		wfProfileOut( __METHOD__ );
	}
}