<?php
/*
 * Displays Global Shortcuts in toolbar
 */
class ShortcutsUserCommand extends UserCommand {

	protected $overflow = false;
	protected $defaultRenderType = 'link';

	protected function buildData() {
		global $wgEnableGlobalShortcutsExt;

		$isEnabled = F::app()->wg->user->isLoggedIn() && !empty( $wgEnableGlobalShortcutsExt );

		$this->available = $isEnabled;
		$this->enabled = $isEnabled;
		$this->caption = wfMessage( 'global-shortcuts-name' )->escaped();
	}

	protected function getTrackerName() {
		return 'global-shortcuts-help-entry-point';
	}
}
