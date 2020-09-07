<?php

declare( strict_types=1 );

namespace Wikia\UCP;

use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\Queues\Queue;

class FinishRenameTask extends AsyncTaskList {

	/** @var int */
	private $renameLogId;

	public function __construct( int $renameLogId ) {
		parent::__construct();
		$this->queue = new Queue( 'go-jobrunner-mediawiki-user-rename' );
		$this->renameLogId = $renameLogId;
	}

	/**
	 * Return a serialized form of this task that can be sent to jobrunner via RabbitMQ
	 * @return array
	 */
	public function serialize(): array {
		global $wgCentralWikiId;

		return [
			'type' => 'AttemptToFinishRenameJob',
  			'wikiId' => $wgCentralWikiId,
			'createdAt' => wfTimestamp( TS_ISO_8601 ),
  			'params' => [
				'renameLogId' => $this->renameLogId,
			]
		];
	}
}
