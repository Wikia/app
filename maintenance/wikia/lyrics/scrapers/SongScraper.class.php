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
		$songName = ( !is_null( $songTitle ) ) ? $this->getSongFromArtistTitle( $songTitle->getText() ) : null;
		if( !is_null( $songName ) ) {
			$songData['song'] = $songName;
			$songData['song_lowercase'] = LyricsUtils::lowercase( $songName );
		} else {
			wfDebugLog( __METHOD__, sprintf( 'Scraped song without title (%d) or with invalid name', $songArticleId ) );
		}

		return $songData;
	}

	/**
	 * @desc If there is {{TranslatedSong}} template returns true; false otherwise
	 *
	 * @param Article $article
	 * @return Boolean
	 */
	public function isSongTraslation( Article $article ) {
		$translation = $this->getTemplateValues( 'TranslatedSong', $article->getContent() );
		return !empty( $translation['current'] );
	}

	/**
	 * @desc Gets the string after last colon if found in title text; otherwise false
	 *
	 * @param String $titleText title text of the song article
	 *
	 * @return null|String
	 */
	protected function getSongFromArtistTitle( $titleText ) {
		$titleTextExploded = explode( ':', $titleText );

		if( count( $titleTextExploded ) > 1 ) {
			return array_pop( $titleTextExploded );
		}

		return null;
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
			'song_lowercase' => 'song_name_lc',
			'iTunes' => 'itunes',
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
