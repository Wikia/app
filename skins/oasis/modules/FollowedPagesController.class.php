<?php
class FollowedPagesController extends WikiaController {

	const MAX_FOLLOWED_PAGES = 6;

	public function executeIndex($params) {
	
		$page_owner = User::newFromName($this->wg->Title->getText());

		if ( !is_object( $page_owner ) || $page_owner->getId() == 0 ) {
			// do not show module if page owner does not exist or is an anonymous user
			return false;
		}

		// add CSS for this module
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL("skins/oasis/css/modules/FollowedPages.scss"));

		$showDeletedPages = isset($params['showDeletedPages']) ? (bool) $params['showDeletedPages'] : true;
		// get 6 followed pages
		$watchlist = FollowModel::getWatchList( $page_owner->getId(), 0, 6, null, $showDeletedPages );
		$data = array();
		// weird.  why is this an array of one element?
		foreach ($watchlist as $unused_id => $item) {
			$pagelist = $item['data'];
			foreach ($pagelist as $page) {
				$data[] = $page;
			}

		}
		// only display  your own page
		if ($page_owner->getId() == $this->wg->User->getId()) {
			$this->follow_all_link = Wikia::specialPageLink('Following', 'oasis-wikiafollowedpages-special-seeall', 'more');
		}
		
		$this->data = $data;
		$this->max_followed_pages = min(self::MAX_FOLLOWED_PAGES, count($this->data));
		
	}
}
