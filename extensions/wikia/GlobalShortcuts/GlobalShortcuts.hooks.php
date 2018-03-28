<?php

namespace Wikia\GlobalShortcuts;

class Hooks {
	/**
	 * Register hooks for the extension
	 */
	public static function register() {
		if ( Helper::shouldDisplayGlobalShortcuts() ) {
			$hooks = new self();
			\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
			\Hooks::register( 'BeforeToolbarMenu', [ $hooks, 'onBeforeToolbarMenu' ] );
		}
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
		global $wgEnableDiscussions;

		if ( !empty( $wgEnableDiscussions ) ) {
			\Wikia::addAssetsToOutput( 'globalshortcuts_discussions_js' );
		}

		\Wikia::addAssetsToOutput( 'globalshortcuts_js' );
		\Wikia::addAssetsToOutput( 'globalshortcuts_scss' );

		$actions = [];
		$shortcuts = [];

		$helper = new Helper();
		$helper->addCurrentPageActions( $actions, $shortcuts );
		$helper->addSpecialPageActions( $actions, $shortcuts );

		$out->addJsConfigVars( [
			'wgWikiaPageActions' => $actions,
			'wgWikiaShortcutKeys' => $shortcuts,
		] );

		return true;
	}

	public function onBeforeToolbarMenu( &$items, $type ) {
		$html = \Html::rawElement(
			'a',
			[
				'href' => '#',
				'class' => 'global-shortcuts-help-entry-point',
				'title' => wfMessage( 'global-shortcuts-title-help-entry-point' )->plain()
			],
			wfMessage( 'global-shortcuts-name' )->escaped()
		);

		if ( $type == 'main' ) {
			$items[] = [
				'type' => 'html',
				'html' => $html
			];
		}

		return true;
	}
}
