<?php

namespace Wikia\Swift\Wiki;

use Wikia\Swift\Entity\Container;
use Wikia\Swift\Entity\Local;
use Wikia\Swift\Entity\Remote;
use Wikia\Swift\Http\HttpRunner;
use Wikia\Swift\Logger\LoggerFeature;
use Wikia\Swift\Net\Cluster;
use Wikia\Swift\Operation\Delete;
use Wikia\Swift\Operation\Operation;
use Wikia\Swift\Operation\Upload;
use Wikia\Swift\S3\Bucket;
use Wikia\Swift\Status\AggregateStatus;
use Wikia\Swift\Status\StatusPrinter;
use Wikia\Swift\Transaction\OperationList;
use Wikia\Swift\Transaction\ThrottledOperationList;

class Target {
	protected $cluster;
	protected $container;
	public function __construct( Cluster $cluster, Container $container ) {
		$this->cluster = $cluster;
		$this->container = $container;
	}
	public function getCluster() { return $this->cluster; }
	public function getContainer() { return $this->container; }
}


abstract class Migration {
	use LoggerFeature;

	const BATCH_RETRY_LIMIT = 3;

	protected $targets;
	protected $files;
	protected $threads = 10;

	protected $operations;
	protected $targetOperationLists;

	protected $invalidFiles = array();

	public function __construct( array $targets, $files ) {
		$this->targets = $targets;
		$this->files = $files;
	}

	public function setThreads( $threads ) {
		$this->threads = $threads;
	}

	protected function buildOperations() {
		$this->invalidFiles = array();
		$operations = array();
		foreach ($this->files as $file) {
			$localFile = new Local($file['src'],$file['metadata'],$file['mime']);
			$remoteFile = new Remote($file['dest']);
			$upload = new Upload($localFile,$remoteFile);

			$localFile->loadExists();
			if ( !$localFile->exists() ) {
				$this->invalidFiles[] = $localFile;
				$this->logError("File not found: " . $localFile->getLocalPath() );
				continue;
			}
			if ( !is_readable($localFile->getLocalPath()) ) {
				$this->logError("Permissions problem (read denied): " . $localFile->getLocalPath());
			}

			$operations[$upload->getId()] = $upload;
		}
		return $operations;
	}

	protected function getOperationsFor( Target $target ) {
		return $this->operations;
	}

	protected function buildTargetRunners() {
		$threadsPerRunner = intval($this->threads / count($this->targets));
		$targetRunners = array();
		/** @var Target $target */
		foreach ($this->targets as $target) {
			$this->logInfo("Building operation list for: ".$target->getCluster()->getName());
			$targetRunner = new ThrottledOperationList($target,$this->getOperationsFor($target));
			$targetRunner->setThreads($threadsPerRunner);
			$targetRunner->copyLogger($this);
			$targetRunners[] = $targetRunner;
		}
		return $targetRunners;
	}

	public function run() {
		$this->operations = $this->buildOperations();

		$this->targetOperationLists = $this->buildTargetRunners();

		$statuses = array();
		/** @var OperationList $list */
		foreach ($this->targetOperationLists as $list) {
			$statuses[] = $list->getResult()->getStatus();
		}
		$statusPrinter = new StatusPrinter(new AggregateStatus($statuses));

		$this->logInfo("Starting to execute queued operations...");

		for ($r=0;$r<self::BATCH_RETRY_LIMIT;$r++) {
			$httpRunner = new HttpRunner($this->targetOperationLists);
			$httpRunner->copyLogger($this);
			$httpRunner->setStatusCallback(array($statusPrinter,'printStatus'));
			$httpRunner->run();

			$failedCount = $this->getFailedCount();
			if ( $failedCount == 0 ) {
				break;
			}

			if ( $r < self::BATCH_RETRY_LIMIT - 1 ) {
				$this->logError(sprintf("%d operations failed in last batch, retrying(%d)...",$failedCount,$r));
				sleep(10);
				/** @var OperationList $list */
				foreach ($this->targetOperationLists as $list) {
					$list->retry();
				}
			}
		}

		$statusPrinter->finish();
	}

	public function getInvalid() {
		return $this->invalidFiles;
	}

	public function getListNames() {
		$names = array();
		/** @var OperationList $list */
		foreach ($this->targetOperationLists as $list) {
			$names[] = $list->getName();
		}
		return $names;
	}

	public function getCompleted() {
		$result = array();
		/** @var OperationList $list */
		foreach ($this->targetOperationLists as $list) {
			$completed = $list->getCompleted();
			$result[$list->getName()] = $completed;
		}
		return $result;
	}

	public function getFailed() {
		$result = array();
		/** @var OperationList $list */
		foreach ($this->targetOperationLists as $list) {
			$failed = $list->getFailed();
			$result[$list->getName()] = $failed;
		}
		return $result;
	}

	public function getFailedCount() {
		$failedCount = 0;
		/** @var OperationList $list */
		foreach ($this->targetOperationLists as $list) {
			$failedCount += count($list->getFailed());
		}
		return $failedCount;
	}

}

class SimpleMigration extends Migration {

}

class DiffMigration extends Migration {
	protected $remoteFilter;
	protected $useDeletes = true;
	public function setRemoteFilter( $remoteFilter ) {
		$this->remoteFilter = $remoteFilter;
	}
	public function setUseDeletes( $useDeletes ) {
		$this->useDeletes = $useDeletes;
	}

	protected function getOperationsFor( Target $target ) {
		$builder = new DiffOperationListBuilder($target,$this->operations,$this->remoteFilter,$this->useDeletes);
		$builder->copyLogger($this);
		return $builder->build();
	}
}

class DiffOperationListBuilder {
	use LoggerFeature;

	/** @var Target $target */
	protected $target;
	protected $operations;
	/** @var WikiFilesFilter $filter */
	protected $remoteFilter;
	protected $useDeletes;


	public function __construct( Target $target, $operations, $remoteFilter, $useDeletes = true ) {
		$this->target = $target;
		$this->operations = $operations;
		$this->remoteFilter = $remoteFilter;
		$this->useDeletes = $useDeletes;
	}

	protected function getLoggerPrefix() { return $this->target->getCluster()->getName(); }

	public function build() {
		$operations = $this->operations;
		$target = $this->target;

		$this->logDebug("Calculating diff of files in file system and ceph");
		$requests = array();
		/** @var Operation $operation */
		foreach ($operations as $operation) {
			$requests[$operation->getRemote()->getRemotePath()] = $operation;
		}

		$this->logDebug(sprintf("Found %d files in file system",count($requests)));

		$this->logDebug("Fetching list of objects from ceph...");
		$cluster = $target->getCluster();
		$container = $target->getContainer();
		$bucket = new Bucket($cluster,$container);
		$existing = $bucket->getItems();
		if ( $this->remoteFilter ) {
			$this->remoteFilter->copyLogger($this);
			$existing = $this->remoteFilter->filter($existing);
		}

		$this->logDebug(sprintf("Found %d files in ceph",count($existing)));
//		var_dump(array_keys($requests),array_keys($existing));
//		die();
//

		$deleteRequests = array();
		if ( $this->useDeletes ) {
			// delete orhapns
			foreach ($existing as $k => $remote) {
				if ( empty($requests[$k]) ) {
					$deleteRequests[] = new Delete($remote);
					unset($existing[$k]);
				}
			}

			$this->logDebug(sprintf("Found %d extra files in ceph, scheduling deletes",count($deleteRequests)));
		}

		// skip already existing files
		/** @var Operation $request */
		foreach ($requests as $k => $request) {
			if ( !empty($existing[$k]) ) {
				/** @var Remote $remote */
				$remote = $existing[$k];
				$local = $request->getLocal();
				$local->load();
				if ( $local->getMd5() === $remote->getMd5() && $local->getSize() === $remote->getSize() ) {
					unset($requests[$k]);
				}
			}
		}

		$this->logDebug(sprintf("Found %d exact files, skipping",count($operations)-count($requests)));

		// prevent key-clashing (which shouldn't happen btw.)
		$requests = array_merge(array_values($requests),array_values($deleteRequests));

		$this->logDebug(sprintf("Final operation list contains %d operations",count($requests)));

		if ( count($requests) <= 400000 ) {
			/** @var Operation $request */
			foreach ($requests as $request) {
				$this->logDebug($request->getDescription());
			}
		} else {
			$this->logDebug("Skipped listing all requests due to number of them");
		}

		return $requests;
	}

}

class WikiFilesFilter {
	use LoggerFeature;

	protected $prefix;
	protected $regex;

	public function __construct( $prefix ) {
		$this->prefix = ltrim($prefix,'/');
		$prefixRegex = preg_quote($this->prefix);
		$this->regex = "#^$prefixRegex/([0-9a-fA-F]/[0-9a-fA-F]{2}/|archive/[0-9a-fA-F]/[0-9a-fA-F]{2}/|deleted/([0-9a-zA-Z]/){3})#";
	}

	protected function getLoggerPrefix() { return 'files-filter'; }

	public function filter( $files ) {
		$this->logDebug(sprintf("Got %d files to process...",count($files)));
		/** @var Remote $remote */
		foreach ($files as $k => $remote) {
			$path = $remote->getRemotePath();
			if ( !preg_match($this->regex,$path) ) {
				unset($files[$k]);
			}
		}
		$this->logDebug(sprintf("Returning %d files that matched the wiki files regex...",count($files)));
		return $files;
	}
}

class AvatarFilesFilter {
	use LoggerFeature;

	protected $prefix;
	protected $regex;

	public function __construct( $prefix ) {
		$this->prefix = ltrim($prefix,'/');
		$prefixRegex = preg_quote($this->prefix);
		$this->regex = "#^$prefixRegex/[0-9a-fA-F]/[0-9a-fA-F]{2}/#";
	}

	protected function getLoggerPrefix() { return 'files-filter'; }

	public function filter( $files ) {
		$this->logDebug(sprintf("Got %d files to process...",count($files)));
		/** @var Remote $remote */
		foreach ($files as $k => $remote) {
			$path = $remote->getRemotePath();
			if ( !preg_match($this->regex,$path) ) {
				unset($files[$k]);
			}
		}
		$this->logDebug(sprintf("Returning %d files that matched the wiki files regex...",count($files)));
		return $files;
	}
}