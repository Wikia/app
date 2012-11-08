<?php
/**
 * @file
 * @ingroup Profiler
 */

/**
 * Execution trace
 * @author Władysław Bodzek
 * @todo document methods (?)
 * @ingroup Profiler
 */
class ProfilerWikiaTrace extends ProfilerSimple {
	var $trace = "";
	var $memory = 0;
	protected $timeDiff = 0;

	function __construct( $params ) {
		global $wgRequestTime, $wgRUstart;
		parent::__construct( $params );
		if ( !empty( $wgRequestTime ) && !empty( $wgRUstart ) ) {
			$this->mWorkStack[] = array( '-total', 0, $wgRequestTime, $this->getCpuTime( $wgRUstart ), 0, '' );
		}
		$this->trace .= "Beginning extended trace: \n";
	}

	protected function getStackDiff() {
		global $IP;
		$IPlength = strlen($IP);
		$lastFrame = end($this->mWorkStack);
		$lastStackSize = isset($lastFrame) && isset($lastFrame[4]) ? $lastFrame[4] : 0;
		$stackTrace = debug_backtrace();
		$stackDiff = array();
		while (count($stackTrace)>$lastStackSize) {
			$frame = array_shift($stackTrace);
			if ( $frame['function'] == 'wfProfileIn' && !isset($frame['class']) ) {
				break;
			}
		}
		$stackTraceSize = count($stackTrace);
		while (count($stackTrace)>$lastStackSize) {
			$frame = array_shift($stackTrace);
			if ( !isset($frame['file']) ) {
				$frame['file'] = '(unknown)';
				$frame['line'] = 0;
			} elseif ( substr( $frame['file'], 0, $IPlength ) === $IP ) {
				$frame['file'] = substr($frame['file'],$IPlength);
			}
			array_unshift($stackDiff, sprintf("%s:%d: %s",
				$frame['file'],
				$frame['line'],
				isset($frame['class'])
					? $frame['class'] . $frame['type'] . $frame['function']
					: $frame['function']
				));
		}
		$stackDiff = implode('|',$stackDiff);
		return array( $stackTraceSize, $stackDiff );
	}

	function profileIn($functionname) {
		$start = microtime(true);
		$time = $start - $this->timeDiff;
		$stackData = $this->getStackDiff();
		$cpuTime = $this->getCpuTime();

		$this->mWorkStack[] = array($functionname, count( $this->mWorkStack ), $time, $cpuTime, $stackData[0], $stackData[1] );
		$this->trace .= "         " . sprintf("%6.1f",$this->memoryDiff()) .
			str_repeat( " ", count($this->mWorkStack)) . " > " . $functionname . "\n";
		if ( $stackData[1] ) {
			$this->trace .= "         " . str_repeat( " ", 8 ) .
				str_repeat( " ", count($this->mWorkStack)) . " : stack = " . $stackData[1] . "\n";
		}

		$end = microtime(true);
		$this->timeDiff += $end - $start;
	}

	function profileOut($functionname) {
		global $wgDebugFunctionEntry;

		$start = microtime(true);
		$time = $start - $this->timeDiff;

		if ( $wgDebugFunctionEntry ) {
			$this->debug(str_repeat(' ', count($this->mWorkStack) - 1).'Exiting '.$functionname."\n");
		}

		list( $ofname, /* $ocount */ , $ortime ) = array_pop( $this->mWorkStack );

		if ( !$ofname ) {
			$this->trace .= "Profiling error: $functionname\n";
		} else {
			if ( $functionname == 'close' ) {
				$message = "Profile section ended by close(): {$ofname}";
				$functionname = $ofname;
				$this->trace .= $message . "\n";
			}
			elseif ( $ofname != $functionname ) {
				$this->trace .= "Profiling error: in({$ofname}), out($functionname)";
			}
			$elapsedreal = $time - $ortime;
			$this->trace .= sprintf( "%03.6f %6.1f", $elapsedreal, $this->memoryDiff() ) .
					str_repeat(" ", count( $this->mWorkStack ) + 1 ) . " < " . $functionname . "\n";
		}

		$end = microtime(true);
		$this->timeDiff += $end - $start;
	}

	function memoryDiff() {
		$diff = memory_get_usage() - $this->memory;
		$this->memory = memory_get_usage();
		return $diff / 1024;
	}

	function logData() {
		print "<!-- \n {$this->trace} \n -->";
	}
}
