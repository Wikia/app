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
		$context = new RequestContext();
		$artistScraper = new ArtistScraper();
		$artistData = $artistScraper->processArticle( $article );
		$albumsData = $artistScraper->getAlbums( $article, $artistData['name'] );
		foreach ( $albumsData as $albumData ) {
			$title = Title::newFromText( $albumData['title'] );
			if ( $title->exists() ) {
				$albumArticle = Article::newFromTitle( $title, $context);
				$albumScraper = new AlbumScraper();
				$albumData = array_merge( $albumData,  $albumScraper->processArticle( $albumArticle ) );
				$songsData = $albumScraper->getSongs( $albumArticle );
				foreach( $songsData as $songData ) {
					$title = Title::newFromText( $songData['title'] );
					if ( $title->exists() ) {
						$songArticle = Article::newFromTitle( $title, $context);
						$songScraper = new SongScraper();
						$songData = array_merge( $songData,  $songScraper->processArticle( $songArticle ) );
					} else {
						echo 'SONG NOT FOUND '. $songData['title'] . PHP_EOL;
					}
					$this->dba->saveSong( $artistData, $albumData, $songData );
				}
			} else {
				echo 'ALBUM NOT FOUND '. $albumData['title'] . PHP_EOL;
			}
			$this->dba->saveAlbum( $artistData, $albumData, $songsData );
		}
		$this->dba->saveArtist($artistData, $albumsData);
	}

} 