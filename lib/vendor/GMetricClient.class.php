<?php

/*
 * GMetricClient class
 *
 * Ganglia 3.1 client sending metrics using UDP protocol
 *
 * Based on:
 * @see http://embeddedgmetric.googlecode.com/svn-history/r149/trunk/php/gmetric.php
 * @see http://search-hadoop.com/c/Hadoop:/hadoop-common-project/hadoop-common/src/main/java/org/apache/hadoop/metrics/ganglia/GangliaContext31.java
 *
 * @author Maciej Brencz
 */

class GMetricClient extends WikiaObject {

	const GANGLIA_SLOPE_ZERO = 0;       // data is fixed, mostly unchanging
    const GANGLIA_SLOPE_POSITIVE = 1;   // value is always increasing (counter)
    const GANGLIA_SLOPE_NEGATIVE = 2;   // value is always decreasing
    const GANGLIA_SLOPE_BOTH = 3;       // value can be anything
    const GANGLIA_SLOPE_UNSPECIFIED = 4;

	const GANGLIA_VALUE_STRING = 'string';
	const GANGLIA_VALUE_UNSIGNED_SHORT = 'uint16';
	const GANGLIA_VALUE_SHORT = 'int16';
	const GANGLIA_VALUE_UNSIGNED_INT = 'uint32';
	const GANGLIA_VALUE_INT = 'int32';
	const GANGLIA_VALUE_FLOAT = 'float';
	const GANGLIA_VALUE_DOUBLE = 'double';

	const GANGLIA_PACKET_TYPE_METADATA = 128;
	const GANGLIA_PACKET_TYPE_VALUE = 133;

	const GANGLIA_SPOOF_ENABLED = 1;
	const GANGLIA_SPOOF_DISABLED = 0;

	// hostname to be spoofed
	private $spoofHostname = false;

	// name of the group of values
	private $group = false;

	// prefix to be added to each value name
	private $prefix = false;

	// queued metrics
	private $metrics = array();

	// UDP "connection"
	private $conn = false;

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Set group for all metrics to be sent
	 *
	 * @param string $group group name
	 */
	public function setGroup($group) {
		$this->group = $group;
	}

	/**
	 * Set name prefix for all metrics to be sent
	 *
	 * @param string $prefix prefix
	 */
	public function setPrefix($prefix) {
		$this->prefix = $prefix;
	}

	/**
	 * Use hostname spoofing feature
	 *
	 * @param string $ip spoffed hostname IP (can be fake one)
	 * @param string $host spoffed hostname
	 */
	public function setHostnameSpoof($ip, $host) {
		$this->spoofHostname = "{$ip}:{$host}";
	}

	/**
	 * Add a metric to be sent to Ganglia
	 *
	 * @param string $name name of the metric
	 * @param string $type type of the metric (see GANGLIA_VALUE_* constants)
	 * @param mixed $value metric value
	 * @param int $slope how can metric value change (default = unspecified)
	 * @param int $tmax the maximum time in seconds between gmetric calls (default = 1h)
	 * @prama int $dmax the lifetime in seconds of this metric (default = 0)
	 */
	public function addMetric($name, $type, $value, $slope = self::GANGLIA_SLOPE_UNSPECIFIED, $tmax = 3600, $dmax = 0) {
		$this->metrics[] = array(
			'name' => $name,
			'type' => $type,
			'value' => (string) $value,
			'slope' => $slope,
			'tmax' => $tmax,
			'dmax' => $dmax
		);
	}

	/**
	 * Send queued metrics to a given Ganglia deamon
	 *
	 * @param string $host Ganglia host
	 * @param integer $port Ganglia port
	 */
	public function send($host, $port) {
		$this->conn = fsockopen("udp://$host", $port, $errno, $errstr);

		if (!$this->conn) {
			throw new WikiaException($errstr, $errno);
		}

		// send values
		foreach($this->metrics as $metric) {
			$this->sendMetric($metric);
		}

		// clear the queue
		$this->metrics = array();

		return fclose($this->conn);
	}

	/**
	 * Send two packets for each metric
	 *
	 * @param mixed $metric single metric
	 */
	private function sendMetric(Array $metric) {
		if ($this->prefix !== false) {
			$metric['name'] = "{$this->prefix}-{$metric['name']}";
		}

		// spoof header
		$spoffHeader = '';

		if ($this->spoofHostname === false) {
			$spoffHeader .= self::xdr_string('UNKNOWN.example.com');
			$spoffHeader .= self::xdr_string($metric['name']);
			$spoffHeader .= self::xdr_uint32(self::GANGLIA_SPOOF_DISABLED);
		}
		else {
			$spoffHeader .= self::xdr_string($this->spoofHostname);
			$spoffHeader .= self::xdr_string($metric['name']);
			$spoffHeader .= self::xdr_uint32(self::GANGLIA_SPOOF_ENABLED);
		}

		// @see https://github.com/ganglia/ganglia_contrib/blob/master/gmetric-python/gmetric.py
		$str  = self::xdr_uint32(self::GANGLIA_PACKET_TYPE_METADATA);
		$str .= $spoffHeader;

		$str .= self::xdr_string($metric['type']);
		$str .= self::xdr_string($metric['name']);
		$str .= self::xdr_string('' /* units */);
		$str .= self::xdr_uint32($metric['slope']);
		$str .= self::xdr_uint32($metric['tmax']);
		$str .= self::xdr_uint32($metric['dmax']);

		if ($this->group === false) {
			$str .= self::xdr_uint32(0);
		}
		else {
			$str .= self::xdr_uint32(1);
			$str .= self::xdr_string('GROUP');
			$str .= self::xdr_string($this->group);
		}

		//Wikia::hex($str);
		fwrite($this->conn, $str);

		$str  = self::xdr_uint32(self::GANGLIA_PACKET_TYPE_VALUE);
		$str .= $spoffHeader;
		$str .= self::xdr_string('%s'); // format field
		$str .= self::xdr_string($metric['value']);

		//Wikia::hex($str);
		fwrite($this->conn, $str);
	}

	private static function xdr_uint32($val) {
		return pack("N", intval($val));
	}

	private static function xdr_string($str) {
		$len = strlen(strval($str));
		$pad = (4 - $len % 4) % 4;
		return self::xdr_uint32($len) . $str . pack("a$pad", "");
	}
}
