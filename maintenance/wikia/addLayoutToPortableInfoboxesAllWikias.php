<?php

/**
 * Script goes through all portable infoboxes definitions on all wikias and adds stacked layout if one is not defined.
 * Stacked layout was default so far and with next release tabular layout will be default
 *
 * @author Kamil Koterba
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class addLayoutToPortableInfoboxesAllWikias extends Maintenance {

	public function __construct() {
		parent::__construct();
	}
	
	public function execute() {
		$pages = $this->getPagesWithInfoboxes();
		foreach ( $pages as $wikiaId => $pagesOnWikia ) {
			$pagesParam = json_encode( $pagesOnWikia );
			$cmd = 'SERVER_ID=' . $wikiaId . ' php maintenance/wikia/addLayoutToPortableInfoboxes.php --pages=' . $pagesParam;
			$result = wfShellExec( $cmd );
			$this->output( "$result\n" );
		}
		$this->output( "\nDone!\n" );
	}

	private function getPagesWithInfoboxes() {
		$app = \F::app();
		$statsdb = wfGetDB( DB_SLAVE, null, $app->wg->StatsDB );
		$pages = ( new \WikiaSQL() )
			->SELECT( 'ct_page_id, ct_wikia_id, ct_namespace' )
			->FROM( 'city_used_tags' )
			->WHERE( 'ct_kind' )->EQUAL_TO( 'infobox' )
			->runLoop( $statsdb, function ( &$pages, $row ) {
				$pages[$row->ct_wikia_id][] = [
					'page_id' => $row->ct_page_id,
					'namespace' => $row->ct_namespace,
				];
			} );
		return $pages;
	}
}

$maintClass = "addLayoutToPortableInfoboxesAllWikias";
require_once( RUN_MAINTENANCE_IF_MAIN );
