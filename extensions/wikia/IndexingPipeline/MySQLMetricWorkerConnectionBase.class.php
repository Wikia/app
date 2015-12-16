<?php

namespace Wikia\IndexingPipeline;

class MySQLMetricWorkerConnectionBase extends ConnectionBase {

	public function __construct() {
		global $MySQLMetricWorker;
		$this->host = $MySQLMetricWorker[ 'host' ];
		$this->port = $MySQLMetricWorker[ 'port' ];
		$this->user = $MySQLMetricWorker[ 'user' ];
		$this->pass = $MySQLMetricWorker[ 'pass' ];
		$this->vhost = $MySQLMetricWorker[ 'vhost' ];
		$this->exchange = $MySQLMetricWorker[ 'exchange' ];
		$this->deadExchange = $MySQLMetricWorker[ 'deadExchange' ];
	}
}
