<?php

class CommunityPageEntryPointController extends WikiaController {
	public function executeIndex( $params ) {
		Wikia::addAssetsToOutput( 'community_page_entry_point_js' );
		Wikia::addAssetsToOutput( 'community_page_entry_point_scss' );
		$this->prepareNoWrapSitename();
	}

	private function prepareNoWrapSitename() {
		$boldSiteName = Html::element(
			'span',
			[ 'class' => 'community-page-entry-point-wiki-name' ],
			$this->app->wg->Sitename
		);

		$this->setVal( 'noWrapOpenWithSiteName', '<span class="community-page-entry-point-nowrap">' . $boldSiteName );
		$this->setVal( 'noWrapClose', '</span>' );
	}
}
