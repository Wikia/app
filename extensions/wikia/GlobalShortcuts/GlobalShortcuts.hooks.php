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
		global $wgEnableDiscussion;
		if ( !empty( $wgEnableDiscussion ) ) {
			\Wikia::addAssetsToOutput( 'globalshortcuts_discussions_js' );
		}
		\Wikia::addAssetsToOutput( 'globalshortcuts_js' );
		\Wikia::addAssetsToOutput( 'globalshortcuts_scss' );
		return true;
	}

	/**
	 * Add global JS variables for GlobalShortcuts
	 */
	public function onMakeGlobalVariablesScript( array &$vars ) {
		$actions = [];
		$shortcuts = [];
		$helper = new Helper();
		$helper->addCurrentPageActions( $actions, $shortcuts );
		$this->addSpecialPageActions( $actions );

		wfRunHooks( 'PageGetActions', [ &$actions, &$shortcuts ] );
		$vars['wgWikiaPageActions'] = $actions;
		$vars['wgWikiaShortcutKeys'] = $shortcuts;

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

}
