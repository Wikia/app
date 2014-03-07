<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 3:08 PM
 */

class SongScraper extends BaseScraper {

	public function processArticle( Article $article ) {
		$songData = [
			'article_id' => $article->getId(),
			'index' => 'lyrics',
			'type' => 'song',
		];
		$songData = array_merge( $songData, $this->getHeader( $article ) );
		$songData = array_merge( $songData, $this->getFooter( $article ) );

		$songData['lyrics'] = $this->getLyrics( $article );
		return $songData;
	}

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

	protected function getFooter( Article $article ) {
		return $this->getTemplateValues( 'SongFooter', $article->getContent() );
	}

	protected function getLyrics( $article ) {
		if ( preg_match('#<lyrics>(.*?)<\/lyrics>#s', $article->getContent(), $matches ) ) {
			return trim( $matches[1] );
		}
	}

	public function getDataMap() {
		return [
			'article_id' => 'article_id',
			'available' => 'available',
			'number' => 'number',
			'index' => 'index',
			'type' => 'type',
			'artist_id' => 'artist_id',
			'Artist' => 'artist',
			'song' => 'name',
			'lyrics' => 'lyrics',
			'romanizedSong' => 'romanized_name',
			'language' => 'language',
			'youtube' => 'youtube',
			'goear' => 'goear',
			'itunes' => 'itunes',
			'asin' => 'asin',
			'musicbrainz' => 'musicbrainz',
			'allmusic' => 'allmusic',
			'download' => 'download',
		];
	}

} 