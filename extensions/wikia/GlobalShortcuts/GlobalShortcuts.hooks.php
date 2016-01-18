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
		$helper->addSpecialPageActions( $actions, $shortcuts );

		wfRunHooks( 'PageGetActions', [ &$actions, &$shortcuts ] );
		$vars['wgWikiaPageActions'] = $actions;
		$vars['wgWikiaShortcutKeys'] = $shortcuts;

		return true;
	}

	public function onWikiaHeaderButtons( &$buttons ) {
		$buttons[] = \F::app()->renderView( 'GlobalShortcuts', 'renderHelpEntryPoint' );
		return true;
	}

}
