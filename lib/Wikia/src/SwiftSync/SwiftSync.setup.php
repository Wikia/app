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

# hooks
$wgHooks[ 'SwiftFileBackend::doStoreInternal'     ][] = 'Wikia\SwiftSync\Hooks::doStoreInternal';
$wgHooks[ 'SwiftFileBackend::doCopyInternal'      ][] = 'Wikia\SwiftSync\Hooks::doCopyInternal';
$wgHooks[ 'SwiftFileBackend::doDeleteInternal'    ][] = 'Wikia\SwiftSync\Hooks::doDeleteInternal';
