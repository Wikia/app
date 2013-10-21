<?php

/**
 * Swift Sync classes/helpers etc
 *
 * @author Maciej Brencz (macbre@wikia-inc.com)
 * @author Piotr Molski (moli@wikia-inc.com)
 */
 
$app = F::app();
$dir = dirname(__FILE__) . '/';

# load 
$wgAutoloadClasses[ 'Wikia\\SwiftSync\\Hooks' ] = $dir . "classes/Hooks.php";

# hooks
$wgHooks['SwiftFileBackend::doStoreInternal' ][]  = 'Wikia\SwiftSync\Hooks::doStoreInternal';
$wgHooks['SwiftFileBackend::doCopyInternal'  ][]  = 'Wikia\SwiftSync\Hooks::doCopyInternal';
$wgHooks['SwiftFileBackend::doDeleteInternal'][]  = 'Wikia\SwiftSync\Hooks::doDeleteInternal';
