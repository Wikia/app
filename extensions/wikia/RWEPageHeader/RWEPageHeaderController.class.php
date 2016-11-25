<?php

class RWEPageHeaderController extends WikiaController {

	public function index() {
		$this->searchModel = $this->getSearchData();
		$this->discussTabLink = $this->getDiscussTabLink();
	}

	private function getDiscussTabLink() {
		global $wgEnableDiscussionsNavigation, $wgEnableDiscussions, $wgEnableForumExt;

		if ( !empty( $wgEnableDiscussionsNavigation ) && !empty( $wgEnableDiscussions ) && empty( $wgEnableForumExt ) ) {
			return '/d';
		} else {
			return '/wiki/Special:Forum';
		}
	}

	private function getSearchData() {
		return $this->sendRequest( 'DesignSystemApi', 'getNavigation', [
			'id' => $this->wg->CityId,
			'product' => 'wikis',
			'lang' => $this->wg->Lang->getCode()
		] )->getData()['search'];
	}
}
