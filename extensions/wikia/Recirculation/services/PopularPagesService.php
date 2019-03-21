<?php

class PopularPagesService {
	public function getPopularPages( int $limit, int $thumbWidth, int $thumbHeight ): array {
		global $wgCityId, $wgContentNamespaces, $wgSitename;

		$articles = DataMartService::getTopArticlesByPageview(
			$wgCityId,
			null,
			$wgContentNamespaces,
			false,
			$limit + 5 // compensate for main page / articles without image
		);

		$mainPage = Title::newMainPage();

		unset( $articles[$mainPage->getArticleID()] );

		$articleIds = array_keys( $articles );
		$titles = Title::newFromIDs( $articleIds );

		$imageServing = new ImageServing( $articleIds, $thumbWidth, $thumbHeight );
		$images = $imageServing->getImages( 1 );

		$data = [];
		$count = 0;

		foreach ( $titles as $title ) {
			$articleId = $title->getArticleID();

			$data[$articleId] = [
				'title' => $title->getPrefixedText(),
				'url' => $title->getFullURL(),
				'thumbnail' => isset( $images[$articleId]) ? $images[$articleId][0]['url'] : null,
				'hasVideo' => false,
				'site_name' => $wgSitename,
			];

			$count++;

			if ( $count >= $limit ) {
				break;
			}
		}

		return $data;
	}

	public function getPopularPagesWithVideoInfo( int $limit, int $thumbWidth, int $thumbHeight ): array {
		global $wgCityId;

		$data = $this->getPopularPages( $limit, $thumbWidth, $thumbHeight );
		$videos = ArticleVideoService::getFeaturedVideosForWiki( $wgCityId );

		foreach ( $videos as $mapping ) {
			if ( isset( $data[$mapping->getId()] ) ) {
				$data[$mapping->getId()]['hasVideo'] = true;
			}
		}
		foreach ( $data as $id => $article ) {
			$data[$id]['id'] = $id;
		}

		return array_values( $data );
	}
}
