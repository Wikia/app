<?php
namespace Wikia\GlobalShortcuts;

class Helper {
	private $pageCommands = [
		'page:Follow' => 'PageAction:Follow',
		'page:History' => 'PageAction:History',
		'page:Move' => 'PageAction:Move',
		'page:Delete' => 'PageAction:Delete',
		'page:Edit' => 'PageAction:Edit',
		'page:Protect' => 'PageAction:Protect',
		'page:Whatlinkshere' => 'PageAction:Whatlinkshere',
	];

	private $shortcutKeys = [
		'page:Delete' => [ 'd' ],
		'page:Edit' => [ 'e' ],
		'page:History' => [ 'g h' ],
		'page:Move' => [ 'm' ],
	];

	/**
	 * Adds page actions available for user on current page and shortcut keys if available
	 * Not all actions needs to have shortcut key assigned
	 * @param $actions
	 * @param $shortcuts
	 */
	public function addCurrentPageActions( &$actions, &$shortcuts ) {
		foreach ( $this->pageCommands as $actionId => $command ) {
			$userCommandService = new \UserCommandsService();
			$pageAction = $userCommandService->get( $command );
			if ( $pageAction->isAvailable() ) {
				$actions[] = [
					'id' => $actionId,
					'caption' => $pageAction->getCaption(),
					'href' => $pageAction->getHref(),
					'category' => wfMessage( 'global-shortcuts-category-current-page')->escaped(),
				];
				$this->addShortcutKeys( $actionId, $shortcuts );
			}
		}
	}

	private function addShortcutKeys( $actionId , &$shortcuts ) {
		 if ( isset( $this->shortcutKeys[$actionId] ) ) {
			 $shortcuts[$actionId] = $this->shortcutKeys[$actionId];
		 }
	 }
 }
