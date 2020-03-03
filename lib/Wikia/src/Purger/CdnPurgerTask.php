<?php

declare( strict_types=1 );

namespace Wikia\Purger;

use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\Queues\Queue;

class CdnPurgerTask extends AsyncTaskList {

	/** @var string */
	private $service;
	/** @var string[] */
	private $urls;
	/** @var string[] */
	private $keys;

	public function __construct( string $service, array $urls, array $keys ) {
		parent::__construct();
		$this->queue = new Queue( 'cdn-purger' );
		$this->service = $service;
		$this->urls = $urls;
		$this->keys = $keys;
	}

	/**
	 * Return a serialized form of this task that can be sent to cdn-purger via RabbitMQ
	 * @return array
	 */
	public function serialize(): array {
		return [
			'service' => $this->service,
			'urls' => $this->urls,
			'keys' => $this->keys,
		];
	}


}
