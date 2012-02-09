<?php
/**
 * WikiaMobile category page service
 *
 * @author Jakub Olek <jolek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileCategoryService extends WikiaService {
	private $model;

	public function init(){
		$this->model = F::build( 'WikiaMobileCategoryModel' );
	}

	public function categoryExhibition() {
		$app = F::app();

		$app->wf->profileIn(__METHOD__);

		$categoryPage = $this->getVal( 'categoryPage' );

		if ( $categoryPage instanceof CategoryPage && class_exists( 'CategoryDataService' ) ) {
			$title = $categoryPage->getTitle();

			$exh = CategoryDataService::getMostVisited( $title->getDBkey(), false, 4 );
			$ids = array_keys( $exh );
			$length = count( $ids );

			$this->length = $length;

			$top = array();

			for( $i = 0; $i < $length; $i++ ) {

				$pageId = $ids[$i];

				$imgRespnse = $app->sendRequest( 'ImageServingController', 'index', array( 'ids' => array ( $pageId ), 'height' => 150, 'width' => 150, 'count' => 1 ) );
				$img = $imgRespnse->getVal( 'result' );

				if ( empty( $img ) ){
					$img = $img[$pageId][0]['url'];
				} else {
					$img = false;
				}

				$oTitle = Title::newFromID( $pageId );

				$top[] = array(
					'img'		=> $img,
					'title'		=> $oTitle->getText(),
					'url'		=> $oTitle->getFullURL()
				);
			}

			$this->top = $top;
			$app->wf->profileOut(__METHOD__);
			return true;
		} else {
			$app->wf->profileOut(__METHOD__);
			return false;
		}
	}

	public function alphabeticalList() {
		$categoryPage = $this->getVal( 'categoryPage' );

		if ( $categoryPage instanceof CategoryPage ) {
			$title = $categoryPage->getTitle();
			$category = F::build( 'Category', array( $title ),  'newFromTitle' );
			$data = $this->model->getItemsCollection( $category );

			$this->response->setVal( 'total', $data->getCount() );
			$this->response->setVal( 'name', $title->getText() );
			$this->response->setVal( 'collections', $data->getItems() );
			$this->response->setVal( 'requestedIndex', $this->wg->Request->getText( 'index', null ) );
			$this->response->setVal( 'requestedBatch', $this->wg->Request->getInt( 'page', 1 ) );
		} else {
			return false;
		}
	}

}
