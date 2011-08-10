<?php
/**
 * Path Finder log utility
 * This is not being implemented as a Controller/Service to speed up the calls to the log function as
 * it is called thousands times when parsing/analyzing onedot data
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 */

class PathFinderLogger extends WikiaService {
	const LOG_PATH_TEMPLATE = '/tmp/PathFinder_%s.log';
	
	/**
	 * Log action types
	 */
	const LOG_TYPE_INFO = 'INFO';
	const LOG_TYPE_WARNING = 'WARNING';
	const LOG_TYPE_ERROR = 'ERROR';
	
	static private $instance = null;
	private $logPath = null;
	private $app = null;
	
	function __construct(){
		$this->app = F::app();
		$this->logPath = sprintf( self::LOG_PATH_TEMPLATE, date( 'Ymd' ) );
		
		//singleton
		F::setInstance( __CLASS__, $this );
	}
	
	/**
	 * @brief logs debugging statement on dev environments
	 * 
	 * @param mixed $msg the value to log
	 * @param string $type the log type, one of LOG_TYPE_INFO, LOG_TYPE_WARNING, LOG_TYPE_ERROR
	 */
	public function log( $msg, $type = self::LOG_TYPE_INFO ) {
		$this->app->wf->profileIn( __METHOD__ );
		
		if ( $this->wg->DevelEnvironment ) {
			if ( isset( $msg ) ) {
				file_put_contents( $this->logPath, '[' . date("H:i:s") . "] {$type}: " . var_export( $msg, true ) . "\n", FILE_APPEND );
			}
		}
		
		$this->app->wf->profileOut( __METHOD__ );
	}
	
	/**
	 * @brief sets the path to the log file
	 * 
	 * @param string $path the path to the log file
	 */
	public function setLogPath( $path ) {
		$this->logPath = $path;
	}
}