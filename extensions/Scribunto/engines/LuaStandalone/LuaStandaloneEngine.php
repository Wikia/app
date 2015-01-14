<?php

class Scribunto_LuaStandaloneEngine extends Scribunto_LuaEngine {
	static $clockTick;
	var $initialStatus;

	public function load() {
		parent::load();
		if ( php_uname( 's' ) === 'Linux' ) {
			$this->initialStatus = $this->interpreter->getStatus();
		} else {
			$this->initialStatus = false;
		}
	}

	public function getPerformanceCharacteristics() {
		return array(
			'phpCallsRequireSerialization' => true,
		);
	}

	/**
	 * @return string
	 */
	function getLimitReport() {
		$this->load();
		if ( !$this->initialStatus ) {
			return '';
		}
		$status = $this->interpreter->getStatus();
		$lang = Language::factory( 'en' );
		return 
			'Lua time usage: ' . sprintf( "%.3f", $status['time'] / $this->getClockTick() ) . "s\n" .			
			'Lua virtual size: ' . 
			$lang->formatSize( $status['vsize'] ) . ' / ' . 
			$lang->formatSize( $this->options['memoryLimit'] ) . "\n" .
			'Lua estimated memory usage: ' .
			$lang->formatSize( $status['vsize'] - $this->initialStatus['vsize'] ) . "\n";
	}

	/**
	 * @return mixed
	 */
	function getClockTick() {
		if ( self::$clockTick === null ) {
			wfSuppressWarnings();
			self::$clockTick = intval( shell_exec( 'getconf CLK_TCK' ) );
			wfRestoreWarnings();
			if ( !self::$clockTick ) {
				self::$clockTick = 100;
			}
		}
		return self::$clockTick;
	}

	/**
	 * @return Scribunto_LuaStandaloneInterpreter
	 */
	function newInterpreter() {
		return new Scribunto_LuaStandaloneInterpreter( $this, $this->options );
	}
}

class Scribunto_LuaStandaloneInterpreter extends Scribunto_LuaInterpreter {
	var $engine, $enableDebug, $proc, $writePipe, $readPipe, $exitError;

	function __construct( $engine, $options ) {
		if ( $options['errorFile'] === null ) {
			$options['errorFile'] = wfGetNull();
		}
		if ( $options['luaPath'] === null ) {
			$path = false;

			if ( PHP_OS == 'Linux' ) {
				if ( PHP_INT_SIZE == 4 ) {
					$path = 'lua5_1_5_linux_32_generic/lua';
				} elseif ( PHP_INT_SIZE == 8 ) {
					$path = 'lua5_1_5_linux_64_generic/lua';
				}
			} elseif ( PHP_OS == 'Windows' || PHP_OS == 'WINNT' || PHP_OS == 'Win32' ) {
				if ( PHP_INT_SIZE == 4 ) {
					$path = 'lua5_1_4_Win32_bin/lua5.1.exe';
				} elseif ( PHP_INT_SIZE == 8 ) {
					$path = 'lua5_1_4_Win64_bin/lua5.1.exe';
				}
			} elseif ( PHP_OS == 'Darwin' ) {
				$path = 'lua5_1_5_mac_lion_fat_generic/lua';
			}
			if ( $path === false ) {
				throw new Scribunto_LuaInterpreterNotFoundError( 
					'No Lua interpreter was given in the configuration, ' .
					'and no bundled binary exists for this platform.' );
			}
			$options['luaPath'] = dirname( __FILE__ ) . "/binaries/$path";
		}

		$this->engine = $engine;
		$this->enableDebug = !empty( $options['debug'] );

		$pipes = null;
		$cmd = wfEscapeShellArg(
			$options['luaPath'], 
			dirname( __FILE__ ) . '/mw_main.lua',
			dirname( dirname( dirname( __FILE__ ) ) ) );
		if ( php_uname( 's' ) == 'Linux' ) {
			// Limit memory and CPU
			$cmd = wfEscapeShellArg(
				'/bin/sh',
				dirname( __FILE__ ) . '/lua_ulimit.sh', 
				$options['cpuLimit'], # soft limit (SIGXCPU)
				$options['cpuLimit'] + 1, # hard limit
				intval( $options['memoryLimit'] / 1024 ),
				$cmd );
		}

		if ( php_uname( 's' ) == 'Windows NT' ) {
			// Like the passthru() in older versions of PHP,
			// PHP's invokation of cmd.exe in proc_open() is broken:
			// http://news.php.net/php.internals/21796
			// Unlike passthru(), it is not fixed in any PHP version,
			// so we use the fix similar to one in wfShellExec()
			$cmd = '"' . $cmd . '"';
		}
		
		wfDebug( __METHOD__.": creating interpreter: $cmd\n" );

		$this->proc = proc_open(
			$cmd, 
			array(
				array( 'pipe', 'r' ),
				array( 'pipe', 'w' ),
				array( 'file', $options['errorFile'], 'a' )
			),
			$pipes );
		if ( !$this->proc ) {
			throw $this->engine->newException( 'scribunto-luastandalone-proc-error' );
		}
		$this->writePipe = $pipes[0];
		$this->readPipe = $pipes[1];
	}

	function __destruct() {
		$this->terminate();
	}

	public function terminate() {
		if ( $this->proc ) {
			wfDebug( __METHOD__.": terminating\n" );
			proc_terminate( $this->proc );
			proc_close( $this->proc );
			$this->proc = false;
		}
	}

	public function quit() {
		if ( !$this->proc ) {
			return;
		}
		$this->dispatch( array( 'op' => 'quit' ) );
		proc_close( $this->proc );
	}

	public function loadString( $text, $chunkName ) {
		$result = $this->dispatch( array(
			'op' => 'loadString',
			'text' => $text,
			'chunkName' => $chunkName
		) );
		return new Scribunto_LuaStandaloneInterpreterFunction( $result[1] );
	}

	public function callFunction( $func /* ... */ ) {
		if ( !($func instanceof Scribunto_LuaStandaloneInterpreterFunction) ) {
			throw new MWException( __METHOD__.': invalid function type' );
		}
		$args = func_get_args();
		unset( $args[0] );
		// $args is now conveniently a 1-based array, as required by the Lua server

		$result = $this->dispatch( array(
			'op' => 'call',
			'id' => $func->id,
			'nargs' => count( $args ),
			'args' => $args ) );
		// Convert return values to zero-based
		return array_values( $result );
	}

	public function wrapPhpFunction( $callable ) {
		static $uid = 0;
		$id = "anonymous*" . ++$uid;
		$this->callbacks[$id] = $callable;
		$ret = $this->dispatch( array(
			'op' => 'wrapPhpFunction',
			'id' => $id ) );
		return $ret[1];
	}

	public function isLuaFunction( $object ) {
		return $object instanceof Scribunto_LuaStandaloneInterpreterFunction;
	}

	public function registerLibrary( $name, $functions ) {
		$functionIds = array();
		foreach ( $functions as $funcName => $callback ) {
			$id = "$name-$funcName";
			$this->callbacks[$id] = $callback;
			$functionIds[$funcName] = $id;
		}
		$this->dispatch( array(
			'op' => 'registerLibrary',
			'name' => $name,
			'functions' => $functionIds ) );
	}

	public function getStatus() {
		$result = $this->dispatch( array(
			'op' => 'getStatus' ) );
		return $result[1];
	}

	/**
	 * Fill in missing nulls in a list received from Lua
	 *
	 * @param $array array List received from Lua
	 * @param $count integer Number of values that should be in the list
	 * @return array Non-sparse array
	 */
	private static function fixNulls( array $array, $count ) {
		if ( count( $array ) === $count ) {
			return $array;
		} else {
			return array_replace( array_fill( 1, $count, null ), $array );
		}
	}

	protected function handleCall( $message ) {
		$message['args'] = self::fixNulls( $message['args'], $message['nargs'] );
		try {
			$result = $this->callback( $message['id'], $message['args'] );
		} catch ( Scribunto_LuaError $e ) {
			return array(
				'op' => 'error',
				'value' => $e->getLuaMessage() );
		}

		// Convert to a 1-based array
		if ( count( $result ) ) {
			$result = array_combine( range( 1, count( $result ) ), $result );
		} else {
			$result = array();
		}

		return array(
			'op' => 'return',
			'nvalues' => count( $result ),
			'values' => $result
		);
	}

	protected function callback( $id, $args ) {
		return call_user_func_array( $this->callbacks[$id], $args );
	}

	protected function handleError( $message ) {
		$opts = array();
		if ( preg_match( '/^(.*?):(\d+): (.*)$/', $message['value'], $m ) ) {
			$opts['module'] = $m[1];
			$opts['line'] = $m[2];
			$message['value'] = $m[3];
		}
		if ( isset( $message['trace'] ) ) {
			$opts['trace'] = array_values( $message['trace'] );
		}
		throw $this->engine->newLuaError( $message['value'], $opts );
	}

	protected function dispatch( $msgToLua ) {
		$this->sendMessage( $msgToLua );
		while ( true ) {
			$msgFromLua = $this->receiveMessage();

			switch ( $msgFromLua['op'] ) {
				case 'return':
					return self::fixNulls( $msgFromLua['values'], $msgFromLua['nvalues'] );
				case 'call':
					$msgToLua = $this->handleCall( $msgFromLua );
					$this->sendMessage( $msgToLua );
					break;
				case 'error':
					$this->handleError( $msgFromLua );
					return; // not reached
				default:
					wfDebug( __METHOD__ .": invalid response op \"{$msgFromLua['op']}\"\n" );
					throw $this->engine->newException( 'scribunto-luastandalone-decode-error' );
			}
		}
	}

	protected function sendMessage( $msg ) {
		$this->debug( "TX ==> {$msg['op']}" );
		$this->checkValid();
		// Send the message
		$encMsg = $this->encodeMessage( $msg );
		if ( !fwrite( $this->writePipe, $encMsg ) ) {
			// Write error, probably the process has terminated
			// If it has, checkStatus() will throw. If not, throw an exception ourselves.
			$this->checkStatus();
			throw $this->engine->newException( 'scribunto-luastandalone-write-error' );
		}
	}

	protected function receiveMessage() {
		$this->checkValid();
		// Read the header
		$header = fread( $this->readPipe, 16 );
		if ( strlen( $header ) !== 16 ) {
			$this->checkStatus();
			throw $this->engine->newException( 'scribunto-luastandalone-read-error' );
		}
		$length = $this->decodeHeader( $header );

		// Read the reply body
		$body = '';
		$lengthRemaining = $length;
		while ( $lengthRemaining ) {
			$buffer = fread( $this->readPipe, $lengthRemaining );
			if ( $buffer === false || feof( $this->readPipe ) ) {
				$this->checkStatus();
				throw $this->engine->newException( 'scribunto-luastandalone-read-error' );
			}
			$body .= $buffer;
			$lengthRemaining -= strlen( $buffer );
		}
		$msg = unserialize( $body );
		$this->debug( "RX <== {$msg['op']}" );
		return $msg;
	}

	protected function encodeMessage( $message ) {
		$serialized = $this->encodeLuaVar( $message );
		$length = strlen( $serialized );
		$check = $length * 2 - 1;

		return sprintf( '%08x%08x%s', $length, $check, $serialized );
	}

	protected function encodeLuaVar( $var, $level = 0 ) {
		if ( $level > 100 ) {
			throw new MWException( __METHOD__.': recursion depth limit exceeded' );
		}
		$type = gettype( $var );
		switch ( $type ) {
			case 'boolean':
				return $var ? 'true' : 'false';
			case 'integer':
				return $var;
			case 'double':
				if ( !is_finite( $var ) ) {
					if ( is_nan( $var ) ) {
						return '(0/0)';
					}
					if ( $var === INF ) {
						return '(1/0)';
					}
					if ( $var === -INF ) {
						return '(-1/0)';
					}
					throw new MWException( __METHOD__.': cannot convert non-finite number' );
				}
				return $var;
			case 'string':
				return '"' .
					strtr( $var, array( 
						'"' => '\\"',
						'\\' => '\\\\',
						"\n" => '\\n',
						"\r" => '\\r',
						"\000" => '\\000',
					) ) .
					'"';
			case 'array':
				$s = '{';
				foreach ( $var as $key => $element ) {
					if ( $s !== '{' ) {
						$s .= ',';
					}
					$s .= '[' . $this->encodeLuaVar( $key, $level + 1 ) . ']' .
						'=' . $this->encodeLuaVar( $element, $level + 1 );
				}
				$s .= '}';
				return $s;
			case 'object':
				if ( $var instanceof Scribunto_LuaStandaloneInterpreterFunction ) {
					return 'chunks[' . intval( $var->id )  . ']';
				} else {
					throw new MWException( __METHOD__.': unable to convert object of type ' . 
						get_class( $var ) );
				}
			case 'resource':
				throw new MWException( __METHOD__.': unable to convert resource' );
			case 'NULL':
				return 'nil';
			default:
				throw new MWException( __METHOD__.': unable to convert variable of unknown type' );
		}
	}

	protected function decodeHeader( $header ) {
		$length = substr( $header, 0, 8 );
		$check = substr( $header, 8, 8 );
		if ( !preg_match( '/^[0-9a-f]+$/', $length ) || !preg_match( '/^[0-9a-f]+$/', $check ) ) {
			throw $this->engine->newException( 'scribunto-luastandalone-decode-error' );
		}
		$length = hexdec( $length );
		$check = hexdec( $check );
		if ( $length * 2 - 1 !== $check ) {
			throw $this->engine->newException( 'scribunto-luastandalone-decode-error' );
		}
		return $length;
	}

	protected function checkValid() {
		if ( !$this->proc ) {
			wfDebug( __METHOD__ . ": process already terminated\n" );
			if ( $this->exitError ) {
				throw $this->exitError;
			} else {
				throw $this->engine->newException( 'scribunto-luastandalone-gone' );
			}
		}
	}

	protected function checkStatus() {
		$this->checkValid();
		$status = proc_get_status( $this->proc );
		if ( !$status['running'] ) {
			wfDebug( __METHOD__.": not running\n" );
			proc_close( $this->proc );
			$this->proc = false;
			if ( $status['signaled'] ) {
				$this->exitError = $this->engine->newException( 'scribunto-luastandalone-signal',
					array( 'args' => array( $status['termsig'] ) ) );
			} elseif ( defined( 'SIGXCPU' ) && $status['exitcode'] == 128 + SIGXCPU ) {
				$this->exitError = $this->engine->newException( 'scribunto-common-timeout' );
			} else {
				$this->exitError = $this->engine->newException( 'scribunto-luastandalone-exited',
					array( 'args' => array( $status['exitcode'] ) ) );
			}
			throw $this->exitError;
		}
	}

	protected function debug( $msg ) {
		if ( $this->enableDebug ) {
			wfDebug( "Lua: $msg\n" );
		}
	}
}

class Scribunto_LuaStandaloneInterpreterFunction {
	public $id;

	function __construct( $id ) {
		$this->id = $id;
	}
}
