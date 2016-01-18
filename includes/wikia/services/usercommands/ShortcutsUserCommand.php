<?php
/*
 * @author Michał "Mix" Roszka <michal(at)wikia-inc.com>
 * @date 2011-05-23
 * 
 * Displays performance stats (ShowPerformaceStats extension written by Sean)
 * as an Oasis Toolbar Service so users can turn the stats on or off via
 * Customize dialog.
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