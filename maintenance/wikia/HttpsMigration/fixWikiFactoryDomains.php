<?php

require_once __DIR__ . '/../../Maintenance.php';

class FixWikiFactoryDomains extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Fixes Wiki Factory domains for non english wikis that were migrated to fandom.com';
		$this->addOption( 'saveChanges', 'Change the wiki factory domains for real.', false, false, 'd' );
	}

	public function execute() {
		global $wgMemc, $wgFandomBaseDomain;

		$saveChanges = $this->hasOption( 'saveChanges' );

		$dbw = wfGetDB( DB_MASTER );

		$res = $dbw->select(
			[ 'city_domains' ],
			[ 'city_domain', 'city_id' ],
			[
				"city_domain LIKE '%wikia.com/_%'",
			],
			__METHOD__
		);

		foreach ( $res as $row ) {
			$cityId = $row->city_id;
			if ( !WikiFactory::isPublic( $cityId ) ) {
				continue;
			}
			$originalDomain = $row->city_domain;

			$currentUrl = WikiFactory::cityIDtoUrl( $cityId );
			if ( strpos( $currentUrl, ".{$wgFandomBaseDomain}" ) === false ) {
				$this->output( "Not an fandom.com wiki (id: $cityId, domain: $originalDomain): skipping\n" );
				continue;
			}

			$finalDomain = "";
			$parts = preg_split('/\//', $originalDomain, 2, PREG_SPLIT_NO_EMPTY);
			if ( count( $parts ) == 2 ) {
				$finalDomain = $parts[1] . "." . $parts[0];
			}
			$this->output( "Updating WF domain for wiki (id: $cityId, domain: $originalDomain) to: $finalDomain\n" );
			if ( empty( $finalDomain) ) {
				$this->output( "No change computed for wiki (id: $cityId, domain: $originalDomain): skipping\n");
				continue;
			}

			if ( $saveChanges ) {
				$dbw->update(
					'city_domains',
					[
						'city_id' => $cityId,
						'city_domain'=> $finalDomain
					],
					[
						'city_id' => $cityId,
						'city_domain'=> $originalDomain
					],
					__METHOD__
				);

				$wgMemc->delete( wfMemcKey( 'wiki_domains', md5( $cityId ) ) );

				$this->output( "Updated wiki (id: $cityId, domain: $originalDomain)!\n" );
			}
		}
		$this->output("Done!\n");
	}
}

$maintClass = 'FixWikiFactoryDomains';
require_once RUN_MAINTENANCE_IF_MAIN;
