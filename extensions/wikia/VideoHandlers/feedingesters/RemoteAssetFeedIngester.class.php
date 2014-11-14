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
class RemoteAssetFeedIngester extends VideoFeedIngester {

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
				$msg = "Skipping {$this->videoData['titleName']} (Id: {$this->videoData['videoId']}, {$this->videoData['provider']}) - video already exists on Ooyala and reupload is disabled.\n";
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
			if ( !empty( $this->duplicateAsset['metadata']['sourceid'] ) && $this->duplicateAsset['metadata']['sourceid'] == $this->metaData['videoId'] ) {
				$result = $this->updateRemoteAsset( $this->metaData['videoId'], $this->metaData['destinationTitle'], $this->metaData, $this->duplicateAsset );
			} else {
				$this->logger->videoSkipped( "Skipping {$this->metaData['name']} - {$this->metaData['description']}. SouceId not match (Id: {$this->metaData['videoId']}).\n" );
				return 0;
			}
		} else {
			$result = $this->createRemoteAsset( $this->metaData['videoId'], $this->metaData['destinationTitle'], $this->metaData );
		}

		return $result;
	}

	/**
	 * Create remote asset
	 * @param string $id
	 * @param string $name
	 * @param array $metadata
	 * @return integer
	 */
	protected function createRemoteAsset( $id, $name, array $metadata ) {

		$assetData = $this->generateRemoteAssetData( $name, $metadata );
		if ( empty( $assetData['url']['flash'] ) ) {
			$this->logger->videoWarnings( "Error when generating remote asset data: empty asset url.\n" );
			return 0;
		}

		if ( empty( $assetData['duration'] ) || $assetData['duration'] < 0 ) {
			$this->logger->videoWarnings( "Error when generating remote asset data: invalid duration ($assetData[duration]).\n" );
			return 0;
		}

		// check if video title exists
		$ooyalaAsset = new OoyalaAsset();
		$isExist = $ooyalaAsset->isTitleExist( $assetData['assetTitle'], $assetData['provider'] );
		if ( $isExist ) {
			$this->logger->videoSkipped( "SKIP: Uploading Asset: $name ($assetData[provider]). Video already exists in remote assets.\n" );
			return 0;
		}

		if ( $this->debugMode() ) {
			print "Ready to create remote asset\n";
			print "id:          $id\n";
			print "name:        $name\n";
			print "assetdata:\n";
			foreach ( explode( "\n", var_export( $assetData, TRUE ) ) as $line ) {
				print ":: $line\n";
			}
		} else {
			$result = $ooyalaAsset->addRemoteAsset( $assetData );
			if ( !$result ) {
				$this->logger->videoWarnings();
				return 0;
			}
		}

		$categories = empty( $metadata['pageCategories'] ) ? [] : explode( ", ", $metadata['pageCategories'] );
		$this->logger->videoIngested( "Uploaded remote asset: $name (id: $id)\n", $categories );

		return 1;
	}

	/**
	 * Update remote asset (metadata only)
	 * @param string $id
	 * @param string $name
	 * @param array $metadata
	 * @param array $dupAsset
	 * @return integer
	 */
	protected function updateRemoteAsset( $id, $name, array $metadata, $dupAsset ) {

		if ( empty( $dupAsset['embed_code'] ) ) {
			$this->logger->videoWarnings( "Error when updating remote asset data: empty asset embed code.\n" );
			return 0;
		}

		$assetData = $this->generateRemoteAssetData( $dupAsset['name'], $metadata, false );

		$ooyalaAsset = new OoyalaAsset();
		$assetMeta = $ooyalaAsset->getAssetMetadata( $assetData );

		// set reupload
		$assetMeta['reupload'] = 1;

		// remove unwanted data
		$emptyMetaKeys = array_diff( array_keys( $dupAsset['metadata'] ), array_keys( $assetMeta ) );
		foreach ( $emptyMetaKeys as $key ) {
			$assetMeta[$key] = null;
		}

		if ( $this->debugMode() ) {
			print "Ready to update remote asset\n";
			print "id:          $id\n";
			print "name:        $name\n";
			print "embed code:  $dupAsset[embed_code]\n";
			print "asset name:  $dupAsset[name]\n";
			print "metadata:\n";
			foreach ( explode( "\n", var_export( $assetMeta, TRUE ) ) as $line ) {
				print ":: $line\n";
			}
		} else {
			$result = OoyalaAsset::updateMetadata( $dupAsset['embed_code'], $assetMeta );
			if ( !$result ) {
				$this->logger->videoWarnings();
				return 0;
			}
		}

		$categories = empty( $metadata['pageCategories'] ) ? [] : explode( ", ", $metadata['pageCategories'] );
		$this->logger->videoIngested( "Uploaded remote asset: $name (id: $id)\n", $categories );

		return 1;
	}

	/**
	 * Generate remote asset data
	 * @param string $name
	 * @param array $data
	 * @return array $data
	 */
	protected function generateRemoteAssetData( $name, array $data ) {
		return $data['assetTitle'];
	}

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