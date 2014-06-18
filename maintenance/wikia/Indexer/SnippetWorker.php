<?php

use Wikia\JsonFormat\JsonFormatWorker;

require_once( dirname( __FILE__ ) . '/../../../extensions/wikia/JsonFormat/JsonFormatWorker.class.php' );
require_once( dirname( __FILE__ ) . '/IndexerWorkerBase.php' );

class SnippetWorker extends IndexerWorkerBase {

	const PREFETCH_SIZE = 5;
	private $worker;

	protected function process( $data ) {
		if( !$data->is_redirect ) {
			$jw = $this->get_worker();
			$jw->setHtml( $data->html );
			$msg = new stdClass();
			$msg->snippet = $jw->process();
			$msg->id = $data->id;
			$this->publish('snippet.ready', $msg );
		}
	}

	protected function getRoutingKey() {
		return 'article.ready';
	}

	protected function get_worker() {
		if ( !isset( $this->worker ) ) {
			$this->worker = new JsonFormatWorker();
		}
		return $this->worker;
	}
}

$maintClass = 'SnippetWorker';
require( RUN_MAINTENANCE_IF_MAIN );