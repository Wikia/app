<?php
/**
 * PHP client for sending JSON reports to sflow deamon
 *
 * @author macbre
 * @see http://blog.sflow.com/2012_05_01_archive.html
 */
namespace Wikia;

class SFlow {

	const APPLICATION = 'mw';

	/**
	 * Report given operation
	 *
	 * @param string $op_name operation name
	 * @param array $data optional params to be sent
	 */
	public static function operation( $op_name, Array $data = array() ) {
		self::app_operation( self::APPLICATION, $op_name, wfArrayToCGI( $data ) );
	}

	/**
	 * Send a packet to SFlow daemon
	 *
	 * @param $app_name
	 * @param $op_name
	 * @param string $attributes
	 * @param int $status
	 * @param string $status_descr
	 * @param int $req_bytes
	 * @param int $resp_bytes
	 * @param int $uS
	 */
	private static function app_operation( $app_name, $op_name, $attributes = "", $status = 0, $status_descr = "", $req_bytes = 0, $resp_bytes = 0, $uS = 0 ) {
		global $wgSFlowHost, $wgSFlowPort, $wgSFlowSampling;

		// sampling handling
		$sampling_rate = $wgSFlowSampling;

		if ( $sampling_rate > 1 ) {
			if ( mt_rand( 1, $sampling_rate ) != 1 ) {
				return;
			}
		}

		wfProfileIn( __METHOD__ );

		try {
			$sock = fsockopen( "udp://" . $wgSFlowHost, $wgSFlowPort, $errno, $errstr );
			if ( !$sock ) {
				return;
			}

			$data = [
				"flow_sample" => [
					"app_name" => $app_name,
					"sampling_rate" => $sampling_rate,
					"app_operation" => [
						"operation" => $op_name,
						"attributes" => $attributes,
						"status_descr" => $status_descr,
						"status" => $status,
						"req_bytes" => $req_bytes,
						"resp_bytes" => $resp_bytes,
						"uS" => $uS
					]
				]
			];

			$payload = json_encode( $data );
			wfDebug( sprintf( "%s: sending '%s'\n", __METHOD__ , $payload ) );

			fwrite( $sock, $payload );
			fclose( $sock );
		} catch ( \Exception $e ) {
			\Wikia::log( __METHOD__, 'send', $e->getMessage(), true );
			\Wikia::logBacktrace( __METHOD__ );
		}

		wfProfileOut( __METHOD__ );
	}
}
