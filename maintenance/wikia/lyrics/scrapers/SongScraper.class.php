<?php
/**
 * Class SongScraper
 *
 * @desc Scrape Song page from Lyrics API
 */
class SongScraper extends BaseScraper {

	/**
	 * @desc Process Song article page
	 *
	 * @param Article $article
	 * @return array
	 */
	public function processArticle( Article $article ) {
		$songArticleId = $article->getId();
		$songData = [
			'article_id' => $songArticleId,
		];

		$songData = array_merge( $songData, $this->getFooter( $article ) );
		$songData['lyrics'] = $this->getLyrics( $article );

		// MOB-1367 - make sure the song name is the same as song's article title
		$songTitle = $article->getTitle();
		$songName = ( !is_null( $songTitle ) ) ? $this->getSongFromArtistTitle( $songTitle ) : false;
		if( !$songName ) {
			$songData['song'] = $songName;
		} else {
			wfDebugLog( __METHOD__, sprintf( 'Scraped song without title (%d) or with invalid name', $songArticleId ) );
		}

		return $songData;
	}

	/**
	 * @desc Gets the string after first colon if found in title text; otherwise false
	 *
	 * @param Title $title Title instance of the song article
	 *
	 * @return bool|String
	 */
	private function getSongFromArtistTitle( Title $title ) {
		$result = false;
		$titleText = $title->getText();
		$titleTextExploded = explode( ':', $titleText );

		if( count( $titleTextExploded ) > 1 ) {
			$result = $titleTextExploded[1];
		}

		return $result;
	}

	/**
	 * @desc Get song data from header template
	 *
	 * @param Article $article
	 * @return array
	 */
	protected function getFooter( Article $article ) {
		return $this->getTemplateValues( 'SongFooter', $article->getContent() );
	}

	/**
	 * Get song lyrics from article
	 *
	 * @param $article
	 * @return string
	 */
	protected function getLyrics( $article ) {
		if ( preg_match('#<lyrics>(.*?)<\/lyrics>#s', $article->getContent(), $matches ) ) {
			return LyricsUtils::removeWikitextFromLyrics( $matches[1] );
		}
		return '';
	}

	/**
	 * @desc Data field mapping
	 *
	 * @return array
	 */
	public function getDataMap() {
		return [
			'article_id' => 'id',
			'number' => 'number',
			'song' => 'song_name',
			'itunes' => 'itunes',
			'lyrics' => 'lyrics',
			'romanizedSong' => 'romanized_song_name',
			'language' => 'language',
			'youtube' => 'youtube',
			'goear' => 'goear',
			'asin' => 'asin',
			'musicbrainz' => 'musicbrainz',
			'allmusic' => 'allmusic',
			'download' => 'download',
		];
	}

}
