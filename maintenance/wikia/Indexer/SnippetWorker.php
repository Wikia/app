<?php

use Wikia\JsonFormat\JsonFormatWorker;

require_once( dirname( __FILE__ ) . '/../../../extensions/wikia/JsonFormat/JsonFormatWorker.class.php' );
require_once( dirname( __FILE__ ) . '/IndexerWorkerBase.php' );

class SnippetWorker extends IndexerWorkerBase {

	const PREFETCH_SIZE = 5;
	private $worker;
	private $max = 1000000000 ; //~1GiB

	protected function process( $data ) {
		if( !$data->is_redirect ) {
			$jw = $this->get_worker();
			$jw->setHtml( $data->html );
			$msg = new stdClass();
			$msg->snippet = $jw->process();
			$msg->lang = $data->wiki_lang;
			$msg->id = $data->id;
			$this->publish('snippet.ready', $msg );
		}
		if (memory_get_usage(true) >= $this->max) die("OUT OF MEMORY!");
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

$instance = new $maintClass;
$instance->execute();
