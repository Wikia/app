<?php

class InWikiGameParserTag {
	public function onParserFirstCallInit(Parser $parser) {
		$parser->setHook('inwikigame', array($this, 'renderTag'));
		return true;
	}

	public function renderTag($input, $params) {
		$app = F::app();

		$html = 'inwikirender';

		if (!empty($app->wg->RTEParserEnabled)) {
			return $html;
		} else {
			return '<nowiki>' . trim($html) . '</nowiki>';
		}
	}
}