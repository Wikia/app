<?php

/**
 * Class representing the options which the voter can choose from when they are
 * answering a question.
 */
class SecurePoll_Option extends SecurePoll_Entity {
	/**
	 * Constructor
	 * @param $context SecurePoll_Context
	 * @param $info Associative array of entity info
	 */
	function __construct( $context, $info ) {
		parent::__construct( $context, 'option', $info );
	}

	/**
	 * Get a list of localisable message names. This is used to provide the 
	 * translate subpage with a list of messages to localise.
	 */
	function getMessageNames() {
		return array( 'text' );
	}
}
