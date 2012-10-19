<?php
/**
 * Class ImportFreeImages to communicate with Flickr and read configuration
 * settings.
 */

class ImportFreeImages {
	public $resultsPerPage;
	public $resultsPerRow;
	public $thumbType;

	public function __construct() {
		# Load settings
		global $wgIFI_FlickrAPIKey, $wgIFI_CreditsTemplate, $wgIFI_GetOriginal,
			$wgIFI_PromptForFilename, $wgIFI_phpFlickr, $wgIFI_ResultsPerRow,
			$wgIFI_ResultsPerPage, $wgIFI_FlickrLicense, $wgIFI_FlickrSort,
			$wgIFI_FlickrSearchBy, $wgIFI_AppendRandomNumber, $wgIFI_ThumbType;

		$this->apiKey = $wgIFI_FlickrAPIKey;
		$this->creditsTemplate = $wgIFI_CreditsTemplate;
		$this->shouldGetOriginal = $wgIFI_GetOriginal;
		$this->promptForFilename = $wgIFI_PromptForFilename;
		$this->phpFlickrFile = $wgIFI_phpFlickr;

		$this->resultsPerRow = $wgIFI_ResultsPerRow;
		$this->resultsPerPage = $wgIFI_ResultsPerPage;
		$this->licenses = is_array( $wgIFI_FlickrLicense ) ?
			$wgIFI_FlickrLicense : explode( ',', $wgIFI_FlickrLicense );
		$this->sortBy = $wgIFI_FlickrSort;
		$this->searchBy = $wgIFI_FlickrSearchBy;
		$this->appendRandomNumber = $wgIFI_AppendRandomNumber;
		$this->thumbType = $wgIFI_ThumbType;

		$this->load();
	}

	/**
	 * Save the old error level and disable E_STRICT warnings. phpFlickr is
	 * written for PHP4 and causes a lot of E_STRICT warnings.
	 */
	protected function suppressStrictWarnings() {
		$this->oldLevel = error_reporting();
		error_reporting( $this->oldLevel ^ E_STRICT );
	}
	/**
	 * Restore the error levels disabled with suppressStrictWarnings()
	 */
	protected function restoreStrictWarnings() {
		error_reporting( $this->oldLevel );
	}

	/**
	 * Try to initiate a phpFlickr object. Will throw MWException if not
	 * properly configured.
	 */
	protected function load() {
		if ( !file_exists( $this->phpFlickrFile ) ) {
			throw new MWException( 'phpFlickr can not be found at ' . $this->phpFlickrFile );
		}

		$this->suppressStrictWarnings();

		require_once( $this->phpFlickrFile );
		if ( !$this->apiKey ) {
			throw new MWException( 'No Flickr API key found' );
		}
		$this->flickr = new phpFlickr( $this->apiKey );

		$this->restoreStrictWarnings();
	}

	/**
	 * Search for Flickr photos
	 *
	 * @param $query String: search query
	 * @param $page Integer: page number
	 * @return array TODO
	 */
	public function searchPhotos( $query, $page ) {
		$this->suppressStrictWarnings();
		$result = $this->flickr->photos_search(
			array(
				$this->searchBy => $query,
				'tag_mode' => 'any',
				'page' => $page,
				'per_page' => $this->resultsPerPage,
				'license' => implode( ',', $this->licenses ),
				'sort' => $this->sortBy,
				'extras' => 'original_format',
			)
		);
		$this->restoreStrictWarnings();

		if ( !$result || !is_array( $result ) || !isset( $result['photo'] ) ) {
			return false;
		}
		return $result;
	}

	/**
	 * Get photo information for an ID
	 *
	 * @param $id Integer: ID
	 * @return array
	 */
	public function getPhotoInfo( $id ) {
		$this->suppressStrictWarnings();
		$result = $this->flickr->photos_getInfo( $id );
		$this->restoreStrictWarnings();
		return $result;
	}

	/**
	 * Get author information for an nsid
	 *
	 * @param $owner String: NSID
	 * @return array TODO
	 */
	public function getOwnerInfo( $owner ) {
		$this->suppressStrictWarnings();
		$result = $this->flickr->people_getInfo( $owner );
		$this->restoreStrictWarnings();
		return $result;
	}

	/**
	 * Get sizes and urls for a certain photo
	 *
	 * @param $id int Flickr photo id
	 * @return array [{'label': 'Large/Original', 'source': 'url', ...}, ...]
	 */
	public function getSizes( $id ) {
		$this->suppressStrictWarnings();
		$result = $this->flickr->photos_getSizes( $id );
		$this->restoreStrictWarnings();
		return $result;
	}

}
