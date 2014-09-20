<?php
/**
 * Basic services that Lua libraries will probably need
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @author Brad Jorsch
 */

/**
 * This class provides some basic services that Lua libraries will probably need
 */
abstract class Scribunto_LuaLibraryBase {
	private $engine;

	/**
	 * Constructor.
	 *
	 * @param $engine Scribunto_LuaEngine
	 * @return Scribunto_LuaLibraryBase $this
	 */
	function __construct( Scribunto_LuaEngine $engine ) {
		$this->engine = $engine;
	}

	/**
	 * Called to register the library.
	 *
	 * This should do any necessary setup and then call $this->getEngine()->registerInterface()
	 *
	 * @return void
	 */
	abstract function register();

	/**
	 * Get the engine
	 *
	 * @return Scribunto_LuaEngine engine
	 */
	protected function getEngine() {
		return $this->engine;
	}

	/**
	 * Get the interpreter
	 *
	 * @return Scribunto_LuaInterpreter interpreter
	 */
	protected function getInterpreter() {
		return $this->engine->getInterpreter();
	}

	/**
	 * Get the parser
	 *
	 * @return Parser parser
	 */
	protected function getParser() {
		return $this->engine->getParser();
	}

	/**
	 * Get the title
	 *
	 * @return Title title
	 */
	protected function getTitle() {
		return $this->getEngine()->getTitle();
	}

	/**
	 * Get the parser options
	 *
	 * @return ParserOptions parser options
	 */
	protected function getParserOptions() {
		return $this->engine->getParser()->getOptions();
	}

	/**
	 * Get the Lua type corresponding to the type of the variable.
	 *
	 * If the variable does not correspond to any type, the PHP type will be
	 * returned (prefixed with "PHP"). For example, "PHP resource" or "PHP
	 * object of class Foo".
	 *
	 * @param $var mixed Variable to test
	 * @return string Type
	 */
	protected function getLuaType( $var ) {
		static $luaTypes = array(
			'NULL' => 'nil',
			'double' => 'number',
			'integer' => 'number',
			'string' => 'string',
			'boolean' => 'boolean',
			'array' => 'table',
		);
		$type = gettype( $var );
		if ( isset( $luaTypes[$type] ) ) {
			return $luaTypes[$type];
		} elseif ( $this->getInterpreter()->isLuaFunction( $var ) ) {
			return 'function';
		} else {
			$type = "PHP $type";
			if ( is_object( $var ) ) {
				$type .= " of class " . get_class( $var );
			}
			return $type;
		}
	}

	/**
	 * Check the type of a variable
	 *
	 * If the type of the variable does not match the expected type,
	 * a Scribunto_LuaError will be thrown.
	 *
	 * @param $name string Name of the calling function (as seen from Lua)
	 * @param $argIdx integer Index of the argument being tested (1-based)
	 * @param $arg mixed Variable to test
	 * @param $expectType string Lua type expected
	 * @return void
	 */
	protected function checkType( $name, $argIdx, $arg, $expectType ) {
		$type = $this->getLuaType( $arg );
		if ( $type !== $expectType ) {
			throw new Scribunto_LuaError(
				"bad argument #$argIdx to '$name' ($expectType expected, got $type)"
			);
		}
	}

	/**
	 * Check the type of a variable, with default if null
	 *
	 * If the variable is null, $default will be assigned. Otherwise, if the
	 * type of the variable does not match the expected type, a
	 * Scribunto_LuaError will be thrown.
	 *
	 * @param $name string Name of the calling function (as seen from Lua)
	 * @param $argIdx integer Index of the argument being tested (1-based)
	 * @param &$arg mixed Variable to test/set
	 * @param $expectType string Lua type expected
	 * @param $default mixed Default value
	 * @return void
	 */
	protected function checkTypeOptional( $name, $argIdx, &$arg, $expectType, $default ) {
		if ( $arg === null ) {
			$arg = $default;
		} else {
			$this->checkType( $name, $argIdx, $arg, $expectType );
		}
	}

	/**
	 * Increment the expensive function count, and throw if limit exceeded
	 *
	 * @return null
	 */
	public function incrementExpensiveFunctionCount() {
		return $this->getEngine()->incrementExpensiveFunctionCount();
	}
}
