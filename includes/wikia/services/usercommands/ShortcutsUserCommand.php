<?php
/*
 * Displays Global Shortcuts in toolbar
 */
class ShortcutsUserCommand extends UserCommand {
    
    protected $overflow = false;
    protected $defaultRenderType = 'link';
    
    protected function buildData() {
		$loggedIn = F::app()->wg->user->isLoggedIn();

        $this->available = $loggedIn;
        $this->enabled = $loggedIn;
        $this->caption = wfMessage( 'global-shortcuts-name' )->escaped();
    }
    
    protected function getTrackerName() {
        return 'global-shortcuts-help-entry-point';
    }
}
