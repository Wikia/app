<?php
/**
 * Lua parser extensions for MediaWiki - Wrapper classes
 *
 * @author Fran Rogers
 * @package MediaWiki
 * @addtogroup Extensions
 * @license See 'COPYING'
 * @file
 */

/**
 * An exception thrown by LuaWrapper on error; creates a big honking red 
 * message, which can be output to the page in place of the chunk's output.
 */
class LuaError extends Exception {
	/**
	 * Create a new LuaWrapper error.
	 * @param $msg \type{\string} Message from Lua.i18n.php to display
	 * @param $parameter \type{\string} Optional parameter for that message
	 */
	public function __construct($msg, $parameter = ''){
		wfLoadExtensionMessages( 'Lua' );
		$this->message = '<strong class="error">' . wfMsgForContent( "lua_$msg", htmlspecialchars( $parameter ) ) . '</strong>';
	}
}

/**
 * Wraps a Lua interpreter in PHP for MediaWiki's use.
 * Chunks of Lua code are read in as strings, and executed in a single 
 * sandbox environment.
 */
class LuaWrapper {
	private $defunct, $lua, $proc, $pipes;

	/**
	 * Creates a new LuaWrapper.
	 */
	public function __construct() {
		global $wgLuaMaxLines, $wgLuaMaxCalls, 
		       $wgLuaExternalInterpreter, $wgLuaExternalCompiler;

		# Optionally byte-compile the wrapper library
		$wrapperLib = dirname(__FILE__) . '/LuaWrapper.lua';
		$compiledWrapperLib = $wrapperLib.'c';
		if ($wgLuaExternalCompiler && is_writable(dirname($compiledWrapperLib))) {
			if (!file_exists($compiledWrapperLib) ||
			    (filemtime($compiledWrapperLib) < filemtime($wrapperLib))) {
				exec("$wgLuaExternalCompiler -o $compiledWrapperLib $wrapperLib",
				     $output, $res);
				if ($res === 0) {
					$wrapperLib = $compiledWrapperLib;
				}
			} else {
				$wrapperLib = $compiledWrapperLib;
			}
		}

		# Are we using the Lua PHP extension or an external binary?
		if (!$wgLuaExternalInterpreter) {
			# We're using the extension - verify it exists
			if (!class_exists('lua')) {
				$this->defunct = TRUE;
				throw new LuaError('extension_notfound');
			}

			# Create a lua instance and load the wrapper library
			$this->lua = new lua;
			try {
				$this->lua->evaluatefile($wrapperLib);
				$this->lua->evaluate("wrap = make_wrapper($wgLuaMaxLines, $wgLuaMaxCalls)");
			} catch (Exception $e) {
				$this->destroy();
				throw new LuaError('error_internal');
			}

			# Ready to go.
			$this->defunct = FALSE;
			return TRUE;
		} else {
			# We're using an external binary; run the wrapper 
			# library as a shell-script, and it'll start an REPL
			$luacmd = "$wgLuaExternalInterpreter $wrapperLib $wgLuaMaxLines $wgLuaMaxCalls";
			# Create a new process and configure pipes to it
			$this->proc = proc_open($luacmd,
						array(0 => array('pipe', 'r'),
						      1 => array('pipe', 'w')),
						$this->pipes, NULL, NULL);
			if (!is_resource($this->proc)) {
				$this->defunct = TRUE;
				throw new LuaError('interp_notfound');
			}
			stream_set_blocking($this->pipes[0], 0);
			stream_set_blocking($this->pipes[1], 0);
			stream_set_write_buffer($this->pipes[0], 0);
			stream_set_write_buffer($this->pipes[1], 0);

			# Ready to go.
			$this->defunct = FALSE;
			return TRUE;
		}
	}

	/**
	 * Releases this LuaWrapper.
	 */
	public function __destruct() {
		# Call destroy() to do the actual freeing, if necessary
		if (!$this->defunct)
			$this->destroy();
	}

	/**
	 * Parses and executes a chunk of Lua code. The output of the chunk is 
	 * returned as a string; if this LuaWrapper has been marked defunct,
	 * a blank string will be returned instead.
	 * 
	 * @param $input \type{\string} Chunk of Lua code to parse and execute
	 * @return \type{\string} The accumulated output of 
	 *         print()/io.write()/etc. output by the chunk.
	 * @throws LuaWrapperError
	 */
	public function wrap($input) {
		global $wgLuaMaxTime;

		# If defunct, just return a blank string
		if ($this->defunct)
			return '';

		# Are we using the Lua PHP extension or an external binary?
		if (isset($this->lua)) {
			# We're using the extension; call wrap() through the
			# lua instance and collect the results.
			$res = $this->lua->wrap($input);
			$out = $res[0];
			$err = $res[1];
		} else {
			# We're using an external binary; send the chunk
			# through the pipe
			$input = trim(preg_replace('/(?<=\n|^)\.(?=\n|$)/', '. --', $input));
			fwrite($this->pipes[0], "$input\n.\n");
			fflush($this->pipes[0]);

			# Wait for a response back on the other pipe
			$res    = '';
			$read   = array($this->pipes[1]);
			$write  = NULL;
			$except = NULL;
			while (!feof($this->pipes[1])) {
				if (false === ($num_changed_streams =
					       stream_select($read, $write, $except,
							     $wgLuaMaxTime))) {
					throw new LuaError('overflow_time');
				}
				$line = fgets($this->pipes[1]);
				if ($line == ".\n")
					break;
				$res .= $line;
			}

			# Parse the response and collect the results
			if (preg_match('/^\'(.*)\', (true|false)$/s', trim($res), $match) != 1) {
				$this->destroy();
				throw new LuaError('error_internal');
			}
			$success = ($match[2] == 'true');
			$out = $success ? $match[1] : '';
			$err = $success ? NULL      : $match[1];
		}
		# Either way, the output should now be in $out, and if 
		# applicable, the error in $err.

		# If an error was raised, abort and throw an exception
		if ($err != NULL) {
			if (preg_match('/LOC_LIMIT$/', $err)) {
				$this->destroy();
				throw new LuaError('overflow_loc');
			} else if (preg_match('/RECURSION_LIMIT$/', $err)) {
				$this->destroy();
				throw new LuaError('overflow_recursion');
			} else {
				$err = preg_replace('/^\[.+?\]:(.+?):/', '$1:', $err);
				throw new LuaError('error', $err);
			}
		}

		# Return the output
		return (trim($out) != '') ? $out : '';
	}

	/**
	 * Destroy the Lua interpreter and mark this LuaWrapper defunct.
	 * Afterwards, all future calls to wrap() on this object will return 
	 * a blank string.
	 */
	public function destroy() {
		# If we're already defunct, we're done
		if ($this->defunct)
			return FALSE;

		# Destroy the lua instance and/or external process and pipes
		if (isset($this->lua)) {
			$this->lua = NULL;
		} else {
			if (isset($this->proc)) {
				fclose($this->pipes[0]);
				fclose($this->pipes[1]);
				proc_close($this->proc);
			}
		}

		# Mark this instance defunct
		$this->defunct = TRUE;
		return TRUE;
	}
}
