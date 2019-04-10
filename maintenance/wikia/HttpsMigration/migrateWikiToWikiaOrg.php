<?php

require_once __DIR__ . '/../../Maintenance.php';

/**
 * Script to migrate a community to wikia.org.
 *
 * It takes a CSV file as input with a list of wiki IDs, one per line.
 * The new wikia.org domain will be determined automatically unless
 * there is a domain next to the wiki ID in the CSV file which will
 * override the default, i.e. the CSV may look like this if you were
 * migrating two wikis, but overriding the target domain for the second:
 *
 *     147
 *     1733,gta.wikia.org/de
 *
 * The script runs in dry mode by default, and the --saveChanges option
 * needs to be used when you actually want to save the changes.
 */
class MigrateWikiToWikiaOrg extends Maintenance {
	private $languageNames;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrates a list of wikis to wikia.org';
		$this->addArg( 'file', 'CSV file with the list of wikis' );
		$this->addOption( 'saveChanges', 'Change the wiki domains for real.', false, false, 'd' );
	}

	public function execute() {
		global $wgWikiaBaseDomain, $wgWikiaOrgBaseDomain, $wgUser;

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

			if ( strpos( $sourceDomain, $wgWikiaBaseDomain ) === false ||
				substr_count( $sourceDomain, '.' ) > 3
			) {
				$this->output( "Wiki with ID {$sourceWikiId} with the domain {$sourceDomain} is not a valid wikia.com domain to move!\n" );
				continue;
			}

			if ( count( $data ) === 2 ) {
				$targetDomain = $data[1];
			} else {
				$targetDomain = $this->getTargetDomain( $sourceDomain );
				if ( !$targetDomain ) {
					$this->output( "Could not get the target domain for wiki with ID {$sourceWikiId}!\n" );
					continue;
				}

				if ( strpos( $targetDomain, "/" ) === false ) {
					$englishAliasDomain = $this->getEnglishAliasDomain( $sourceDomain );
				}
			}

			if ( strpos( $targetDomain, $wgWikiaOrgBaseDomain ) === false ||
				substr_count( $targetDomain, '.' ) > 3
			) {
				$this->output( "Invalid target domain {$targetDomain} for the wiki with ID {$sourceWikiId}!\n" );
				continue;
			}

			if ( $saveChanges ) {
				WikiFactory::addDomain( $sourceWikiId, $targetDomain, 'Migration to wikia.org' );

				WikiFactory::setmainDomain( $sourceWikiId, $targetDomain, 'Migration to wikia.org' );

				if ( !empty( $englishAliasDomain ) ) {
					WikiFactory::addDomain( $sourceWikiId, $englishAliasDomain, 'Creating /en alias for Wiki with ID {$sourceWikiId}' );
				}

				WikiFactory::removeVarByName( 'wgWikiaOrgMigrationScheduled', $sourceWikiId, 'Migration to wikia.org' );
				WikiFactory::setVarByName( 'wgWikiaOrgMigrationDone', $sourceWikiId, true, 'Migration to wikia.org' );

				// Update lastmod in sitemap timestamps
				WikiFactory::setVarByName( 'wgDomainChangeDate', $sourceWikiId, wfTimestamp( TS_MW ), 'Migration to wikia.org' );

				$this->purgeCachesForWiki( $sourceWikiId );
			}

			$this->output( "Wiki with ID {$sourceWikiId} was migrated from {$sourceDomain} to {$targetDomain}!\n" );

			if ( !empty( $englishAliasDomain ) ) {
				$this->output( "/en alias domain was created: {$englishAliasDomain}\n" );
			}
		}

		fclose( $fileHandle );
	}

	private function getTargetDomain( $sourceDomain ) {
		global $wgWikiaOrgBaseDomain;

		$parts = explode( '.', $sourceDomain );
		if ( count( $parts ) > 3 ) {
			if ( !$this->isValidLanguagePath( $parts[0] ) ) {
				$this->output( "{$sourceDomain} is a multiple subdomain URL but the language code is not valid!\n" );
				return false;
			}
			return "{$parts[1]}.{$wgWikiaOrgBaseDomain}/{$parts[0]}";
		}
		return "{$parts[0]}.{$wgWikiaOrgBaseDomain}";
	}

	private function getEnglishAliasDomain( $sourceDomain ) {
		global $wgWikiaOrgBaseDomain;
		$parts = explode( '.', $sourceDomain );

		if ( $parts[1] !== 'wikia' ) {
			return false;
		}

		return "{$parts[0]}.{$wgWikiaOrgBaseDomain}/en";
	}

	private function isValidLanguagePath( $languageCode ): bool {
		if ( !$this->languageNames ) {
			$this->languageNames = Language::getLanguageNames();
		}

		return isset( $this->languageNames[ $languageCode ] );
	}

	private function purgeCachesForWiki( $wikiId ) {
		global $wgMemc;

		WikiFactory::clearCache( $wikiId );

		Wikia::purgeSurrogateKey( Wikia::wikiSurrogateKey( $wikiId ) );
		Wikia::purgeSurrogateKey( Wikia::wikiSurrogateKey( $wikiId ), 'mercury' );

		$dbName = WikiFactory::IDtoDB( $wikiId );

		$keys = [
			wfSharedMemcKey( 'globaltitlev1', $wikiId ),
			wfSharedMemcKey( 'globaltitlev1:https', $wikiId ),
			wfForeignMemcKey(
				$dbName,
				false,
				'Wikia\Search\TopWikiArticles',
				'WikiaSearch',
				'topWikiArticles',
				$wikiId,
				Wikia\Search\TopWikiArticles::TOP_ARTICLES_CACHE,
				false
			),
			wfForeignMemcKey(
				$dbName,
				false,
				'Wikia\Search\TopWikiArticles',
				'WikiaSearch',
				'topWikiArticles',
				$wikiId,
				Wikia\Search\TopWikiArticles::TOP_ARTICLES_CACHE,
				true
			),
		];

		foreach ( $keys as $key ) {
			$wgMemc->delete( $key );
		}
	}
}

$maintClass = 'MigrateWikiToWikiaOrg';
require_once RUN_MAINTENANCE_IF_MAIN;
