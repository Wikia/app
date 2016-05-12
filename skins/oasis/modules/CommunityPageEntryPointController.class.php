<?php

class CommunityPageEntryPointController extends WikiaController {
	public function executeIndex( $params ) {
		Wikia::addAssetsToOutput( 'community_page_entry_point_js' );
		Wikia::addAssetsToOutput( 'community_page_entry_point_scss' );
	}
}
