<?php

require_once __DIR__ . '/../../Maintenance.php';

class MigrateInterwikiLinksToFandom extends Maintenance {
	private $languageNames;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrates interwiki links for URLs that were migrated to fandom.com';
		$this->addOption( 'saveChanges', 'Change the interwiki links for real.', false, false, 'd' );
	}

	public function execute() {
		global $wgMemc, $wgFandomBaseDomain;

		$saveChanges = $this->hasOption( 'saveChanges' );

		$dbw = wfGetDB( DB_MASTER );

		$res = $dbw->select(
			[ 'interwiki' ],
			[ 'iw_prefix', 'iw_url' ],
			[
				"iw_url LIKE 'http://%.wikia.com/wiki/$1'",
			],
			__METHOD__
		);

		foreach ( $res as $row ) {
			$cityId = WikiFactory::DomainToID( parse_url( $row->iw_url, PHP_URL_HOST ) );
			if ( !$cityId || !WikiFactory::isPublic( $cityId ) ) {
				continue;
			}

			$currentUrl = WikiFactory::cityIDtoUrl( $cityId );
			if ( strpos( $currentUrl, ".{$wgFandomBaseDomain}" ) === false ) {
				continue;
			}

			$newInterwikiUrl = rtrim( wfHttpToHttps( $currentUrl ), '/' ) . '/wiki/$1';

			$this->output( "Updating interwiki with prefix {$row->iw_prefix} from {$row->iw_url} to {$newInterwikiUrl}!\n" );
			if ( $saveChanges ) {
				$dbw->update(
					'interwiki',
					[
						'iw_url' => $newInterwikiUrl,
					],
					[
						'iw_prefix' => $row->iw_prefix,
						'iw_url' => $row->iw_url,
					],
					__METHOD__
				);

				$wgMemc->delete( wfMemcKey( 'interwiki', md5( $row->iw_prefix ) ) );

				$this->output( "Done!\n" );
			}
		}
	}
}

$maintClass = 'MigrateInterwikiLinksToFandom';
require_once RUN_MAINTENANCE_IF_MAIN;
