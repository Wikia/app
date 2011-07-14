<?php
/**
 * User Path Prediction Debug Log Service
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 */

class UserPathPredictionLogService extends WikiaService {
	const LOG_TYPE_INFO = 'INFO';
	const LOG_TYPE_WARNING = 'WARNING';
	const LOG_TYPE_ERROR = 'ERROR';
	
	private $logPath;
	private $initialized = false;
	
	public function init(){
		if ( !$this->initialized ) {
			$this->logPath = "/tmp/UserPathPrediction_" . date( 'Ymd' ) . ".log";
			$this->initialized = true;
			
			F::setInstance( __CLASS__, $this );
		}
	}
	
	/**
	 * @brief logs debugging statement on dev environments
	 */
	public function log() {
		$this->app->wf->profileIn( __METHOD__ );
		
		if ( $this->wg->DevelEnvironment ) {
			$msg = $this->getVal( 'msg' );
			$type = $this->getVal( 'type', self::LOG_TYPE_INFO );
			
			if ( isset( $msg ) ) {
				file_put_contents( $this->logPath, '[' . date("H:i:s") . "] {$type}: " . var_export( $msg, true ) . "\n", FILE_APPEND );
			}
		}
		
		$this->app->wf->profileOut( __METHOD__ );
	}
}