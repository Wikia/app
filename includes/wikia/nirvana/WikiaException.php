<?php

/**
 * Base exception class for the Nirvana framework
 *
 * @ingroup nirvana
 *
 * @author Wojciech Szela <wojtek@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @link http://pl2.php.net/manual/en/class.exception.php
 */
class WikiaException extends MWException {
	/**
	 * Constructor
	 *
	 * @param string $message The exception message
	 * @param int $code The error code
	 * @param Exception $previous The previous exception in the chain if any
	 *
	 * @link  http://www.php.net/manual/en/class.exception.php
	 * @see MWException
	 */
	public function __construct($message = '', $code = 0, Exception $previous = null) {
		parent::__construct( $message, $code, $previous );

		// log more details (macbre)
		Wikia::logBacktrace( __METHOD__ );
	}

	/**
	 * Overrides MWException::report to also write exceptions to error_log
	 *
	 * @see  MWException::report
	 */
	function report() {
		$file = $this->getFile();
		$line = $this->getLine();
		$message = $this->getMessage();
		$request = RequestContext::getMain()->getRequest();
		$url = '[no URL]';

		if ( isset( $request ) ) {
			$url = $request->getFullRequestURL();
		}

		trigger_error( "Exception from line {$line} of {$file}: {$message} ({$url})", E_USER_ERROR );

		/*
		bust the headers_sent check in MWException::report()
		Uncomment to override normal MWException headers
		in order to display an error page instead of a 500 error
		WARNING: Varnish doesn't like those
		flush();
		*/
		parent::report();
	}
}
