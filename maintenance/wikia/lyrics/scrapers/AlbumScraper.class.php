<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 2:23 PM
 */

class AlbumScraper extends BaseScraper {

	public function processArticle( Article $article ) {
		$albumData = [
			'article_id' => $article->getId(),
			'index' => 'lyrics',
			'type' => 'album',
		];
		$albumData = array_merge( $albumData, $this->getHeader( $article ) );
		$albumData = array_merge( $albumData, $this->getFooter( $article ) );
		return $albumData;
	}

	protected function getHeader( Article $article ) {
		return $this->getTemplateValues( 'Album', $article->getContent() );
	}

	protected function getFooter( Article $article ) {
		return $this->getTemplateValues( 'AlbumFooter', $article->getContent() );
	}

	public function getSongs( Article $article ) {
		// # '''[[La Polla Records:Salve|Salve]]'''
		$songs = [];
		$re = '/# \'\'\'\[\[(.+)\]\]/';
		if ( preg_match_all( $re, $article->getContent(), $matches ) ) {
			$trackNumber = 1;
			foreach ( $matches[1] as $songName ) {
				$song = $this->getSongData( $songName );
				$song['number'] = $trackNumber;
				$songs[] = $song;
				$trackNumber++;
			}
		}
		return $songs;
	}

 	protected function getSongData( $songName ) {
		$songFields = explode( '|', $songName );
		return [
			'title' => $songFields[0],
			'name' => $songFields[1],
		];
	}

} 