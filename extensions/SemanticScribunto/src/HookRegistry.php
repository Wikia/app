<?php

namespace SMW\Scribunto;

use Hooks;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class HookRegistry {

	/**
	 * @var array
	 */
	private $handlers = [];

	/**
	 * @since 1.0
	 */
	public function __construct() {
		$this->addCallbackHandlers();
	}

	/**
	 * @since  1.0
	 */
	public function clear() {
		foreach ( $this->handlers as $name => $callback ) {
			Hooks::clear( $name );
		}
	}

	/**
	 * @since  1.0
	 */
	public function register() {
		foreach ( $this->handlers as $name => $callback ) {
			Hooks::register( $name, $callback );
		}
	}

	/**
	 * @since  1.0
	 *
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function isRegistered( $name ) {
		return Hooks::isRegistered( $name );
	}

	/**
	 * @since  1.0
	 *
	 * @param string $name
	 *
	 * @return Callable|false
	 */
	public function getHandlerFor( $name ) {
		return isset( $this->handlers[$name] ) ? $this->handlers[$name] : false;
	}

	private function addCallbackHandlers() {

		$this->handlers['ScribuntoExternalLibraries'] = function( $engine, array &$extraLibraries ) {
			$extraLibraries['mw.smw'] = 'SMW\Scribunto\ScribuntoLuaLibrary';
			return true;
		};
	}

}
