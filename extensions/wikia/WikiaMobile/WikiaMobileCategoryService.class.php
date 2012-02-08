<?php
/**
 * WikiaMobile category page
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
		$categoryPage = $this->getVal( 'categoryPage' );

		if ( $categoryPage instanceof CategoryPage && class_exists( 'CategoryExhibitionPage' ) ) {
			$title = $categoryPage->getTitle();
			$exh = CategoryDataService::getMostVisited( $title->getDBkey(), false, 4 );
			$ids = array_keys($exh);

			for ( $i = 0; $i < 4; $i++ ) {
				$pageId = $ids[$i];

				$imageServing = new ImageServing( $pageId, 150 , array( "w" => 150, "h" => 150 ) );

						$snippetText = '';
						$imageUrl = $imageServing->getImages( 1 );

						if ( empty( $imageUrl ) ){
							$snippetService = F::build( 'ArticleService', array( $pageId ) );
							$snippetText = $snippetService->getTextSnippet();
						}

						$oTitle = F::build( 'Title', array( $pageId ), 'newFromID' );

						$returnData = array(
							'id'		=> $pageId,
							'img'		=> $imageUrl,
							'snippet'	=> $snippetText,
							'title'		=> $oTitle->getText(),
							'url'		=> $oTitle->getFullURL()
						);
			}
		} else {
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
		} else {
			return false;
		}
	}

}
