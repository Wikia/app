<?php

class CurationCMSService {
	static protected $instance = null;
	private $slug;
	private $limit;

	const API_BASE = 'https://services.wikia.com/curation-cms/stories/feed/slug/';

	const MCACHE_VER = '1.0';
	const MCACHE_TIME = 900; // 15 minutes

	public function getPosts( $slug, $limit ) {
		$this->limit = $limit;
		$this->slug = $slug;
		$memcKey = wfSharedMemcKey( __METHOD__, self::MCACHE_VER, $slug, $limit );

		return WikiaDataAccess::cache(
			$memcKey,
			self::MCACHE_TIME,
			function() {
				return $this->apiRequest();
			}
		);
	}

	private function buildUrl() {
		return self::API_BASE.$this->slug.'?limit='.$this->limit.'&postType=fandom-article';
	}

	/**
	 * Make an API request to CurationCMS to gather posts
	 * @return [] array of posts
	 */
	private function apiRequest() {
		$response = ExternalHttp::get( self::buildUrl() );
		$data = json_decode( $response, true );

		if ( isset( $data['feed'] ) && is_array( $data['feed'] ) ) {
			return $this->formatData( $data['feed'] );
		} else {
			return [];
		}
	}

	private function formatData( $rawPosts ) {
		$posts = [];

		foreach ( $rawPosts as $index => $post ) {
			$posts[] = [
				'index' => $index,
				'id' => $post['id'],
				'url' => $post['fandomUrl'],
				'thumbnail' => $post['image'],
				'title' => $post['headline'],
				'pub_date' => $post['publishAt'],
				'source' => 'stories',
			];
		}

		return $posts;
	}
}
