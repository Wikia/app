<?php
class ImageServingDriverCategoryNS extends ImageServingDriverMainNS {
	const STRAIGHT_JOIN_LIMIT = 70000;
	const ARTICLES_LIMIT_PER_CATEGORY = 10;

	protected function loadImagesFromDb( $articleIds = array() ) {
		parent::loadImagesFromDb( $articleIds );

		$articleCategories = array();
		foreach ( $articleIds as $categoryId ) {
			if ( $this->getAllImagesCountForArticle( $categoryId ) < self::QUERY_LIMIT ) {
				$this->addTopArticlesFromCategory( $categoryId, $articleCategories );
			}
		}

		$imageIndex = $this->getImageIndex( array_keys( $articleCategories ), self::QUERY_LIMIT );

		$propNumber = 0;
		foreach ( $imageIndex as $articleId => $articleImageIndex ) {
			$propNumber++;
			foreach ( $articleImageIndex as $key => $imageData ) {
				foreach ( $articleCategories[$articleId] as $categoryId ) {
					$this->addImage( $imageData, $categoryId, $propNumber * ( 2 * self::QUERY_LIMIT + $key ), self::QUERY_LIMIT );
				}
			}
		}
	}

	protected function addTopArticlesFromCategory( $categoryId, &$articleCategories ) {

		$key = wfMemcKey("ImageServingCategoryNSTopArticles", $categoryId);
		$cachedPageIds = $this->memc->get($key);
		if (!empty($cachedPageIds)) {
			foreach ($cachedPageIds as $page_id) {
				if ( empty( $articleCategories[$page_id] ) ) {
					$articleCategories[$page_id] = array();
				}
				$articleCategories[$page_id][] = $categoryId;
			}
			return;
		}

		# fetch number of articles in category
		# which controls if we use STRAIGHT_JOIN in the next query
		$count = $this->db->selectField(
			array( 'page', 'categorylinks' ),
			array( 'COUNT(cl_from)' ),
			array(
				'cl_to  = page_title',
				'page_id' => $categoryId
			),
			__METHOD__
		);

		# fetch list of N longest (by wikitext size) articles from this category
		$options = array(
			'ORDER BY' => 'page.page_len desc',
			'LIMIT' => self::ARTICLES_LIMIT_PER_CATEGORY,
		);

		if ( $count > self::STRAIGHT_JOIN_LIMIT ) {
			$options[] = 'STRAIGHT_JOIN';
		}

		$res = $this->db->select(
			array( 'page', 'categorylinks', 'page as cat_page' ),
			array(
				"page.page_id",
			),
			array(
				'cl_from = page.page_id',
				'cl_to  = cat_page.page_title',
				'cat_page.page_id' => $categoryId
			),
			__METHOD__,
			$options
		);

		while ( $row = $this->db->fetchRow( $res ) ) {
			if ( empty( $articleCategories[$row['page_id']] ) ) {
				$articleCategories[$row['page_id']] = array();
			}
			$articleCategories[$row['page_id']][] = $categoryId;
			$cachedPageIds[] = $row['page_id'];
		}
		$this->memc->set($key, $cachedPageIds, 86400);
	}
}
