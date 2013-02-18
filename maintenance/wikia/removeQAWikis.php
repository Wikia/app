<?php

/**
 * Script that marks QA wikis (created by automated tests)
 * to be removed by /extensions/wikia/WikiFactory/Close/maintenance.php script
 *
 * Use --quiet option when running on cron machines
 *
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class RemoveQAWikis extends Maintenance {

	const REASON = 'Marked for removal by RemoveQAWikis maintenance script';
	const WIKI_PREFIX = 'qatestwiki';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( "dry-run", "Do not mark any wikis, just list them" );
		$this->mDescription = 'Mark QA wikis created by automated tests for removal';
	}

	/**
	 * Mark given wiki as queued for removal
	 *
	 * @param $wikiId integer city ID
	 * @return bool
	 */
	private function markWikiAsClosed($wikiId) {
		WikiFactory::setFlags( $wikiId, WikiFactory::FLAG_FREE_WIKI_URL | WikiFactory::FLAG_DELETE_DB_IMAGES );
		$res = WikiFactory::setPublicStatus( WikiFactory::CLOSE_ACTION, $wikiId, self::REASON );
		WikiFactory::clearCache( $wikiId );

		return $res !== false;
	}

	public function execute() {
		global $wgExternalSharedDB;
		$isDryRun = $this->hasOption('dry-run');

		$this->output("Looking for wikis matching '" . self::WIKI_PREFIX ."' prefix...");

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$res = $dbr->select(
			'city_list',
			array(
				'city_id',
				'city_dbname',
				'city_url',
				'city_factory_timestamp',
			),
			array(
				'city_public' => 1,
				'city_dbname ' . $dbr->buildLike( self::WIKI_PREFIX, $dbr->anyString() )
			),
			__METHOD__
		);

		$this->output("\n\n");

		while($wiki = $res->fetchObject()) {
			$this->output("* {$wiki->city_dbname} <{$wiki->city_url}>... ");

			if (!$isDryRun) {
				if ($this->markWikiAsClosed($wiki->city_id)) {
					$this->output("done\n");
				}
				else {
					$this->output("err!\n");
				}
			}
			else {
				$this->output("skipping, dry run\n");
			}
		}

		$this->output("\nDone!\n");
	}
}

$maintClass = "RemoveQAWikis";
require_once( RUN_MAINTENANCE_IF_MAIN );
