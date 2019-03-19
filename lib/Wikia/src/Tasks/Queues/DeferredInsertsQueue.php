<?php
/**
 * DeferredInsertsQueue
 *
 * Handles tasks that perform delayed inserts into city_list (when was a given wiki last edited?)
 * and events_local_users (where - which wiki - and when a given user made edits).
 *
 * @author macbre
 * @see CORE-175
 */

namespace Wikia\Tasks\Queues;

class DeferredInsertsQueue extends Queue {
	const NAME = 'DeferredInsertsQueue';

	public function __construct() {
		parent::__construct('mediawiki_deferred_inserts');
	}
}
