<?php

class CommunityDataService extends WikiaService {
	const CURATED_CONTENT_VAR_NAME = 'wgWikiaCuratedContent';
	private $curatedContentData = [ ];

	private $cityId;

	function __construct( $cityId ) {
		parent::__construct();
		$this->cityId = $cityId;
	}

	public function setCuratedContent( $data ) {
		$ready = $this->isOldFormat( $data ) ? $this->toNew( $data ) : $data;
		$status = WikiFactory::setVarByName( self::CURATED_CONTENT_VAR_NAME, $this->cityId, $ready );
		if ( $status ) {
			wfWaitForSlaves();
		}
		return $status;
	}

	public function getCuratedContent( $useLegacyFormat = false ) {
		$data = $this->curatedContentData();
		return $useLegacyFormat ? $this->toOld( $data ) : $data;
	}

	private function curatedContentData() {
		if ( empty( $this->curatedContentData ) ) {
			$raw = WikiFactory::getVarValueByName( self::CURATED_CONTENT_VAR_NAME, $this->cityId );

			if ( !is_array( $raw ) ) {
				$this->curatedContentData = [ ];
			} else {
				// transformation for transition phase
				$this->curatedContentData = $this->isOldFormat( $raw ) ?
					$this->toNew( $raw ) : $raw;
			}
		}

		return $this->curatedContentData;
	}

	private function toNew( $data ) {
		$result = [ ];
		foreach ( $data as $section ) {
			$extended = [
				'label' => $section[ 'title' ],
				'image_id' => $section[ 'image_id' ],
				'items' => $section[ 'items' ]
			];

			//figure out what type of section it is
			if ( $section[ 'featured' ] ) {
				$result[ 'featured' ] = $extended;
			} elseif ( empty( $section[ 'title' ] ) ) {
				$result[ 'optional' ] = $extended;
			} else {
				$result[ 'curated' ][] = $extended;
			}
		}

		return $result;
	}

	private function toOld( $data ) {
		$data[ 'featured' ][ 'featured' ] = true;

		$result = [ $data[ 'featured' ] ];
		$result = array_merge( $result, $data[ 'curated' ] );
		$result[] = $data[ 'optional' ];

		return array_map( function ( $section ) {
			$section[ 'title' ] = $section[ 'label' ];
			unset( $section[ 'label' ] );
			return $section;
		}, $result );
	}

	/**
	 * Needs to be removed after migration of wgWikiaCuratedContent
	 * to new format
	 *
	 * @param $curatedContent array
	 * @return bool true if wgWikiaCuratedContent has old format
	 */
	private function isOldFormat( $curatedContent ) {
		return ( array_values( $curatedContent ) === $curatedContent );
	}

	public function getData() {
		return $this->curatedContentData();
	}

	public function getCommunityData() {
		$data = $this->curatedContentData();

		return isset( $data[ 'community_data' ] ) ? $data[ 'community_data' ] : [ ];
	}

	public function getCommunityDescription() {
		$data = $this->curatedContentData();

		return isset( $data[ 'community_data' ][ 'description' ] ) ? $data[ 'community_data' ][ 'description' ] : "";
	}

	public function getCommunityImageId() {
		$data = $this->curatedContentData();

		return isset( $data[ 'community_data' ][ 'image_id' ] ) ? $data[ 'community_data' ][ 'image_id' ] : 0;
	}
}
