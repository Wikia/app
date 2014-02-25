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
		'name' => 'name',
		'romanizedArtist' => 'romanized_name',
		'pic' => 'image',
		'officialSite' => 'official_site',
		'myspace' => 'myspace',
		'twitter' => 'twitter',
		'facebook' => 'facebook',
		'wikia' => 'wikia',
		'wikipedia' => 'wikipedia',
		'wikipedia2' => 'wikipedia2',
		'country' => 'country',
		'state' => 'state',
		'hometown' => 'hometown',
		'iTunes' => 'itunes',
		'asin' => 'asin',
		'allmusic' => 'allmusic',
		'discogs' => 'discogs',
		'musicbrainz' => 'musicbrainz',
		'youtube' => 'youtube',
	];

	public function processPage( Article $article ) {
		$data = [
			'name' => $article->getTitle()->getText()
		];
		$data = array_merge( $data, $this->getHeader( $article ) );
		$data = array_merge( $data, $this->getFooter( $article ) );
		$this->save( $data );
	}

	protected function save( $data ) {
		$replaceData = $this->sanitiseData( $data, $this->dataMap);
		$this->db->replace(
			self::TABLE_NAME,
			null,
			$replaceData,
			__METHOD__
		);
	}

	protected function getHeader( Article $article ) {
		return getTemplateValues( 'ArtistHeader', $article->getContent() );
	}

	protected function getFooter(Article $article) {
		return getTemplateValues( 'ArtistFooter', $article->getContent() );
	}
}
