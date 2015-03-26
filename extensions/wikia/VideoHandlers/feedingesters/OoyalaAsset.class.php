<?php

class OoyalaAsset extends WikiaModel {

	const TIMEOUT = 60;

	/**
	 * Constructs a URL to get assets from Ooyala API
	 * @param integer $apiPageSize
	 * @param string $nextPage
	 * @param array $cond - conditions for query
	 * @return string $url
	 */
	public static function getApiUrlAssets( $apiPageSize = 100, $nextPage = '', $cond = [] ) {
		wfProfileIn( __METHOD__ );

		// only live video
		$cond[] = "status = 'live'";

		$params = [
			'limit' => $apiPageSize,
			'where' => implode( ' AND ', $cond ),
		];

		if ( !empty( $nextPage ) ) {
			$parsed = explode( "?", $nextPage );
			parse_str( array_pop( $parsed ), $params );
		}

		$method = 'GET';
		$reqPath = '/v2/assets';
		$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );

		wfProfileOut( __METHOD__ );

		return $url;
	}

	/**
	 * Get API content
	 * @param string $url
	 * @return array|false $result
	 */
	public static function getApiContent( $url ) {
		wfProfileIn( __METHOD__ );

		$options = [
			'noProxy' => true,
			'timeout' => self::TIMEOUT
		];

		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$result = json_decode( iconv( "UTF-8", "UTF-8//IGNORE", $req->getContent() ), true );
		} else {
			$result = false;
			print( "ERROR: problem downloading content (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Get asset by id
	 * @param string $videoId
	 * @return array|false $result
	 */
	public static function getAssetById( $videoId ) {
		wfProfileIn( __METHOD__ );

		$method = 'GET';
		$reqPath = '/v2/assets/'.$videoId;
		$params = [];

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );
		print( "Connecting to $url...\n" );

		$result = self::getApiContent( $url );

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Get assets by sourceid in metadata
	 * @param string $sourceId
	 * @param string $provider
	 * @param string $assetType [remote_asset]
	 * @param int $max
	 * @return array $assets
	 */
	public static function getAssetsBySourceId( $sourceId, $provider, $assetType = 'remote_asset', $max = 3 ) {
		wfProfileIn( __METHOD__ );

		$cond = [
			"asset_type='$assetType'",
			"metadata.sourceid='$sourceId'",
		];

		$params = [
			'limit' => $max,
			'where' => implode( ' AND ', $cond ),
		];

		$method = 'GET';
		$reqPath = '/v2/assets';

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );
		$response = self::getApiContent( $url );

		$assets = [];
		if ( !empty( $response['items'] ) ) {
			$asset = $response['items'][0];
			// Make sure the video returned by Ooyala is from the same provider we're expecting (this is just
			// in case 2 providers might share the same videoId, aka sourceId)
			if ( !empty( $asset['metadata']['source'] ) && $asset['metadata']['source'] == $provider ) {
				$assets = $response['items'];
			}
		}

		wfProfileOut( __METHOD__ );

		return $assets;
	}

	/**
	 * Get labels for all providers
	 * @return array|false $providers
	 */
	public static function getApiLabelsProviders() {
		wfProfileIn( __METHOD__ );

		$method = 'GET';
		$reqPath = '/v2/labels/';

		$url = OoyalaApiWrapper::getApi( $method, $reqPath );

		$result = self::getApiContent( $url );
		if ( $result == false ) {
			wfProfileOut( __METHOD__ );
			return $result;
		}

		$labels = empty( $result['items'] ) ? [] : $result['items'];

		$providers = [];
		foreach ( $labels as $label ) {
			if ( !empty( $label['full_name'] ) && preg_match( '/\/Providers\/([\w\s]+)/', $label['full_name'] ) ) {
				$providers[$label['id']] = $label['name'];
			}
		}

		wfProfileOut( __METHOD__ );

		return $providers;
	}

	/**
	 * Get label id
	 * @param string $labelName - name of the label
	 * @return string|false $labelId
	 */
	public static function getLabelId( $labelName ) {
		wfProfileIn( __METHOD__ );

		$labelId = false;

		$labels = self::getApiLabelsProviders();
		if ( $labels == false ) {
			wfProfileOut( __METHOD__ );
			return $labelId;
		}

		foreach ( $labels as $id => $name ) {
			if ( strtolower( $name ) == strtolower( $labelName ) ) {
				$labelId = $id;
				break;
			}
		}

		wfProfileOut( __METHOD__ );

		return $labelId;
	}

	/**
	 * Add remote asset
	 * @param array $data
	 * @return boolean $resp
	 */
	public function addRemoteAsset( $data, &$videoId = null ) {
		wfProfileIn( __METHOD__ );

		$resp = false;

		$method = 'POST';
		$reqPath = '/v2/assets';
		$reqBody = json_encode( $this->generateRemoteAssetParams( $data ) );

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, [], $reqBody );
		//print( "Connecting to $url...\n" );

		$options = [
			'method'   => $method,
			'postData' => $reqBody,
			'noProxy'  => true,
		];
		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$response = $req->getContent();
			$asset = json_decode( $response, true );

			$videoId = $asset['embed_code'];
			print( "Ooyala: Uploaded Remote Asset: $data[provider]: $asset[name] \n" );
			foreach( explode( "\n", var_export( $asset, 1 ) ) as $line ) {
				print ":: $line\n";
			}

			// add metadata for the asset
			$resp = $this->addMetadata( $asset['embed_code'], $data );
			if ( $resp ) {
				if ( empty( $data['thumbnail'] ) ) {
					print( "NOTE: No thumbnail for $asset[name] ($asset[embed_code]).\n" );
				} else {
					// set thumbnail
					$resp = $this->setThumbnail( $asset['embed_code'], $data );
					if ( !$resp ) {
						print( "Error: Cannot setting thumbnail for $asset[name] ($asset[embed_code]).\n" );
					}
				}

				// always set labels
				$resp = $this->setLabels( $asset['embed_code'], $data );
			}
		} else {
			print( "ERROR: problem posting remote asset (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * Set thumbnail
	 * @param string $videoId
	 * @param array $data
	 * @return boolean
	 */
	public function setThumbnail( $videoId, $data ) {
		// set thumbnail
		$resp = $this->setThumbnailUrl( $videoId, $data );
		if ( $resp ) {
			// set primary thumbnail
			$resp = $this->setPrimaryThumbnail( $videoId );
		}

		return $resp;
	}

	/**
	 * Generate remote asset params
	 * @param array $data
	 * @return array $params
	 */
	protected function generateRemoteAssetParams( $data ) {
		$params = [
			'name'        => $data['assetTitle'],
			'asset_type'  => 'remote_asset',
			'description' => $data['description'],
			'duration'    => $data['duration'],
			'stream_urls' => [
				'flash'  => $data['url']['flash'],
				'iphone' => $data['url']['iphone'],
			],
		];

		return $params;
	}

	/**
	 * Add metadata
	 * @param string $videoId
	 * @param array $metadata
	 * @return boolean $resp
	 */
	public function addMetadata( $videoId, $metadata ) {
		wfProfileIn( __METHOD__ );

		$method = 'PUT';
		$reqPath = '/v2/assets/'.$videoId.'/metadata';

		$assetData = $this->getAssetMetadata( $metadata );

		$reqBody = json_encode( $assetData );

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, [], $reqBody );
		//print( "Connecting to $url...\n" );

		$options = [
			'method'   => $method,
			'postData' => $reqBody,
			'noProxy'  => true,
		];

		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$meta = json_decode( $req->getContent(), true );
			$resp = true;

			print( "Ooyala: Added Metadata for $videoId: \n" );
			foreach( explode( "\n", var_export( $meta, true ) ) as $line ) {
				print ":: $line\n";
			}
		} else {
			$resp = false;
			print( "ERROR: problem adding metadata (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * Send request to Ooyala to update metadata
	 * @param string $videoId
	 * @param array $metadata
	 * @return boolean $resp
	 */
	public static function updateMetadata( $videoId, $metadata ) {
		$reqPath = '/v2/assets/'.$videoId.'/metadata';
		return self::updateAsset( $videoId, $metadata, $reqPath );
	}

	/**
	 * Send request to Ooyala to update asset
	 * @param string $videoId
	 * @param array $params
	 * @param string $reqPath
	 * @return boolean $resp
	 */
	public static function updateAsset( $videoId, $params, $reqPath ) {
		$method = 'PATCH';
		$reqBody = json_encode( $params );

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, [], $reqBody );
		echo "\tRequest to update asset: $url\n";

		$options = [
			'method'   => $method,
			'postData' => $reqBody,
			'noProxy'  => true,
		];

		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$meta = json_decode( $req->getContent(), true );
			$resp = true;

			echo "\tUpdated Asset for $videoId: \n";
			foreach( explode( "\n", var_export( $meta, true ) ) as $line ) {
				echo "\t\t:: $line\n";
			}
		} else {
			$resp = false;
			echo "\tERROR: problem updating asset (".$status->getMessage().").\n";
		}

		return $resp;
	}

	/**
	 * Send request to Ooyala to update urls for remote asset
	 * @param string $videoId
	 * @param array $urls
	 * @return boolean $resp
	 */
	public static function updateRemoteAssetUrls( $videoId, $urls ) {
		$reqPath = '/v2/assets/'.$videoId;
		$params['stream_urls'] = $urls;
		return self::updateAsset( $videoId, $params, $reqPath );
	}

	/**
	 * Generate asset metadata
	 * @param array $data
	 * @return array $metadata
	 */
	public function getAssetMetadata( $data ) {
		$metadata = [];

		if ( !empty( $data['category'] ) ) {
			$metadata['category'] = $data['category'];
		}
		if ( !empty( $data['actors'] ) ) {
			$metadata['actors'] = $data['actors'];
		}
		if ( !empty( $data['published'] ) ) {
			$metadata['published'] = $data['published'];
		}
		// ageGate can be 0
		if ( isset( $data['ageGate'] ) ) {
			$metadata['agegate'] = $data['ageGate'];
		}
		// hd can be 0
		if ( isset( $data['hd'] ) ) {
			$metadata['hd'] = $data['hd'];
		}
		if ( !empty( $data['name'] ) ) {
			$metadata['name'] = $data['name'];
		}
		if ( !empty( $data['language'] ) ) {
			$metadata['lang'] = $data['language'];
		}
		if ( !empty( $data['subtitle'] ) ) {
			$metadata['subtitle'] = $data['subtitle'];
		}
		if ( !empty( $data['type'] ) ) {
			$metadata['type'] = $data['type'];
		}
		if ( !empty( $data['industryRating'] ) ) {
			$metadata['industryrating'] = $data['industryRating'];
		}
		if ( !empty( $data['genres'] ) ) {
			$metadata['genres'] = $data['genres'];
		}
		if ( !empty( $data['expirationDate'] ) ) {
			$metadata['expirationdate'] = $data['expirationDate'];
		}
		if ( !empty( $data['regionalRestrictions'] ) ) {
			$metadata['regional_restrictions'] = $data['regionalRestrictions'];
		}
		if ( !empty( $data['keywords'] ) ) {
			$metadata['keywords'] = $data['keywords'];
		}
		if ( !empty( $data['ageRequired'] ) ) {
			$metadata['age_required'] = $data['ageRequired'];
		}
		if ( !empty( $data['targetCountry'] ) ) {
			$metadata['targetcountry'] = $data['targetCountry'];
		}
		if ( !empty( $data['series'] ) ) {
			$metadata['series'] = $data['series'];
		}
		if ( !empty( $data['season'] ) ) {
			$metadata['season'] = $data['season'];
		}
		if ( !empty( $data['episode'] ) ) {
			$metadata['episode'] = $data['episode'];
		}
		if ( !empty( $data['characters'] ) ) {
			$metadata['characters'] = $data['characters'];
		}
		if ( !empty( $data['resolution'] ) ) {
			$metadata['resolution'] = $data['resolution'];
		}
		// ignore if aspectRatio is empty or 0
		if ( !empty( $data['aspectRatio'] ) ) {
			$metadata['aspectratio'] = $data['aspectRatio'];
		}
		if ( !empty( $data['pageCategories'] ) ) {
			$metadata['pagecategories'] = $data['pageCategories'];
		}
		if ( !empty( $data['distributor'] ) ) {
			$metadata['distributor'] = $data['distributor'];
		}
		if ( !empty( $data['streamHdUrl'] ) ) {
			$metadata['streamHdUrl'] = $data['streamHdUrl'];
		}
		// set blank thumbnail
		if ( empty( $data['thumbnail'] ) ) {
			$metadata['thumbnail'] = 1;
		}

		// filter empty value
		$this->filterEmptyValue( $metadata );

		// source and sourceid are required. They are used for tracking the video.
		$metadata['source'] = $data['provider'];
		$metadata['sourceid'] = $data['videoId'];

		return $metadata;
	}

	/**
	 * Check if video title exists
	 * @param string $name
	 * @param string $source
	 * @param string $assetType [remote_asset]
	 * @return boolean
	 */
	public function isTitleExist( $name, $source, $assetType = 'remote_asset' ) {
		$cond = [
			"asset_type='$assetType'",
			"name='".addslashes( $name )."'",
			"metadata.source='$source'",
		];

		return $this->isExist( $cond );
	}

	/**
	 * Check if video id exists (match sourceid in metadata)
	 * @param string $sourceId
	 * @param string $source
	 * @param string $assetType [remote_asset]
	 * @return boolean
	 */
	public function isSourceIdExist( $sourceId, $source, $assetType = 'remote_asset' ) {
		$cond = [
			"asset_type='$assetType'",
			"metadata.sourceid='$sourceId'",
			"metadata.source='$source'",
		];

		return $this->isExist( $cond );
	}

	/**
	 * Check if video exists
	 * @param array $cond
	 * @return boolean
	 */
	public function isExist( $cond ) {
		wfProfileIn( __METHOD__ );

		$params = [
			'limit' => 1,
			'where' => implode( ' AND ', $cond ),
		];

		$method = 'GET';
		$reqPath = '/v2/assets';

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );
		//print( "Connecting to $url...\n" );

		$req = MWHttpRequest::factory( $url, [ 'noProxy' => true ] );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$response = json_decode( $req->getContent(), true );
			$result = !empty( $response['items'] );
		} else {
			$result = false;
			print( "Error: problem checking video (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Set thumbnail url
	 * @param string $videoId
	 * @param array $assetData
	 * @return boolean $resp
	 */
	public function setThumbnailUrl( $videoId, $assetData ) {
		wfProfileIn( __METHOD__ );

		$method = 'PUT';
		$reqPath = '/v2/assets/'.$videoId.'/preview_image_urls';

		$params[] = [
			'url'    => $assetData['thumbnail'],
			'width'  => 240,
			'height' => 320,
		];

		$resp = $this->sendRequest( $method, $reqPath, $params );

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * Set primary thumbnail
	 * @param string $videoId
	 * @return boolean $resp
	 */
	public function setPrimaryThumbnail( $videoId ) {
		wfProfileIn( __METHOD__ );

		$method = 'PUT';
		$reqPath = '/v2/assets/'.$videoId.'/primary_preview_image';
		$params = [ 'type' => 'remote_url' ];

		$resp = $this->sendRequest( $method, $reqPath, $params );

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * Get player info
	 * @param string $videoId
	 * @return array|false $response
	 */
	public function getPlayer( $videoId ) {
		wfProfileIn( __METHOD__ );

		$method = 'GET';
		$reqPath = '/v2/assets/'.$videoId.'/player/';

		$url = OoyalaApiWrapper::getApi( $method, $reqPath );
		//print( "Connecting to $url...\n" );

		$req = MWHttpRequest::factory( $url, [ 'noProxy' => true ] );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$response = json_decode( $req->getContent(), true );
		} else {
			$response = false;
			print( "Error: problem getting player (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $response;
	}

	/**
	 * Set player
	 * @param string $videoId
	 * @param string $playerId (new player id)
	 * @return boolean $resp
	 */
	public function setPlayer( $videoId, $playerId ) {
		wfProfileIn( __METHOD__ );

		$method = 'PUT';
		$reqPath = '/v2/assets/'.$videoId.'/player/'.$playerId;
		$params = [];

		$resp = $this->sendRequest( $method, $reqPath, $params );

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * Set age gate player
	 * @param string $videoId
	 * @param array $data
	 * @return boolean $resp
	 */
	public function setAgeGatePlayer( $videoId, $data ) {
		wfProfileIn( __METHOD__ );

		$resp = true;
		if ( !empty( $data['ageRequired'] ) ) {
			$resp = $this->setPlayer( $videoId, OoyalaVideoHandler::OOYALA_PLAYER_ID_AGEGATE );
		}

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * Set ad set
	 * @param string $videoId
	 * @param string $adSet
	 * @return boolean $resp
	 */
	public function setAdSet( $videoId, $adSet ) {
		wfProfileIn( __METHOD__ );

		$method = 'PUT';
		$reqPath = '/v2/assets/'.$videoId.'/ad_set/'.$adSet;
		$params = [];

		$resp = $this->sendRequest( $method, $reqPath, $params );

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * Set label
	 * @param string $videoId
	 * @param array $data
	 * @return boolean $resp
	 */
	public function setLabels( $videoId, $data ) {
		wfProfileIn( __METHOD__ );

		$params = [];
		if ( !empty( $data['ageRequired'] ) && !empty( $this->wg->OoyalaApiConfig['LabelAgeGate'] ) ) {
			$params[] = $this->wg->OoyalaApiConfig['LabelAgeGate'];
		}

		$provider = 'Label'.ucfirst( strtolower( $data['provider'] ) );
		if ( !empty( $this->wg->OoyalaApiConfig[$provider] ) ) {
			$params[] = $this->wg->OoyalaApiConfig[$provider];
		}

		if ( empty( $params ) ) {
			$resp = true;
			print( "WARNING: Cannot set label for $data[name] (Label not found).\n" );
		} else {
			$method = 'POST';
			$reqPath = '/v2/assets/'.$videoId.'/labels';

			$resp = $this->sendRequest( $method, $reqPath, $params );
		}

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * Send request
	 * @param string $method
	 * @param string $reqPath
	 * @param array $params
	 * @return boolean $result
	 */
	protected function sendRequest( $method, $reqPath, $params = [] ) {
		wfProfileIn( __METHOD__ );

		$reqBody = empty( $params ) ? '' : json_encode( $params );

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, [], $reqBody );
		//print( "Connecting to $url...\n" );

		$options = [
			'method'   => $method,
			'postData' => $reqBody,
			'noProxy'  => true,
		];

		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$result = true;
			print( "Ooyala: sent $reqPath request: \n" );
		} else {
			$result = false;
			print( "ERROR: problem sending $reqPath request (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Send request to Ooyala to delete video
	 * @param string $videoId
	 * @return boolean $resp
	 */
	public function deleteAsset( $videoId ) {
		$method = 'DELETE';
		$reqPath = '/v2/assets/'.$videoId;
		$resp = $this->sendRequest( $method, $reqPath );

		return $resp;
	}

	/**
	 * Filter empty value
	 * @param array $metadata
	 * @return array $metadata
	 */
	public function filterEmptyValue( &$metadata ) {
		foreach ( $metadata as $key => $value ) {
			if ( empty( $value ) ) {
				unset( $metadata[$key] );
			}
		}
	}

}
