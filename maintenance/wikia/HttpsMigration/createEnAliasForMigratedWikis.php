<?php

require_once __DIR__ . '/../../Maintenance.php';

/**
 * Script to create /en alias for migrated English wikis
 * Input: CSV file with list of wiki IDs, one per line
 * e.g.
 * 	ghostbusters.fandom.com will have additional /en alias domain: ghostbusters.fandom.com/en
 * 	for ar.ghostbusters.fandom.com additional domain with /en won't be created
 *
 * The script runs in dry mode by default, and the --saveChanges option
 * needs to be used when you actually want to save the changes.
 */
class CreateEnAliasForMigratedWikis extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Creates /en alias domain for migrated English wikis';
		$this->addArg( 'file', 'CSV file with the list of wikis' );
		$this->addOption( 'saveChanges', 'Create /en alias domains for real.', false, false, 'd' );
	}

	public function execute() {
		global $wgUser;

		$fileName = $this->getArg( 0 );
		$saveChanges = $this->hasOption( 'saveChanges' );

		$fileHandle = fopen( $fileName, 'r' );

		if ( $fileHandle === false ) {
			$this->output( "Invalid file provided\n" );
			exit( 1 );
		}

		$wgUser = User::newFromName( Wikia::BOT_USER );

		while ( ( $data = fgetcsv( $fileHandle ) ) !== false ) {
			if ( is_null( $data[0] ) ) {
				continue;
			}

			$sourceWikiId = $data[0];

			if ( !WikiFactory::isPublic( $sourceWikiId ) ) {
				$this->output( "Wiki with ID {$sourceWikiId} was not found or is closed!\n" );
				continue;
			}

			$sourceDomain = wfNormalizeHost( parse_url( WikiFactory::cityIDtoDomain( $sourceWikiId ), PHP_URL_HOST ) );

			if ( !$sourceDomain ) {
				$this->output( "Wiki with ID {$sourceWikiId} was not found!\n" );
				continue;
			}

			$additionalTargetDomain = $this->getAdditionalDomain( $sourceWikiId, $sourceDomain );

			if ( !empty( $additionalTargetDomain ) ) {
				continue;
			}

			if ( $saveChanges ) {
				WikiFactory::addDomain( $sourceWikiId, $additionalTargetDomain, 'Creating /en alias for Wiki with ID {$sourceWikiId}' );
			}

			$this->output( "/en alias was created for wiki with ID {$sourceWikiId}: {$additionalTargetDomain}\n" );
		}

		fclose( $fileHandle );
	}

	private function getAdditionalDomain( $sourceWikiId, $sourceDomain ) {
		global $wgFandomBaseDomain;
		$parts = explode( '.', $sourceDomain );

		if ( $parts[1] !== 'fandom' ) {
			$this->output( "{$sourceDomain} isn't a fandom.com domain so we won't create a /en alias\n" );
			return false;
		}

		$sourceWiki = WikiFactory::getWikiByID( $sourceWikiId );

		if ( $sourceWiki->city_lang !== 'en' ) {
			$this->output( "{$sourceDomain} isn't an English wiki so we won't create a /en alias\n" );
			return false;
		}

		$sourceWikiDomains = WikiFactory::getDomains( $sourceWikiId );

		foreach ( $sourceWikiDomains as $domain ) {
			if ( endsWith( $domain, "{$wgFandomBaseDomain}/en" ) ) {
				$this->output( "{$sourceDomain} already has a /en alias\n" );
				return false;
			}
		}

		return "{$parts[0]}.{$wgFandomBaseDomain}/en";
	}
}

$maintClass = 'CreateEnAliasForMigratedWikis';
require_once RUN_MAINTENANCE_IF_MAIN;
