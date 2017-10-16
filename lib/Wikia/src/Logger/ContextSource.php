<?php

namespace Wikia\Logger;


class ContextSource {

	/**
	 * @var array
	 */
	private $context = [ ];
	private $listeners = [ ];

	public function __construct( array $context ) {
		$this->context = $context;
	}

	public function getContext() {
		return $this->context;
	}

	public function setContext( array $context ) {
		$this->context = $context;
		foreach ( $this->listeners as $listener ) {
			$listener( $this );
		}
	}

	public function listen( callable $listener ) {
		if ( array_search( $listener, $this->listeners ) === false ) {
			$this->listeners[] = $listener;
		}
	}

	public function unlisten( callable $listener ) {
		$index = array_search( $listener, $this->listeners );
		if ( $index !== false ) {
			$this->listeners = array_splice( $this->listeners, $index, 1 );
		}
	}

}