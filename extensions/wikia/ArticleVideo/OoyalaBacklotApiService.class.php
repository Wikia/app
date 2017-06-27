<?php

class OoyalaBacklotApiService {
	private $api;

	public function __construct() {
		global $wgOoyalaApiConfig;

		$this->api = new OoyalaApi(
			$wgOoyalaApiConfig['AppId'],
			$wgOoyalaApiConfig['AppKey']
		);
	}

	//TODO use memcache
	public function getLabels( string $videoId ): array {
		$labels = [];

		try {
			$result = $this->api->get(
				'assets/' . $videoId,
				[
					'include' => 'labels'
				]
			);

			if ( !empty( $result->labels ) ) {
				foreach ( $result->labels as $label ) {
					$labels[] = $label->full_name;
				}
			}
		} catch ( OoyalaRequestErrorException $exception ) {
			// On error, we return an empty array
		}

		return $labels;
	}
}
