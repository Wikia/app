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
	private $artistScraper;
	private $albumScraper;
	private $songScraper;

	function __construct( $dba ) {
		$this->dba = $dba;
		$this->context = new RequestContext();
		$this->artistScraper = new ArtistScraper();
		$this->albumScraper = new AlbumScraper();
		$this->songScraper = new SongScraper();
	}

	function processArtistArticle( Article $article ) {
		$artistData = $this->artistScraper->processArticle( $article );
		$leanAlbumsData = $this->artistScraper->getAlbums( $article, $artistData['name'] );
		self::log( "\tARTIST: " . $artistData['name'] . PHP_EOL );
		$albumsData = $this->processAlbums( $artistData, $leanAlbumsData );
		$this->dba->saveArtist( $artistData, $albumsData );
	}

	function processAlbums( $artistData, $leanAlbumsData ) {
		$albumsData = [];
		foreach ( $leanAlbumsData as $albumData ) {
			if ( $albumData['title'] ) {
				$albumArticle = $this->articleFromTitle( $albumData['title'] );
				if ( $albumArticle !== null ) {
					self::log( "\t\tALBUM: " . $albumData['title'] . PHP_EOL );
					$albumData = array_merge( $albumData,  $this->albumScraper->processArticle( $albumArticle ) );
					$leanSongsData = $this->albumScraper->getSongs( $albumArticle );
					$songsData = $this->processSongs( $artistData, $albumData, $leanSongsData );
					$this->dba->saveAlbum( $artistData, $albumData, $songsData );
					$albumsData[] = $albumData;
					continue;
				}
			}
			self::log( "\t\tALBUM: NOT FOUND: ". $albumData['name'] . PHP_EOL );
			$albumData['songs'] = $this->processSongs( $artistData, $albumData, $albumData['songs'] );
			// Add to list only
			$albumsData[] = $this->albumScraper->sanitizeData(
				$albumData,
				$this->albumScraper->getDataMap()
			);
		}
		return $albumsData;
	}

	function processSongs( $artistData, $albumData, $leanSongsData ) {
		$songsData = [];
		foreach( $leanSongsData as $songData ) {
			$songArticle = $this->articleFromTitle( $songData['title'] );
			if ( $songArticle !== null ) {
				self::log( "\t\t\tSONG: " . $songData['title'] . PHP_EOL );
				$songData = array_merge( $songData,  $this->songScraper->processArticle( $songArticle ) );
				$songsData[] = $songData;
				// Save only songs we have
				$this->dba->saveSong( $artistData, $albumData, $songData );
			} else {
				self::log( "\t\t\tSONG NOT FOUND: " . $songData['name'] . PHP_EOL );
				// but also add to list the one which we don't have
				$albumsData[] = $this->songScraper->sanitizeData(
					$songData,
					$this->songScraper->getDataMap()
				);
			}
		}
		return $songsData;
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