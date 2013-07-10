<?php

class HelloWorld {
	private $title = null;
	private $app = null;

	public function __construct(Title $currentTitle = null) {
		$this->app = F::app();
		$this->title = $currentTitle;
	}

	public function getWikiData( $wikiId ) {
		$this->app->wf->profileIn( __METHOD__ );

		if( empty($wikiId) ) {
			throw new WikiaException("Unknown wikiId");
		}

		$dbr = $this->app->wf->GetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );
		$row = $dbr->selectRow( 'city_list', array('city_url', 'city_title'), array( 'city_id' => $wikiId ), __METHOD__ );

		if ( !empty($row) ) {
			$wiki = array( 'title' => $row->city_title, 'url' => $row->city_url );
		} else {
			throw new WikiaException("Unknown wikiId: $wikiId");
		}

		$this->app->wf->profileOut( __METHOD__ );
		return $wiki;
	}
}
