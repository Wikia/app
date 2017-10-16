<?php

/**
 * Class RemoteAssetFeedIngester
 *
 * This class is used to represent remote assets, ie, videos which we upload onto
 * Ooyala for hosting. Most providers host videos themselves, but for special
 * cases (currently IVA and Screenplay), we upload their videos onto Ooyala and when
 * the OoyalaFeedIngester runs, these videos are ingested along with all of Ooyala's
 * own content.
 */
abstract class RemoteAssetFeedIngester extends VideoFeedIngester {

	public static $REMOTE_ASSET = true;

	private $duplicateAsset;

	/**
	 * Checks if the video is a duplicate. This is overrides the FeedIngester version
	 * which only checks if the video exists on Wikia. This version also checks if the
	 * video exists on Ooyala.
	 */
	public function checkIsDuplicateVideo() {
		$this->checkVideoExistsOnWikia();
		$this->checkVideoExistsOnOoyala();
	}

	/**
	 * Checks if a the video already exists on Ooyala. If so, and reupload is on, save that
	 * asset. This will be used later in the ingestion process.
	 * @throws FeedIngesterSkippedException
	 */
	public function checkVideoExistsOnOoyala() {
		$dupAssets = OoyalaAsset::getAssetsBySourceId( $this->videoData['videoId'], $this->videoData['provider'] );
		if ( !empty( $dupAssets ) ) {
			if ( $this->reupload === false ) {
				$msg = "Skipping {$this->videoData['titleName']} (Id: {$this->videoData['videoId']}, ";
				$msg .= "{$this->videoData['provider']}) - video already exists on Ooyala and reupload is disabled.\n";
				throw new FeedIngesterSkippedException( $msg );
			}
			$this->duplicateAsset = $dupAssets[0];
		} else {
			$this->duplicateAsset = null;
		}
	}

	/**
	 * After all the video meta data and categories have been prepared, upload the video
	 * onto Ooyala.
	 * @return int
	 */
	public function saveVideo() {
		$this->metaData['pageCategories'] = implode( ', ', $this->pageCategories );
		if ( !empty( $this->duplicateAsset ) ) {
			if ( !empty( $this->duplicateAsset['metadata']['sourceid'] )
				&& $this->duplicateAsset['metadata']['sourceid'] == $this->metaData['videoId'] ) {
				$result = $this->updateRemoteAsset();
			} else {
				$msg = "Skipping {$this->metaData['name']} - {$this->metaData['description']}. ";
				$msg .= " SourceId not match (Id: {$this->metaData['videoId']}).\n";
				$this->logger->videoSkipped( $msg );
				return 0;
			}
		} else {
			$result = $this->createRemoteAsset();
		}

		return $result;
	}

	/**
	 * Create remote asset
	 * @return integer
	 */
	protected function createRemoteAsset() {

		$this->prepareMetaDataForOoyala();
		if ( empty( $this->metaData['url']['flash'] ) ) {
			$this->logger->videoWarnings( "Error when generating remote asset data: empty asset url.\n" );
			return 0;
		}

		if ( empty( $this->metaData['duration'] ) || $this->metaData['duration'] < 0 ) {
			$msg = "Error when generating remote asset data: invalid duration ($this->metaData[duration]).\n";
			$this->logger->videoWarnings( $msg );
			return 0;
		}

		// check if video title exists
		$ooyalaAsset = new OoyalaAsset();
		$isExist = $ooyalaAsset->isTitleExist( $this->metaData['assetTitle'], $this->metaData['provider'] );
		if ( $isExist ) {
			$msg = "SKIP: Uploading Asset: {$this->metaData['destinationTitle']} ({$this->metaData['provider']}). ";
			$msg .= "Video already exists in remote assets.\n";
			$this->logger->videoSkipped( $msg );
			return 0;
		}

		if ( $this->debugMode() ) {
			print "Ready to create remote asset\n";
			print "id:          {$this->metaData['videoId']}\n";
			print "name:        {$this->metaData['destinationTitle']}\n";
			print "assetdata:\n";
			foreach ( explode( "\n", var_export( $this->metaData, TRUE ) ) as $line ) {
				print ":: $line\n";
			}
		} else {
			$result = $ooyalaAsset->addRemoteAsset( $this->metaData );
			if ( !$result ) {
				$this->logger->videoWarnings();
				return 0;
			}
		}

		$categories = empty( $this->metaData['pageCategories'] ) ? [] : explode( ", ", $this->metaData['pageCategories'] );
		$msg = "Uploaded remote asset: {$this->metaData['destinationTitle']} (id: {$this->metaData['videoId']})\n";
		$this->logger->videoIngested( $msg, $categories );

		return 1;
	}

	/**
	 * Update remote asset (metadata only)
	 * @return integer
	 */
	protected function updateRemoteAsset() {

		if ( empty( $this->duplicateAsset['embed_code'] ) ) {
			$this->logger->videoWarnings( "Error when updating remote asset data: empty asset embed code.\n" );
			return 0;
		}

		$this->prepareMetaDataForOoyala( $generateUrl = false );
		$ooyalaAsset = new OoyalaAsset();
		$assetMeta = $ooyalaAsset->getAssetMetadata( $this->metaData );

		// set reupload
		$assetMeta['reupload'] = 1;

		// remove unwanted data
		$emptyMetaKeys = array_diff( array_keys( $this->duplicateAsset['metadata'] ), array_keys( $assetMeta ) );
		foreach ( $emptyMetaKeys as $key ) {
			$assetMeta[$key] = null;
		}

		if ( $this->debugMode() ) {
			print "Ready to update remote asset\n";
			print "id:          {$this->metaData['videoId']}\n";
			print "name:        {$this->metaData['destinationTitle']}\n";
			print "embed code:  {$this->duplicateAsset['embed_code']}\n";
			print "asset name:  {$this->duplicateAsset['name']}\n";
			print "metadata:\n";
			foreach ( explode( "\n", var_export( $assetMeta, TRUE ) ) as $line ) {
				print ":: $line\n";
			}
		} else {
			$result = OoyalaAsset::updateMetadata( $this->duplicateAsset['embed_code'], $assetMeta );
			if ( !$result ) {
				$this->logger->videoWarnings();
				return 0;
			}
		}

		$categories = empty( $this->metaData['pageCategories'] ) ? [] : explode( ", ", $this->metaData['pageCategories'] );
		$msg = "Uploaded remote asset: {$this->metaData['destinationTitle']} (id: {$this->metaData['videoId']})\n";
		$this->logger->videoIngested( $msg, $categories );

		return 1;
	}

	/**
	 * Prepate metaData for ingestion onto Ooyala
	 * @param boolean $generateUrl
	 */
	abstract protected function prepareMetaDataForOoyala( $generateUrl = false );

	/**
	 * @param string $content
	 * @param array $params
	 * @return mixed
	 * @throws Exception
	 */
	public function import( $content = '', array $params = [] ) {
		throw new Exception( "Must be implemented by a subclass" );
	}

	/**
	 * @param array $addlCategories
	 * @return array|void
	 * @throws Exception
	 */
	public function generateCategories( array $addlCategories ) {
		throw new Exception( "Must be implemented by a sublcass" );
	}

}