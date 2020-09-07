<?php

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

//cat wikis.txt | while read line ; do SERVER_ID=$line php extensions/wikia/Discussions/maintenance/dumpForumSizes.php ; done > result.txt

class ForumSize extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addArg( 'out', "Output file for results", $required = false );
	}

	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {

		global $wgCityId, $wgSitename;

		$outputName = $this->hasOption( 'out' ) ? $this->getArg() : "php://stdout";
		$fh = fopen( $outputName, 'a' );

		$dbr = wfGetDB( DB_SLAVE );

		$pages = ( new \WikiaSQL() )->SELECT(
			"count(*) as i"
		)
			->FROM( "page" )
			->WHERE( 'page_namespace' )
			->IN( 2000, 2001 )
			->runLoop(
				$dbr,
				function ( &$data, $row ) {
					$data[] = $row->i;
				}
			);

		$votes = ( new \WikiaSQL() )->SELECT(
			"count(*) as i"
		)
			->FROM( "page_vote" )
			->JOIN( "page" )
			->ON( "article_id", "page_id" )
			->WHERE( 'page_namespace' )
			->IN( 2000, 2001 )
			->runLoop(
				$dbr,
				function ( &$data, $row ) {
					$data[] = $row->i;
				}
			);

		$topics = ( new \WikiaSQL() )->SELECT(
			"count(*) as i"
		)
			->FROM( "wall_related_pages" )
			->JOIN( "page" )
			->AS_( 'p' )
			->ON( 'comment_id', 'p.page_id' )
			->WHERE( 'p.page_namespace' )
			->IN( 2000, 2001 )
			->runLoop(
				$dbr,
				function ( &$data, $row ) {
					$data[] = $row->i;
				}
			);

		$history = ( new \WikiaSQL() )->SELECT(
			"count(*) as i"
		)
			->FROM( "wall_history" )
			->JOIN( "page" )
			->AS_( 'p' )
			->ON( 'parent_page_id', 'p.page_id' )
			->WHERE( 'p.page_namespace' )
			->IN( 2000 )
			->runLoop(
				$dbr,
				function ( &$data, $row ) {
					$data[] = $row->i;
				}
			);

		$total = $pages[0] * 2 + $votes[0] + $topics[0] + $history[0];

		echo("Result: " . $total . " inserts for " . $wgCityId . ": " . $wgSitename . "\n");

		fwrite( $fh, $wgCityId . ';' . $wgSitename . ';' . $total . ";\n" );
	}
}

$maintClass = ForumSize::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
