<?php

/**
 * Class ProfilerDataUdpSink implements sending profiling data via UDP
 */
class ProfilerDataUdpSink implements ProfilerDataSink {

	const LESS_THAN_MTU = 1400;

	/**
	 * Send data via UDP
	 *
	 * @param ProfilerData $data
	 */
	public function send( ProfilerData $data ) {
		list( $host, $port ) = $this->getEndpoint( $data->getEngine() );
		if ( !$host || !$port ) {
			return;
		}

		$profile = $data->getProfile();

		$sock = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
		$plength = 0;
		$packet = "";
		foreach ( $data->getEntries() as $name => $pfdata ) {
			foreach (array('cpu','cpu_sq','real','real_sq') as $key) {
				if ( !isset( $pfdata[$key] ) ) {
					$pfdata[$key] = -1;
				}
			}
			$pfline = sprintf( "%s %s %d %f %f %f %f %s\n", $profile, "-", $pfdata['count'],
				$pfdata['cpu'], $pfdata['cpu_sq'], $pfdata['real'], $pfdata['real_sq'], $name );
			$length = strlen( $pfline );
			if ( $length + $plength > self::LESS_THAN_MTU ) {
				socket_sendto( $sock, $packet, $plength, 0, $host, $port );
				$packet = "";
				$plength = 0;
			}
			$packet .= $pfline;
			$plength += $length;
		}
		socket_sendto( $sock, $packet, $plength, 0x100, $host, $port );
	}

	/**
	 * Returns host and port appropriate for the given profiling engine
	 *
	 * @param $engine
	 * @return array
	 */
	protected function getEndpoint( $engine ) {
		global $wgUDPProfilerHost, $wgUDPProfilerPort, $wgXhprofUDPHost, $wgXhprofUDPPort;
		switch ( $engine ) {
			case ProfilerData::ENGINE_MEDIAWIKI:
				return array(
					$wgUDPProfilerHost,
					$wgUDPProfilerPort,
				);
				break;
			case ProfilerData::ENGINE_XHPROF:
				return array(
					isset( $wgXhprofUDPHost ) ? $wgXhprofUDPHost : $wgUDPProfilerHost,
					$wgXhprofUDPPort,
				);
				break;
		}

		return array( false, false );
	}

}
