<?php

/**
 * Nirvana Framework - Wikia  dispatched exception
 *
 * Exception thrown by WikiaDispatcher::dispatch
 *
 * @ingroup nirvana
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
class WikiaDispatchedException extends WikiaException {
	/**
	 * Original exception
	 *
	 * @var Exception|null
	 */
	private $_original;

	/**
	 * Constructor
	 *
	 * @link  http://pl2.php.net/manual/en/exception.construct.php
	 * @param string $message
	 * @param int $code
	 * @param Exception $original
	 */
	public function __construct($message = '',  Exception $original = null) {
			parent::__construct( $message );
			$this->_original = $original;
	}


	/**
	 * Original exception getter
	 *
	 * @return Exception|null
	 */
	protected function getOriginal() {
		return $this->_original;
	}

	/**
	 * String representation of the exception
	 *
	 * @link http://pl2.php.net/manual/en/exception.tostring.php
	 * @return string
	 */
	public function __toString() {
		$ret = '';

		if ( null !== ( $e = $this->getOriginal() ) ) {
			$ret .= $e->__toString() . "\n\n";
		}

		$ret .= 'Reported by ' . parent::__toString();

		return $ret;
	}

	/**
	 * Override WikiaException report() and write exceptions to error_log
	 */
	function report() {
		global $wgRequest;
		$info = '';

		if ( !empty( $this->_original ) ) {
			$file = $this->_original->getFile();
			$line = $this->_original->getLine();
			$message = $this->_original->getMessage();

			$info = "exception has occurred at line {$line} of {$file}: {$message}";
		} else {
			$info = "unknown exception has occurred";
		}

		$url = '[no URL]';

		if ( isset( $wgRequest ) ) {
			$url = $wgRequest->getFullRequestURL();
		}

		// Display normal mediawiki eror page for mediawiki exceptions
		if ( $this->_original instanceof MWException ) {
			$this->_original->report();
		}
		else {
			trigger_error("[REPORT: {$this->getMessage()}] WikiaDispatcher reports an {$info}  (URL: {$url}) [REPORT: End]", E_USER_ERROR);
		}
	}
}
