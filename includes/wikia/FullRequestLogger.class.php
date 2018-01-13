<?php

class FullRequestLogger {
	static $data = [];
	static $reasons = [];

	static public function init() {
		self::$data = [
			'REQUEST_URI' => array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : '',
			'GET' => $_GET,
			'POST' => $_POST,
			'COOKIE' => $_COOKIE,
			'SERVER' => $_SERVER,
		];

		if ( !self::needLogging() ) {
			self::$data = null;
			return true;
		}
		$toScramble = [
			'password',
			'newpassword',
			'wpPassword',
			'retype',
		];
		foreach (['GET', 'POST'] as $method) {
			foreach ($toScramble as $name) {
				if (isset(self::$data[$method][$name])) {
					self::$data[$method][$name] = self::scramble(self::$data[$method][$name]);
				}
			}
		}

		self::ellipsis(self::$data['GET']);
		self::ellipsis(self::$data['POST']);

		self::send();

		return true;
	}

	static public function ellipsis( &$data ) {
		if (is_array($data)) {
			array_walk($data, [__CLASS__,'ellipsis']);
		} if (is_string($data)) {
			if (strlen($data) > 200) {
				$data = sprintf("[length=%d]%s...", strlen($data), substr($data,0,180));
			}
		}
	}

	static public function needLogging() {
		global $wgRequest;

		self::$reasons = [];
		$data = self::$data;

		if (
			@$data['GET']['controller'] == 'UserLoginSpecial' || @$data['POST']['controller'] == 'UserLoginSpecial'
			|| stripos(@$data['REQUEST_URI'], ':UserLogin') !== false
		) {
			self::$reasons[] = 'UserLogin';
		}

		$ip = $wgRequest->getIP();
		if ( $ip === null ) {
			$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : null;
		}

		if (
			!is_null($ip) &&
			self::inRange( ip2long($ip), [
				90529792,90532863,90533120,90533887,629866496,629874687,758579200,758607871,758611968,758644735,
				778371072,778395647,778403840,778436607,1357938688,1357942783,1388576768,1388580863,
				1599406080,1599422463,1744670720,1744671743,1753415680,1753481215,1760296960,1760362495,
				1806303232,1806368767,2160533504,2160590847,2365630720,2365630975,2461630464,2461646847,
				2680881152,2680918015,2680942592,2680946687,2733834240,2733899775,2737768448,2737769471,
				2990407680,2990473215,3104749568,3104750591,3164995584,3165030399,3165052928,3165061119,
				3168960512,3168993279,3223468032,3223470079,3226587136,3226591231,3237052416,3237085183,
				3334946816,3334963199,3335741440,3335749631,3494126592,3494127615
			])
		) {
			self::$reasons[] = 'DigitalOcean';
		}

		return !empty(self::$reasons);
	}

	static public function inRange( $value, $ranges ) {
		if ( count($ranges) == 0 || $value < $ranges[0] ) {
			return false;
		}

		$a = 0;
		$b = count($ranges) - 1;
		while ( $a != $b ) {
			$c = intval(($a+$b+1)/2);
			if ( $value < $ranges[$c] ) {
				$b = $c - 1;
			} else if ( $value >= $ranges[$c] ) {
				$a = $c;
			}
		}

		return ($value == $ranges[$a]) || ($a % 2 == 0);
	}

	static public function scramble( $val ) {
		if (is_string($val)) {
			$len = strlen($val);
			$flags = [];
			if ( strpos($val, '"') !== false || strpos($val, "'") !== false ) {
				$flags['Q'] = true;
			}
			if ( strpos($val, ';') !== false ) {
				$flags['S'] = true;
			}
			if ( strpos($val, '-') !== false ) {
				$flags['D'] = true;
			}
			if ( strpos($val, '(') !== false || strpos($val, ')') !== false ) {
				$flags['P'] = true;
			}
			for ($i=0;$i<$len;$i++) {
				$c = ord($val[$i]);
				if ($c < 32 || $c >= 128) {
					$flags['N'] = true;
					break;
				}
			}
			$flagsString = implode('', array_keys($flags));
			return "[str, len=$len, flags=$flagsString]";
		} else {
			return "[type=" . gettype($val) . "]";
		}
	}

	static public function send() {
		if ( !is_callable( 'Wikia\\Logger\\WikiaLogger', 'instance' ) ) {
			return;
		}

		$encoded = json_encode(self::$data);
		$chunks = str_split($encoded, 4096);
		$cnt = count($chunks);

		$n = 0;
		foreach ($chunks as $id => $chunk) {
			$n = $id + 1;
			\Wikia\Logger\WikiaLogger::instance()->info("Full request dump -- chunked -- ($n out of $cnt)",[
				'full_log_chunk_count' => $cnt,
				'full_log_chunk_id' => $n,
				'full_log_json_data' => $chunk,
				'full_log_data_type' => 'chunk',
				'full_log_reasons' => self::$reasons,
			]);
		}
		\Wikia\Logger\WikiaLogger::instance()->info("Full request dump -- all in one",[
			'full_log_chunk_count' => $cnt,
			'full_log_chunk_id' => $n,
			'full_log_json_data' => $encoded,
			'full_log_data_type' => 'full',
			'full_log_reasons' => self::$reasons,
		]);
	}
}
