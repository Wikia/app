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

	protected $targets;
	protected $files;
	protected $threads = 10;

	protected $operations;
	protected $targetOperationLists;

	public function __construct( array $targets, $files ) {
		$this->targets = $targets;
		$this->files = $files;
	}

	public function setThreads( $threads ) {
		$this->threads = $threads;
	}

	protected function buildOperations() {
		$operations = array();
		foreach ($this->files as $file) {
			$localFile = new Local($file['src'],$file['metadata'],$file['mime']);
			$remoteFile = new Remote($file['dest']);
			$upload = new Upload($localFile,$remoteFile);

			$localFile->loadExists();
			if ( !$localFile->exists() ) {
				$this->log(0,"File not found: " . $localFile->getLocalPath() );
				continue;
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
			$this->log(2,"Building operation list for: ".$target->getCluster()->getName());
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

		$httpRunner = new HttpRunner($this->targetOperationLists);
		$httpRunner->copyLogger($this);
		$httpRunner->setStatusCallback(array($statusPrinter,'printStatus'));
		$httpRunner->run();

		$statusPrinter->finish();
	}

}

class SimpleMigration extends Migration {

}

class DiffMigration extends Migration {

	protected function getOperationsFor( Target $target ) {
		$builder = new DiffOperationListBuilder($target,$this->operations);
		$builder->copyLogger($this);
		return $builder->build();
	}
}

class DiffOperationListBuilder {
	use LoggerFeature;

	public function __construct( Target $target, $operations ) {
		$this->target = $target;
		$this->operations = $operations;
	}

	protected function getLoggerPrefix() { return $this->target->getCluster()->getName(); }

	public function build() {
		$operations = $this->operations;
		$target = $this->target;

		$this->log(3,"Calculating diff of files in file system and ceph");
		$requests = array();
		/** @var Operation $operation */
		foreach ($operations as $operation) {
			$requests[$operation->getRemote()->getRemotePath()] = $operation;
		}

		$this->log(3,sprintf("Found %d files in file system",count($requests)));

		$cluster = $target->getCluster();
		$container = $target->getContainer();
		$bucket = new Bucket($cluster,$container);
		$existing = $bucket->getItems();

		$this->log(3,sprintf("Found %d files in ceph",count($existing)));
//		var_dump(array_keys($requests),array_keys($existing));
//		die();
//
		// delete orhapns
		$deleteRequests = array();
		foreach ($existing as $k => $remote) {
			if ( empty($requests[$k]) ) {
				$deleteRequests[] = new Delete($remote);
				unset($existing[$k]);
			}
		}

		$this->log(3,sprintf("Found %d extra files in ceph, scheduling deletes",count($deleteRequests)));

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

		$this->log(3,sprintf("Found %d exact files, skipping",count($operations)-count($requests)));

		// prevent key-clashing (which shouldn't happen btw.)
		$requests = array_merge(array_values($requests),array_values($deleteRequests));

		$this->log(3,sprintf("Final operation list contains %d operations",count($requests)));

		return $requests;
	}

}
