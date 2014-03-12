<?php


/**
 * Class SongScraper
 *
 * Scrape Song page from Lyrics API
 */
class SongScraper extends BaseScraper {

	/**
	 * Process Song article page
	 *
	 * @param Article $article
	 * @return array
	 */
	public function processArticle( Article $article ) {
		$songData = [
			'article_id' => $article->getId(),
		];
		$songData = array_merge( $songData, $this->getHeader( $article ) );
		$songData = array_merge( $songData, $this->getFooter( $article ) );

		$songData['lyrics'] = $this->getLyrics( $article );
		return $songData;
	}

	/**
	 * Get song data from header template
	 *
	 * @param Article $article
	 * @return array
	 */
	protected function getHeader( Article $article ) {
		$result = [];
		$values = $this->getTemplateValues( 'song', $article->getContent(), '|', false );
		if ( $values ) {
			$result['Artist'] = $values[2];
			if ( $values[1] ) {
				list( $albumName, $albumYear ) = $this->getAlbumNameYear( $values[1] );
			}
			$result['Album'] = $albumName;
		}
		return $result;
	}

	/**
	 * Get song data from header template
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
			return trim( removeWikitextFromLyrics( $matches[1] ) );
		}
	}

	/**
	 * Clear wikitext from the lyrics tag
	 *
	 * Borrowed from extensions/3rdparty/LyricWiki/server.php
	 *
	 * @param $lyrics
	 * @return mixed
	 */
	function removeWikitextFromLyrics( $lyrics ) {
		// Clean up wikipedia template to be plaintext
		$lyrics = preg_replace( '/\{\{wp.*\|(.*?)\}\}/', '$1', $lyrics );

		// Clean up links & category-links to be plaintext
		$lyrics = preg_replace( '/\[\[([^\|\]]*)\]\]/', '$1', $lyrics ); // links with no alias (no pipe)
		$lyrics = preg_replace( '/\[\[.*\|(.*?)\]\]/', '$1', $lyrics );

		// Filter out extra formatting markup
		$lyrics = preg_replace("/'''/", "", $lyrics); // rm bold
		$lyrics = preg_replace("/''/", "", $lyrics); // rm italics

		return $lyrics;
	}

	/**
	 * Data field mapping
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
			'Artist' => 'artist',
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