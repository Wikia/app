<?

class ApiMediaSearch extends ApiBase {

	const LIMIT = 50;

	private $query;
	private $batch;
	private $limit;

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

		// Get formatted results
		if ( $video && $photo ) {
			if ( isset( $params['separate'] ) && $params['separate'] == 'true' ) {
				// video and photo separate
				$response = $this->formatResults( [
					$this->getResults( true, false ),
					$this->getResults( false, true )
				] );
			} else {
				// video and photo combined
				$response = $this->formatResults( [
					$this->getResults( false, false )
				] );
			}
		} else {
			// either photo or video
			$response = $this->formatResults( [
				$this->getResults( $video, $photo )
			] );
		}

		// Return response
		$this->getResult()->addValue( null, 'response', $response );
		return true;
	}

	private function formatResults( $raw ) {
		$results = [];

		if ( count( $raw ) == 1 ) {
			$results = [
				'limit' => $this->limit,
				'batch' => $raw[0]['currentBatch'],
				'all' => [
					'batches' => $raw[0]['batches'],
					'items' => $this->formatItems( $raw[0] )
				]
			];
		} else if ( count( $raw ) == 2 ) {
			$results = [
				'limit' => $this->limit,
				'batch' => $raw[0]['currentBatch'],
				'video' => [
					'batches' => $raw[0]['batches'],
					'items' => $this->formatItems( $raw[0] )
				],
				'photo' => [
					'batches' => $raw[1]['batches'],
					'items' => $this->formatItems( $raw[1] )
				]
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
			->searchAsApi( [ 'url', 'id', 'pageid', 'wid', 'title' ], true );

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
			'separate' => array (
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
