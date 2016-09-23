<?php

class CuratedContentService {
	static protected $instance = null;

	const API_BASE = 'http://fandom.wikia.com/ajax/recirculation_units/';

	const MCACHE_VER = '1.0';
	const MCACHE_TIME = 900; // 15 minutes

	/**
	 * Get curated posts. Uses cache if available
	 * @return an array of posts
	 */
	public function getPosts() {

		$memcKey = wfSharedMemcKey( __METHOD__, self::MCACHE_VER );

		$data = WikiaDataAccess::cache(
			$memcKey,
			self::MCACHE_TIME,
			function() {
				return $this->apiRequest();
			}
		);

		return $data;
	}

	/**
	 * Make an API request to parsely to gather posts
	 * @param string $type
	 * @return an array of posts
	 */
	private function apiRequest( $type, $meta ) {
		$response = ExternalHttp::get( self::API_BASE );
		$data = json_decode( $response, true );

		if ( isset( $data['posts'] ) && is_array( $data['posts'] ) ) {
			return $this->formatData($data['posts']);
		} else {
			return [];
		}
	}

	private function formatData( $rawPosts ) {
		$posts = [];

		foreach ( $rawPosts as $index => $post ) {
			$posts[] = [
				'index' => $index,
				'id' => $post['post_id'],
				'url' => $post['content_url'],
				'thumbnail' => $post['thumbnail'],
				'title' => $post['title'],
				'pub_date' => $post['publish_start_date'],
				'source' => 'curated',
				'isVideo' => $post['is_video_post'],
			];
		}

		return $posts;
	}
}
