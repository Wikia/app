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
		if( !is_null( $songTitle ) ) {
			$songData['song'] = $songTitle->getText();
		} else {
			wfDebugLog( __METHOD__, sprintf( 'Scraped song without title (%d)', $songArticleId ) );
		}

		return $songData;
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
			return $this->removeWikiTextFromLyrics( $matches[1] );
		}
		return '';
	}

	/**
	 * Remove wikitext from the lyrics tag
	 *
	 * Borrowed from extensions/3rdparty/LyricWiki/server.php
	 *
	 * @param $lyrics
	 * @return mixed
	 */
	function removeWikiTextFromLyrics( $lyrics ) {
		global $wgParser;

		$lyrics = preg_replace( '/\{\{(.*?)\}\}/', '$1', $lyrics );
		return trim( $wgParser->stripSectionName( $lyrics ) );
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
