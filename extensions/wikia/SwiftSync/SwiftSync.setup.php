<?php

/**
 * Swift Sync
 *
 * This code synchronizes DFS operations made in our master DC (SJC) with our secondary DC (RES).
 *
 * Files on DFS can be:
 *
 *  - created (file from SJC is copied over to RES)
 *  - deleted (delete operation takes place in RES)
 *  - moved (copy and delete operation takes place locally on RES)
 *
 * Each of those operations as "queued" in ImageSyncTask class and at the end of the request
 * handling they're are all queued as a single task and pushed to Celery / RabbitMQ.
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
$wgHooks[ 'RestInPeace' ][] = 'Wikia\SwiftSync\Hooks::onRestInPeace';
