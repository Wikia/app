<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * An Exception for use within WikiCitation.
 */
class WCException extends UnexpectedValueException {

	/**
	 * Constructor.
	 * 
	 * In addition to a message key, the constructor may include optional
	 * arguments of any number, as in:
	 * new WCException( 'message-1', ... );
	 * @param messageKey string The message key
	 * @param optionalArgs string = any number of arguments
	 * @return string Value of object.
	 */
	public function __construct( $messageKey ) {
		$args = func_get_args();
		array_shift( $args );
		$transformedMessage = wfMsgReal( $messageKey, $args, true );
		parent::__construct( $transformedMessage );
    }

}