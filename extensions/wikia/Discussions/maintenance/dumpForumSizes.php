<?php

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

//cat wikis.txt | while read line ; do SERVER_ID=$line php extensions/wikia/Discussions/maintenance/dumpForumSizes.php ; done > result.txt

class ForumSize extends Maintenance {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {

		global $wgCityId, $wgSitename;

		$dbr = wfGetDB( DB_SLAVE );

		$data = ( new \WikiaSQL() )->SELECT(
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

		echo("Result;${wgCityId};${wgSitename};${$data[0]};\n");
	}
}

$maintClass = ForumSize::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
