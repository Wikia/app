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
		// TODO: Save tracks
	}

	protected function getHeader( Article $article ) {
		return $this->getTemplateValues( 'Album', $article->getContent() );
	}

	protected function getFooter( Article $article ) {
		return $this->getTemplateValues( 'AlbumFooter', $article->getContent() );
	}

} 