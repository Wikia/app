<?php

/**
 * Class ArtistScraper
 *
 * @desc Scrape Artist page from Lyrics API
 */
class ArtistScraper extends BaseScraper {

	/**
	 * @desc Process Artist article page
	 *
	 * @param Article $article
	 *
	 * @return array
	 */
	public function processArticle( Article $article ) {
		$name = $article->getTitle()->getText();
		$artistData = [
			'article_id' => $article->getId(),
			'name' => $name,
			'name_lowercase' => LyricsUtils::lowercase( $name ),
		];

		$artistData = array_merge( $artistData, $this->getHeader( $article ) );
		$artistData = array_merge( $artistData, $this->getFooter( $article ) );
		$artistData['genres'] = $this->getGenres( $article );

		return $this->sanitizeData( $artistData, $this->getDataMap() );
	}

	/**
	 * @desc Get artist data from header template
	 *
	 * @param Article $article
	 *
	 * @return array
	 */
	protected function getHeader( Article $article ) {
		return $this->getTemplateValues( 'ArtistHeader', $article->getContent() );
	}

	/**
	 * @desc Get artist data from footer template
	 *
	 * @param Article $article
	 * @return array
	 */
	protected function getFooter( Article $article ) {
		return $this->getTemplateValues( 'ArtistFooter', $article->getContent() );
	}

	/**
	 * @desc Split article page into h2 sections (albums or song groups)
	 *
	 * @param $text - article content
	 * @return array - article sections
	 */
	public function getSections( $text ) {
		// Remove templates
		$text = preg_replace ( '#\{\{(.+?)\}\}#s', '', $text );
		$sections = [];
		$offset = 0;

		if( preg_match_all( '#==(.+?)==#u', $text, $matches, PREG_OFFSET_CAPTURE ) ) {
			$positions = $matches[0];
			array_shift( $positions );
			foreach ( $positions as $section ) {
				if ( $section[0][2] !== '=' ) {
					$sections[] = substr( $text, $offset, ( $section[1] - $offset ) );
					$offset = $section[1];
				}
			}
			$sections[] = substr( $text, $offset, ( strlen( $text ) - $offset ) );
		}

		return $sections;
	}

	/**
	 * @desc Get list of albums (or song sections from Artist article)
	 *
	 * @param Article $article
	 * @param string $artistName
	 * @return array - Albums and song sections
	 */
	public function getAlbums( Article $article, $artistName ) {
		$albums = [];
		$text = $article->getContent();
		$sections = $this->getSections( $text );
		foreach( $sections as $section ) {
			if ( preg_match( '#==(.*?)==#mu', $section, $matches ) ) {
				$albumData = $this->getAlbumData( $matches[1] );
				$albumData['image'] = $this->getAlbumPic( $section, $artistName );
				$albumData['songs'] = $this->getAlbumSongs( $section );
				$albums[] = $albumData;
			}
		}
		return $albums;
	}

	/**
	 * @desc Extract songs from album section
	 *
	 * @param string $section
	 * @return array
	 */
	public function getAlbumSongs( $section ) {
		$songs = [];

		if ( preg_match_all('/^[#*](.+?)$/mu', $section, $matches ) ) {
			$number = 1;
			foreach ( $matches[1] as $song ) {
				$songExploded = explode( ':', $song );

				if( count( $songExploded ) > 1 ) {
					$songs[] = $this->getSongData( $song, $number );
					$number++;
				}
			}
		}

		return $songs;
	}

	/**
	 * @desc Extract album data from section heading
	 *
	 * @param string $heading - section heading
	 * @return array
	 */
	public function getAlbumData( $heading ) {
		//==[[Entombed:Serpent Saints The Ten Amendments (2007)|Serpent Saints - The Ten Amendments (2007)]]==
		$result = [];
		$headingArr = explode( '|', trim( $heading, '][= ' ) );
		$result['title'] = false;

		if ( count( $headingArr ) > 1) {
			$result['title'] = trim( $headingArr[0] );
			$result['year'] = '';
			$heading = $headingArr[1];
		}

		if ( preg_match( '#(.+)\(([\d]+)\)#', $heading, $matches ) ) {
			$result['Album'] = trim( $matches[1] );
			$result['year'] = trim( $matches[2] );
		} else {
			$result['Album'] = trim( $heading );
		}

		$result['album_name_lc'] = LyricsUtils::lowercase( $result['Album'] );

		return $result;
	}

	/**
	 * @desc Extract album pic form {{Album Art}} template
	 *
	 * @param string $section - Section text
	 * @param string $artistName - Artist name
	 * @return string - image title
	 */
	public function getAlbumPic( $section, $artistName ) {
		$values = $this->getTemplateValues( 'Album Art', $section, '|', false );
		$result = '';

		if ( isset( $values[0] ) && isset( $values[1] ) ) {
			$result = sprintf( '%s - %s.jpg', $values[0], $values[1] );
		} else if( isset( $values[0] ) ) {
			$result = sprintf( '%s - %s.jpg', $artistName, $values[0] );
		}

		return $result;
	}

	/**
	 * @desc Data field mapping
	 *
	 * @return array
	 */
	public function getDataMap() {
		return [
			'article_id' => 'id',
			'name' => 'artist_name',
			'name_lowercase' => 'artist_name_lc',
			'pic' => 'image',
			'iTunes' => 'itunes',
			'genres' => 'genres',
			'romanizedArtist' => 'romanized_artist_name',
			'officialSite' => 'official_site',
			'myspace' => 'myspace',
			'twitter' => 'twitter',
			'facebook' => 'facebook',
			'wikia' => 'wikia',
			'wikipedia' => 'wikipedia',
			'wikipedia2' => 'wikipedia2',
			'country' => 'country',
			'state' => 'state',
			'hometown' => 'hometown',
			'asin' => 'asin',
			'allmusic' => 'allmusic',
			'discogs' => 'discogs',
			'musicbrainz' => 'musicbrainz',
			'youtube' => 'youtube',
		];
	}

}
