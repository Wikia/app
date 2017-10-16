<?php

namespace Wikia\Swift\Http;

use Wikia\Swift\Logger\LoggerFeature;
use Wikia\Swift\Net\IDirector;

interface IHttpRequest {
	public function getCurlRequest();
	public function onComplete( HttpResponse $response );
}
interface IHttpRequestSource {
	public function next();
	public function onRunnerStart( HttpRunner $runner );
}

class HttpResponse {
	protected $result;
	protected $handle;
	protected $headers;
	protected $content;

	public function __construct( $result, $handle, $headers, $content ) {
		$this->result = $result;
		$this->handle = $handle;
		$this->headers = $headers;
		$this->content = $content;
	}

	public function getResult() { return $this->result; }
	public function isGood() { return $this->result === CURLE_OK; }
	public function getHandle() { return $this->handle; }
	public function getCode() { return curl_getinfo($this->handle,CURLINFO_HTTP_CODE); }
	public function getHeaders() { return $this->headers; }
	public function getContent() { return $this->content; }
}

class HttpRunner {
	use LoggerFeature;

	const FETCH_BATCH_LIMIT = 500;
	const CURL_EXEC_LIMIT = 10000;

	protected $sources;
	protected $debug = false;
	protected $mh;

	/** @var callable */
	protected $statusCallback = null;
	protected $active = array();
	protected $headers = array();

	public function __construct( $sources ) {
		$this->sources = $sources;
	}

	protected function getLoggerPrefix() { return 'runner'; }
	public function setDebug( $debug ) {
		$this->debug = $debug;
	}
	public function setStatusCallback( callable $statusCallback ) {
		$this->statusCallback = $statusCallback;
	}

	public function run() {
		$this->mh = curl_multi_init();

		$inactiveFor = -1;
		$running = null;

		$lastStatus = time();

		/** @var IHttpRequestSource $source */
		foreach ($this->sources as $source) {
			$source->onRunnerStart($this);
		}
		$this->fetchRequests();

		if ( !empty($this->active) ) {
			do {
				$st = microtime(true);
				curl_multi_select($this->mh);
				$st = microtime(true) - $st;
				// do the hard work
				for ($i=0;$i<self::CURL_EXEC_LIMIT;$i++) {
					$status = curl_multi_exec($this->mh,$running);
					if ( $status !== CURLM_CALL_MULTI_PERFORM ) break;
					$inactiveFor = -1;
				}
				// find out if any of the requests has been finished
				$j = 0;
				while ( ($info = curl_multi_info_read($this->mh)) !== false ) {
					$j++;
					$this->handleMessage($info);
					$inactiveFor = -1;
				}
				// fill up the queue
				$k = $this->fetchRequests();
				// increase the inactive loop counter
				$inactiveFor++;
				if ( time() >= $lastStatus + 1 ) {
					$lastStatus = time();
					if ( $this->statusCallback ) {
						$statusCallback = $this->statusCallback;
						$statusCallback($this);
					}
				}
//				$this->logTrace(11,sprintf("select_time=%.5f exec_count=%d info_count=%d added_count=%d\n",
//						$st, $i, $j, $k ));
			} while ($inactiveFor <= 3 || !empty($this->active) );
		}

		curl_multi_close($this->mh);
		$this->mh = null;
	}

	protected function fetchRequests() {
		$added = 0;
		/** @var IHttpRequestSource $source */
		foreach ($this->sources as $source) {
			$i = 0;
			while ( $i++ < self::FETCH_BATCH_LIMIT && ($request = $source->next()) ) {
				$added++;
				$this->addRequest($request);
			}
		}
		return $added;
	}

	protected function addRequest( IHttpRequest $request ) {
		$ch = $request->getCurlRequest();
		if ( !is_resource($ch) ) {
			return;
		}
		curl_setopt($ch,CURLOPT_HEADERFUNCTION,array($this,'_header_cb'));
		$resourceId = intval($ch);
		$this->active[$resourceId] = $request;
		$this->headers[$resourceId] = '';
		curl_multi_add_handle($this->mh,$ch);
	}

	protected function handleMessage( $info ) {
		$ch = $info['handle'];
		$resourceId = intval($ch);
		$content = curl_multi_getcontent($ch);

		/** @var IHttpRequest $request */
		$request = $this->active[$resourceId];
		unset($this->active[$resourceId]);
		curl_multi_remove_handle($this->mh,$ch);

		$headers = $this->headers[$resourceId];
		unset($this->headers[$resourceId]);

		$response = new HttpResponse($info['result'],$info['handle'],$headers,$content);
		$request->onComplete($response);
	}

	public function _header_cb( $ch, $s ) {
		$resourceId = intval($ch);
		$this->headers[$resourceId] .= $s;
		return strlen($s);
	}

}

class SimpleHttpGetRequest {
	protected $hostnames;
	protected $url;
	protected $retryLimit;

	public function __construct( IDirector $director, $url, $retryLimit = 3 ) {
		$this->director = $director;
		$this->url = $url;
		$this->retryLimit = $retryLimit;
	}

	public function execute() {
		$except = array();
		for ($i=0;$i<$this->retryLimit;$i++) {
			$host = $this->director->get($except);
			$hostname = $host->getHostname();
			$url = "http://{$hostname}{$this->url}";
			$contents = file_get_contents($url);
			if ( $contents !== false ) {
				return $contents;
			}
		}
		throw new \Exception("Could not fetch the following URL: {$this->url}");
	}

}