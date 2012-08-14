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

		if ( $this->type ) {
			$id = 1;
			foreach ($this->articles as $article) {
				$pageIndex = $article['title'];
				$type = isset($article['type']) ? $article['type'] : $this->type;
				$pageInfo = array(
					'type' => $type,
				);
				if ( !empty( $article['cityId'] ) ) {
					$pageIndex = 'fakename'.($id++);
					$pageInfo['city_id'] = intval($article['cityId']);
					$pageInfo['title'] = $article['title'];
				}
				$pages[$pageIndex] = $pageInfo;
			}
		}

		return $pages;
	}

}