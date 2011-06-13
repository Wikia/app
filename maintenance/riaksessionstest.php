<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

// Configuration - start
//define('RIAKTEST_DEVBOX','wladek');
$SJC_APACHES = array( 'ap-s20', 'ap-s21', 'ap-s22', 'ap-s23', 'ap-s24', 'ap-s25' );
$IOWA_APACHES = array( 'ap-i15', 'ap-i16', 'ap-i17', 'ap-i18', 'ap-i19', 'ap-i20' );
// Configuration - end

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );

$optionsWithArgs = array(
	'username',
	'password',
);

require_once( "commandLine.inc" );

class RandomPool {

	public function __construct( $data ) {
		$this->data = $data;
		$this->pool = array_keys($this->data);
		$this->last = null;
	}

	public function get() {
		$val = $this->_get();
//		var_dump("RandomPool",$val);
		return $val;
	}

	protected function _get() {
		if (empty($this->data))
			return null;
		else if (count($this->data) == 1)
			return reset($this->data);

		if (empty($this->pool))
			$this->pool = array_keys($this->data);
		while (true) {
			$n = rand(0, count($this->pool) - 1);
			$key = $this->pool[$n];
			if ($key !== $this->last) {
				$this->last = $key;
				array_splice($this->pool,$n,1,array());
				return $this->data[$key];
			}
		}
		// never reached
		return null;
	}

}

class HttpSession {

	protected $cookieFile = false;
	protected $xxx = 1;

	public function __construct() {
		$this->cookieFile = tempnam('/tmp','riaktest');
	}

	public function __destruct() {
//		unlink($this->cookieFile);
	}

	public function post( $host, $url, $data = array(), $options = array() ) {
		$curlOptions = array(
			CURLINFO_HEADER_OUT => true,
			CURLOPT_COOKIEJAR => $this->cookieFile,
			CURLOPT_COOKIEFILE => $this->cookieFile,
		);
		if ($host) {
			$curlOptions = array(
				CURLOPT_HTTPPROXYTUNNEL => false,
				CURLOPT_PROXY => $host,
			) + $curlOptions;
		}
		if (isset($options['cookies'])) {
			$curlOptions[CURLOPT_COOKIE] = $options['cookies'];
		}


		return Http::post($url,array(
			'curlOptions' => $curlOptions,
			'postData' => $data,
		));
	}

}

class MediawikiHttpSession extends HttpSession {

	public $apiDefaults = array(
		'format' => 'json',
	);
	public $cookies = '';
	public $apiUrl = 'http://www.wikia.com/api.php';

	public function api( $host, $data = array(), $options = array() ) {
//		var_dump($host);
//		var_dump($data);
		$result = $this->post( $host, $this->apiUrl, array_merge( $this->apiDefaults, $data ),
			array_merge( array(
//				'cookies' => $this->cookies,
			), $options ) );
//		var_dump($result);
		return $result;
	}

	public function logIn( $host, $username, $password ) {
		$data = $this->api($host,array(
			'action' => 'login',
			'lgname' => $username,
			'lgpassword' => $password,
		));
//		var_dump($data);
		$data = Wikia::json_decode($data,true);
		if (isset($data['login']['token'])) {
			$this->token = $data['login']['token'];
			$this->cookies = $data['login']['cookieprefix'].'_session='.$this->token;
			$data = $this->api($host,array(
				'action' => 'login',
				'lgname' => $username,
				'lgpassword' => $password,
				'lgtoken' => $this->token,
			));
//			var_dump($data);
			$data = Wikia::json_decode($data,true);
			if (isset($data['login']['result']) && $data['login']['result'] == 'Success' )
				return true;
		}

		return false;
	}
}

class RiakSessionsTest {

	const SJC = 'SJC';
	const IOWA = 'IOWA';

	protected $defaultHost = 'www.wikia.com';

	protected $wasError = false;

	protected $sjc;
	protected $iowa;
	protected $http;

	protected $username;
	protected $password;

	public function __construct( $options ) {
		// load command line options
		$this->options = $options;
		$this->username = @$this->options['username'];
		$this->password = @$this->options['password'];

		// initialize helpers
		if (!defined('RIAKTEST_DEVBOX')) {
			global $SJC_APACHES, $IOWA_APACHES;
			$this->sjc = new RandomPool($SJC_APACHES);
			$this->iowa = new RandomPool($IOWA_APACHES);
		} else {
			$this->defaultHost = RIAKTEST_DEVBOX.'.wikia-dev.com';
			$this->sjc = new RandomPool(array($this->defaultHost));
			$this->iowa = new RandomPool(array($this->defaultHost));
		}
		$this->mw = new MediawikiHttpSession();
		$this->mw->apiUrl = "http://".$this->defaultHost."/api.php";
	}

	protected function api( $host, $data ) {
		$out = $this->mw->api($host,$data);
		if (is_string($out))
			$out = @Wikia::json_decode($out,true);
		return $out;
	}

	protected function randomString( $length ) {
		for ($s='',$i=0;$i<$length;$i++)
			$s .= chr(rand(ord('A'),ord('Z')));
		return $s;
	}

	protected function testScenario1( $bucket, $key, $value ) {
		$key = $this->randomString(10);
		$val1 = $this->randomString(50);
		$val2 = $this->randomString(50);

		// step 1 - log in
		$status = $this->mw->logIn($this->defaultHost, $this->username, $this->password);
		if (!$status)
			die('Could not log in\n');

		// step 2
		$data = $this->api($this->sjc->get(),array(
			'action' => 'riakaccess',
			'op' => 'set',
			'bucket' => 'riaktest',
			'key' => $key,
			'value' => $val1,
		));
		$data = !empty($data['riakaccess']) ? $data['riakaccess'] : array();
		$this->assert($data && $data['status'],"Create session @ one of SJC apaches");

		// step 3
		$data = $this->api($this->sjc->get(),array(
			'action' => 'riakaccess',
			'op' => 'get',
			'bucket' => 'riaktest',
			'key' => $key,
		));
		$data = !empty($data['riakaccess']) ? $data['riakaccess'] : array();
		$this->assert($data && $data['status'] && !$data['empty'] && $data['value'] === $val1,"Read session data @ another SJC apache");

		// step 4
		$data = $this->api($this->iowa->get(),array(
			'action' => 'riakaccess',
			'op' => 'get',
			'bucket' => 'riaktest',
			'key' => $key,
		));
		$data = !empty($data['riakaccess']) ? $data['riakaccess'] : array();
		$this->assert($data && $data['status'] && !$data['empty'] && $data['value'] === $val1,"Read session data @ one of Iowa apaches");

		// step 5
		$data = $this->api($this->sjc->get(),array(
			'action' => 'riakaccess',
			'op' => 'set',
			'bucket' => 'riaktest',
			'key' => $key,
			'value' => $val2,
		));
		$data = !empty($data['riakaccess']) ? $data['riakaccess'] : array();
		$this->assert($data && $data['status'],"Update session data @ one of SJC apaches");

		// step 6
		$data = $this->api($this->sjc->get(),array(
			'action' => 'riakaccess',
			'op' => 'get',
			'bucket' => 'riaktest',
			'key' => $key,
		));
		$data = !empty($data['riakaccess']) ? $data['riakaccess'] : array();
		$this->assert($data && $data['status'] && !$data['empty'] && $data['value'] === $val2,"Read session data @ another SJC apache");

		// step 7
		$data = $this->api($this->iowa->get(),array(
			'action' => 'riakaccess',
			'op' => 'get',
			'bucket' => 'riaktest',
			'key' => $key,
		));
		$data = !empty($data['riakaccess']) ? $data['riakaccess'] : array();
		$this->assert($data && $data['status'] && !$data['empty'] && $data['value'] === $val2,"Read session data @ one of Iowa apaches");

		// step 8
		$data = $this->api($this->sjc->get(),array(
			'action' => 'riakaccess',
			'op' => 'delete',
			'bucket' => 'riaktest',
			'key' => $key,
		));
		$data = !empty($data['riakaccess']) ? $data['riakaccess'] : array();
		$this->assert($data && $data['status'],"Delete session data @ one of SJC apaches");

		// step 9
		$data = $this->api($this->sjc->get(),array(
			'action' => 'riakaccess',
			'op' => 'get',
			'bucket' => 'riaktest',
			'key' => $key,
		));
		$data = !empty($data['riakaccess']) ? $data['riakaccess'] : array();
		$this->assert($data && $data['status'] && $data['empty'] && $data['value'] === false,"Read session data @ another SJC apache");

		// step 10
		$data = $this->api($this->iowa->get(),array(
			'action' => 'riakaccess',
			'op' => 'get',
			'bucket' => 'riaktest',
			'key' => $key,
		));
		$data = !empty($data['riakaccess']) ? $data['riakaccess'] : array();
		$this->assert($data && $data['status'] && $data['empty'] && $data['value'] === false,"Read session data @ one of Iowa apaches");

		if ($this->wasError) {
			exit(1);
		}
	}

	protected function assert( $status, $message ) {
		if (!$status) {
			echo "error: {$message}\n";
			$this->wasError = true;
		}
	}

	public function execute() {
		$this->testScenario1('riaktest','riaktest','riaktest');
	}

}

/**
 * used options:
 */
$maintenance = new RiakSessionsTest( $options );
$maintenance->execute();
