<?

class ApiMediaSearch extends ApiBase {

	const LIMIT = 50;

	/* Main API Method */

	public function execute() {

		// Extract params from request
		$params = $this->extractRequestParams();

		// Query
		$query = $this->getQuery( $params );

		// Batch
		$batch = $this->getBatch( $params );

		// Limit
		$limit = $this->getLimit( $params );

		// Mixed
		$mixed = $this->getMixed( $params );

		// Type
		$video = $this->getVideo( $params );
		$photo = $this->getPhoto( $params );

		// Get results, not well-structured
		$results = $this->getResults( $query, $limit, $batch, $video, $photo, $mixed );

		// Properly format results
		$response = $this->formatResults( $results, $limit, $batch );

		// Return response
		$this->getResult()->addValue( null, 'response', $response );
		return true;
	}

	public function getQuery( $params ) {
		return $params['query'];
	}

	public function getBatch( $params ) {
		return isset( $params['batch'] ) ? $params['batch'] : 1;
	}

	public function getLimit( $params ) {
		return isset( $params['limit'] ) ? $params['limit'] : self::LIMIT;
	}

	public function getMixed( $params ) {
		return filter_var( $params['mixed'], FILTER_VALIDATE_BOOLEAN ) ? true : false;
	}

	public function getVideo( $params ) {
		$typeArray = explode( '|', $params['type'] );
		return in_array( 'video', $typeArray );
	}

	public function getPhoto( $params ) {
		$typeArray = explode( '|', $params['type'] );
		return in_array( 'photo', $typeArray );
	}

	protected function getType( $title ) {
		$fileTitle = Title::newFromText( $title, NS_FILE );
		$image = wfFindFile( $fileTitle );

		$mediaTypes = [
			'BITMAP' => 'photo',
			'VIDEO' => 'video'
		];

		return $mediaTypes[ $image->getMediaType() ];
	}

	protected function getUrl( $title ) {
		$fileTitle = Title::newFromText( $title, NS_FILE );
		$image = wfFindFile( $fileTitle );
		return $image->getFullUrl();
	}

	public function getResults( $query, $limit, $batch, $video, $photo, $mixed ) {
		$results = [];
		if ( $video && $photo ) {
			if ( $mixed ) {
				// video and photo mixed
				$results['mixed'] = $this->getSearchResults( $query, $limit, $batch, false, false );
			} else {
				// video and photo separate
				$results['video'] = $this->getSearchResults( $query, $limit, $batch, true, false );
				$results['photo'] = $this->getSearchResults( $query, $limit, $batch, false, true );
			}
		} else {
			// either photo or video
			$items = $this->getSearchResults( $query, $limit, $batch, $video, $photo );
			if ( $mixed ) {
				$key = 'mixed';
			} else {
				$key = $video ? 'video' : 'photo';
			}
			$results[$key] = $items;
		}
		return $results;
	}

	protected function getSearchResults( $query, $limit, $batch, $videoOnly, $imageOnly ) {
		$searchConfig = (new Wikia\Search\Config())
			->setQuery( $query )
			->setLimit( $limit )
			->setPage( $batch )
			->setCombinedMediaSearch( true )
			->setCombinedMediaSearchIsVideoOnly( $videoOnly )
			->setCombinedMediaSearchIsImageOnly( $imageOnly );
		$searchResults = (new Wikia\Search\QueryService\Factory)
			->getFromConfig( $searchConfig )
			->searchAsApi( [ 'title' ], true );

		return $searchResults;
	}

	public function formatResults( $raw, $limit, $batch ) {
		$results = [
			'limit' => $limit,
			'batch' => $batch
		];
		$keys = array_keys( $raw );

		for ( $i = 0; $i < count( $raw ); $i++ ) {
			$key = $keys[$i];
			$results['results'][$key] = [
				'batches' => $raw[$key]['batches'],
				'items' => $this->formatItems( $raw[$key] )
			];
		}

		return $results;
	}

	public function formatItems( $raw ) {
		$items = [];

		foreach( $raw['items'] as $rawItem ) {
			$item = [
				'title' => $rawItem['title'],
				'type' => $this->getType( $rawItem['title'] ),
				'url' => $this->getUrl( $rawItem['title'] )
			];
			array_push( $items, $item );
		}

		$this->setItemTagName( $items );

		return $items;
	}

	/* Helper for proper XML formatting */
	protected function setItemTagName( &$items ) {
		$this->getResult()->setIndexedTagName( $items, 'item');
	}

	public function getAllowedParams() {
		return array(
			'query' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'type' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'mixed' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'batch' => array (
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => false
			),
			'limit' => array (
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => false
			),
		);
	}

	public function getVersion() {
		return '$Id$';
	}
}
