<?php
/**
 * Controller for InWikiGame extension
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */
class InWikiGameController extends WikiaController {

	public function executeIndex() {
		$this->gameId = $this->getVal('inWikiGameId', 1);
		$this->jsSnippet = JSSnippets::addToStack(
			array('/extensions/wikia/InWikiGame/js/InWikiGame.js'),
			null,
			'InWikiGame.init',
			array(
				'id' => 'InWikiGameWrapper-' . $this->gameId
			)
		);
	}
}
