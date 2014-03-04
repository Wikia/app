<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 11:41 AM
 */

class ScraperFactory {

	private $dba;

	function __construct( $dba ) {
		$this->dba = $dba;
	}

	/**
	 * @param Article $article
	 * @return AlbumScraper|ArtistScraper|SongScraper|null
	 */
	public function newFromArticle( Article $article ) {
		$content = $article->getContent();
		if ( strpos( $content, '{{ArtistHeader' ) !== FALSE ) {
			return new ArtistScraper( $this->dl );
		}
		if ( strpos( $content, '{{Album' ) !== FALSE ) {
			return new AlbumScraper( $this->dl );
		}
		if ( strpos( $content, '{{Song' ) !== FALSE ) {
			return new SongScraper( $this->esClient );
		}
		return null;
	}
} 