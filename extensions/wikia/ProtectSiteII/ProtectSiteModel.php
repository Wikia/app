<?php

class ProtectSiteModel extends WikiaModel {

	const PROTECT_ACTIONS = [
		'edit' => 1,
		'create' => 2,
		'move' => 4,
		'upload' => 8,
	];

	const PREVENT_ANONS_ONLY = 512;

	/** @var int[] $protection */
	private $protection = [];

	public function getProtectionSettings( int $wikiId ): int {
		if ( !isset( $this->protection[$wikiId] ) ) {
			$dbr = $this->getSharedDB();

			$safeNow = $dbr->addQuotes( $dbr->timestamp() );

			$result = $dbr->selectField(
				'protectsite',
				'protection_bitfield',
				[ 'wiki_id' => $wikiId, "protection_expiry > $safeNow" ],
				__METHOD__
			);

			$this->protection[$wikiId] = intval( $result );
		}

		return $this->protection[$wikiId];
	}

	public function updateProtectionSettings( int $wikiId, int $settings, int $expiry ) {
		$dbw = $this->getSharedDB( DB_MASTER );

		$dbExpiry = $dbw->timestamp( $expiry );

		$this->getSharedDB( DB_MASTER )->upsert(
			'protectsite',
			[
				'wiki_id' => $wikiId,
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

	public function unprotect( int $wikiId ) {
		$this->getSharedDB( DB_MASTER )->delete( 'protectsite', [ 'wiki_id' => $wikiId ], __METHOD__ );
	}

	public function deleteExpiredSettings() {
		$this->getSharedDB( DB_MASTER )->delete( 'protectsite', [ 'protection_expiry < NOW() - INTERVAL 7 DAY' ],__METHOD__ );
	}

	public static function getValidActions(): array {
		return array_keys( self::PROTECT_ACTIONS );
	}

	public static function isActionFlagSet( int $bitfield, string $action ): bool {
		return ( $bitfield & self::PROTECT_ACTIONS[$action] ) > 0;
	}

	public static function isPreventAnonsOnlyFlagSet( int $bitfield ): bool {
		return ( $bitfield & self::PREVENT_ANONS_ONLY ) > 0;
	}
}
