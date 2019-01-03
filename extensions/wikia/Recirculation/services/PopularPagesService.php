<?php

class PopularPagesService {
	public function getPopularPages( int $limit ): array {
		global $wgCityId, $wgContentNamespaces;

		$articles = DataMartService::getTopArticlesByPageview(
			$wgCityId,
			null,
			$wgContentNamespaces,
			false,
			$limit + 1
		);

		$mainPage = Title::newMainPage();

		unset( $articles[$mainPage->getArticleID()] );

		$articleIds = array_keys( $articles );
		$titles = Title::newFromIDs( $articleIds );

		$imageServing = new ImageServing( $articleIds, 80, 50 );
		$images = $imageServing->getImages( 1 );

		$data = [];

		foreach ( $titles as $title ) {
			$articleId = $title->getArticleID();

			if ( isset( $images[$articleId] ) ) {
				$data[] = [
					'title' => $title->getPrefixedText(),
					'url' => $title->getFullURL(),
					'thumbnail' => $images[$articleId][0]['url'],
				];
			}
		}

		return $data;
	}
}
