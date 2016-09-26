<?php

namespace Wikia\Search;

use \Wikia\Logger\WikiaLogger;

class FandomSearch {
	const FANDOM_API = 'http://fandom.wikia.com/wp-json/wp/v2/';
	const FANDOM_API_POSTS_ENDPOINT = 'posts';
	const FANDOM_SEARCH_PAGE = 'http://fandom.wikia.com/?s=';
	const RESULTS_COUNT = 5;
	const VERTICALS_PARENT_CATEGORY_ID = 3;
	const CATEGORY_TAXONOMY_NAME = 'category';
	const CACHE_TTL = 12 * 60 * 60;

	public static function getStoriesWithCache( $query ) {
		return \WikiaDataAccess::cache(
			wfSharedMemcKey( 'FandomSearch', $query ),
			static::CACHE_TTL,
			function() use ( $query ) {
				return static::getStories( $query );
			}
		);
	}

	public static function getStories( $query ) {
		$url = static::buildUrl( $query );
		$method = 'GET';
		$options = [
			'curlOptions' => [
				// TODO set when we use internal copy
				//CURLOPT_TIMEOUT_MS => 1000,
				CURLOPT_NOSIGNAL => true,
			],
			'noProxy' => true
		];
		$log = WikiaLogger::instance();

		$result = \Http::request( $method, $url, $options );
		if ( !empty( $result ) ) {
			return static::parseResult( $result );
		}

		$loggingParams['request'] = [
			'url' => $url,
			'method' => $method,
			'options' => $options,
		];
		$log->debug( 'Empty response from fandom search API', $loggingParams );

		return [];
	}

	public static function getViewMoreLink( $stories, $query ) {
		if ( count( $stories ) === static::RESULTS_COUNT ) {
			return static::FANDOM_SEARCH_PAGE . urlencode( $query );
		}

		return null;
	}

	private static function buildUrl( $query ) {
		return static::FANDOM_API . static::FANDOM_API_POSTS_ENDPOINT . '?' . http_build_query(
			[
				'search' => $query,
				'per_page' => static::RESULTS_COUNT,
				'_embed' => 1
			]
		);
	}

	private static function parseResult( $result ) {
		$stories = json_decode( $result );
		$out = [];

		foreach ( $stories as $story ) {
			$out[] = [
				'title' => $story->title->rendered,
				'excerpt' => $story->excerpt->rendered,
				'vertical' => static::getVertical( $story ),
				'image' => $story->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->thumbnail->source_url,
				'url' => $story->link
			];
		}

		return $out;
	}

	private static function getVertical( $story ) {
		foreach ( $story->_embedded->{'wp:term'} as $wpTerms ) {
			foreach ( $wpTerms as $wpTerm ) {

				if ( $wpTerm->taxonomy !== static::CATEGORY_TAXONOMY_NAME ) {
					// break entire loop if wpTerm isn't a category. All wpTerms in this array are of the same type
					break;
				}

				$parentLinkParts = explode( '/', $wpTerm->_links->up[0]->href );
				if ( (int) $parentLinkParts[ count( $parentLinkParts ) - 1 ] === static::VERTICALS_PARENT_CATEGORY_ID ) {
					return $wpTerm->name;
				}
			}
		}

		return null;
	}
}
