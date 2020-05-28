<?php

/**
 * Retrieves the content of tiles displayed by the recommendations module.
 * This controller supports a single wiki. If data regarding articles from multiple wikis is required, you should make multiple call with a modified wiki id header.
 */
class RecommendationTileApiController extends WikiaApiController {

	const THUMBNAIL_MIN_SIZE = 400;
	const CACHE_3_DAYS = 259200;

	function getDetails() {
		$this->setOutputFieldType( "items", self::OUTPUT_FIELD_TYPE_OBJECT );
		$articleIds = str_getcsv( $this->request->getVal( 'ids', null ) );

		$wikiId = $this->getWikiId();
		$wikiName = $this->getWikiName();

		$articles = $this->getArticleProperties( $articleIds );
		$thumbnails = $this->getArticlesThumbnails( $articleIds, self::THUMBNAIL_MIN_SIZE, self::THUMBNAIL_MIN_SIZE );

		$items = [];
		/** @var Title $articleTitle */
		foreach ( $articles as $articleTitle ) {
			$articleId = $articleTitle->getArticleID();
			$thumbnail = $thumbnails[$articleId];
			$url = $articleTitle->getFullURL();

			$items[$wikiId . '_' . $articleId] = [
				// IW-2588: Force these URLs to always use HTTPS
				// The recommendations service calls this API over HTTP, but forwards these URLs to clients
				'url' => wfHttpsAllowedForURL( $url ) ? wfHttpToHttps( $url ) : $url,
				'title' => $articleTitle->getPrefixedText(),
				'wikiName' => $wikiName,
				'thumbnail' => $thumbnail,
				'hasVideo' => !empty( $this->getFeaturedVideos( $articleId ) ),
			];
		}

		$this->setResponseData(
			[ 'items' => $items ],
			null,
			# cache for 3 days to avoid daily cache hit ratio drops - https://wikia-inc.atlassian.net/browse/DE-4346
			static::CACHE_3_DAYS
		);
	}

	private function getArticlesThumbnails( array $articleIds, int $width, int $height ): iterable {
		$result = [];
		if ( $width > 0 && $height > 0 ) {
			$is = $this->getImageServing( $articleIds, $width, $height );
			// only one image max is returned
			$images = $is->getImages( 1 );
			// parse results
			foreach ( $articleIds as $id ) {
				$result[ $id ] = $images[$id][0]['url'] ?? null;
			}
		}

		return $result;
	}

	protected function getImageServing( Array $ids, int $width, int $height ): ImageServing {
		return new ImageServing( $ids, $width, $height );
	}

	protected function getArticleProperties( Array $articles ): iterable {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			['page'],
			'page.page_id, page_title, page_namespace',
			['page.page_id' => $articles],
			__METHOD__,
			[],
			[]
		);

		foreach ( $res as $result ) {
			yield Title::newFromRow( $result );
		}
	}

	protected function getFeaturedVideos($articleId): string {
		return ArticleVideoService::getFeatureVideoForArticle( $this->getWikiId(), $articleId )['mediaId'];
	}

	protected function getWikiId(): int {
		global $wgCityId;
		return $wgCityId;
	}

	protected function getWikiName(): string {
		global $wgSitename;
		return $wgSitename;
	}
}
