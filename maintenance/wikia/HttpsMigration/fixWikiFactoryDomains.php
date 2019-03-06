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

		$totalCount = $res->numRows();
		$this->output( "Processing wikis, $totalCount in total\n");

		$currentIndex = 0;
		foreach ( $res as $row ) {
			++$currentIndex;
			$cityId = $row->city_id;
			$originalDomain = $row->city_domain;

			$this->output("$currentIndex/$totalCount: Processing wiki (id: $cityId, domain: $originalDomain): ");
			if ( !WikiFactory::isPublic( $cityId ) ) {
				$this->output( "wiki not public - skipping\n");
				continue;
			}

			$currentUrl = WikiFactory::cityIDtoUrl( $cityId );
			if ( strpos( $currentUrl, ".{$wgFandomBaseDomain}" ) === false ) {
				$this->output( "not an fandom.com wiki - skipping\n" );
				continue;
			}

			$finalDomain = "";
			$parts = preg_split('/\//', $originalDomain, 2, PREG_SPLIT_NO_EMPTY);
			if ( count( $parts ) == 2 ) {
				$finalDomain = $parts[1] . "." . $parts[0];
			}
			$this->output( "updating WF domain for wiki to: $finalDomain" );
			if ( empty( $finalDomain) ) {
				$this->output( "no change computed for wiki - skipping\n");
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

				$this->output( "done\n" );
			} else {
				$this->output( "dry run - skipping\n" );
			}
		}
		$this->output("All done!\n");
	}
}

$maintClass = 'FixWikiFactoryDomains';
require_once RUN_MAINTENANCE_IF_MAIN;
