<?php
require_once( dirname( __FILE__ ) . '/Maintenance.php' );

class CountVideoTags extends Maintenance {

	public function execute() {
		global $wgSpecialsDB, $wgCityId;

		$this->output( "Starting video tag count" );

		$counts = [
			'youtube' => 0,
			'aovideo' => 0,
			'aoaudio' => 0,
			'wegame' => 0,
			'gtrailer' => 0,
			'nicovideo' => 0,
			'cgamer' => 0,
			'longtail' => 0
		];

		$specials = wfGetDB( DB_SLAVE, false, $wgSpecialsDB );

		$this->output( "Got handle to specials db" );

		$res = $specials->select( 'city_used_tags', [ 'ct_wikia_id', 'ct_page_id' ], [ 'ct_kind' => "youtube", 'ct_wikia_id' => $wgCityId ] );

		$this->output( "Query executed" );

		foreach ( $res as $row ) {
			$content = Title::newFromID( $row->ct_page_id )->fetchContent();
			foreach ( $counts as $tag => $count ) {
				$counts[$tag] = $count + preg_match_all( "<" . $tag, $content );
			}
		}

		$this->output( "Tag counts for wiki: " . $wgCityId );
		foreach ( $counts as $tag => $count ) {
			$this->output($tag . ": " . $count );
		}
	}

}

$maintClass = CountVideoTags::class;
require_once( RUN_MAINTENANCE_IF_MAIN );