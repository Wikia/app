<?php
/*
 * Displays Global Shortcuts in toolbar
 */
class ShortcutsUserCommand extends UserCommand {
    
    protected $overflow = false;
    protected $defaultRenderType = 'link';
    
    protected function buildData() {
        $this->available = F::app()->wg->user->isLoggedIn();
        $this->enabled = F::app()->wg->user->isLoggedIn();
        $this->caption = 'Shortcuts';
    }
    
    protected function getTrackerName() {
        return 'global-shortcuts-help-entry-point';
    }
}
