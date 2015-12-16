<?php

namespace Wikia\IndexingPipeline;

class MySQLMetricWorkerConnectionBase extends ConnectionBase {

	public function __construct() {
		global $wgMySQLMetricWorker;
		$this->host = $wgMySQLMetricWorker[ 'host' ];
		$this->port = $wgMySQLMetricWorker[ 'port' ];
		$this->user = $wgMySQLMetricWorker[ 'user' ];
		$this->pass = $wgMySQLMetricWorker[ 'pass' ];
		$this->vhost = $wgMySQLMetricWorker[ 'vhost' ];
		$this->exchange = $wgMySQLMetricWorker[ 'exchange' ];
		$this->deadExchange = $wgMySQLMetricWorker[ 'deadExchange' ];
	}
}
