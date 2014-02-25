<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/25/14
 * Time: 4:37 PM
 */

namespace scrappers;


class ArtistScrapper extends BaseScraper {

	const TABLE_NAME = 'artist';

	var $dataMap = [
		'pic' => 'image',
		'officialSite' => 'official_site',
		'myspace' => 'myspace',
		'wikipedia' => 'wikipedia',
		'country' => 'country',
		'state' => 'state',
		'hometown' => 'hometown',
	];

	public function processPage( Article $article ) {
		$data = [];
		$data += $this->getHeader( $article );
		$data += $this->getFooter( $article );
		$this->save( $data );
	}

	protected function save( $data ) {
		return 0;
	}

	protected function getHeader( Article $article ) {
		return getTemplateValues( 'ArtistHeader' , $article->getContent() );
	}

	protected function getFooter( Article $article ) {
		return getTemplateValues( 'ArtistFooter' , $article->getContent() );
	}
} 