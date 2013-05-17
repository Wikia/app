<?php

class OoyalaAsset extends WikiaModel {

	/**
	 * add remote asset
	 * @param array $data
	 * @return boolean $resp
	 */
	public function addRemoteAsset( $data ) {
		wfProfileIn( __METHOD__ );

		$resp = false;

		$method = 'POST';
		$reqPath = '/v2/assets';
		$reqBody = json_encode( $this->generateRemoteAssetParams( $data ) );

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, array(), $reqBody );
		//print( "Connecting to $url...\n" );

		$options = array(
			'method' => $method,
			'postData' => $reqBody,
		);
		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$response = $req->getContent();
			$asset = json_decode( $response, true );

			print( "Ooyala: Uploaded Remote Asset: $data[provider]: $asset[name] \n" );
			foreach( explode("\n", var_export($asset, 1)) as $line ) {
				print ":: $line\n";
			}

			// add metadata for the asset
			$resp = $this->addMetadata( $asset['embed_code'], $data );
			if ( $resp ) {
				// set thumbnail
				$resp = $this->setThumbnailUrl( $asset['embed_code'], $data );
				if ( $resp ) {
					// set primary thumbnail
					$resp = $this->setPrimaryThumbnail( $asset['embed_code'] );
				}
			}
		} else {
			print( "ERROR: problem posting remote asset (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * generate remote asset params
	 * @param array $data
	 * @return array $params
	 */
	protected function generateRemoteAssetParams( $data ) {
		$params = array(
			'name' => $data['name'],
			'asset_type' => 'remote_asset',
			'description' => $data['description'],
			'duration' => $data['duration'],
			'stream_urls' => array(
				'flash' => $data['url']['flash'],
				'iphone' => $data['url']['iphone'],
			),
		);

		return $params;
	}

	/**
	 * add metadata
	 * @param string $videoId
	 * @param array $metadata
	 * @return boolean $resp
	 */
	public function addMetadata( $videoId, $metadata ) {
		wfProfileIn( __METHOD__ );

		$method = 'PUT';
		$reqPath = '/v2/assets/'.$videoId.'/metadata';

		$assetData = $this->getAssetMetadata( $metadata );
		$assetData['source'] = $metadata['provider'];
		$assetData['sourceid'] = $metadata['videoId'];
		$reqBody = json_encode( $assetData );

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, array(), $reqBody );
		//print( "Connecting to $url...\n" );

		$options = array(
			'method' => $method,
			'postData' => $reqBody,
		);

		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$meta = json_decode( $req->getContent(), true );
			$resp = true;

			print( "Ooyala: Updated Metadata for $videoId: \n" );
			foreach( explode( "\n", var_export( $meta, TRUE ) ) as $line ) {
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
	 * generate asset metadata
	 * @param array $data
	 * @return array $metadata
	 */
	protected function getAssetMetadata( $data ) {
		$metadata = array();

		if ( !empty( $data['category'] ) ) {
			$metadata['category'] = $data['category'];
		}
		if ( !empty( $data['actors'] ) ) {
			$metadata['actors'] = is_array( $data['actors'] ) ? implode( ', ', $data['actors'] ) : $data['actors'];
		}
		if ( !empty( $data['published'] ) ) {
			$metadata['published'] = $data['published'];
		}
		if ( !empty( $data['ageGate'] ) ) {
			$metadata['agegate'] = $data['ageGate'];
		}
		if ( !empty( $data['tags'] ) ) {
			$metadata['tags'] = $data['tags'];
		}
		if ( !empty( $data['hd'] ) ) {
			$metadata['hd'] = $data['hd'];
		}
		if ( !empty( $data['language'] ) ) {
			$metadata['lang'] = $data['language'];
		}
		if ( !empty( $data['trailerrating'] ) ) {
			$metadata['trailerrating'] = $data['trailerrating'];
		}
		if ( !empty( $data['industryrating'] ) ) {
			$metadata['industryrating'] = $data['industryrating'];
		}
		if ( !empty( $data['genres'] ) ) {
			$metadata['genres'] = $data['genres'];
		}
		if ( !empty( $data['expirationdate'] ) ) {
			$metadata['expirationdate'] = $data['expirationdate'];
		}
		if ( !empty( $data['keywords'] ) ) {
			$metadata['keywords'] = $data['keywords'];
		}

		return $metadata;
	}

	/**
	 * check if video exists
	 * @param string $name
	 * @param string $source
	 * @param string $assetType [remote_asset]
	 * @return boolean
	 */
	public function isExist( $name, $source, $assetType = 'remote_asset' ) {
		wfProfileIn( __METHOD__ );

		$cond = array(
			"asset_type='$assetType'",
			"name='".addslashes($name)."'",
			"metadata.source='$source'",
		);

		$params = array(
			'limit' => 1,
			'where' => implode( ' AND ', $cond ),
		);

		$method = 'GET';
		$reqPath = '/v2/assets';

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );
		//print( "Connecting to $url...\n" );

		$req = MWHttpRequest::factory( $url );
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
	 * set thumbnail url
	 * @param string $videoId
	 * @param array $assetData
	 * @return boolean $resp
	 */
	public function setThumbnailUrl( $videoId, $assetData ) {
		wfProfileIn( __METHOD__ );

		$method = 'PUT';
		$reqPath = '/v2/assets/'.$videoId.'/preview_image_urls';

		$params[] = array(
			'url' => $assetData['thumbnail'],
			'width' => 240,
			'height' => 320,
		);

		$resp = $this->sendRequest( $method, $reqPath, $params );

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * set primary thumbnail
	 * @param string $videoId
	 * @return boolean $resp
	 */
	public function setPrimaryThumbnail( $videoId ) {
		wfProfileIn( __METHOD__ );

		$method = 'PUT';
		$reqPath = '/v2/assets/'.$videoId.'/primary_preview_image';
		$params = array( 'type' => 'remote_url' );

		$resp = $this->sendRequest( $method, $reqPath, $params );

		wfProfileOut( __METHOD__ );

		return $resp;
	}

	/**
	 * send request
	 * @param string $method
	 * @param string $reqPath
	 * @param array $params
	 * @return boolean $result
	 */
	protected function sendRequest( $method, $reqPath, $params ) {
		wfProfileIn( __METHOD__ );

		$reqBody = json_encode( $params );

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, array(), $reqBody );
		//print( "Connecting to $url...\n" );

		$options = array(
			'method' => $method,
			'postData' => $reqBody,
		);

		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$resp = json_decode( $req->getContent(), true );
			$result = true;

			print( "Ooyala: sent $reqPath request: \n" );
			foreach( explode( "\n", var_export( $resp, TRUE ) ) as $line ) {
				print ":: $line\n";
			}
		} else {
			$result = false;
			print( "ERROR: problem sending $reqPath request (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

}