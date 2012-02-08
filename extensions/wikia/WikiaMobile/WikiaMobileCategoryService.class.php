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
			$sCategoryDBKey = $title->getDBkey();
			
			$exh = CategoryDataService::getMostVisited( $sCategoryDBKey, false, 4 );

			return true;
		}
		
		return false;
	}
	
	public function alphabeticalList() {
		return true;
	}

}
