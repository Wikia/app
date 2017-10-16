<?php

use Wikia\Logger\WikiaLogger;

/**
 * WikiaBaseException
 *
 * it is used by WikiaException and WikiaHttpException
 * WikiaHttpExceptions should not be logged by default
 * as they are more about communication than errors
 *
 * @ingroup nirvana
 *
 * @author Jakub Olek <jakubolek@wikia-inc.com>
 */
abstract class WikiaBaseException extends MWException {
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

/**
 * Base exception class for the Nirvana framework
 *
 * @ingroup nirvana
 *
 * @author Wojciech Szela <wojtek@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @link http://pl2.php.net/manual/en/class.exception.php
 */
class WikiaException extends WikiaBaseException {
	public function __construct($message = '', $code = 0, Exception $previous = null) {
		global $wgRunningUnitTests;
		parent::__construct( $message, $code, $previous );

		if (!$wgRunningUnitTests) {
			$exceptionClass = get_class($this);

			// log on devboxes to /tmp/debug.log
			wfDebug($exceptionClass . ": {$message}\n");
			wfDebug($this->getTraceAsString());

			WikiaLogger::instance()->error($exceptionClass, [
				'err' => $message,
				'errno' => $code,
				'exception' => $previous instanceof Exception ? $previous : $this,
			]);
		}
	}
}

/**
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
		// Display normal mediawiki error page for mediawiki exceptions
		if ( $this->_original instanceof MWException ) {
			$this->_original->report();
		}
		// Wikia-specific exceptions will be sent to Logstash
		else {
			WikiaLogger::instance()->error(__CLASS__, [
				'err' => $this->getMessage(),
				'exception' => $this->getOriginal(),
			]);
		}
	}
}

/**
 * Base class for exceptions that match HTTP status codes,
 * mainly meant for Wikia's API modules but could be used
 * in any Nirvana-based code.
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
abstract class WikiaHttpException extends WikiaBaseException {
	protected $code = null;
	protected $message = null;
	protected $details = null;

	function __construct( $details = null, Exception $previous = null ) {
		parent::__construct( $this->message, $this->code, $previous );
		wfDebug(get_class($this). " raised from " . wfGetAllCallers(2) . "\n");
		if (!empty($details)) {
			$this->details = $details;
			wfDebug(get_class($this)  . ": {$this->details}\n");
		}
	}

	public function getDetails() {
		return $this->details;
	}
}

/**
 * The following is a collection of WikiaHttpException
 * subclasses each matching a specific HTTP status code
 */

class BadRequestException extends WikiaHttpException {
	protected $code = 400;
	protected $message = 'Bad request';
}

class UnauthorizedException extends WikiaHttpException {
	protected $code = 401;
	protected $message = 'Unauthorized';
}

class ForbiddenException extends WikiaHttpException {
	protected $code = 403;
	protected $message = 'Forbidden';
}

class NotFoundException extends WikiaHttpException {
	protected $code = 404;
	protected $message = 'Not found';
}

class MethodNotAllowedException extends WikiaHttpException {
	protected $code = 405;
	protected $message = 'Method not allowed';
}

class NotImplementedException extends WikiaHttpException {
	protected $code = 501;
	protected $message = 'Not implemented';
}

class InvalidDataException extends WikiaHttpException {
	protected $code = 555;//custom HTTP status, 500 cannot be used as it makes us fallback to IOWA
	protected $message = 'Invalid data';
}

class ControllerNotFoundException extends NotFoundException {
	function __construct($name) {
		parent::__construct("Controller not found: $name");
	}
}

class MethodNotFoundException extends NotFoundException {
	function __construct($name) {
		parent::__construct("Method not found: $name");
	}
}

class PermissionsException extends ForbiddenException {
	protected $message = "No Permissions";

	function __construct( $requiredPermission ) {
		$this->details = "Current User don't have required permissions: " . $requiredPermission;
	}
}
