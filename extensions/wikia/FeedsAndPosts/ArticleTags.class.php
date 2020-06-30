<?php


namespace Wikia\FeedsAndPosts;


use DataMartService;
use LinkSuggest;
use Title;
use WebRequest;

class ArticleTags {
	const SEARCH_TAGS_LIMIT = 6;

	public function getPopularTags() {
		global $wgCityId;

		$mainPageId = Title::newMainPage()->getArticleID();
		$articleIds = array_keys( DataMartService::getTopArticlesByPageview( $wgCityId, [], [ 0 ], false, 21 ));

		$titles = Title::newFromIDs( $articleIds );
		$imageServing = new \ImageServing( $articleIds, 200 );
		$images = $imageServing->getImages( 1 );

		$tags = [];
		foreach ( $titles as $title ) {
			$articleId = $title->getArticleID();
			if ( $articleId != $mainPageId ) {
				$tags[$articleId] = [
					'siteId' => (string)$wgCityId,
					'articleId' => (string)$articleId,
					'articleTitle' => $title->getText(),
					'relativeUrl' => $title->getLocalURL(),
					'image' => !empty($images[$articleId])
						? $images[$articleId][0]['url']
						: ''
				];
			}
		}

		// return items in the order from DataMartService::getTopArticlesByPageview
		$tagsSorted = [];
		foreach ( $articleIds as $id ) {
			if ( array_key_exists( $id, $tags ) ) {
				$tagsSorted[] = $tags[$id];
			}
		}

		return $tagsSorted;
	}

	public function searchTags( string $query ) {
		global $wgCityId;

		$request = new WebRequest();
		$request->setVal( 'format', 'array' );
		$request->setVal( 'query', $query );
		$request->setVal( 'limit', 20 );

		$linkSuggestions = LinkSuggest::getLinkSuggest( $request );

		if ( !is_array( $linkSuggestions ) ) {
			$linkSuggestions = [];
		}

		$titles = Title::newFromIDs( array_map( 'intval', array_keys( $linkSuggestions ) ) );

		$tags = [];
		foreach ( $titles as $title ) {
			if ( $title->isRedirect() ) {
				continue;
			}

			$tags[$title->getArticleID()] = [
				'siteId' => (string)$wgCityId,
				'articleId' => (string)$title->getArticleID(),
				'articleTitle' => $title->getText(),
				'relativeUrl' => $title->getLocalURL(),
			];
		}

		// return items in the order from LinkSuggest
		$tagsSorted = [];
		foreach ( array_keys( $linkSuggestions ) as $id ) {
			if ( count( $tagsSorted ) >= self::SEARCH_TAGS_LIMIT ) {
				break;
			}

			if ( array_key_exists( $id, $tags ) ) {
				$tagsSorted[] = $tags[$id];
			}
		}

		return $tagsSorted;
	}
}