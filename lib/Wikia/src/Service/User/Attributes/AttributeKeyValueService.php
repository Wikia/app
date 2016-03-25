<?php

namespace Wikia\Service\User\Attributes;

use Wikia\Domain\User\Attribute;
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

	/**
	 * @param int $userId
	 * @param Attribute $attribute
	 * @return bool
	 * @throws \Exception
	 */
	public function set( $userId, Attribute $attribute ) {
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
			$this->logError( $userId, $e, "USER_ATTRIBUTE error saving to service" );
			return false;
		}
	}

	/**
	 * @param int $userId
	 * @return array
	 */
	public function get( $userId ) {
		$attributeArray = [];

		if ( $userId == 0 ) {
			return $attributeArray;
		}

		try {
			$attributeArray = $this->persistenceAdapter->getAttributes( $userId );
		} catch ( \Exception $e ) {
			$this->logError( $userId, $e, "USER_ATTRIBUTE error getting from service" );
		}

		return $attributeArray;
	}

	/**
	 * @param int $userId
	 * @param Attribute $attribute
	 * @return bool
	 * @throws \Exception
	 */
	public function delete( $userId, Attribute $attribute ) {
		if ( empty( $attribute ) || $userId === 0 ) {
			throw new \Exception( 'Invalid parameters, $attribute must not be empty and $userId must be > 0' );
		}

		try {
			$ret = $this->persistenceAdapter->deleteAttribute( $userId, $attribute );
			return $ret;
		} catch ( \Exception $e ) {
			$this->logError( $userId, $e, "USER_ATTRIBUTE error deleting from service" );
			return false;
		}
	}

	private function logError( $userId, \Exception $e, $msg ) {
		$this->error( $msg , [
			'user' => $userId,
			'exception' => $e
		] );
	}

	protected function getLoggerContext() {
		return [
			'persistence-class' => get_class( $this->persistenceAdapter ),
		];
	}
}
