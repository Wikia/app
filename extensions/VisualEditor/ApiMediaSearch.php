<?

class ApiMediaSearch extends ApiBase {

	const THUMB_SIZE = 150;

	public function execute() {

		$params = $this->extractRequestParams();

		// What are we looking for?
		$query = $params['query'];

		// Which batch?
		$batch = $params['batch'];

		// What type of media are we looking for?
		$mediaTypeArray = explode( '|', $params['mediaType'] );
		if ( count( $mediaTypeArray ) == 1 ) {
			if ( in_array( 'video', $mediaTypeArray ) ) {
				// video
				$response = $this->formatResponse( [
					$this->makeRequest( $query, $batch, true, false )
				] );
			} else if ( in_array( 'photo', $mediaTypeArray ) ) {
				// photo
				$response = $this->formatResponse( [
					$this->makeRequest( $query, $batch, false, true )
				] );
			}
		} else if (
			count ( $mediaTypeArray ) == 2 &&
			in_array( 'photo', $mediaTypeArray ) &&
			in_array( 'video', $mediaTypeArray )
		) {
			if ( isset( $params['separate'] ) && $params['separate'] == 'true' ) {
				// video and photo separate
				$response = $this->formatResponse( [
					$this->makeRequest( $query, $batch, true, false ),
					$this->makeRequest( $query, $batch, false, true )
				] );
			} else {
				// video and photo combined
				$response = $this->formatResponse( [
					$this->makeRequest( $query, $batch, false, false )
				] );
			}
		}

		// Return response
		$this->getResult()->addValue( null, 'response', $response );
		return true;
	}

	private function formatResponse( $raw ) {
		$response = [];

		if ( count( $raw ) == 1 ) {
			$response = [
				'batches' => $raw[0]['batches'],
				'currentBatch' => $raw[0]['currentBatch'],
				'items' => $this->formatItems( $raw[0] )
			];
		} else if ( count( $raw ) == 2 ) {
			$response = [
				'videos' => [
					'batches' => $raw[0]['batches'],
					'currentBatch' => $raw[0]['currentBatch'],
					'items' => $this->formatItems( $raw[0] )
				],
				'photos' => [
					'batches' => $raw[1]['batches'],
					'currentBatch' => $raw[1]['currentBatch'],
					'items' => $this->formatItems( $raw[1] )
				]
			];
		}

		return $response;

	}

	private function makeRequest( $query, $batch = 1, $videoOnly, $imageOnly ) {
		$searchConfig = (new Wikia\Search\Config())
			->setQuery( $query )
			->setLimit( 10 )
			->setPage( $batch )
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
				'thumbnail' => $this->getThumbnail( $rawItem['title'] )
			];
			array_push( $items, $item );
		}

		$this->getResult()->setIndexedTagName($items, 'item');

		return $items;
	}

	private function getThumbnail( $title ) {
		// Borrowed from WikiaQuizElement.class.php
		$imageSrc = '';
		$fileTitle = Title::newFromText( $title, NS_FILE );
		$image = wfFindFile( $fileTitle );
		if ( !is_object( $image ) || $image->height == 0 || $image->width == 0 ){
			return $imageSrc;
		} else {
			$thumbDim = ($image->height > $image->width) ? $image->width : $image->height;
			$imageServing = new ImageServing( array( $fileTitle->getArticleID() ), self::THUMB_SIZE, array( "w" => $thumbDim, "h" => $thumbDim ) );
			$imageSrc = wfReplaceImageServer(
				$image->getThumbUrl(
					$imageServing->getCut( $thumbDim, $thumbDim )
				)
			);
		}

		return $imageSrc;
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
			'separate' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'batch' => array (
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => false
			),
		);
	}

	public function getVersion() {
		return '$Id$';
	}
}
