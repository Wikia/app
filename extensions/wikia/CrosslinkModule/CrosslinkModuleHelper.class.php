<?php

/**
 * Class CrosslinkModuleHelper
 */
class CrosslinkModuleHelper extends WikiaModel {

	const CACHE_TTL = 86400;

	/**
	 * Show the module only on article pages (for Anon users only)
	 * @return boolean
	 */
	public function canShowModule() {
		if ( $this->wg->User->isLoggedIn() || !$this->app->checkSkin( 'oasis' ) ) {
			return false;
		}

		$title = $this->wg->Title;
		if ( $title instanceof Title && $title->getNamespace() == NS_MAIN ) {
			return in_array( $title->getArticleID(), $this->getValidPages() );
		}

		return false;
	}

	/**
	 * Get list of pages that the module is enabled
	 * @return array
	 */
	protected function getValidPages() {
		$cacheKey = wfMemcKey( 'crosslink_module', 'valid_pages' );
		$db = wfGetDB( DB_SLAVE, [], 'specials' );
		$pages = ( new WikiaSQL() )->cache( static::CACHE_TTL, $cacheKey, true )
			->SELECT( 'source_page' )
			->DISTINCT( 'source_page' )
			->FROM( 'crosslink' )
			->WHERE( 'source_wiki' )->EQUAL_TO( $this->wg->CityId )
			->runLoop( $db, function( &$pages, $row ) {
				$pages[] = $row->source_page;
			});

		return empty( $pages ) ? [] : $pages;
	}

	/**
	 * Get list of articles
	 * @param int $pageId
	 * @return array
	 */
	public function getArticles( $pageId ) {
		$cacheKey = wfMemcKey( 'crosslink_module', $pageId );
		$db = wfGetDB( DB_SLAVE, [], 'specials' );
		$articles = ( new WikiaSQL() )->cache( static::CACHE_TTL, $cacheKey, true )
			->SELECT( '*' )
			->FROM( 'crosslink' )
			->WHERE( 'source_wiki' )->EQUAL_TO( $this->wg->CityId )
			->AND_( 'source_page')->EQUAL_TO( $pageId )
			->runLoop( $db, function( &$articles, $row ) {
				$wiki = WikiFactory::getWikiByID( $row->target_wiki );
				if ( !empty( $wiki ) ) {
					$title = GlobalTitle::newFromId( $row->target_page, $row->target_wiki );
					if ( $title instanceof Title && !empty( $title->exists() ) ) {
						$articles[] = [
							'wikiId' => $row->target_wiki,
							'wikiTitle' => trim( $wiki->city_title ),
							'pageTitle' => $title->getText(),
							'pageUrl' => $title->getFullURL()
						];
					}
				}
			});

		return empty( $articles ) ? [] : $articles;
	}

}
