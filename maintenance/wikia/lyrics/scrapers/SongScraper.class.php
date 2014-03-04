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

} 