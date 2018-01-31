<?php
require_once( dirname( __FILE__ ) . '/Maintenance.php' );

class CountTags extends Maintenance {

	public function execute() {
		global $wgSpecialsDB, $wgCityId;

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

		$res = $specials->select( 'city_used_tags', [ 'ct_wikia_id', 'ct_page_id' ], [ 'ct_kind' => "youtube", 'ct_wikia_id' => $wgCityId ] );

		foreach ( $res as $row ) {
			$content = Title::newFromID( $row->ct_page_id )->fetchContent();
			foreach ( $counts as $tag => $c ) {
				$counts[$tag] += preg_match_all( "<" . $tag, $content );
			}
		}

		$this->output( "Tag counts for wiki: " . $wgCityId );
		foreach ( $counts as $tag => $count ) {
			$this->output($tag . ": " . $count );
		}
	}

}