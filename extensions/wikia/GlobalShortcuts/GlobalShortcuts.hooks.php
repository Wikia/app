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
		$vars['globalShortcutsConfig'] = [
			'insights' => \SpecialPage::getTitleFor( 'Insights' )->getLocalURL(),
			'recentChanges' => \SpecialPage::getTitleFor( 'RecentChanges' )->getLocalURL()
		];
		return true;
	}

	public function onWikiaHeaderButtons( &$buttons ) {
		$buttons[] = \F::app()->renderView( 'GlobalShortcuts', 'renderHelpEntryPoint' );
		return true;
	}
}
