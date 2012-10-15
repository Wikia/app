<?php

/**
 * An abstract class for gateway 'extras'
 */
abstract class Gateway_Extras {

	/**
	 * File handle for log file
	 * @var public
	 */
	public $log_fh = NULL;
	public $gateway_adapter;

	public function __construct( &$gateway_adapter ) {
		$this->gateway_adapter = &$gateway_adapter;

		$extrasLog = $this->gateway_adapter->getGlobal( 'ExtrasLog' );
		// prepare the log file if the user has specified one
		if ( strlen( $extrasLog ) > 0 )
			$this->prepare_log_file( $extrasLog );
	}

	/**
	 * Prepare logging mechanism
	 * 
	 * If 'syslog' is specified, we can use the syslogger.  If a file
	 * is specified, we'll writ to the file.  Otherwise, do nothing.
	 *
	 * @param string path to log file
	 */
	protected function prepare_log_file( $log_file ) {

		if ( strtolower( $log_file ) == "syslog" ) {

			$this->log_fh = 'syslog';
		} elseif ( is_file( $log_file ) ) {

			$this->log_fh = fopen( $log_file, 'a+' );
		} else {

			$this->log_fh = null;
		}
	}

	/**
	 * Writes message to the log
	 *
	 * If a log file does not exist and we are not using syslog,
	 * do nothing.
	 * @fixme Perhaps lack of log file can be handled better?
	 * @param string The message to log
	 */
	public function log( $id = '', $status = '', $data = '', $log_level=LOG_INFO ) {
		if ( !$this->log_fh ) {
			echo "what log file?";
			return;
		}

		// format the message
		$msg = '"' . date( 'c' ) . '"';
		$msg .= "\t" . '"' . $id . '"';
		$msg .= "\t" . '"' . $status . '"';
		$msg .= "\t" . $data . "\n";

		// write to the log
		if ( $this->log_fh == 'syslog' ) { //use syslog facility
			// replace tabs with spaces - maybe do this universally?  cuz who needs tabs.
			$msg = str_replace( "\t", " ", $msg );
			$this->gateway_adapter->log( $msg, $log_level, '_trxn' );
		} else { //write to file
			fwrite( $this->log_fh, $msg );
		}
	}

	/**
	 * Generate a hash of some data
	 * @param string the data to hash
	 * @return string The hash of the data
	 */
	public function generate_hash( $data ) {
		$salt = $this->gateway_adapter->getGlobal( 'Salt' );
		return hash( "sha512", $salt . $data );
	}

	/**
	 * Compare a hash to the hash of some given data
	 * @param string $hash A given hash
	 * @param string $data The data to hash and compare to $hash
	 * @return bool
	 */
	public function compare_hash( $hash, $data ) {
		if ( $hash == $this->generate_hash( $data ) ) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Close the open log file handler if it's open
	 */
	public function __destruct() {
		if ( is_resource( $this->log_fh ) )
			fclose( $this->log_fh );
	}

}
