<?php

class Scribunto_LuaSandboxEngine extends Scribunto_LuaEngine {
	public $options, $loaded = false;
	protected $lineCache = array();

	public function getPerformanceCharacteristics() {
		return array(
			'phpCallsRequireSerialization' => false,
		);
	}

	public function getLimitReport() {
		$this->load();
		$lang = Language::factory( 'en' );

		$t = $this->interpreter->getCPUUsage();
		$s = 'Lua time usage: ' . sprintf( "%.3f", $t ) . "s\n" .
			'Lua memory usage: ' . $lang->formatSize( $this->interpreter->getPeakMemoryUsage() ) . "\n";
		if ( $t < 1.0 ) {
			return $s;
		}
		$percentProfile = $this->interpreter->getProfilerFunctionReport( 
			Scribunto_LuaSandboxInterpreter::PERCENT );
		if ( !count( $percentProfile ) ) {
			return $s;
		}
		$timeProfile = $this->interpreter->getProfilerFunctionReport( 
			Scribunto_LuaSandboxInterpreter::SECONDS );

		$s .= "Lua Profile:\n";
		$cumulativePercent = $cumulativeTime = 0;
		$num = $otherTime = $otherPercent = 0;
		$format = "    %-59s %8.0f ms %8.1f%%\n";
		foreach ( $percentProfile as $name => $percent ) {
			$time = $timeProfile[$name] * 1000;
			$cumulativePercent += $percent;
			$cumulativeTime += $time;
			$num++;
			if ( $cumulativePercent <= 99 && $num <= 10 ) {
				// Map some regularly appearing internal names
				if ( preg_match( '/^<mw.lua:(\d+)>$/', $name, $m ) ) {
					$line = $this->getMwLuaLine( $m[1] );
					if ( preg_match( '/^\s*(local\s+)?function ([a-zA-Z0-9_.]*)/', $line, $m ) ) {
						$name = $m[2] . ' ' . $name;
					}
				}
				$s .= sprintf( $format, $name, $time, $percent );
			} else {
				$otherTime += $time;
				$otherPercent += $percent;
			}
		}
		if ( $otherTime ) {
			$s .= sprintf( $format, "[others]", $otherTime, $otherPercent );
		}
		return $s;
	}

	protected function getMwLuaLine( $lineNum ) {
		if ( !isset( $this->lineCache['mw.lua'] ) ) {
			$this->lineCache['mw.lua'] = file( $this->getLuaLibDir() . '/mw.lua' );
		}
		return $this->lineCache['mw.lua'][$lineNum - 1];
	}

	function newInterpreter() {
		return new Scribunto_LuaSandboxInterpreter( $this, $this->options );
	}
}

class Scribunto_LuaSandboxInterpreter extends Scribunto_LuaInterpreter {
	var $engine, $sandbox, $libraries, $profilerEnabled;

	const SAMPLES = 0;
	const SECONDS = 1;
	const PERCENT = 2;

	function __construct( $engine, $options ) {
		if ( !extension_loaded( 'luasandbox' ) ) {
			throw new Scribunto_LuaInterpreterNotFoundError( 
				'The luasandbox extension is not present, this engine cannot be used.' );
		}
		$this->engine = $engine;
		$this->sandbox = new LuaSandbox;
		$this->sandbox->setMemoryLimit( $options['memoryLimit'] );
		$this->sandbox->setCPULimit( $options['cpuLimit'] );
		if ( is_callable( array( $this->sandbox, 'enableProfiler' ) ) ) 
		{
			if ( !isset( $options['profilerPeriod'] ) ) {
				$options['profilerPeriod'] = 0.02;
			}
			if ( $options['profilerPeriod'] ) {
				$this->profilerEnabled = true;
				$this->sandbox->enableProfiler( $options['profilerPeriod'] );
			}
		}
	}

	protected function convertSandboxError( $e ) {
		$opts = array();
		if ( isset( $e->luaTrace ) ) {
			$opts['trace'] = $e->luaTrace;
		}
		$message = $e->getMessage();
		if ( preg_match( '/^(.*?):(\d+): (.*)$/', $message, $m ) ) {
			$opts['module'] = $m[1];
			$opts['line'] = $m[2];
			$message = $m[3];
		}
		return $this->engine->newLuaError( $message, $opts );
	}

	public function loadString( $text, $chunkName ) {
		try {
			return $this->sandbox->loadString( $text, $chunkName );
		} catch ( LuaSandboxError $e ) {
			throw $this->convertSandboxError( $e );
		}
	}
	
	public function registerLibrary( $name, $functions ) {
		$realLibrary = array();
		foreach ( $functions as $funcName => $callback ) {
			$realLibrary[$funcName] = array(
				new Scribunto_LuaSandboxCallback( $callback ),
				$funcName );
		}
		$this->sandbox->registerLibrary( $name, $realLibrary );

		# TODO: replace this with
		#$this->sandbox->registerVirtualLibrary(
		#	$name, array( $this, 'callback' ), $functions );
	}

	public function callFunction( $func /*, ... */ ) {
		$args = func_get_args();
		$func = array_shift( $args );
		try {
			return call_user_func_array( array( $func, 'call' ), $args );
		} catch ( LuaSandboxTimeoutError $e ) {
			throw $this->engine->newException( 'scribunto-common-timeout' );
		} catch ( LuaSandboxError $e ) {
			throw $this->convertSandboxError( $e );
		}
	}

	public function wrapPhpFunction( $callable ) {
		if ( is_callable( array( $this->sandbox, 'wrapPhpFunction' ) ) ) {
			return $this->sandbox->wrapPhpFunction( $callable );
		}

		// We have to hack around the lack of the wrapper function by loading a
		// dummy library with $callable, then extracting the function, and then
		// for good measure nilling out the library table.
		list( $name ) = $this->sandbox->loadString( '
			for i = 0, math.huge do
				if not _G["*LuaSandbox* temp" .. i] then return "*LuaSandbox* temp" .. i end
			end
			' )->call();
		$this->sandbox->registerLibrary( $name, array( 'func' => $callable ) );
		list( $func ) = $this->sandbox->loadString(
			"local ret = _G['$name'].func _G['$name'] = nil return ret"
		)->call();
		return $func;
	}

	public function isLuaFunction( $object ) {
		return $object instanceof LuaSandboxFunction;
	}

	public function getPeakMemoryUsage() {
		return $this->sandbox->getPeakMemoryUsage();
	}

	public function getCPUUsage() {
		return $this->sandbox->getCPUUsage();
	}

	public function getProfilerFunctionReport( $units ) {
		if ( $this->profilerEnabled ) {
			static $unitsMap;
			if ( !$unitsMap ) {
				$unitsMap = array(
					self::SAMPLES => LuaSandbox::SAMPLES,
					self::SECONDS => LuaSandbox::SECONDS,
					self::PERCENT => LuaSandbox::PERCENT );
			}
			return $this->sandbox->getProfilerFunctionReport( $unitsMap[$units] );
		} else {
			return array();
		}
	}
}

class Scribunto_LuaSandboxCallback {
	function __construct( $callback ) {
		$this->callback = $callback;
	}

	/**
	 * We use __call with a variable function name so that LuaSandbox will be 
	 * able to return a meaningful function name in profiling data.
	 */
	function __call( $funcName, $args ) {
		try {
			return call_user_func_array( $this->callback, $args );
		} catch ( Scribunto_LuaError $e ) {
			throw new LuaSandboxRuntimeError( $e->getLuaMessage() );
		}
	}
}
