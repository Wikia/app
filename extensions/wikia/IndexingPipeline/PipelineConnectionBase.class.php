<?php

namespace Wikia\IndexingPipeline;

class PipelineConnectionBase extends ConnectionBase {

	public function __construct() {
		global $wgIndexingPipeline;
		$this->host = $wgIndexingPipeline[ 'host' ];
		$this->port = $wgIndexingPipeline[ 'port' ];
		$this->user = $wgIndexingPipeline[ 'user' ];
		$this->pass = $wgIndexingPipeline[ 'pass' ];
		$this->vhost = $wgIndexingPipeline[ 'vhost' ];
		$this->exchange = $wgIndexingPipeline[ 'exchange' ];
		$this->deadExchange = $wgIndexingPipeline[ 'deadExchange' ];
	}
}
