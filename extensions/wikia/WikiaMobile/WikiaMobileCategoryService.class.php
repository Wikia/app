<?php
/**
 * WikiaMobile category page service
 *
 * @author Jakub Olek <jolek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileCategoryService extends WikiaService {
	/**
	 * @var $model WikiaMobileCategoryModel
	 */
	private $model;

	//3 hours
	const CACHE_TIME = 10800;

	private function initModel(){
		if ( !isset( $this->model ) ){
			$this->model = new WikiaMobileCategoryModel;
		}
	}

	public function index(){
		$categoryLinks = $this->request->getVal( 'categoryLinks', '' );

		//$catlinks are always returned even empty
		if (strpos($categoryLinks, ' catlinks-allhidden\'></div>') !== false) {
			$categoryLinks = '';
		}

		$this->response->setVal( 'categoryLinks', $categoryLinks );
	}

	public function categoryExhibition() {
		wfProfileIn(__METHOD__);

		/**
		 * @var $categoryPage CategoryPage
		 */
		$categoryPage = $this->getVal( 'categoryPage' );

		if ( $categoryPage instanceof CategoryPage ) {
			$title = $categoryPage->getTitle();
			$this->initModel();

			$items = $this->model->getExhibitionItems( $title );
			
			if ( empty( $items ) ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			$this->response->setVal( 'items', $items );

		} else {
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	public function alphabeticalList() {
		wfProfileIn( __METHOD__ );

		/**
		 * @var $categoryPage CategoryPage
		 */
		$categoryPage = $this->request->getVal( 'categoryPage' );

		if ( $categoryPage instanceof CategoryPage ) {
			$this->initModel();

			$title = $categoryPage->getTitle();
			$category = Category::newFromTitle( $title );
			$collections = $this->model->getCollection( $category );

			$this->response->setVal( 'total', $collections['count'] );
			$this->response->setVal( 'collections', $collections['items'] );
			$this->response->setVal( 'requestedIndex', $this->wg->Request->getText( 'index', null ) );
			$this->response->setVal( 'requestedBatch', $this->wg->Request->getInt( 'page', 1 ) );
		} else {
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public function getBatch(){
		//see Category::newFromName for valid format
		$categoryName = str_replace( ' ', '_', $this->request->getVal( 'category' ) );
		$index = $this->request->getVal( 'index' );
		$batch = $this->request->getInt( 'batch' );
		$err = false;

		if ( !empty( $categoryName ) && isset( $index ) && !empty( $batch ) ){
			$category = Category::newFromTitle( Title::newFromText( $categoryName, NS_CATEGORY ) );

			if ( $category instanceof Category ) {
				$this->initModel();

				$data = wfPaginateArray(
					$this->model->getCollection( $category )['items'][$index],
					WikiaMobileCategoryModel::BATCH_SIZE,
					$batch
				);

				if ( !empty( $data['items'] ) ) {
					//cache response for 3 hours in varnish and browser
					$this->response->setCacheValidity(
						WikiaMobileCategoryService::CACHE_TIME,
						WikiaMobileCategoryService::CACHE_TIME,
						[
							WikiaResponse::CACHE_TARGET_BROWSER,
							WikiaResponse::CACHE_TARGET_VARNISH
						]
					);
					$this->response->setVal( 'itemsBatch', $data['items'] );
				} else {
					$err = "No Data for given index or batch";
				}
			} else {
				$err = "Wrong category";
			}
		} else {
			$err = "Wrong values given";
		}

		if ( $err ) {
			Wikia::log( __METHOD__, false, "Error loading batch {$batch} for index {$index} in Category {$categoryName}. Msg: {$err}" );
			header( 'Status: 404 Not Found', true, 404 );
		}
	}
}
