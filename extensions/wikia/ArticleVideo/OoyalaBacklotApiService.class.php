<?php

class OoyalaBacklotApiService {
	private static $instance = null;
	private $api;

	public function __construct() {
		global $wgOoyalaApiConfig;

		$this->api = new OoyalaApi(
			$wgOoyalaApiConfig['AppId'],
			$wgOoyalaApiConfig['AppKey']
		);
	}

	public static function getInstance(): self {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function getTitle( string $videoId ): string {
		$data = $this->getData( $videoId );
		$title = '';

		if ( !empty( $data ) ) {
			$title = $data->name;
		}

		return $title;
	}

	public function getDuration( string $videoId ): string {
		$data = $this->getData( $videoId );
		$duration = 0;

		if ( !empty( $data ) ) {
			$duration = WikiaFileHelper::formatDuration( $data->duration / 1000 );
		}

		return $duration;
	}

	public function getLabels( string $videoId ): array {
		$data = $this->getData( $videoId );
		$labels = [];

		if ( !empty( $data ) && !empty( $data->labels ) ) {
			foreach ( $data->labels as $label ) {
				$labels[] = $label->full_name;
			}
		}

		return $labels;
	}

	private function getData( string $videoId ) {
		return WikiaDataAccess::cache(
			wfMemcKey( __CLASS__, __METHOD__, $videoId ),
			WikiaResponse::CACHE_STANDARD,
			function () use ( $videoId ) {
				try {
					return $this->api->get(
						'assets/' . $videoId,
						[
							'include' => 'labels'
						]
					);
				} catch ( OoyalaRequestErrorException $exception ) {
					return null;
				}
			}
		);
	}
}
