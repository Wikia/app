<?php

class AutoLinkerController extends WikiaController {

	const LIMIT = 250;
	const CACHE_TTL = 86400;

	public function getPagesList() {
		// list of sources can be found in QueryPage.php
		$pages = array_values(array_unique(array_merge(
			$this->getPagesFrom('LonelyPages'),
			$this->getPagesFrom('Mostlinked'),
			$this->getPagesFrom('Shortpages')
		)));

		sort($pages);

		$regexp = implode('|', array_map('preg_quote', $pages));

		//$this->setVal('pages', $ret);
		$this->setVal('regexp', $regexp);
		$this->setVal('count', count($pages));

		$this->getResponse()->setCacheValidity(self::CACHE_TTL, self::CACHE_TTL, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
	}

	private function getPagesFrom($source) {
		$dbr = wfGetDb(DB_SLAVE);

		$className = "{$source}Page";
		if (!class_exists($className)) {
			return array();
		}

		$queryPage = new $className();

		$sql = $dbr->limitResult($queryPage->getSQL(), self::LIMIT, 0);
		$res = $dbr->query($sql, __METHOD__ . "::{$source}");

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
