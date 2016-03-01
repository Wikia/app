<?php
/**
 * This trait allows you to include accessor methods in your class that wrap the wfMessage functionality.
 * The motivation for this is to provide a boundary between core MediaWiki functionality that relies upon
 * globally accessible functions that have side effects or do IO and new functionality that needs to be tested.
 *
 * For example, you can't reliably test a function that has a call to wfMessage() without hitting the database.
 * This means that you can't effectively unit test such a function.
 *
 * @author Damon Snyder (damon@wikia-inc.com)
 */

trait IncludeMessagesTrait {

	/**
	 * Get the text version of inContentLanguage message.
	 *
	 * Example:
	 *	$this->getTextVersionOfMessage( 'a-message', $option1, $option2, ... )
	 *
	 * @param string $message
	 * @param array $params This is a flat array of parameters
	 * @return string
	 */
	protected function getTextVersionOfMessage( $message, array $params = array() ) {
		$message = new Message( $message, $params );
		return $message->inContentLanguage()->text();
	}

	/**
	 * Get the plain version of an inContentLanguage message.
	 *
	 * @param string $message
	 * @param array $params This is a flat array of parameters
	 * @return string
	 */
	protected function getPlainVersionOfMessage( $message, array $params = array() ) {
		$message = new Message( $message, $params );
		return $message->inContentLanguage()->plain();
	}

}
