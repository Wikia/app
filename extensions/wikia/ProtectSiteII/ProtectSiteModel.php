<?php

class ProtectSiteModel extends WikiaModel {

	const PROTECT_ACTIONS = [
		'edit' => 1,
		'create' => 2,
		'move' => 4,
		'upload' => 8,
	];

	const PREVENT_USERS_FLAG = 512;

	/** @var int $protection */
	private $protection;

	public function getProtectionSettings(): int {
		if ( $this->protection === null ) {
			global $wgCityId;

			$dbr = $this->getSharedDB();

			$safeNow = $dbr->addQuotes( $dbr->timestamp() );

			$result = $dbr->selectField(
				'protectsite',
				'protection_bitfield',
				[ 'wiki_id' => $wgCityId, "protection_expiry < $safeNow" ],
				__METHOD__
			);

			$this->protection = intval( $result );
		}

		return $this->protection;
	}

	public function updateProtectionSettings( int $settings, int $expiry ) {
		global $wgCityId;

		$dbw = $this->getSharedDB( DB_MASTER );

		$dbExpiry = $dbw->timestamp( $expiry );

		$this->getSharedDB( DB_MASTER )->upsert(
			'protectsite',
			[
				'wiki_id' => $wgCityId,
				'protection_bitfield' => $settings,
				'protection_expiry' => $dbExpiry,
			],
			[],
			[
				'protection_bitfield = VALUES(protection_bitfield)',
				'protection_expiry = VALUES(protection_expiry)',
			],
			__METHOD__
		);
	}

	public function unprotect() {
		global $wgCityId;

		$this->getSharedDB( DB_MASTER )->delete( 'protectsite', [ 'wiki_id' => $wgCityId ], __METHOD__ );
	}

	public function deleteExpiredSettings() {
		$this->getSharedDB( DB_MASTER )->delete( 'protectsite', [ 'protection_expiry < NOW()' ], __METHOD__ );
	}

	public static function getValidActions(): array {
		return array_keys( self::PROTECT_ACTIONS );
	}

	public static function isActionFlagSet( int $bitfield, string $action ): bool {
		return ( $bitfield & self::PROTECT_ACTIONS[$action] ) > 0;
	}

	public static function isPreventUsersFlagSet( int $bitfield ): bool {
		return ( $bitfield & self::PREVENT_USERS_FLAG ) > 0;
	}
}
