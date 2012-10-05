<?php

class InWikiGameParserTag {
	private static $instanceCounter = 1;

	public function onParserFirstCallInit(Parser $parser) {
		$parser->setHook('inwikigame', array($this, 'renderTag'));
		return true;
	}

	public function renderTag($input, $params) {
		$app = F::app();

		$html = F::app()->renderView('InWikiGame', 'Index', array('inWikiGameId' => self::$instanceCounter++));

		if (!empty($app->wg->RTEParserEnabled)) {
			return $html;
		} else {
			return '<nowiki>' . trim($html) . '</nowiki>';
		}
	}
}