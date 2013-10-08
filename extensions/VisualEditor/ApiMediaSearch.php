<?

class ApiMediaSearch extends ApiBase {

	const LIMIT = 50;

	private $query;
	private $batch;
	private $limit;
	private $mixed = false;

	public function execute() {

		$params = $this->extractRequestParams();

		// What are we looking for?
		$this->query = $params['query'];

		// Which batch?
		$this->batch = $params['batch'] ? $params['batch'] : 1;

		// How many?
		$this->limit = $params['limit'] ? $params['limit'] : self::LIMIT;

		// What type of media are we looking for?
		$typeArray = explode( '|', $params['type'] );
		$video = in_array( 'video', $typeArray );
		$photo = in_array( 'photo', $typeArray );

		// Mixed?
		if ( isset( $params['mixed'] ) && $params['mixed'] == 'true' ) {
			$this->mixed = true;
		}

		// Get results
		$results = [];
		if ( $video && $photo ) {
			if ( $this->mixed ) {
				// video and photo mixed
				$results['mixed'] = $this->getResults( false, false );
			} else {
				// video and photo separate
				$results['video'] = $this->getResults( true, false );
				$results['photo'] = $this->getResults( false, true );
			}
		} else {
			// either photo or video
			$items = $this->getResults( $video, $photo );
			if ( $this->mixed ) {
				$key = 'mixed';
			} else {
				$key = $video ? 'video' : 'photo';
			}
			$results[$key] = $items;
		}

		// Format results
		$response = $this->formatResults( $results );

		// Return response
		$this->getResult()->addValue( null, 'response', $response );
		return true;
	}

	private function formatResults( $raw ) {
		$results = [
			'limit' => $this->limit,
			'batch' => $this->batch
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

	private function getResults( $videoOnly, $imageOnly ) {
		$searchConfig = (new Wikia\Search\Config())
			->setQuery( $this->query )
			->setLimit( $this->limit )
			->setPage( $this->batch )
			->setCombinedMediaSearch( true )
			->setCombinedMediaSearchIsVideoOnly( $videoOnly )
			->setCombinedMediaSearchIsImageOnly( $imageOnly );
		$results = (new Wikia\Search\QueryService\Factory)
			->getFromConfig( $searchConfig )
			->searchAsApi( [ 'title' ], true );

		return $results;
	}

	private function formatItems( $raw ) {
		$items = [];

		foreach( $raw['items'] as $rawItem ) {
			$item = [
				'title' => $rawItem['title'],
				'type' => $this->getType( $rawItem['title'] ),
				'url' => $this->getUrl( $rawItem['title'] )
			];
			array_push( $items, $item );
		}

		$this->getResult()->setIndexedTagName($items, 'item');

		return $items;
	}

	private function getType( $title ) {
		$fileTitle = Title::newFromText( $title, NS_FILE );
		$image = wfFindFile( $fileTitle );

		$mediaTypes = [
			'BITMAP' => 'photo',
			'VIDEO' => 'video'
		];

		return $mediaTypes[ $image->getMediaType() ];
	}

	private function getUrl( $title ) {
		$fileTitle = Title::newFromText( $title, NS_FILE );
		$image = wfFindFile( $fileTitle );
		return $image->getFullUrl();
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
