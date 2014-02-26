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
	 * @return null|ArtistScraper
	 */
	public function newFromArticle( Article $article ) {
		$content = $article->getContent();
		if ( strpos( $content, '{{ArtistHeader' ) !== FALSE ) {
			return new ArtistScraper( $this->db );
		}
		return null;
	}
} 