<?php
/*
 * @author Michał "Mix" Roszka <michal(at)wikia-inc.com>
 * @date 2011-05-23
 * 
 * Displays performance stats (ShowPerformaceStats extension written by Sean)
 * as an Oasis Toolbar Service so users can turn the stats on or off via
 * Customize dialog.
 */
class DevInfoUserCommand extends UserCommand {
    
    protected $overflow = false;
    protected $defaultRenderType = 'devinfo';
    
    protected function buildData() {
        $this->available = F::app()->wg->user->isAllowed( 'performancestats' );
        $this->enabled = F::app()->wg->user->isAllowed( 'performancestats' );
        $this->caption = wfMsg('oasis-toolbar-devinfo');
        $this->linkClass = 'tools-devinfo';
    }
    
    protected function getTrackerName() {
        return 'devinfo';
    }
}