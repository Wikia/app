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
		$ready = $this->isLegacyFormat( $data ) ? $this->toNew( $data ) : $data;
		$status = WikiFactory::setVarByName( self::CURATED_CONTENT_VAR_NAME, $this->cityId, $ready );
		if ( $status ) {
			wfWaitForSlaves();
			$this->curatedContentData = $ready;
		}
		return $status;
	}

	public function hasData() {
		return !empty( $this->curatedContentData() );
	}

	/**
	 * Returns curated content sections extended with optional section (if exists)
	 * @return array
	 */
	public function getNonFeaturedSections() {
		$curated = $this->getCurated();
		$optional = $this->getOptional();
		if ( !empty( $optional ) ) {
			$curated[] = $optional;
		}
		return is_array( $curated ) ? $curated : [ ];
	}

	/**
	 * Returns filtered sections
	 * @param string $section
	 * @return array
	 */
	public function getNonFeaturedSection( $section ) {
		return array_filter( $this->getNonFeaturedSections(),
			function ( $s ) use ( $section ) {
				return $s[ 'label' ] == $section;
			} );
	}

	public function getOptional() {
		$data = $this->curatedContentData();
		return isset( $data[ 'optional' ] ) ? $data[ 'optional' ] : [ ];
	}

	public function getOptionalItems() {
		$opt = $this->getOptional();
		return isset( $opt[ 'items' ] ) ? $opt[ 'items' ] : [ ];
	}

	public function getCurated() {
		$data = $this->curatedContentData();
		return isset( $data[ 'curated' ] ) ? $data[ 'curated' ] : [ ];
	}

	public function getFeatured() {
		$data = $this->curatedContentData();
		return isset( $data[ 'featured' ] ) ? $data[ 'featured' ] : [ ];
	}

	public function getFeaturedItems() {
		$opt = $this->getFeatured();
		return isset( $opt[ 'items' ] ) ? $opt[ 'items' ] : [ ];
	}

	public function getCommunityData() {
		$data = $this->curatedContentData();

		return isset( $data[ 'community_data' ] ) ? $data[ 'community_data' ] : [ ];
	}

	public function getCommunityDescription() {
		$data = $this->getCommunityData();

		return isset( $data[ 'description' ] ) ? $data[ 'description' ] : "";
	}

	public function getCommunityImageId() {
		$data = $this->getCommunityData();

		return isset( $data[ 'image_id' ] ) ? $data[ 'image_id' ] : 0;
	}

	private function curatedContentData() {
		if ( empty( $this->curatedContentData ) ) {
			$raw = WikiFactory::getVarValueByName( self::CURATED_CONTENT_VAR_NAME, $this->cityId );

			if ( !is_array( $raw ) ) {
				$this->curatedContentData = [ ];
			} else {
				// transformation for transition phase
				$this->curatedContentData = $this->isLegacyFormat( $raw ) ?
					$this->toNew( $raw ) : $raw;
			}
		}

		return $this->curatedContentData;
	}

	private function toNew( $data ) {
		$result = [ ];
		foreach ( $data as $section ) {
			$extended = [
				// use label if set
				'label' => isset( $section[ 'label' ] ) ? $section[ 'label' ]
					// or title as fallback
					: ( isset( $section[ 'title' ] ) ? $section[ 'title' ] : "" ),
				'image_id' => isset( $section[ 'image_id' ] ) ? $section[ 'image_id' ] : 0,
				'items' => isset( $section[ 'items' ] ) ? $section[ 'items' ] : [ ]
			];
			if ( isset( $section[ 'image_crop' ] ) ) {
				$extended[ 'image_crop' ] = $section[ 'image_crop' ];
			}

			//figure out what type of section it is
			if ( $section[ 'featured' ] ) {
				$result[ 'featured' ] = $extended;
			} elseif ( $section[ 'community_data' ] == 'true' ) {
				$result[ 'community_data' ] = [
					'description' => $section[ 'description' ],
					'image_id' => isset( $section[ 'image_id' ] ) ? $section[ 'image_id' ] : 0
				];
			} elseif ( empty( $extended[ 'label' ] ) ) {
				$result[ 'optional' ] = $extended;
			} else {
				$result[ 'curated' ][] = $extended;
			}
		}

		return $result;
	}

	/**
	 * Needs to be removed after migration of wgWikiaCuratedContent
	 * to new format
	 *
	 * @param $curatedContent array
	 * @return bool true if wgWikiaCuratedContent has old format
	 */
	private function isLegacyFormat( $curatedContent ) {
		return ( array_values( $curatedContent ) === $curatedContent );
	}
}
