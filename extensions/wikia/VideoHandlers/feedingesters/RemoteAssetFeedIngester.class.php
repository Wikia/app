<?php

class RemoteAssetFeedIngester extends VideoFeedIngester {

	const REMOTE_ASSET = true;

	public function isDuplicateVideo( $videoData, $provider ) {
		return $this->videoExistsOnOoyala( $videoData, $provider ) || $this->videoExistsOnWikia( $videoData, $provider );
	}

	public function videoExistsOnOoyala( $videoData, $provider ) {
		$dupAssets = OoyalaAsset::getAssetsBySourceId( $videoData['videoId'], $provider );
		if ( !empty( $dupAssets ) ) {
			if ( $this->reupload === false ) {
				$this->logger->videoSkipped( "Skipping {$videoData['destinationTitle']} (Id: {$videoData['videoId']}, $provider) - video already exists in remote assets.\n" );
			}
			return true;
		}
		return false;
	}

	public function saveAsset( $categories ) {
		$this->metaData['pageCategories'] = implode( ', ', $categories );
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

	public function import( $content = '', array $params = [] ) {
		throw new Exception("Must implement this");
	}

	public function generateCategories( array $addlCategories ) {
		throw new Exception("Must implement this");
	}

}