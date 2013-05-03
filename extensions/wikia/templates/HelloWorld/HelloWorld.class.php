<?php

class HelloWorld {

	// MediaWiki Title object
	private $title = null;

	// WikiaApp
	private $app = null;

	public function __construct(Title $currentTitle = null) {
		$this->app = F::app();
		$this->title = $currentTitle;
	}

	/**
	 * @brief Gets the title and URL for a wiki
	 * @details Returns an array containing 'title' and 'url' keys, given a wiki ID
	 *
	 * @param int $wikiId
	 *
	 * @return array
	 */
	public function getWikiData( $wikiId ) {
		wfProfileIn( __METHOD__ );

		if( empty( $wikiId ) ) {
			throw new WikiaException("Unknown wikiId");
		}

		$dbr = wfGetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );
		$row = $dbr->selectRow( 'city_list', array('city_url', 'city_title'), array( 'city_id' => $wikiId ), __METHOD__ );

		if( !empty($row) ) {
			$wiki = array( 'title' => $row->city_title, 'url' => $row->city_url );
		}
		else {
			throw new WikiaException("Unknown wikiId: $wikiId");
		}

		wfProfileOut( __METHOD__ );
		return $wiki;
	}

	/**
	 * @brief Returns true
	 * @details This function doesn't actually do anything - handler for MediaWiki hook
	 *
	 * @param OutputPage &$out MediaWiki OutputPage passed by reference
	 * @param string &$text The article contents passed by reference
	 *
	 * @return true
	 */
	public function onOutputPageBeforeHTML( &$out, &$text ) {
		return true;
	}

}
