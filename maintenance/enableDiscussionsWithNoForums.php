<?php
/**
 * Enables Discussions on the given wikis, after verifying there are no threaded forum posts on each wiki
 * Usage: php enableDiscussionsWithNoForums.php <listfile>
 * Where:
 * 	<listfile> is a file where each line is a site ID where we want to enable discussions
 *
 * @ingroup Maintenance
 */
require_once( __DIR__ . '/Maintenance.php' );

class EnableDiscussionsWithNoForums extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Enables Discussions on given wikis with no threaded forum posts';
		$this->addArg( 'listfile', 'File with site IDs to enable discussions on, separated by newlines.' );
	}

	public function execute() {
		$fh = fopen( $this->getArg(), 'r' );

		if ( !$fh ) {
			$this->error( 'Unable to read from input file, exiting', true );
		}

		while ( !empty( $wikiId = trim( fgets( $fh ) ) ) ) {
			$wiki = WikiFactory::getWikiByID( $wikiId );

			$count = $this->getForumThreadCount( $wiki );
			if ( $count > 0 ) {
				$this->error( $wikiId . ' has ' . $count . ' forum threads, skipping!' );
				continue;
			}

			if ( WikiFactory::getVarValueByName( 'wgEnableDiscussions', $wikiId ) === true) {
				$this->error( 'Discussions are already enabled on ' . $wikiId . ', skipping!' );
				continue;
			}

			try {
				$this->activateDiscussions( $wikiId, $wiki->city_lang, $wiki->city_title );
				$this->enableDiscussions( $wikiId );
				$this->output( 'Enabled discussions on ' . $wikiId . "\n" );
			} catch ( Exception $e ) {
				$this->error( 'Creating site ' . $wikiId . ' caused an error: ' . $e->getMessage() );
			}
		}
	}

	private function getForumThreadCount( $wiki ) {
		$dbw = wfGetDB( DB_SLAVE, [ ], $wiki->city_dbname );
		$row = $dbw->selectRow(
			[ 'comments_index', 'page' ],
			[ 'count(*) cnt' ],
			[
				'parent_comment_id' => 0,
				'archived' => 0,
				'deleted' => 0,
				'removed' => 0,
				'page_namespace' => NS_WIKIA_FORUM_BOARD_THREAD
			],
			__METHOD__,
			[ ],
			[ 'page' => [ 'LEFT JOIN', [ 'page_id=comment_id' ] ] ]
		);

		return intval( $row->cnt );
	}

	private function activateDiscussions( $cityId, $cityName, $cityLang ) {
		( new \DiscussionsActivator( $cityId, $cityName, $cityLang ) )->activateDiscussions();
	}

	private function enableDiscussions( $cityId ) {
		( new \DiscussionsVarToggler( $cityId ) )
			->setEnableDiscussions( true )
			->setEnableDiscussionsNav( true )
			->setEnableForums( false )
			->setArchiveWikiForums( true )
			->save();
	}
}

$maintClass = 'EnableDiscussionsWithNoForums';
require_once( RUN_MAINTENANCE_IF_MAIN );
