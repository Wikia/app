<?php

require_once( dirname( __FILE__ ) . '/IndexerWorkerBase.php' );

class ReindexEventGenerator extends IndexerWorkerBase {

	const WG_CONTENT_NAMESPACES_KEY = 'wgContentNamespaces';
	const DELAY = 200; //1m = 1sec

	protected function preprocess() {
		$db = wfGetDB( DB_SLAVE );
		$namespaces = WikiFactory::getVarValueByName( self::WG_CONTENT_NAMESPACES_KEY, $this->city_id );
		( new WikiaSQL() )->SELECT('page_id')->FROM('page')->WHERE('page_namespace')->IN($namespaces)
			->runLoop($db, function (&$d, $row) {
				$msg = new stdClass();
				$msg->cityId = $this->city_id;
				$msg->pageId = $row->page_id;
				$this->publish('article.index', $msg);
				usleep(static::DELAY);
			});
	}
}

$maintClass = 'ReindexEventGenerator';
require( RUN_MAINTENANCE_IF_MAIN );
