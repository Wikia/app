<?php 
class ImageServingDriverCategoryNS extends ImageServingDriverMainNS {
	protected $articlesFromCategory = 10;
	private $straightJoinLimit = 70000;
	
	protected function getImagesFromDB($articles = array()) {
		parent::getImagesFromDB($articles);

		$toGetFromArticle = array();
		foreach($articles as $val) {
			if($this->getImagesCountBeforeFiltr($val) < $this->queryLimit) {
				$this->getCategoryArticleList($val, $toGetFromArticle);
			}
		}
		
		$props = $this->getArticleProbs(array_keys($toGetFromArticle), $this->queryLimit);
		
		$propNumber = 0;
		foreach($props as  $article => $prop) {
			$count = 0;
			$propNumber++;
			foreach( $prop as $key => $image  ) {
				foreach( $toGetFromArticle[$article] as $cat ) {
					$this->addImagesList(  $image, $cat, $propNumber*(2*$this->queryLimit + $key), $this->queryLimit );
				}
			}
		}		
	}
	
	protected function getCategoryArticleList($id, &$toGetFromArticle) {
		$out = array();
				
		$count = $this->db->selectField ( 
			array( 'page', 'categorylinks' ), 
			array( 'COUNT(cl_from)' ), 
			array(
				'cl_to  = page_title', 
				'page_id' => $id 
			),
			__METHOD__
		);
		
		$options = array(
			'ORDER BY' =>  'page.page_len desc',
			'LIMIT' => $this->articlesFromCategory
		);
		
		if ( $count > $this->straightJoinLimit ) {
			$options[] = 'STRAIGHT_JOIN';
		}

		$res = $this->db->select(
			array( 'page', 'categorylinks' ,'page as cat_page'  ),
			array(
				"page.page_title", 
				"page.page_id", 
				"page.page_len" 
			),
			array(
				'cl_from = page.page_id',
				'cl_to  = cat_page.page_title', 
				'cat_page.page_id' => $id 
			),
			__METHOD__,
			$options
		);

		while ($row =  $this->db->fetchRow( $res ) ) {
			if(empty($toGetFromArticle[$row['page_id']])) {
				$toGetFromArticle[$row['page_id']] = array( $id );	
			} else {
				$toGetFromArticle[$row['page_id']][] = $id;
			}
		}
		return $out;
	}
}
