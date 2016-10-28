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
$wgAutoloadClasses[ 'Wikia\\SwiftSync\\Hooks'         ] = $dir . "classes/Hooks.php";
$wgAutoloadClasses[ 'Wikia\\SwiftSync\\Queue'         ] = $dir . "classes/Queue.class.php";
$wgAutoloadClasses[ 'Wikia\\SwiftSync\\ImageSync'     ] = $dir . "classes/ImageSync.class.php";

# hooks
$wgHooks[ 'SwiftFileBackend::doStoreInternal'     ][] = 'Wikia\SwiftSync\Hooks::doStoreInternal';
$wgHooks[ 'SwiftFileBackend::doCopyInternal'      ][] = 'Wikia\SwiftSync\Hooks::doCopyInternal';
$wgHooks[ 'SwiftFileBackend::doDeleteInternal'    ][] = 'Wikia\SwiftSync\Hooks::doDeleteInternal';
