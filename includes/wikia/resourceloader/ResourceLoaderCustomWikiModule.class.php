<?php

class ResourceLoaderCustomWikiModule extends ResourceLoaderGlobalWikiModule {

	protected $type;
	protected $articles;

	public function __construct( $info ) {
		$this->type = $info['type'];
		$this->articles = $info['articles'];
	}

	public function getPages( ResourceLoaderContext $context ) {
		$pages = array();
        $missingCallback = $context->getRequest()->getVal('missingCallback');

		if ( $this->type ) {
			$id = 1;
			foreach ($this->articles as $article) {
				$pageIndex = $article['title'];
				$type = isset($article['type']) ? $article['type'] : $this->type;
				$pageInfo = array(
					'type' => $type,
				);

                if ( isset( $article['originalName'] ) ) {
                    $pageInfo['originalName'] = $article['originalName'];
                }
                if ( $missingCallback ) {
                    $pageInfo['missingCallback'] = $missingCallback;
                }

				if(isset($article['cityId']) && empty($article['cityId'])){
					// Caller put in a wiki name, but it didn't resolve to a cityId.
				} else {
					if ( !empty( $article['cityId'] ) ) {
						$pageIndex = 'fakename'.($id++);
						$pageInfo['city_id'] = intval($article['cityId']);
						$pageInfo['title'] = $article['title'];
					}
					$pages[$pageIndex] = $pageInfo;
				}
			}
		}

		return $pages;
	}

}