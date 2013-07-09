<?php

/**
 * Class HelloWorld
 * @author kenkouot
 */

class HelloWorld {
	private $title = null;
	private $app = null;

	public function __construct(Title $currentTitle = null) {
		// 'F' is a alias for WikiaSuperFactory, which we can use to
		// get an instance of WikiaApp
		$this->app = F::app();
		$this->title =	$currentTitle;
	}
	
	public function getWikiData( $wikiId ) {
		$this->app->wf->profileIn( __METHOD__ );

		if( empty( $wikiId) ) {
			throw new WikiException("Unknown wikiId");
		}

		$dbr = $this->app->wf->GetDb( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );
		$row = $dbr->selectRow( 'city_list', array('city_url', 'city_title'), array( 'city_id' => $wikiId ), __METHOD__ );

		if ( !empty($row) ) {
			$wiki = array( 'title' => $row->city_title, 'url' => $row->city_url );
		}
		else {
			throw new WikiaException("Unkown wikiId: $wikiId");
		}

		$this->app->wf->profileOut( __METHOD__ );
		return $wiki;
	}
}

