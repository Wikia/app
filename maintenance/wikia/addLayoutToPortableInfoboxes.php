<?php

/**
 * Script goes through all pages on a wikia that has infoboxes definitions and adds layout="stacked"
 *
 * @author Kamil Koterba
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );
require_once( dirname( __FILE__ ) . '/Infoboxes/InfoboxReplaceHelper.class.php' );

/**
 * Maintenance script class
 */
class addLayoutToPortableInfoboxes extends Maintenance {

	private $summaries = [
		'en' => 'Adding explicit layout parameter'
	];

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		global $wgUser;
		$wgUser = User::newFromName( 'Wikia' );
		$pages = $this->getPagesWithInfoboxes();
		foreach ( $pages as $pageId ) {
			$article = Article::newFromID( $pageId );
			$content = $article->getContent();
			$replaceHelper = new InfoboxReplaceHelper();
			$replacedContent = $replaceHelper->processLayoutAttribute( $content );
			$article->getPage()->doEdit( $replacedContent, $this->getSummary() );
		}
		$this->output( "\nDone!\n" );
	}

	private function getPagesWithInfoboxes() {
		global $wgCityId;
		$app = \F::app();
		$statsdb = wfGetDB( DB_SLAVE, null, $app->wg->StatsDB );
		$pages = ( new \WikiaSQL() )
			->SELECT( 'ct_page_id' )
			->FROM( 'city_used_tags' )
			->WHERE( 'ct_kind' )->EQUAL_TO( 'infobox' )
			->AND_( 'ct_wikia_id' )->EQUAL_TO( $wgCityId )
			->runLoop( $statsdb, function ( &$pages, $row ) {
				$pages[] = $row->ct_page_id;
			} );
		return $pages;
	}

	private function getSummary() {
		global $wgContLang;
		$summary = $this->summaries[$wgContLang];
		if ( $summary ) {
			return $summary;
		} else {
			return $this->summaries['en'];
		}
	}

}

$maintClass = "addLayoutToPortableInfoboxes";
require_once( RUN_MAINTENANCE_IF_MAIN );
