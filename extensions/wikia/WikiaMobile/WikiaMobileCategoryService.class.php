<?php
/**
 * WikiaMobile category page
 * 
 * @author Jakub Olek <jolek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileCategoryService extends WikiaService {
	
	public function categoryExhibition() {
		$title = $this->getVal('title');

		if( class_exists( 'CategoryExhibitionPage' ) ) {

			$exh = CategoryDataService::getMostVisited( $title->getDBkey(), false, 4 );
			$ids = array_keys($exh);
			
			for( $i = 0; $i < 4; $i++ ) {
				$pageId = $ids[$i];
				var_dump($pageId);
				$imageServing = new ImageServing( $pageId, 150 , array( "w" => 150, "h" => 150 ) );
				var_dump($imageServing->getImages( 1 ) );
				
						$snippetText = '';
						$imageUrl = $imageServing->getImages( 1 );
				
						if ( empty( $imageUrl ) ){
							$snippetService = new ArticleService ( $pageId );
							$snippetText = $snippetService->getTextSnippet();
						}
				var_dump($snippetText);
						$oTitle = Title::newFromID( $pageId );
				
						$returnData = array(
							'id'		=> $pageId,
							'img'		=> $imageUrl,
							'snippet'	=> $snippetText,
							'title'		=> $oTitle->getText(),
							'url'		=> $oTitle->getFullURL()
						);
			}
			exit();
			return true;
		}
		
		return false;
	}
	
	public function alphabeticalList() {
		return true;
	}

}
