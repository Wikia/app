<?php
/**
 * Class AlbumScraper
 *
 * @desc Scrape Album page from Lyrics API
 */
class AlbumScraper extends BaseScraper {


	/**
	 * @desc Process Album article page
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
		if ( isset( $albumData['Genre']) && !in_array($albumData['Genre'], $albumData['genres'] ) ) {
			$albumData['genres'][] = $albumData['Genre'];
		}
		return array_merge( $albumData, $this->getFooter( $article ) );
	}

	/**
	 * @desc Get album data from header template
	 *
	 * @param Article $article
	 * @return array
	 */
	protected function getHeader( Article $article ) {
		return $this->getTemplateValues( 'Album', $article->getContent() );
	}

	/**
	 * @desc Get album data from footer template
	 *
	 * @param Article $article
	 * @return array
	 */
	protected function getFooter( Article $article ) {
		return $this->getTemplateValues( 'AlbumFooter', $article->getContent() );
	}

	/**
	 * @desc Data field mapping
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
			'genres' => 'genres',
			'Length' => 'length',
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
