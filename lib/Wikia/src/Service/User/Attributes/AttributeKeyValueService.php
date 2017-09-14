<?php

namespace Wikia\Service\User\Attributes;

use Wikia\Domain\User\Attribute;
use Wikia\Logger\Loggable;
use Wikia\Persistence\User\Attributes\AttributePersistence;
use Wikia\Util\WikiaProfiler;
use Wikia\Service\User\Attributes;
use Wikia\Service\PersistenceException;

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
				[ 'user_id' => intval($userId), 'method' => 'saveAttribute' ] );

			return $ret;
		} catch ( \Exception $e ) {
			$this->logException( $userId, $e, "USER_ATTRIBUTES failure saving to service" );
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
			$this->logException( $userId, $e, "USER_ATTRIBUTES failure getting from service" );
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
			$this->logException( $userId, $e, "USER_ATTRIBUTES failure deleting from service" );
			return false;
		}
	}

	/**
	 * Log any exceptions thrown when contacting the attribute service. There are 4 possible exceptions
	 * which can be thrown, and which this method can expect to receive: PersistenceException, ForbiddenException,
	 * NotFoundException, and UnauthorizedException. Log PersistenceExceptions at error level, and all others
	 * at warning. PersistenceExceptions indicate a problem was encountered contacting the service, or that we received
	 * an unexpected HTTP response like a 500. The other exceptions indicate a resources wasn't found, or that the
	 * request was refused.
	 * @param $userId
	 * @param \Exception $e
	 * @param $msg
	 */
	private function logException( $userId, \Exception $e, $msg ) {
		$context = [ 'user' => $userId, 'exception' => $e ];
		if ( $e instanceof PersistenceException ) {
			$this->error( $msg, $context );
		} else {
			$this->warning( $msg, $context );
		}
	}

	protected function getLoggerContext() {
		return [
			'persistence-class' => get_class( $this->persistenceAdapter ),
		];
	}
}
