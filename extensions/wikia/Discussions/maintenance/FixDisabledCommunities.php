<?php
/**
 * Enables Discussions that were created but not successfully enabled
 * Usage: php FixDisabledCommunities.php [--dry-run]
 * @See https://wikia-inc.atlassian.net/browse/SOC-3551
 *
 * @ingroup Maintenance
 */
require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class FixDisabledCommunities extends Maintenance {

	protected $dryRun = false;
	protected $disabledCommunities;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Enables Discussions that were created but not successfully enabled';
		$this->disabledCommunities = range( 1489568, 1490879 );
		$this->disabledCommunities[] = 296530;
	}

	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );

		if ( $this->dryRun ) {
			echo "Dry Run Mode; no changes will be made!\n";
		}

		foreach ( $this->disabledCommunities as $wikiId ) {
			$wiki = WikiFactory::getWikiByID( $wikiId );

			if ( WikiFactory::getVarValueByName( 'wgEnableDiscussions', $wikiId ) === true ) {
				$this->error( 'Discussions are already enabled on ' . $wikiId . ', skipping!' );
				continue;
			}

			try {
				if (!$this->dryRun) {
					$this->enableDiscussions( $wikiId );
				}
				$this->output( 'Enabled discussions on ' . $wikiId . "\n" );
			} catch ( Exception $e ) {
				$this->error( 'Enabling ' . $wikiId . ' caused an error: ' . $e->getMessage() );
				continue;
			}

			if ( !$this->dryRun ) {
				$this->postWelcomeMessage( $wiki );
			}
		}
	}

	private function enableDiscussions( $cityId ) {
		( new \DiscussionsVarToggler( $cityId ) )
			->setEnableDiscussions( true )
			->setEnableDiscussionsNav( true )
			->setEnableForums( false )
			->setArchiveWikiForums( true )
			->save();
	}

	private function postWelcomeMessage( stdClass $wiki ) {
		$success = ( new StaffWelcomePoster() )->postMessage( $wiki->city_id, $wiki->city_lang );
		if ( !$success ) {
			$this->error( 'Unable to post staff welcome message for siteId: ' . $wiki->city_id );
		}
	}
}

$maintClass = FixDisabledCommunities::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
