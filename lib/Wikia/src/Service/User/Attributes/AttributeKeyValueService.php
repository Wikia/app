<?php

namespace Wikia\Service\User\Attributes;

use Wikia\Logger\Loggable;
use Wikia\Persistence\User\Attributes\AttributePersistence;
use Wikia\Util\WikiaProfiler;
use Wikia\Service\User\Attributes;

class AttributeKeyValueService implements AttributeService {

	const PROFILE_EVENT = \Transaction::EVENT_USER_ATTRIBUTES;

	use WikiaProfiler;
	use Loggable;

	/** @var AttributePersistence */
	private $persistenceAdapter;

	/**
	 * @Inject({
	 *    Wikia\Persistence\User\Attributes\AttributePersistence::class
	 * })
	 * @param AttributePersistence $persistenceAdapter
	 */
	function __construct( AttributePersistence $persistenceAdapter ) {
		$this->persistenceAdapter = $persistenceAdapter;
	}

	public function set( $userId, $attribute ) {
		if ( empty( $attribute ) || $userId === 0 ) {
			throw new \Exception( 'Invalid parameters, $attribute must not be empty and $userId must be > 0' );
		}

		try {
			$profilerStart = $this->startProfile();
			$ret = $this->persistenceAdapter->saveAttribute( $userId, $attribute );
			$this->endProfile( AttributeKeyValueService::PROFILE_EVENT, $profilerStart,
				[ 'user_id' => $userId, 'method' => 'saveAttribute' ] );

			return $ret;
		} catch ( \Exception $e ) {
			$this->error( $e->getMessage(), [
				'user' => $userId
			] );

			throw $e;
		}
	}

	public function get( $userId ) {
		if ( $userId == 0 ) {
			return [];
		}

		try {
			$attributeArray = $this->persistenceAdapter->getAttributes( $userId );
		} catch ( \Exception $e ) {
			$this->error( $e->getMessage(), [
				'user' => $userId
			] );

			throw $e;
		}

		return $attributeArray;
	}

	public function delete( $userId, $attribute ) {
		if ( empty( $attribute ) || $userId === 0 ) {
			return false;
		}

		try {
			$ret = $this->persistenceAdapter->deleteAttribute( $userId, $attribute );
			return $ret;
		} catch ( \Exception $e ) {
			$this->error( $e->getMessage(), [
				'user' => $userId
			] );

			throw $e;
		}
	}

	protected function getLoggerContext() {
		return [
			'persistence-class' => get_class( $this->persistenceAdapter ),
		];
	}
}
