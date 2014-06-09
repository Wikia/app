<?php
/**
 * NlpPipelineQueue
 *
 * Used for handling NLP parsing events
 *
 * @author Robert Elwell <robert@wikia-inc.com>
 */

namespace Wikia\Tasks\Queues;

class NlpPipelineQueue extends Queue {
	const NAME = 'NlpPipelineQueue';

	public function __construct() {
		$this->name = 'nlp_pipeline';
		$this->routingKey = 'nlp_pipeline';
	}
} 