<?php

/**
 * Class LyricsScraper
 *
 * Scrapes lyrics wiki articles for structured lyrics data
 */
class LyricsScraper {

	/**
	 * @var DataBaseAdapter
	 */
	private $dba;

	/**
	 * @var RequestContext
	 */
	private $context;

	/**
	 * @var ArtistScraper
	 */
	private $artistScraper;

	/**
	 * @var AlbumScraper
	 */
	private $albumScraper;

	/**
	 * @var SongScraper
	 */
	private $songScraper;

	function __construct( DataBaseAdapter $dba ) {
		$this->dba = $dba;
		$this->context = new RequestContext();
		$this->artistScraper = new ArtistScraper();
		$this->albumScraper = new AlbumScraper();
		$this->songScraper = new SongScraper();
	}

	/**
	 * Process Lyrics wiki Artist Article
	 *
	 * @param Article $article
	 */
	function processArtistArticle( Article $article ) {
		// Get Artist data
		$artistData = $this->artistScraper->processArticle( $article );
		// Get basic albums data from Artist page
		$leanAlbumsData = $this->artistScraper->getAlbums( $article, $artistData['artist_name'] );
		self::log( "\tARTIST: " . $artistData['artist_name'] . PHP_EOL );
		$albumsData = $this->processAlbums( $artistData, $leanAlbumsData );
		// Save Artist
		$this->dba->saveArtist( $artistData, $albumsData );
	}

	/**
	 * Process Lyrics wiki Albums
	 *
	 * @param array $artistData - Artist data
	 * @param array $leanAlbumsData - Albums data collected from Artist page
	 * @return array - Fill albums data
	 */
	function processAlbums( $artistData, $leanAlbumsData ) {
		$albumsData = [];
		foreach ( $leanAlbumsData as $albumData ) {
			self::log( "\t\tALBUM: " . $albumData['Album'] . PHP_EOL );
			// Check if Album has MediaWiki Title
			if ( $albumData['title'] ) {
				$albumArticle = $this->articleFromTitle( $albumData['title'] );
				// Check if the page exists
				if ( $albumArticle !== null ) {
					// Get full album data from Album page
					$albumData = array_merge( $albumData,  $this->albumScraper->processArticle( $albumArticle ) );
					// Get songs from Album page NOT
					// $leanSongsData = $this->albumScraper->getSongs( $albumArticle );
				}
			}
			$leanSongsData = $albumData['songs'];
			$albumData = $this->albumScraper->sanitizeData(
				$albumData,
				$this->albumScraper->getDataMap()
			);
			$songsData = $this->processSongs( $artistData, $albumData, $leanSongsData );
			$albumData['songs'] = $songsData;
			if ( isset( $albumData['id'] ) ) {
				// Save only albums which are actual wiki pages
				$this->dba->saveAlbum( $artistData, $albumData, $songsData );
			}
			$albumsData[] = $albumData;
		}
		return $albumsData;
	}


	/**
	 * Process Lyrics wiki Songs
	 *
	 * @param $artistData - Artist data
	 * @param $albumData - Fill Album data
	 * @param $leanSongsData - songs data collected from Artist's page
	 * @return array - Full songs data
	 */
	function processSongs( $artistData, $albumData, $leanSongsData ) {
		$songsData = [];
		foreach( $leanSongsData as $songData ) {
			if ( $songData['title'] ) {
				// Song has wiki title
				$songArticle = $this->articleFromTitle( $songData['title'] );
				if ( $songArticle !== null ) {
					// Song article exists
					self::log( "\t\t\tSONG: " . $songData['title'] . PHP_EOL );
					$songData = array_merge( $songData, $this->songScraper->processArticle( $songArticle ) );
					$songData = $this->songScraper->sanitizeData(
						$songData,
						$this->songScraper->getDataMap()
					);

					// Add song to songs list
					$songsData[] = $songData;

					if ( isset( $songData['id'] ) && !empty( $songData['lyrics'] ) ) {
						// Save only songs we have as Wiki pages and have lyrics
						$this->dba->saveSong(
							$artistData,
							$albumData,
							$songData
						);
					}
					continue;
				}
			}
			self::log( "\t\t\tSONG NOT FOUND: " . $songData['song'] . PHP_EOL );
			// Add song to songs list
			$songsData[] = $this->songScraper->sanitizeData(
				$songData,
				$this->songScraper->getDataMap()
			);
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


	/**
	 * Helper log function
	 *
	 * @param $text - text to log
	 */
	static function log ( $text ) {
		echo $text;
	}
}
