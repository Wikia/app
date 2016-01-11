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
		'special:Recentchanges' => [ 'g r' ],
	];

	/**
	 * Adds page actions available for user on current page and shortcut keys if available
	 * Not all actions needs to have shortcut key assigned
	 * @param array $actions
	 * @param array $shortcuts
	 */
	public function addCurrentPageActions( array &$actions, array &$shortcuts ) {
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

	/**
	 * Add shortcut keys to provided $shortcuts array for provided actionId if available
	 * @param string $actionId
	 * @param array $shortcuts
	 */
	public function addShortcutKeys( $actionId , array &$shortcuts ) {
		 if ( isset( $this->shortcutKeys[$actionId] ) ) {
			 $shortcuts[$actionId] = $this->shortcutKeys[$actionId];
		 }
	 }
 }
