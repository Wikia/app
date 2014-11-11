<?php

class RemoteAssetFeedIngester extends VideoFeedIngester {

	const REMOTE_ASSET = true;

	public function isDuplicateVideo( $name ) {
		return $this->videoExistsOnOoyala( $name ) || $this->videoExistsOnWikia();
	}

	public function videoExistsOnOoyala( $name ) {
		$dupAssets = OoyalaAsset::getAssetsBySourceId( $this->videoData['videoId'], $this->provider );
		if ( !empty( $dupAssets ) ) {
			if ( $this->reupload === false ) {
				$this->logger->videoSkipped( "Skipping $name (Id: {$this->videoData['videoId']}, $this->provider) - video already exists in remote assets.\n" );
			}
			return true;
		}
		return false;
	}
}