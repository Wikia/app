<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/4/14
 * Time: 11:20 AM
 */

class LyricsScrapper {

	private $dba;
	private $context;

	function __construct( $dba ) {
		$this->dba = $dba;
		$this->context = new RequestContext();
	}

	function processArtistArticle( Article $article ) {
		$albumsData = [];
		$artistScraper = new ArtistScraper();
		$artistData = $artistScraper->processArticle( $article );
		$albumsData = $artistScraper->getAlbums( $article, $artistData['name'] );
		self::log( 'ARTIST: ' . $artistData['name'] . PHP_EOL );
		foreach ( $albumsData as $albumData ) {
			$songsData = [];
			$albumArticle = $this->articleFromTitle( $albumData['title'] );
			self::log( "\tALBUM: " . $albumData['title'] . PHP_EOL );
			if ( $albumArticle !== null ) {
				$albumScraper = new AlbumScraper();
				$albumData = array_merge( $albumData,  $albumScraper->processArticle( $albumArticle ) );
				$songsData = $albumScraper->getSongs( $albumArticle );
				foreach( $songsData as $songData ) {
					$songArticle = $this->articleFromTitle( $songData['title'] );
					self::log( "\t\tSONG: " . $songData['title'] . PHP_EOL );
					if ( $songArticle !== null ) {
						$songScraper = new SongScraper();
						$songData = array_merge( $songData,  $songScraper->processArticle( $songArticle ) );
						// Save only songs we have
						$this->dba->saveSong( $artistData, $albumData, $songData );
					} else {
						self::log( 'SONG NOT FOUND '. $songData['title'] . PHP_EOL );
					}
				}
			} else {
				self::log( 'ALBUM NOT FOUND '. $albumData['title'] . PHP_EOL );
			}
			$this->dba->saveAlbum( $artistData, $albumData, $songsData );
		}
		$this->dba->saveArtist( $artistData, $albumsData );
	}

	/**
	 * Get wiki article from article title
	 *
	 * @param $titleText Wiki page title text
	 * @return Article|null
	 */
	function articleFromTitle ( $titleText ) {
		$title = Title::newFromText( $titleText, NS_MAIN );
		if ( !is_null( $title ) && $title->exists() ) {
			 return Article::newFromTitle( $title, $this->context);
		}
		return null;
	}

	static function log ( $text ) {
		echo $text;
	}
} 