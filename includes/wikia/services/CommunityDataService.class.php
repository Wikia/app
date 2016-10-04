<?php

class CommunityDataService extends WikiaService {
	const CURATED_CONTENT_VAR_NAME = 'wgWikiaCuratedContent';
	const FEATURED_SECTION = 'featured';
	const CURATED_SECTION = 'curated';
	const OPTIONAL_SECTION = 'optional';
	const COMMUNITY_DATA_SECTION = 'community_data';

	private $curatedContentData = [ ];
	private $cityId;

	function __construct( $cityId ) {
		parent::__construct();
		$this->cityId = $cityId;
	}

	public function setCuratedContent( $data, $reason = null ) {
		$ready = $this->isLegacyFormat( $data ) ? $this->toNew( $data ) : $data;
		$status = WikiFactory::setVarByName( self::CURATED_CONTENT_VAR_NAME, $this->cityId, $ready, $reason );
		if ( $status ) {
			wfWaitForSlaves();
			$this->curatedContentData = $ready;
		}
		return $status;
	}

	public function hasData() {
		$data = $this->curatedContentData();

		return !empty( $data ) &&
			   ( !$this->isCommunityDataEmpty( $data ) ||
				 !$this->isSectionEmpty( $data, self::FEATURED_SECTION ) ||
				 !$this->isSectionEmpty( $data, self::CURATED_SECTION ) ||
				 !$this->isSectionEmpty( $data, self::OPTIONAL_SECTION ) );
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
		return $this->getSection( self::OPTIONAL_SECTION );
	}

	public function getOptionalItems() {
		$opt = $this->getOptional();
		return isset( $opt[ 'items' ] ) ? $opt[ 'items' ] : [ ];
	}

	public function getCurated() {
		return $this->getSection( self::CURATED_SECTION );
	}

	public function getFeatured() {
		return $this->getSection( self::FEATURED_SECTION );
	}

	public function getFeaturedItems() {
		$opt = $this->getFeatured();
		return isset( $opt[ 'items' ] ) ? $opt[ 'items' ] : [ ];
	}

	public function getCommunityData() {
		$data = $this->curatedContentData();

		return !$this->isCommunityDataEmpty( $data ) ? $data[ self::COMMUNITY_DATA_SECTION ] : [ ];
	}

	public function getCommunityDescription() {
		$data = $this->getCommunityData();

		return isset( $data[ 'description' ] ) ? $data[ 'description' ] : "";
	}

	public function getCommunityImageId() {
		$data = $this->getCommunityData();

		return isset( $data[ 'image_id' ] ) ? $data[ 'image_id' ] : 0;
	}

	/** format of returned data:
	   'featured' => [
			'items' => [
				'article_id' => int,
				'image_id' => int,
				'label' => string,
				'title' => string,
				'type' => "article",
			]],
		'curated' => [
			[
				'label' : string
				'article_id': int,
				'image_id': int,
				'image_url' : string
				'image_crop': {},
				'items': [
					'article_id' => int,
					'image_id' => int,
					'items' => "",
					'label' => string,
					'title' => string,
					'type' => "article",
					'image_url' => string
					'node_type' => "item"
				]],
			...
			[]
		],
		'optional' => [
			'label' => string,
			'items' => [
				[
					'article_id': int,
					'image_id': int,
					'image_crop': {},
					'items': "",
					'label': string,
					'title': string,
					'type': "category",
					'image_url': string
					'node_type': "item"
				],
				[]
			]],
		'community_data' => [
			'description' => string,
			'image_id': int,
			'image_crop': {},
			'node_type': "section"
		]]
	 */
	public function getCuratedContentData() {
		return $this->curatedContentData();
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
			if ( $section[ self::FEATURED_SECTION ] ) {
				$result[ self::FEATURED_SECTION ] = $extended;
			} elseif ( $section[ self::COMMUNITY_DATA_SECTION ] == 'true' ) {
				$result[ self::COMMUNITY_DATA_SECTION ] = [
					'description' => $section[ 'description' ],
					'image_id' => isset( $section[ 'image_id' ] ) ? $section[ 'image_id' ] : 0
				];
			} elseif ( empty( $extended[ 'label' ] ) ) {
				$result[ self::OPTIONAL_SECTION ] = $extended;
			} else {
				$result[ self::CURATED_SECTION ][] = $extended;
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

	/**
	 * @param $data
	 * @return bool
	 */
	private function isCommunityDataEmpty( $data ) {
		return !isset( $data[ self::COMMUNITY_DATA_SECTION ] ) ||
			   ( empty( $data[ self::COMMUNITY_DATA_SECTION ][ 'description' ] ) &&
				 $data[ self::COMMUNITY_DATA_SECTION ][ 'image_id' ] == 0 );
	}

	private function isSectionEmpty( $data, $section ) {
		return !isset( $data[ $section ] ) ||
			   empty( $data[ $section ] );
	}

	private function getSection( $section ) {
		$data = $this->curatedContentData();
		return $this->isSectionEmpty( $data, $section ) ? [ ] : $data[ $section ];
	}
}
