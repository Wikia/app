<?php

/**
 * A MessageCache that allows to set overrides for message text, otherwise simply returns the key as message text.
 * Useful for testing.
 */
class TestMessageCache extends MessageCache {
	/** @var array $overrides */
	private $overrides;

	function __construct( array $overrides = [] ) {
		parent::__construct( null, false, false );
		$this->overrides = $overrides;
	}

	function get( $key, $useDB = true, $langcode = true, $isFullKey = false, $fixWhitespace = true
	) {
		if ( isset( $this->overrides[$key][$langcode] ) ) {
			return $this->overrides[$key][$langcode];
		}

		// the key is the message.
		return $key;
	}
}
