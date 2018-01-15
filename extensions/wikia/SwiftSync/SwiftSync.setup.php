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
$wgAutoloadClasses[ 'Wikia\\SwiftSync\\ImageSyncTask' ] = $dir . "classes/ImageSyncTask.class.php";

# hooks
$wgHooks[ 'SwiftFileBackend::doStoreInternal'     ][] = 'Wikia\SwiftSync\Hooks::doStoreInternal';
$wgHooks[ 'SwiftFileBackend::doCopyInternal'      ][] = 'Wikia\SwiftSync\Hooks::doCopyInternal';
$wgHooks[ 'SwiftFileBackend::doDeleteInternal'    ][] = 'Wikia\SwiftSync\Hooks::doDeleteInternal';

# DFS operations triggered by the above hooks are pushed to tasks queue via this hook
$wgHooks[ 'FileUpload'            ][] = 'Wikia\SwiftSync\Hooks::onFileUpload';
$wgHooks[ 'OldFileDeleteComplete' ][] = 'Wikia\SwiftSync\Hooks::onOldFileDeleteComplete';