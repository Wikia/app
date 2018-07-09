<?php
/**
 * SMWQueue
 *
 * Queue for tasks created on wikis with $wgEnableSemanticMediaWikiExt = true
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Queues;


class SMWQueue extends Queue {
	const NAME = 'SMWQueue';

	public function __construct() {
		parent::__construct('mediawiki_smw');
	}
}
