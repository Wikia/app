<?php
class FollowedPagesController extends WikiaController {

	const MAX_FOLLOWED_PAGES = 6;

	public function index() {
		$pageOwner = User::newFromName( $this->wg->Title->getText() );

		if ( !is_object( $pageOwner ) || $pageOwner->getId() == 0 ) {
			// do not show module if page owner does not exist or is an anonymous user
			return false;
		}

		// add CSS for this module
		$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( "skins/oasis/css/modules/FollowedPages.scss" ) );

		$showDeletedPages = $this->request->getBool( 'showDeletedPages', true );
		// get 6 followed pages
		$watchlist = FollowModel::getWatchList( $pageOwner->getId(), 0, 6, null, $showDeletedPages );
		$data = [ ];
		// weird.  why is this an array of one element?
		foreach ( $watchlist as $unused_id => $item ) {
			$pagelist = $item['data'];
			foreach ( $pagelist as $page ) {
				$data[] = $page;
			}

		}
		// only display  your own page
		if ( $pageOwner->getId() == $this->wg->User->getId() ) {
			$this->follow_all_link = Linker::linkKnown(
				SpecialPage::getTitleFor( 'Following' ),
				wfMessage( 'oasis-wikiafollowedpages-special-seeall' )->escaped(),
				[ 'class' => 'more' ]
			);
		}

		$this->data = $data;
		$this->max_followed_pages = min( self::MAX_FOLLOWED_PAGES, count( $this->data ) );

	}
}
