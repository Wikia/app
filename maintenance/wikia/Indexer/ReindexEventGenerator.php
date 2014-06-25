<?php

require_once( dirname( __FILE__ ) . '/IndexerWorkerBase.php' );

class ReindexEventGenerator extends IndexerWorkerBase {

	const WG_CONTENT_NAMESPACES_KEY = 'wgContentNamespaces';
	const DELAY = 1000; //1m = 1sec
	private $delay;

	public function __construct() {
		parent::__construct();
		$this->addOption('delay', 'Delay in micro seconds between messages', false, true);
	}

	protected function preprocess() {
		$this->delay = $this->getOption( 'delay', static::DELAY );
		$db = wfGetDB( DB_SLAVE );
		$namespaces = WikiFactory::getVarValueByName( self::WG_CONTENT_NAMESPACES_KEY, $this->city_id );
		( new WikiaSQL() )->SELECT('page_id')->FROM('page')->WHERE('page_namespace')->IN($namespaces)
			->runLoop($db, function (&$d, $row) {
				$msg = new stdClass();
				$msg->cityId = $this->city_id;
				$msg->pageId = $row->page_id;
				$this->publish('article.index', $msg);
				usleep($this->delay);
			});
	}
}

$maintClass = 'ReindexEventGenerator';

$instance = new $maintClass;
$instance->execute();

