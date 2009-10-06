<?php
/**
 * Applies staff powers to select users, like unblockableness, superhuman strenght and
 * general awesomeness.
 *
 * @author Lucas Garczewski <tor@wikia-inc.com>
 */

// Power: unblockableness
$wgHooks['BlockIp'][] = 'efPowersMakeUnblockable';
$wgGroupPermissions['staff'][] = 'unblockable';

function efPowersMakeUnblockable( $block, $user ) {
        if ( $user->isAllowed( 'unblockable' ) ) {
                return false;
        }

        return true;
}
