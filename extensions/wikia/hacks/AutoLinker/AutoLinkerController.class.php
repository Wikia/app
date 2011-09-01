<?php

class AutoLinkerController extends WikiaController {

	const LIMIT = 250;
	const CACHE_TTL = 86400;

	public function getPagesList() {
		// list of sources can be found in QueryPage.php
		$ret = array_values(array_unique(array_merge(
			$this->getPagesFrom('LonelyPages'),
			$this->getPagesFrom('Mostlinked'),
			$this->getPagesFrom('Shortpages')
		)));

		sort($ret);

		$this->setVal('pages', $ret);
		$this->setVal('count', count($ret));

		$this->getResponse()->setCacheValidity(self::CACHE_TTL, self::CACHE_TTL, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
	}

	private function getPagesFrom($source) {
		$app = F::app();
		$dbr = $app->wf->GetDb(DB_SLAVE);

		$className = "{$source}Page";
		if (!class_exists($className)) {
			return array();
		}

		$queryPage = new $className();

		$sql = $dbr->limitResult($queryPage->getSQL(), self::LIMIT, 0);
		$res = $dbr->query($sql);
		$num = $dbr->numRows($res);

		$pages = array();

		foreach($res as $row) {
			$title = Title::newFromText($row->title, $row->namespace);

			if ($title instanceof Title && $title->getNamespace() == NS_MAIN) {
				$pages[] = $title->getText();
			}
		}

		return $pages;
	}

}
