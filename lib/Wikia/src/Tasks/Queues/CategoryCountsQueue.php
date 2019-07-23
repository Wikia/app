<?php
/**
 * CategoryCountsQueue
 *
 * Queue used for category counts purging etc..
 *
 * @author Przemysław Czaus <pczaus@wikia-inc.com>
 */

namespace Wikia\Tasks\Queues;


class CategoryCountsQueue extends Queue {
	const NAME = 'CategoryCounts';

	public function __construct() {
		parent::__construct( 'category_counts' );
	}
}
