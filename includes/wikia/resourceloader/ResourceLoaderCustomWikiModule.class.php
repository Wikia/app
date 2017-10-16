<?php

class ResourceLoaderCustomWikiModule extends ResourceLoaderGlobalWikiModule {

	protected $id;
	protected $type;
	protected $articles;

	public function __construct( $info ) {
		$this->id = 0;
		$this->type = $info['type'];
		$this->articles = $info['articles'];
	}

	public function getPages( ResourceLoaderContext $context ) {
		$pages = array();
		$missingCallback = $context->getRequest()->getVal('missingCallback');

		if ( $this->type ) {
			foreach ($this->articles as $article) {
				$pageKey = isset( $article['originalName'] ) ? $article['originalName'] : $article['title'];
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

				if ( !empty( $article['cityId'] ) ) {
					$pageIndex = 'fakename' . ( $this->id++ );
					$pageInfo['city_id'] = intval($article['cityId']);
					$pageInfo['title'] = $article['title'];

				// Unable to resolve wiki to cityId
				} else if ( isset( $article['cityId'] ) ) {
					$pageInfo['missing'] = true;
				}

				$pages[$pageKey] = $pageInfo;
			}
		}

		return $pages;
	}
}