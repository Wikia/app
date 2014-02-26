<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 11:41 AM
 */

class ScraperFactory {

	private $db;

	function __construct( $db ) {
		$this->db = $db;
	}

	/**
	 * @param Article $article
	 * @return AlbumScraper|ArtistScraper|SongScraper|null
	 */
	public function newFromArticle( Article $article ) {
		$content = $article->getContent();
		if ( strpos( $content, '{{ArtistHeader' ) !== FALSE ) {
			return new ArtistScraper( $this->db );
		}
		if ( strpos( $content, '{{Album' ) !== FALSE ) {
			return new AlbumScraper( $this->db );
		}
		if ( strpos( $content, '{{Song' ) !== FALSE ) {
			return new SongScraper( $this->db );
		}
		return null;
	}
} 