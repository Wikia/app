<?php

/**
 * Class AlbumScraper
 *
 * Scrape Album page from Lyrics API
 */
class AlbumScraper extends BaseScraper {

	public function processArticle( Article $article ) {
		$albumData = [
			'article_id' => $article->getId(),
		];
		$albumData = array_merge( $albumData, $this->getHeader( $article ) );
		$albumData['genres'] = $this->getGenres( $article );
		return array_merge( $albumData, $this->getFooter( $article ) );
	}

	protected function getHeader( Article $article ) {
		return $this->getTemplateValues( 'Album', $article->getContent() );
	}

	protected function getFooter( Article $article ) {
		return $this->getTemplateValues( 'AlbumFooter', $article->getContent() );
	}

	public function getDataMap() {
		return [
			'available' => 'available',
			'article_id' => 'article_id',
			'Cover' => 'image',
			'year' => 'year',
			'Album' => 'name',
			'iTunes' => 'itunes',
			'Genre' => 'genres',
			'Length' => 'length',
			'Artist' => 'artist',
			'Wikipedia' => 'wikipedia',
			'romanizedAlbum' => 'romanized_album_name',
			'asin' => 'asin',
			'allmusic' => 'allmusic',
			'discogs' => 'discogs',
			'musicbrainz' => 'musicbrainz',
			'download' => 'download',
			'songs' => 'songs',
		];
	}

} 