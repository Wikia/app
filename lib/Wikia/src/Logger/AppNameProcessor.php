<?php
namespace Wikia\Logger;

/**
 * Append appname field to every log entry
 */
class AppNameProcessor {

	/** @var string $appName */
	private $appName;

	public function __construct( string $appName ) {
		$this->appName = $appName;
	}

	public function __invoke( array $record ): array {
		$record['appname'] = $this->appName;

		return $record;
	}
}
