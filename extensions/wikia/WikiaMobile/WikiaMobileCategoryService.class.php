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
			$this->model = F::build( 'WikiaMobileCategoryModel' );
		}
	}

	public function index(){
		$categoryLinks = $this->request->getVal( 'categoryLinks', '' );

		//MW1.16 always returns non empty $catlinks
		//TODO: remove since we're on 1.17+?
		if (strpos($categoryLinks, ' catlinks-allhidden\'></div>') !== false) {
			$categoryLinks = '';
		}

		$this->response->setVal( 'categoryLinks', $categoryLinks );
	}

	public function categoryExhibition() {
		$this->wf->profileIn(__METHOD__);

		/**
		 * @var $categoryPage CategoryPage
		 */
		$categoryPage = $this->getVal( 'categoryPage' );

		if ( $categoryPage instanceof CategoryPage ) {
			$title = $categoryPage->getTitle();
			$this->initModel();

			$items = $this->model->getExhibitionItems( $title );
			
			if ( empty( $items ) ) {
				$this->wf->profileOut( __METHOD__ );
				return false;
			}

			$this->response->setVal( 'items', $items );

		} else {
			$this->wf->profileOut( __METHOD__ );
			return false;
		}

		$this->wf->profileOut( __METHOD__ );
		return null;
	}

	public function alphabeticalList() {
		$this->wf->profileIn( __METHOD__ );

		/**
		 * @var $categoryPage CategoryPage
		 */

		$categoryPage = $this->getVal( 'categoryPage' );

		if ( $categoryPage instanceof CategoryPage ) {
			$this->initModel();

			$title = $categoryPage->getTitle();
			$category = F::build( 'Category', array( $title ),  'newFromTitle' );
			/**
			 * @var $data WikiaMobileCategoryContents
			 */
			$data = $this->model->getItemsCollection( $category );

			$this->response->setVal( 'total', $data->getCount() );
			$this->response->setVal( 'collections', $data->getItems() );
			$this->response->setVal( 'requestedIndex', $this->wg->Request->getText( 'index', null ) );
			$this->response->setVal( 'requestedBatch', $this->wg->Request->getInt( 'page', 1 ) );
		} else {
			$this->wf->profileOut( __METHOD__ );
			return false;
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function getBatch(){
		//see Category::newFromName for valid format
		$categoryName = str_replace( ' ', '_', $this->request->getVal( 'category' ) );
		$index = $this->request->getVal( 'index' );
		$batch = $this->request->getInt( 'batch' );
		$err = false;

		if ( !empty( $categoryName ) && isset( $index ) && !empty( $batch ) ){
			$category = F::build( 'Category', array ( F::build( 'Title' , array ( $categoryName, NS_CATEGORY ), 'newFromText' ) ), 'newFromTitle' );

			if ( $category instanceof Category ) {
				/**
				 * @var $categoryModel WikiaMobileCategoryModel
				 */
				$categoryModel = F::build( 'WikiaMobileCategoryModel' );
				$data = $categoryModel->getItemsCollection( $category );
				
				if ( !empty( $data[$index] ) && $batch > 0) {
					//cache response for 3 hours in varnish and browser
					$this->response->setCacheValidity(
						WikiaMobileCategoryService::CACHE_TIME,
						WikiaMobileCategoryService::CACHE_TIME,
						array(
							WikiaResponse::CACHE_TARGET_BROWSER,
							WikiaResponse::CACHE_TARGET_VARNISH
						));
					$this->response->setVal( 'itemsBatch', $data[$index]->getItems( $batch ) );
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
