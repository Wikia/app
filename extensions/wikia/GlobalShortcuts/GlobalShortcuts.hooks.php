<?php

namespace Wikia\GlobalShortcuts;

class Hooks {
	/**
	 * Register hooks for the extension
	 */
	public static function register() {
		$hooks = new self();
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
		\Hooks::register( 'MakeGlobalVariablesScript', [ $hooks, 'onMakeGlobalVariablesScript' ] );
	}


	/**
	 * Adds assets for GlobalShortcuts
	 *
	 * @param \OutputPage $out
	 * @param \Skin $skin
	 *
	 * @return true
	 */
	public function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'globalshortcuts_js' );
		\Wikia::addAssetsToOutput( 'globalshortcuts_scss' );
		return true;
	}

	/**
	 * Add global JS variables for GlobalShortcuts
	 */
	public function onMakeGlobalVariablesScript( array &$vars ) {
		$actions = [];
		$this->addCurrentPageActions( $actions );
		$this->addSpecialPageActions( $actions );

		wfRunHooks( 'PageGetActions', [ &$actions ] );
		$vars['wgWikiaPageActions'] = $actions;


		$vars['globalShortcutsConfig'] = [
			'recentChanges' => \SpecialPage::getTitleFor( 'RecentChanges' )->getLocalURL()
		];
		return true;
	}

	public function onWikiaHeaderButtons( &$buttons ) {
		$buttons[] = \F::app()->renderView( 'GlobalShortcuts', 'renderHelpEntryPoint' );
		return true;
	}

	private function addSpecialPageActions( &$actions ) {
		$context = \RequestContext::getMain();
		$pages = \SpecialPageFactory::getUsablePages( $context->getUser() );

		$groups = [ ];
		foreach ( $pages as $page ) {
			if ( $page->isListed() ) {
				$group = \SpecialPageFactory::getGroup( $page );

				$groups[$group][] = [
					'id' => 'special:' . $page->getName(),
					'caption' => $page->getDescription(),
					'href' => $page->getTitle()->getFullURL(),
				];
			}
		}

		foreach ( $groups as $group => $entries ) {
			$groupName = wfMessage( "specialpages-group-$group" )->plain();
			$category = "Special Pages > $groupName";
			foreach ( $entries as $entry ) {
				$actions[] = array_merge( $entry, [
					'category' => $category,
				] );
			}
		}

		return true;
	}

	private function addCurrentPageActions( &$actions ) {
		$commands = [
			'page:Follow' => 'PageAction:Follow',
			'page:History' => 'PageAction:History',
			'page:Move' => 'PageAction:Move',
			'page:Delete' => 'PageAction:Delete',
			'page:Edit' => 'PageAction:Edit',
			'page:Protect' => 'PageAction:Protect',
			'page:Whatlinkshere' => 'PageAction:Whatlinkshere',
		];

		foreach ( $commands as $actionId => $command ) {
			$userCommandService = new \UserCommandsService();
			$pageAction = $userCommandService->get( $command );
			if ( $pageAction->isAvailable() ) {
				$actions[] = [
					'id' => $actionId,
					'caption' => $pageAction->getCaption(),
					'href' => $pageAction->getHref(),
					'category' => 'Current page',
				];
			}
		}

		return true;
	}


}
