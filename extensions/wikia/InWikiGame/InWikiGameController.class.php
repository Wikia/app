<?php

class InWikiGameController extends WikiaController {

	public function executeIndex() {
		$this->gameId = $this->getVal('inWikiGameId',1);
		$this->jsSnippet = F::build('JSSnippets')->addToStack(
			array('/extensions/wikia/InWikiGame/js/InWikiGame.js'),
			null,
			'InWikiGame.init',
			array(
				'id' => 'InWikiGameWrapper-' . $this->gameId
			)
		);
	}
}
