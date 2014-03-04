<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/4/14
 * Time: 11:20 AM
 */

class LyricsScrapper {

	private $dba;

	function __construct( $dba ) {
		$this->dba = $dba;
	}

	function processArtistArticle( Article $article ) {
		$artistScraper = new ArtistScraper();
		$artist = $artistScraper->processArticle( $article );
		$albumsData = $artistScraper->getAlbums( $article, $artist['name'] );
		foreach ( $albumsData as $albumData ) {
			$context = new RequestContext();
			$title = Title::newFromText( $albumData['title'] );
			$albumArticle = Article::newFromTitle( $title, $context);
			$albumScraper = new AlbumScraper();
			$albumData = array_merge( $albumData,  $albumScraper->processArticle( $albumArticle ) );
			$artist['_albums'][] = $albumData;
		}
		print_r( $artist );
		print_r( $albumData );
		die();
	}

} 