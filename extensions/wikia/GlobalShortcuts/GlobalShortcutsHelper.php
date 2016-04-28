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

	/**
	 * Adds usable Special Pages from SpecialPageFactory and shortcut keys if available.
	 * Not all actions needs to have shortcut key assigned.
	 * @param array $actions
	 * @param array $shortcuts
	 * @return bool
	 */
	public function addSpecialPageActions( array &$actions, array &$shortcuts ) {
		$context = \RequestContext::getMain();
		$pages = \SpecialPageFactory::getUsablePages( $context->getUser() );
		$helper = new Helper();

		$groups = [ ];
		foreach ( $pages as $page ) {
			if ( $page->isListed() ) {
				$group = \SpecialPageFactory::getGroup( $page );
				$actionId = 'special:' . $page->getName();

				$groups[$group][] = [
					'id' => $actionId,
					'caption' => $page->getDescription(),
					'href' => $page->getTitle()->getFullURL(),
				];

				$helper->addShortcutKeys( $actionId, $shortcuts );
			}
		}

		$specialPagesMsg = wfMessage( 'specialpages' )->escaped();

		foreach ( $groups as $group => $entries ) {
			/*
			 * 'specialpages-group-maintenance'
			 * 'specialpages-group-other'
			 * 'specialpages-group-login'
			 * 'specialpages-group-changes'
			 * 'specialpages-group-media'
			 * 'specialpages-group-users'
			 * 'specialpages-group-highuse'
			 * 'specialpages-group-pages'
			 * 'specialpages-group-pagetools'
			 * 'specialpages-group-wiki'
			 * 'specialpages-group-redirects'
			 * 'specialpages-group-spam'
			 */
			$groupName = wfMessage( "specialpages-group-$group" )->escaped();
			$category = "$specialPagesMsg > $groupName";
			foreach ( $entries as $entry ) {
				$actions[] = array_merge( $entry, [
					'category' => $category,
				] );
			}
		}

		return true;
	}

	/**
	 * Checks if Global Shortcuts should be loaded and displayed
	 *
	 * @return Bool
	 */
	public static function shouldDisplayGlobalShortcuts() {
		return \RequestContext::getMain()->getUser()->isLoggedIn();
	}
 }
