<?php

/**
 * Class AlbumScraper
 *
 * Scrape Album page from Lyrics API
 */
class AlbumScraper extends BaseScraper {


	/**
	 * Process Album article page
	 *
	 * @param Article $article
	 * @return array
	 */
	public function processArticle( Article $article ) {
		$albumData = [
			'article_id' => $article->getId(),
		];
		$albumData = array_merge( $albumData, $this->getHeader( $article ) );
		$albumData['genres'] = $this->getGenres( $article );
		return array_merge( $albumData, $this->getFooter( $article ) );
	}

	/**
	 * Get album data from header template
	 *
	 * @param Article $article
	 * @return array
	 */
	protected function getHeader( Article $article ) {
		return $this->getTemplateValues( 'Album', $article->getContent() );
	}

	/**
	 * Get album data from footer template
	 *
	 * @param Article $article
	 * @return array
	 */
	protected function getFooter( Article $article ) {
		return $this->getTemplateValues( 'AlbumFooter', $article->getContent() );
	}

	/**
	 * Data field mapping
	 *
	 * @return array
	 */
	public function getDataMap() {
		return [
			'article_id' => 'id',
			'Cover' => 'image',
			'year' => 'release_date',
			'Album' => 'album_name',
			'iTunes' => 'itunes',
			'Genre' => 'genres',
			'Length' => 'length',
			'Artist' => 'artist',
			'Wikipedia' => 'wikipedia',
			'romanizedAlbum' => 'romanized_name',
			'asin' => 'asin',
			'allmusic' => 'allmusic',
			'discogs' => 'discogs',
			'musicbrainz' => 'musicbrainz',
			'download' => 'download',
			'songs' => 'songs',
		];
	}

} 