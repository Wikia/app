<?php
/**
 * @file
 * @ingroup Profiler
 */

/**
 * ProfilerSimpleUDP class, that sends out messages for 'udpprofile' daemon
 * (the one from mediawiki/trunk/udpprofile SVN )
 * @ingroup Profiler
 */
class ProfilerSimpleUDP extends ProfilerSimple {

	const SCRIBE_KEY = 'mwprofiler_data';

	public function logData() {
		global $wgUDPProfilerHost, $wgUDPProfilerPort, $wgProfilerSendViaScribe;

		$this->close();

		if ( isset( $this->mCollated['-total'] ) && $this->mCollated['-total']['real'] < $this->mMinimumTime ) {
			# Less than minimum, ignore
			return;
		}

		if ( !MWInit::functionExists( 'socket_create' ) ) {
			# Sockets are not enabled
			return;
		}

		$profilerId = $this->getProfileID();

		if ( !empty($wgProfilerSendViaScribe) ) {
			$this->logDataScribe( $profilerId );
			return;
		}

		$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		$plength = 0;
		$packet = "";
		foreach ( $this->mCollated as $entry => $pfdata ) {
			if( !isset($pfdata['count'])
				|| !isset( $pfdata['cpu'] )
				|| !isset( $pfdata['cpu_sq'] )
				|| !isset( $pfdata['real'] )
				|| !isset( $pfdata['real_sq'] ) ) {
				continue;
			}
			$pfline = sprintf( "%s %s %d %f %f %f %f %s\n", $profilerId, "-", $pfdata['count'],
				$pfdata['cpu'], $pfdata['cpu_sq'], $pfdata['real'], $pfdata['real_sq'], $entry);
			$length = strlen( $pfline );
			/* printf("<!-- $pfline -->"); */
			if ( $length + $plength > 1400 ) {
				socket_sendto( $sock, $packet, $plength, 0, $wgUDPProfilerHost, $wgUDPProfilerPort );
				$packet = "";
				$plength = 0;
			}
			$packet .= $pfline;
			$plength += $length;
		}
		socket_sendto( $sock, $packet, $plength, 0x100, $wgUDPProfilerHost, $wgUDPProfilerPort );
	}

	public function logDataScribe( $profilerId ) {
		global $wgProfilerMinimumTime;

		if ( !is_callable( array( 'WScribeClient', 'singleton' ) ) ) {
			if ( function_exists( 'wfIncrStats' ) ) {
				wfIncrStats('mwprofiler-scribe-not-available');
			}
			return false;
		}

		$entries = array();
		foreach ( $this->mCollated as $name => $pfdata ) {
			if( !isset($pfdata['count'])
				|| !isset( $pfdata['cpu'] )
				|| !isset( $pfdata['cpu_sq'] )
				|| !isset( $pfdata['real'] )
				|| !isset( $pfdata['real_sq'] ) ) {
				continue;
			}
			if ( $pfdata['real'] < $wgProfilerMinimumTime ) {
				continue;
			}
			$entries[$name] = array( $pfdata['count'],
				round($pfdata['cpu'],6),
				round($pfdata['cpu_sq'],6),
				round($pfdata['real'],6),
				round($pfdata['real_sq'],6),
			);
		}

		$data = array(
			'engine' => 'mwprofiler',
			'profile' => $profilerId,
			'entries' => $entries,
		);
		if ( is_callable( array( 'Transaction', 'getAll' ) ) ) {
			$data['context'] = Transaction::getAll();
		}

		$data = json_encode( $data );

		try {
			WScribeClient::singleton( self::SCRIBE_KEY )->send( $data );
		} catch ( TException $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
		}

		return true;
	}

}
