<?php

class WikiGetDataHelper {
	const DISPLAY_APPROVED_ONLY = "WikiGetDataHelper::displayApprovedOnly";
	const DISPLAY_ALL = "WikiGetDataHelper::displayAll";

	protected $queryFilter;

	public function __construct( callable $queryFilter = null ) {
		$this->queryFilter = $queryFilter;
	}

	public static function displayApprovedOnly( WikiaSQL $sql ) {
		$sql->AND_( 'image_review_status' )->EQUAL_TO( ImageReviewStatuses::STATE_APPROVED );
		return $sql;
	}

	public static function displayAll( WikiaSQL $sql ) {
		$sql->AND_( 'image_review_status' )->IN(
			ImageReviewStatuses::STATE_APPROVED,
			ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING,
			ImageReviewStatuses::STATE_AUTO_APPROVED,
			ImageReviewStatuses::STATE_IN_REVIEW,
			ImageReviewStatuses::STATE_REJECTED,
			ImageReviewStatuses::STATE_REJECTED_IN_REVIEW,
			ImageReviewStatuses::STATE_QUESTIONABLE,
			ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW,
			ImageReviewStatuses::STATE_UNREVIEWED
		);
		return $sql;
	}

	public function getImages( $wikiId, $langCode, $wikiRow = null ) {
		global $wgExternalSharedDB;
		$db = wfGetDB( DB_SLAVE, [ ], $wgExternalSharedDB );

		$query = ( new \WikiaSQL() )
			->SELECT( 'image_name', 'image_index', 'image_review_status' )
			->FROM( CityVisualization::CITY_VISUALIZATION_IMAGES_TABLE_NAME )
			->WHERE( 'city_id' )->EQUAL_TO( $wikiId )
			->AND_( 'image_type' )->EQUAL_TO( PromoImage::ADDITIONAL )
			->AND_( 'city_lang_code' )->EQUAL_TO( $langCode );
		if ( !empty( $this->queryFilter ) ) {
			call_user_func_array( $this->queryFilter, [ $query ] );
		}
		$query->ORDER_BY( 'last_edited DESC' );

		$wikiImages = $query->run( $db, function ( $result ) {
			$wikiImages = [ ];
			while ( $row = $result->fetchObject( $result ) ) {
				$parsed = WikiImageRowHelper::parseWikiImageRow( $row );
				$promoImage = new PromoXWikiImage( $parsed->name );
				$promoImage->setReviewStatus( $parsed->review_status );
				$wikiImages[$parsed->index] = $promoImage;
			}
			return $wikiImages;
		} );

		return $wikiImages;
	}

	/**
	 * @param $wikiId int
	 * @param $langCode String
	 * @param $imageSource object (city_visualization row)
	 * @param $currentData array
	 * @return bool
	 */
	public function getMainImage( $wikiId, $langCode, $imageSource = null, &$currentData = null ) {
		global $wgExternalSharedDB;

		$db = wfGetDB( DB_SLAVE, [ ], $wgExternalSharedDB );

		$query = ( new \WikiaSQL() )
			->SELECT( 'image_name', 'image_index', 'image_review_status' )
			->FROM( CityVisualization::CITY_VISUALIZATION_IMAGES_TABLE_NAME )
			->WHERE( 'city_id' )->EQUAL_TO( $wikiId )
			->AND_( 'city_lang_code' )->EQUAL_TO( $langCode )
			->AND_( 'image_type' )->EQUAL_TO( PromoImage::MAIN );
		if ( !empty( $this->queryFilter ) ) {
			call_user_func_array( $this->queryFilter, [ $query ] );
		}

		$query->ORDER_BY( 'last_edited DESC' );
		$promoImage = $query->run( $db, function ( $result ) {
			while ( $row = $result->fetchObject( $result ) ) {
				$parsed = WikiImageRowHelper::parseWikiImageRow( $row );

				$promoImage = new PromoXWikiImage( $parsed->name );
				$promoImage->setReviewStatus( $parsed->review_status );
				return $promoImage;
			}
		} );

		return $promoImage;
	}
}
