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
		print( "Connecting to $url...\n" );

		$options = array(
			'method' => $method,
			'postData' => $reqBody,
		);
		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$response = $req->getContent();
			$asset = json_decode( $response, true );

			print( "Ooyala: Uploaded Remote Asset: \n" );
			foreach( explode("\n", var_export($asset, 1)) as $line ) {
				print ":: $line\n";
			}

			// add metadata for the asset
			$resp = $this->addMetadata( $asset['embed_code'], $data );
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
	 * @return boolean
	 */
	public function addMetadata( $videoId, $metadata ) {
		$method = 'PUT';
		$reqPath = '/v2/assets/'.$videoId.'/metadata';

		$assetData = $this->getAssetMetadata( $metadata );
		$assetData['source'] = $metadata['provider'];
		$assetData['sourceid'] = $metadata['videoId'];
		$reqBody = json_encode( $assetData );

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, array(), $reqBody );
		print( "Connecting to $url...\n" );

		$options = array(
			'method' => $method,
			'postData' => $reqBody,
		);
		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$meta = json_decode( $req->getContent(), true );

			print( "Ooyala: Updated Metadata for $videoId: \n" );
			foreach( explode( "\n", var_export( $meta, TRUE ) ) as $line ) {
				print ":: $line\n";
			}
		} else {
			print( "ERROR: problem adding metadata (".$status->getMessage().").\n" );
			wfProfileOut( __METHOD__ );

			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
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
			"name='$name'",
			"metadata.source='$source'",
		);

		$params = array(
			'limit' => 1,
			'where' => implode( ' AND ', $cond ),
		);

		$method = 'GET';
		$reqPath = '/v2/assets';

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );
		print( "Connecting to $url...\n" );

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

}