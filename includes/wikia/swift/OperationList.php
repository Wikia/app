<?php

namespace Wikia\Swift\Transaction;

use Wikia\Swift\Entity\Local;
use Wikia\Swift\Http\HttpResponse;
use Wikia\Swift\Http\HttpRunner;
use Wikia\Swift\Http\IHttpRequest;
use Wikia\Swift\Http\IHttpRequestSource;
use Wikia\Swift\Logger\LoggerFeature;
use Wikia\Swift\Net\Host;
use Wikia\Swift\Net\RandomDirector;
use Wikia\Swift\Operation\Delete;
use Wikia\Swift\Operation\Operation;
use Wikia\Swift\Operation\Upload;
use Wikia\Swift\Status\AggregateStatus;
use Wikia\Swift\Status\CountStatus;
use Wikia\Swift\Status\NamedAggregateStatus;
use Wikia\Swift\Status\SizeStatus;
use Wikia\Swift\Status\StatusPrinter;
use Wikia\Swift\Wiki\Target;

class OperationList implements IHttpRequestSource {
	use LoggerFeature;

	const RETRY_LIMIT = 3;

	protected $cluster;
	protected $container;
	protected $operations;

	protected $queueBuilt = false;
	protected $queue = array();
	protected $active = array();

	protected $result = null;
	protected $completed = array();
	protected $failed = array();

	public function __construct( Target $target, array $operations ) {
		$this->target = $target;
		$this->cluster = $target->getCluster();
		$this->container = $target->getContainer();
		$this->operations = $operations;

		$this->director = new RandomDirector($this->cluster);
		$this->result = new OperationListResult($this->target->getCluster()->getName());
	}
	public function getName() { return $this->target->getCluster()->getName(); }
	protected function buildResults() {
		$this->logDebug("Building result objects...\n");
		$countStatus = new CountStatus();
		$countStatus->setTotal(count($this->operations));
		$statusPrinter = new StatusPrinter($countStatus);

		$i = 0;
		/** @var Operation $operation */
		foreach ($this->operations as $k => $operation) {
			$result = new OperationResult($operation);
			$result->copyLogger($this);
			$this->queue[$operation->getId()] = $result;
			$countStatus->completed(1);
			if ( ++$i % 10000 == 0 ) {
				$statusPrinter->printStatus();
			}
		}
		$statusPrinter->finish();
		$this->result->setQueue($this->queue);
		$this->queueBuilt = true;
		$this->logDebug("Finished building result objects...\n");
	}
	protected function getLoggerPrefix() { return $this->target->getCluster()->getName(); }
	public function getResult() { return $this->result; }
	public function getContainer() { return $this->container; }
	public function getCompleted() { return $this->result->getCompleted(); }
	public function getFailed() { return $this->result->getFailed(); }

	public function next() {
		if ( empty($this->queue) ) return null;

		/** @var OperationResult $result */
		$result = null;
		/** @var OperationHttpRequest $request */
		$request = null;
		while ( !$request && count($this->queue) ) {
			$result = array_shift($this->queue);
			$this->active[$result->getId()] = $result;
			$request = $this->createRequest($result);
		}

		$result->logTrace("Adding request to runner.");

		return $request;
	}

	public function onRunnerStart( HttpRunner $runner ) {
		if ( !$this->queueBuilt ) {$this->buildResults(); }
	}

	public function onRequestSuccess( OperationHttpRequest $request, HttpResponse $response ) {
		$id = $request->getId();
		/** @var OperationResult $result */
		$result = $this->active[$id];
		unset($this->active[$id]);

		$this->result->onComplete($result);
		$result->setStatus(OperationResult::COMPLETED);
	}
	public function onRequestFailure( OperationHttpRequest $request, HttpResponse $response ) {
		$id = $request->getId();
		/** @var OperationResult $result */
		$result = $this->active[$id];
		unset($this->active[$id]);

		$hostname = $request->getHost()->getHostname();
		$retryCount = $result->retry( $hostname );
		if ( $retryCount < self::RETRY_LIMIT ) {
			$this->queue[$id] = $result;
			$result->logWarning("Retrying ({$retryCount})...");
		} else {
			$this->result->onFail($result);
			$result->setStatus(OperationResult::ERROR,"Retry limit reached.");
			$result->logError("Retry limit reached. Giving up.");
			$result->logError("Operation failed.");
		}
	}

	protected function createRequest( OperationResult $result ) {
		$operation = $result->getOperation();
		if ( !$operation->verify() ) {
			$id = $result->getId();
			$result->setStatus(OperationResult::ERROR,"Verification error.");
			$result->logError("File not found: " . $operation->getLocal()->getLocalPath());
			unset($this->queue[$id]);
			unset($this->active[$id]); // sanity
			$this->result->onFail($result);
			return null;
		}
		$request = null;
		if ( $operation instanceof Upload ) {
			$host = $this->selectHost($operation,$result);
			$request = new UploadHttpRequest($this,$host,$operation,$result);
			$request->copyLogger($result);
		} else if ( $operation instanceof Delete ) {
			$host = $this->selectHost($operation,$result);
			$request = new DeleteHttpRequest($this,$host,$operation,$result);
			$request->copyLogger($result);
		} else {
			$result->logError("ERROR: Unsupported type of request");
		}
		return $request;
	}

	protected function selectHost( Operation $operation, OperationResult $result ) {
		return $this->director->get($result->getFailedHosts());
	}

	public function retry() {
		$failed = $this->result->getFailed();
		/** @var OperationResult $result */
		foreach ($failed as $result) {
			$result->resetRetries();
			$this->queue[$result->getOperation()->getId()] = $result;
		}
		$this->result->clearFailed();
	}
}

class ThrottledOperationList extends OperationList {
	protected $threads = -1;
	public function setThreads( $threads ) {
		$this->threads = $threads;
	}
	public function next() {
		if ( $this->threads >= 0 && count($this->active) >= $this->threads ) {
			return null;
		}
		return parent::next();
	}
}

class OperationResult_Base {
	use LoggerFeature;
}
class OperationResult extends OperationResult_Base {
	const PENDING = 0;
	const COMPLETED = 1;
	const ERROR = -1;
	const FATAL_ERROR = -2;
	protected $operation;

	protected $status = self::PENDING;
	protected $error = null;
	protected $logs = array();

	protected $totalRetries = 0;
	protected $retries = 0;
	protected $failedHosts = array();

	public function __construct( Operation $operation ) {
		$this->operation = $operation;
	}
	protected function getLoggerPrefix() { return $this->operation->getDescription(); }
	public function getId() { return $this->operation->getId(); }
	public function getOperation() { return $this->operation; }
	public function getFailedHosts() { return $this->failedHosts; }
	public function getStatus() { return $this->status; }
	public function getError() { return $this->error; }

	public function setStatus( $status, $errorMessage = null ) {
		$this->status = $status;
		$this->error = $errorMessage;
	}
	public function retry( $failedHost = null ) {
		if ( $failedHost ) { $this->failedHosts[] = $failedHost; }
		$this->totalRetries++;
		return $this->retries++;
	}
	public function resetRetries() {
		$this->retries = 0;
		$this->failedHosts = array();
	}
	public function log( $level, $message ) {
		$prefix = $this->getLogger()->getPrefix();
		$this->logs[] = $message;
		return parent::log($level,$message);
	}
	public function getLogs() {
		return $this->logs;
	}
}

abstract class OperationHttpRequest implements IHttpRequest {
	use LoggerFeature;

	const CONNECT_TIMEOUT = 10;
	const TIMEOUT = 30;

	protected $runner;
	protected $host;
	protected $operation;
	protected $result;

	public function __construct( OperationList $runner, Host $host, Operation $operation, OperationResult $result ) {
		$this->runner = $runner;
		$this->host = $host;
		$this->operation = $operation;
		$this->result = $result;
	}
	public function getId() { return $this->operation->getId(); }
	public function getHost() { return $this->host; }

	protected function quoteName( $name ) {
		return str_replace("%2F","/",rawurlencode($name));
	}
	public function getRemoteUrl() {
		$path = array();
		// storage url
		$path[] = $this->host->getUrl();
		// container
		$path[] = $this->runner->getContainer()->getName();
		// object
		$path[] = $this->quoteName( $this->operation->getRemote()->getRemotePath() );
		return implode('/',$path);
	}

	protected function logDetails( HttpResponse $response ) {
		$details = array();
		$details[] = "URL: " . $this->getRemoteUrl();
		$details[] = "Response code: " . $response->getCode();
		$details[] = "Response headers: " . $response->getHeaders();
		$details[] = "Response content: " . $response->getContent();
		$this->logError( implode("\n",$details)."\n" );
	}

	public function _read_cb( $ch, $fd, $length ) {
		$chunk = fread($fd, $length);
		$bytesRead = strlen($chunk);
		if ( $length !== $bytesRead ) {
			$currentPos = ftell($fd);
			$local = $this->operation->getLocal();
			if ( $currentPos < $local->getSize() ) {
				$this->logError(sprintf("Could not read from file (pos=%d/%d requested=%d read=%d): %s",
					$currentPos, $local->getSize(),
					$length,$bytesRead,$local->getLocalPath()));
				$localPath = $local->getLocalPath();
				clearstatcache();
				$size = filesize($localPath);
				$md5 = md5_file($localPath);
				$this->logError(sprintf(" * local file details: o(size=%d md5=%s) f(size=%d md5=%s)",
					$local->getSize(),$local->getMd5(),
					$size, $md5
				));
			}
		}
		return $chunk;
	}

}

class UploadHttpRequest extends OperationHttpRequest {
	protected $url;

	protected $fd;
	protected $ch;
	public function getCurlRequest() {
		$this->logTrace("Building curl request.");

		/** @var Local $localFile */
		$localFile = $this->operation->getLocal();
		$localFile->load();

		/** @var Host $host */
		$host = $this->host;

		$this->openFile();

		$headers = array();
		$headers[] = "ETag: {$localFile->getMd5()}";
		$headers[] = "Content-Type: {$localFile->getMimeType()}";
		$headers[] = "X-Auth-Token: {$host->getToken()}";
		foreach ($localFile->getMetadata() as $k => $v) {
			$k = ucfirst(strtolower($k));
			$v = trim($v);
			$headers[] = "X-Object-Meta-$k: $v";
		}

		$url_path = $this->getRemoteUrl();
		$this->url = $url_path;

		$ch = curl_init();

//		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, True);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CONNECT_TIMEOUT);
		curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($ch,$header) {
			return strlen($header);
		});

		curl_setopt($ch, CURLOPT_PUT, 1);
		curl_setopt($ch, CURLOPT_READFUNCTION, array($this, '_read_cb'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_INFILE, $this->fd);
		curl_setopt($ch, CURLOPT_INFILESIZE, $localFile->getSize());
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url_path);

		$this->ch = $ch;

		return $ch;
	}

	public function onComplete( HttpResponse $response ) {
		$this->closeFile();

		if ( $response->getCode() >= 500 ) {
			$this->logError("Server responded with 500: ".$this->url);
		}

		if ( $response->isGood() && $response->getCode() === 201 ) {
			// success
			$this->runner->onRequestSuccess($this,$response);
			$this->logInfo("Completed successfully.");
		} else {
			// failure
			$this->runner->onRequestFailure($this,$response);
			$this->logInfo("Operation failed.");
			$this->logDetails($response);
		}
		curl_close($this->ch);
		$this->ch = null;
	}

	protected function openFile() {
		if ( $this->fd === null ) {
			$this->fd = fopen($this->operation->getLocal()->getLocalPath(),'rb');
		}
	}
	protected function closeFile() {
		if ( $this->fd !== null ) {
			fclose($this->fd);
			$this->fd = null;
		}
	}

}

class DeleteHttpRequest extends OperationHttpRequest {
	protected $ch;
	public function getCurlRequest() {
		$this->logTrace("Building curl request.");

		/** @var Host $host */
		$host = $this->host;

		$headers = array();
		$headers[] = "X-Auth-Token: {$host->getToken()}";

		$url_path = $this->getRemoteUrl();

		$ch = curl_init();

//		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, True);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CONNECT_TIMEOUT);
		curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($ch,$header) {
			return strlen($header);
		});

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_READFUNCTION, array($this, '_read_cb'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url_path);

		$this->ch = $ch;

		return $ch;
	}

	public function onComplete( HttpResponse $response ) {
		if ( $response->isGood() && $response->getCode() >= 200 && $response->getCode() <= 299 ) {
			// success
			$this->runner->onRequestSuccess($this,$response);
			$this->logInfo("Completed successfully.");
		} else {
			// failure
			$this->runner->onRequestFailure($this,$response);
			$this->logInfo("Operation failed.");
			$this->logDetails($response);
		}
		curl_close($this->ch);
		$this->ch = null;
	}

}

class OperationListResult {

	/** @var CountStatus $count */
	protected $count;
	/** @var SizeStatus $size */
	protected $size;
	/** @var NamedAggregateStatus $status */
	protected $status;

	public $failed = array();
	public $completed = array();

	public function __construct( $name ) {
		$this->count = new CountStatus();
		$this->size = new SizeStatus();
		$this->status = new NamedAggregateStatus($name,new AggregateStatus(array($this->count,$this->size)));
	}
	public function setQueue( $queue ) {
		$totalSize = 0;
		$totalCount = 0;
		/** @var OperationResult $result */
		foreach ($queue as $result) {
			$local = $result->getOperation()->getLocal();
			if ( $local ) {
				$local->loadSize();
				$totalSize += $local->getSize();
			}
			$totalCount += 1;
		}
		$this->count->setTotal($totalCount);
		$this->size->setTotal($totalSize);
	}

	public function onComplete( OperationResult $result ) {
		$size = $result->getOperation()->getLocal() ? $result->getOperation()->getLocal()->getSize() : 0;
		$this->count->completed(1);
		$this->size->completed($size);
		$this->completed[] = $result;
	}

	public function onFail( OperationResult $result ) {
		$size = $result->getOperation()->getLocal() ? $result->getOperation()->getLocal()->getSize() : 0;
		$this->count->failed(1);
		$this->size->failed($size);
		$this->failed[] = $result;
	}

	public function clearFailed() {
		$this->count->resetFailed();
		$this->size->resetFailed();
		$this->failed = array();
	}

	public function getFailed() {
		return $this->failed;
	}

	public function getCompleted() {
		return $this->completed;
	}

	public function getStatus() { return $this->status; }

}
