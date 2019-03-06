<?php

require_once __DIR__ . '/../../Maintenance.php';


class FixWikiFactoryDomains extends Maintenance {
	private $COLOR_GREEN = "\e[0;32m";
	private $COLOR_CYAN = "\e[0;36m";
	private $COLOR_RED = "\e[0;31m";
	private $COLOR_BLUE = "\e[0;34m";
	private $COLOR_PURPLE = "\e[0;35m";
	private $COLOR_NONE = "\e[0m";

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Fixes Wiki Factory domains for non english wikis that were migrated to fandom.com';
		$this->addOption( 'saveChanges', 'Change the wiki factory domains for real.', false, false, 'd' );
	}

	public function execute() {
		global $wgFandomBaseDomain, $wgUser;

		$saveChanges = $this->hasOption( 'saveChanges' );

		$dbw = WikiFactory::db( DB_MASTER );
		$wgUser = User::newFromName( Wikia::BOT_USER );

		$res = $dbw->select(
			[ 'city_domains' ],
			[ 'city_domain', 'city_id' ],
			[
				"city_domain LIKE '%wikia.com/_%'",
			],
			__METHOD__
		);

		$totalCount = $res->numRows();
		$counterWidth = floor( log10( $totalCount ) ) + 1;
		$this->output( "Processing wikis, {$this->COLOR_CYAN}$totalCount{$this->COLOR_NONE} in total\n" );

		$currentIndex = 0;
		foreach ( $res as $row ) {
			++$currentIndex;
			$cityId = $row->city_id;
			$originalDomain = $row->city_domain;

			$this->output(
				sprintf( "[%0{$counterWidth}d/%0{$counterWidth}d]: Processing wiki ", $currentIndex, $totalCount ) .
				"(id: {$this->COLOR_PURPLE}$cityId{$this->COLOR_NONE}, domain: {$this->COLOR_GREEN}$originalDomain){$this->COLOR_NONE}: "
			);
			if ( !WikiFactory::isPublic( $cityId ) ) {
				$this->output( "wiki not public - skipping\n" );
				continue;
			}

			$currentUrl = WikiFactory::cityIDtoUrl( $cityId );
			if ( strpos( $currentUrl, ".{$wgFandomBaseDomain}" ) === false ) {
				$this->output( "not an fandom.com wiki - {$this->COLOR_BLUE}skipping{$this->COLOR_NONE}\n" );
				continue;
			}

			$finalDomain = '';
			$parts = preg_split('/\//', $originalDomain, 2, PREG_SPLIT_NO_EMPTY );
			if ( count( $parts ) == 2 ) {
				$finalDomain = $parts[1] . "." . $parts[0];
			}
			$this->output(
				"updating WF domain for wiki: {$this->COLOR_GREEN}$originalDomain{$this->COLOR_NONE} -> " .
				"{$this->COLOR_CYAN}$finalDomain{$this->COLOR_NONE}: "
			);
			if ( empty( $finalDomain) ) {
				$this->output( "no change computed for wiki - {$this->COLOR_CYAN}skipping{$this->COLOR_NONE}\n" );
				continue;
			}

			if ( $saveChanges ) {
				if ( !WikiFactory::removeDomain( $cityId, $originalDomain, [ 'fixing legacy domain after fandom.com migration' ] ) ) {
					$this->output( "failed to remove original domain: {$this->COLOR_RED}$originalDomain{$this->COLOR_NONE}\n" );
					continue;
				}
				if ( !WikiFactory::addDomain( $cityId, $finalDomain, [ 'fixing legacy domain after fandom.com migration' ] ) ) {
					$this->output( "failed to add new domain: {$this->COLOR_RED}$finalDomain{$this->COLOR_NONE}\n" );
					continue;
				}

				$this->output( "{$this->COLOR_GREEN}done{$this->COLOR_NONE}\n" );
			} else {
				$this->output( "{$this->COLOR_BLUE}dry run - skipping{$this->COLOR_NONE}\n" );
			}
		}
		$this->output( "{$this->COLOR_GREEN}All done!{$this->COLOR_NONE}\n" );
	}
}

$maintClass = 'FixWikiFactoryDomains';
require_once RUN_MAINTENANCE_IF_MAIN;
