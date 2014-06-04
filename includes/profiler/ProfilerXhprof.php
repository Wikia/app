<?php
/**
 * ProfilerXhprof implements profiler interface for Mediawiki and delegates profiling
 * data collection to Facebook's XHProf extension. Afterwards sends the gathered data
 * to UDP formatted in similar way to regular ProfilerSimpleUDP.
 *
 * @author wladek
 */
class ProfilerXhprof extends ProfilerStub {

	const UDP_PACKET_MAX_SIZE = 1000;

	/**
	 * @var bool Is XHProf initialized in this request?
	 */
	protected static $initialized = false;

	/**
	 * Create a new ProfilerXhprof instance and bind to request shutdown event to transfer
	 * collected data.
	 */
	public function __construct() {
		if ( !self::$initialized ) {
			self::$initialized = true;
			if ( !function_exists('xhprof_enable') ) {
				return;
			}
			xhprof_enable(XHPROF_FLAGS_NO_BUILTINS);
			register_shutdown_function(array($this,'finalize'));
		}
	}

	/**
	 * Collect XHProf data and send it to the destination host through UDP.
	 *
	 * DO NOT CALL DIRECTLY! Has to be public as it's called from outside the class.
	 *
	 * @access private
	 */
	public function finalize() {
		if ( !function_exists('xhprof_disable') ) {
			return;
		}
		$data = xhprof_disable();
		$data = $this->parse($data);
		$data = $this->filter($data);
		$this->send($data);
	}

	/**
	 * Parse raw xhprof profiling data and return per-function summarized values.
	 * Removes closure entries as they are more misleading than helpful.
	 * Renames "main()" to "-total" which is better-known in MW world.
	 *
	 * @param $data array Raw XHProf profiling data
	 * @return array Per-function summary
	 */
	protected function parse( $data ) {
		$ndata = array();
		foreach ($data as $k => $v) {
			$p = strpos($k,'==>');
			if ( $p !== false ) {
				$k = substr($k,$p+3);
			} else if ( $k === 'main()' ) {
				$k = '-total';
			} else {
				continue;
			}
			if ( substr($k,0,9) === '{closure}' ) {
				// closure data is more misleading than helpful
				continue;
			}
			// collapse different versions of the same function
			$p = strpos($k,'@');
			if ( $p !== false ) {
				$k = substr($k,0,$p);
			}
			// scale times to MW standard (us => s)
			if ( isset($v['wt']) ) $v['wt'] /= 1000000;
			if ( isset($v['rt']) ) $v['rt'] /= 1000000;
			foreach ($v as $k2 => $v2) {
				@$ndata[$k][$k2] += $v2;
			}
		}
		uasort($ndata,function($a,$b){
			return $a['wt'] <= $b['wt'];
		});
		return $ndata;
	}

	/**
	 * Filter given profiling data.
	 * Removes entries that are invalid or didn't reach the time threshold to be reported.
	 *
	 * @param $data array
	 * @return array
	 */
	protected function filter($data) {
		$config = $this->config();
		$minimumTime = $config['minimum_time'];
		foreach ( $data as $k => $v ) {
			if( (isset($v['ct']) && isset( $v['wt']))
				&& $v['wt'] >= $minimumTime ) {
				continue;
			}
			unset($data[$k]);
		}
		return $data;
	}

	/**
	 * Send data through UDP socket to the destination host.
	 *
	 * @param $data array Data ready to be sent
	 */
	protected function send($data) {
		$config = $this->config();
		$udpHost = $config['host'];
		$udpPort = $config['port'];
		$dbName = $config['db_name'];
		$maxPacketSize = self::UDP_PACKET_MAX_SIZE;

		print "<!-- xhprof:dest=$udpHost:$udpPort -->";

		$profilerId = function_exists('wfWikiID') ? wfWikiID() : $dbName;

		$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		$plength = 0;
		$packet = "";
		foreach ( $data as $entry => $pfdata ) {
			$pfline = sprintf( "%s %s %d %f %f %f %f %s\n", $profilerId, "-", $pfdata['ct'],
				-1, -1, $pfdata['wt'], -1, $entry);
			$length = strlen( $pfline );
//			printf("<!-- $pfline -->");
			if ( $length + $plength > $maxPacketSize ) {
				socket_sendto( $sock, $packet, $plength, 0, $udpHost, $udpPort );
				$packet = "";
				$plength = 0;
			}
			$packet .= $pfline;
			$plength += $length;
		}
		socket_sendto( $sock, $packet, $plength, 0x100, $udpHost, $udpPort );
	}

	/**
	 * Get configuration from global variables
	 * Reads global variables each time in order to reflect changes in global variables
	 * during the request (constructor is called before all the configuration files are read).
	 *
	 * @return array Configuration
	 */
	protected function config() {
		global $wgUDPProfilerHost, $wgXhprofUDPHost, $wgXhprofUDPPort, $wgXhprofMinimumTime, $wgDBname;
		$config = array(
			'host' => isset($wgXhprofUDPHost) ? $wgXhprofUDPHost : $wgUDPProfilerHost,
			'port' => $wgXhprofUDPPort,
			'minimum_time' => $wgXhprofMinimumTime,
			'db_name' => $wgDBname,
		);
		return $config;
	}

}