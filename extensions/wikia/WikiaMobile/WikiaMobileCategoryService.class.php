<?php
/**
 * WikiaMobile category page service
 *
 * @author Jakub Olek <jolek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileCategoryService extends WikiaService {
	private $model;

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
	}

	public function alphabeticalList() {
		$this->wf->profileIn( __METHOD__ );

		$categoryPage = $this->getVal( 'categoryPage' );

		if ( $categoryPage instanceof CategoryPage ) {
			$this->initModel();

			$title = $categoryPage->getTitle();
			$category = F::build( 'Category', array( $title ),  'newFromTitle' );
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
				$data = F::build( 'WikiaMobileCategoryModel' )->getItemsCollection( $category );
				
				if ( !empty( $data[$index] ) && $batch > 0) {
					$this->response->setVal( 'itemsBatch', $data[$index]->getItems( $batch ) );
				} else {
					$err = true;
				}
			} else {
				$err = true;
			}
		} else {
			$err = true;
		}

		if ( $err ) {
			throw new WikiaException( "Error loading batch {$batch} for index {$index} in Category {$categoryName}" );
		}
	}
}
