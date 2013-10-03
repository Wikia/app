<?

class ApiMediaSearch extends ApiBase {

	public function execute() {

		$params = $this->extractRequestParams();

		// What are we looking for?
		$query = $params['query'];

		// What type of media are we looking for?
		$mediaTypeArray = explode( '|', $params['mediaType'] );
		if ( count( $mediaTypeArray ) == 1 ) {
			if ( in_array( 'video', $mediaTypeArray ) ) {
				$combinedMediaSearch = true;
				$videoOnly = true;
				$imageOnly = false;
			} else if ( in_array( 'photo', $mediaTypeArray ) ) {
				$combinedMediaSearch = true;
				$videoOnly = false;
				$imageOnly = true;
			}
		} else if (
			count ( $mediaTypeArray ) == 2 &&
			in_array( 'photo', $mediaTypeArray ) &&
			in_array( 'video', $mediaTypeArray )
		) {
			$combinedMediaSearch = true;
			$videoOnly = false;
			$imageOnly = false;
		}

		// Perform search
		$searchConfig = (new Wikia\Search\Config())
			->setQuery( $query )
			->setLimit( 10 )
			->setStart( 0 )
			->setCombinedMediaSearch( $combinedMediaSearch )
			->setCombinedMediaSearchIsVideoOnly( $videoOnly )
			->setCombinedMediaSearchIsImageOnly( $imageOnly );
		$results = (new Wikia\Search\QueryService\Factory)
			->getFromConfig( $searchConfig )
			->searchAsApi( [ 'url', 'id', 'pageid', 'wid', 'title' ], true );

		// Set results
		$this->getResult()->addValue( null, 'results', $results );

		return true;
	}

	public function getAllowedParams() {
		return array(
			'query' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'mediaType' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
		);
	}

	public function getVersion() {
		return '$Id$';
	}
}
