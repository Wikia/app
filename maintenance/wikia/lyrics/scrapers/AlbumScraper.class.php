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
		];
		$albumData = array_merge( $albumData, $this->getHeader( $article ) );
		$albumData = array_merge( $albumData, $this->getFooter( $article ) );

		$albumData['artist_id'] = $this->getArtistId( $albumData['Artist'] );
		$album = new Album( $this->db );
		$albumData['id'] = $album->save( $albumData );
		$this->saveTracks( $article, $albumData );
	}

	protected function getHeader( Article $article ) {
		return $this->getTemplateValues( 'Album', $article->getContent() );
	}

	protected function getFooter( Article $article ) {
		return $this->getTemplateValues( 'AlbumFooter', $article->getContent() );
	}

	function saveTracks( Article $article, $albumData ) {
		// # '''[[La Polla Records:Salve|Salve]]'''
		$re = '/# \'\'\'\[\[(.+)\]\]/';
		if ( preg_match_all( $re, $article->getContent(), $matches ) ) {
			$trackNumber = 1;
			$song = new Song( $this->db );
			$track = new SongTrack( $this->db );
			foreach ( $matches[1] as $songName ) {
				$trackData = [];
				$trackData['album_id'] = $albumData['id'];
				$trackData['song_id'] = $song->getIdByNameAndArtistId( $songName, $albumData['artist_id'] );
				$trackData['track_number'] = $trackNumber;
				$track->save( $trackData );
				$trackNumber++;
			}
		}
	}

} 