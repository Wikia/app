<?php
/**
 * A tool for running hook functions.
 *
 * Copyright 2004, 2005 Evan Prodromou <evan@wikitravel.org>.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 *
 * @author Evan Prodromou <evan@wikitravel.org>
 * @see hooks.txt
 * @file
 */

/**
 * Hooks class.
 *
 * Used to supersede $wgHooks, because globals are EVIL.
 */
class Hooks {

	protected static $handlers = array();

	public static function &getHandlersArray() {
		return self::$handlers;
	}

	/**
	 * Attach an event handler to a given hook
	 *
	 * @param $name Mixed: name of hook
	 * @param $callback Mixed: callback function to attach
	 * @return void
	 */
	public static function register( $name, $callback ) {
		if( !isset( self::$handlers[$name] ) ) {
			self::$handlers[$name] = array();
		}

		self::$handlers[$name][] = $callback;
	}

	/**
	 * Returns true if a hook has a function registered to it.
	 *
	 * @param $name Mixed: name of hook
	 * @return Boolean: true if a hook has a function registered to it
	 */
	public static function isRegistered( $name ) {
		if( !isset( self::$handlers[$name] ) ) {
			self::$handlers[$name] = array();
		}

		return ( count( self::$handlers[$name] ) != 0 );
	}

	/**
	 * Returns an array of all the event functions attached to a hook
	 *
	 * @param $name Mixed: name of the hook
	 * @return array
	 */
	public static function getHandlers( $name ) {
		if( !isset( self::$handlers[$name] ) ) {
			return array();
		}

		return self::$handlers[$name];
	}

	/**
	 * Call hook functions defined in Hooks::register
	 *
	 * Because programmers assign to $wgHooks, we need to be very
	 * careful about its contents. So, there's a lot more error-checking
	 * in here than would normally be necessary.
	 *
	 * @param $event String: event name
	 * @param $args array: parameters passed to hook functions
	 * @return bool True if no handler aborted the hook
	 * @throws FatalError if a hook handler returns string
	 * @throws MWException if the hook handler setup for this hook is invalid
	 */
	public static function run( $event, $args = array() ) {
		// Wikia change - begin - @author: wladek
		// optimized hooks execution

		// Return quickly in the most common case
		if ( !isset( self::$handlers[$event] ) ) {
			return true;
		}

		$handlers = self::$handlers[$event];

		if ( !is_array( $handlers ) ) {
			throw new MWException( "Hooks array for event '$event' is not an array!\n" );
		}
		// Wikia change - end

		foreach ( $handlers as $hook ) { # Wikia
			$object = null;
			$method = null;
			$func = null;
			$data = null;
			$have_data = false;
			$closure = false;

			/**
			 * $hook can be: a function, an object, an array of $function and
			 * $data, an array of just a function, an array of object and
			 * method, or an array of object, method, and data.
			 */
			if ( is_array( $hook ) ) {
				if ( count( $hook ) < 1 ) {
					throw new MWException( 'Empty array in hooks for ' . $event . "\n" );
				} elseif ( is_object( $hook[0] ) ) {
					$object = $hook[0]; # Wikia
					if ( $object instanceof Closure ) {
						$closure = true;
						if ( count( $hook ) > 1 ) {
							$data = $hook[1];
							$have_data = true;
						}
					} else {
						if ( count( $hook ) < 2 ) {
							$method = 'on' . $event;
						} else {
							$method = $hook[1];
							if ( count( $hook ) > 2 ) {
								$data = $hook[2];
								$have_data = true;
							}
						}
					}
				} elseif ( is_string( $hook[0] ) ) {
					$func = $hook[0];
					if ( count( $hook ) > 1) {
						$data = $hook[1];
						$have_data = true;
					}
				} else {
					throw new MWException( 'Unknown datatype in hooks for ' . $event . "\n" );
				}
			} elseif ( is_string( $hook ) ) { # functions look like strings, too
				$func = $hook;
			} elseif ( is_object( $hook ) ) {
				$object = $hook; # Wikia
				if ( is_callable( $object ) ) {
					$closure = true;
				} else {
					$method = "on" . $event;
				}
			} else {
				throw new MWException( 'Unknown datatype in hooks for ' . $event . "\n" );
			}

			/* We put the first data element on, if needed. */
			if ( $have_data ) {
				$hook_args = array_merge( array( $data ), $args );
			} else {
				$hook_args = $args;
			}

			if ( $closure ) {
				$callback = $object;
			} elseif ( isset( $object ) ) {
				$callback = array( $object, $method );
			} else {
				$callback = $func;
			}

			// Run autoloader (workaround for call_user_func_array bug)
			is_callable( $callback );

			/**
			 * Call the hook. The documentation of call_user_func_array clearly
			 * states that FALSE is returned on failure. However this is not
			 * case always. In some version of PHP if the function signature
			 * does not match the call signature, PHP will issue an warning:
			 * Param y in x expected to be a reference, value given.
			 *
			 * In that case the call will also return null. The following code
			 * catches that warning and provides better error message. The
			 * function documentation also says that:
			 *     In other words, it does not depend on the function signature
			 *     whether the parameter is passed by a value or by a reference.
			 * There is also PHP bug http://bugs.php.net/bug.php?id=47554 which
			 * is unsurprisingly marked as bogus. In short handling of failures
			 * with call_user_func_array is a failure, the documentation for that
			 * function is wrong and misleading and PHP developers don't see any
			 * problem here.
			 */
			$retval = null;

			$retval = call_user_func_array( $callback, $hook_args );

			// Process the return value.
			if ( is_string( $retval ) ) {
				// String returned means error.
				throw new FatalError( $retval );
			} elseif ( $retval === false ) {
				// False was returned. Stop processing, but no error.
				return false;
			}
		}

		return true;
	}

}
