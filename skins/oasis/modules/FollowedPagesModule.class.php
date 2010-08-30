<?php
class FollowedPagesModule extends Module {
	var $data;
	var $user_id;
	var $comments; /** @todo fill information **/
	var $likes; /** @todo fill information **/
	var $follow_all_link;
	var $max_followed_pages = 6;
	var $wgBlankImgUrl;

	public function executeIndex($params) {
		global $wgUser, $wgTitle, $wgOut, $wgStylePath;

		// add CSS for this module
		$wgOut->addStyle(wfGetSassUrl("skins/oasis/css/modules/FollowedPages.scss"));
		
		// probably need some logic to only display on user pages
    	$page_owner = User::newFromName($wgTitle->getText());
				
		if ($page_owner) {

			// get 6 followed pages
			$watchlist = FollowModel::getWatchList( $page_owner->getId(), 0, 6 );
			// weird.  why is this an array of one element?
			foreach ($watchlist as $unused_id => $item) {
				$pagelist = $item['data'];
				foreach ($pagelist as $page) {
					$this->data[] = $page;
				}

			}
			// only display  your own page
			if ($page_owner->getId() == $wgUser->getId()) {
				$this->follow_all_link = View::specialPageLink('Following', 'oasis-wikiafollowedpages-special-seeall', 'more');
			}
		}
		$this->max_followed_pages = min($this->max_followed_pages, count($this->data));
		$this->user_id = $wgUser->getId();
		$this->wgStylePath = $wgStylePath;
		
	}
}