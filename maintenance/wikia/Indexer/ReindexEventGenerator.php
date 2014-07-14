<?php

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
require_once( dirname( __FILE__ ) . '/IndexerWorkerBase.php' );

class ReindexEventGenerator extends Maintenance {
	use IndexerWorkerBase;

	const WG_CONTENT_NAMESPACES_KEY = 'wgContentNamespaces';
	const WG_ENABLE_SMW_KEY = 'wgEnableSemanticMediaWikiExt';
	const DELAY = 1000; //1m = 1sec
	private $delay;
	private $key;

	public function __construct() {
		parent::__construct();
		$this->addOption('delay', 'Delay in micro seconds between messages', false, true);
	}

	protected function preprocess() {
		$this->delay = $this->getOption( 'delay', static::DELAY );
		$db = wfGetDB( DB_SLAVE );
		$namespaces = WikiFactory::getVarValueByName( self::WG_CONTENT_NAMESPACES_KEY, $this->city_id );
		$smw = WikiFactory::getVarValueByName( self::WG_ENABLE_SMW_KEY, $this->city_id );
		$this->key = $smw ? 'article.prod.index' : 'article.index';
		( new WikiaSQL() )->SELECT('page_id')->FROM('page')->WHERE('page_namespace')->IN($namespaces)
			->runLoop($db, function (&$d, $row) {
				$msg = new stdClass();
				$msg->cityId = $this->city_id;
				$msg->pageId = $row->page_id;
				$this->publish($this->key, $msg);
				usleep($this->delay);
			});
	}
}

$maintClass = 'ReindexEventGenerator';
require_once( RUN_MAINTENANCE_IF_MAIN );