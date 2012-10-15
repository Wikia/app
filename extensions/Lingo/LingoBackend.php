<?php

/**
 * File holding the LingoBackend class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup Lingo
 */
if ( !defined( 'LINGO_VERSION' ) ) {
	die( 'This file is part of the Lingo extension, it is not a valid entry point.' );
}

/**
 * The LingoBackend class.
 *
 * @ingroup Lingo
 */
abstract class LingoBackend {

	protected $mMessageLog;

	public function __construct( LingoMessageLog &$messages = null ) {

		if ( !$messages ) {
			$this->mMessageLog = new LingoMessageLog();
		} else {
			$this->mMessageLog = $messages;
		}
	}

	public function getMessageLog() {
		return $this->mMessageLog;
	}

	/**
	 * This function returns the next element. The element is an array of four
	 * strings: Term, Definition, Link, Source. If there is no next element the
	 * function returns null.
	 *
	 * @return the next element or null
	 */
	abstract public function next();
}

