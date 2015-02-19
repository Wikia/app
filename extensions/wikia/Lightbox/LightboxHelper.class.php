<?php

/**
 * Lightbox Helper
 * @author Saipetch Kongkatong
 */
class LightboxHelper extends WikiaModel {

	const CACHE_TTL = 3600;

	/**
	 * Get list of images
	 * @param integer $limit
	 * @param string $to - timestamp
	 * @return array $imageList - array( 'images' => list of image, 'minTimestamp' => minimum timestamp of the list )
	 */
	public function getImageList( $limit, $to ) {
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( 'lightbox', 'images', $limit, $to );
		$imageList = $this->wg->Memc->get( $memKey );
		if ( !is_array( $imageList ) ) {
			$db = wfGetDB( DB_SLAVE );

			$result = $db->select(
				array( 'image' ),
				array( 'img_name, img_timestamp' ),
				array(
					"img_media_type in ('".MEDIATYPE_BITMAP."', '".MEDIATYPE_DRAWING."')",
					"img_timestamp < $to",
				),
				__METHOD__,
				array(
					'ORDER BY' => 'img_timestamp DESC',
					'LIMIT' => $limit,
				)
			);

			$images = array();
			$imageList = array( 'images' => $images, 'minTimestamp' => 0 );
			while( $row = $db->fetchObject( $result ) ) {
				$minTimestamp = $row->img_timestamp;
				$images[] = array(
					'title' => $row->img_name,
					'type' => 'image',
				);
			}

			if ( !empty( $images ) ) {
				$imageList = array(
					'images' => $images,
					'minTimestamp' => wfTimestamp( TS_MW, $minTimestamp ),
				);
			}

			$this->wg->Memc->set( $memKey, $imageList, self::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );

		return $imageList;
	}

	/**
	 * Get list of images from LatestPhotosController ( image only )
	 * @return array $latestPhotos - array( 'title' => imageName, 'type' => 'image' )
	 */
	public function getLatestPhotos() {
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( 'lightbox', 'latest_photos' );
		$latestPhotos = $this->wg->Memc->get( $memKey );
		if ( !is_array( $latestPhotos ) ) {
			$response = $this->app->sendRequest( 'LatestPhotosController', 'getLatestThumbsUrls' );
			$thumbUrls = $response->getVal( 'thumbUrls', '' );

			$latestPhotos = array();
			if ( !empty( $thumbUrls ) && is_array( $thumbUrls ) ) {
				foreach ( $thumbUrls as $thumb ) {
					$latestPhotos[] = array(
						'title' => $thumb['image_key'],
						'type' => 'image',
					);
				}
			}
			$this->wg->Memc->set( $memKey, $latestPhotos, self::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );

		return $latestPhotos;
	}

	/**
	 * Get Total number of images until specific timestamp
	 * @return array $imageInfo [ array( 'totalWikiImages' => value, 'timestamp' => value ) ]
	 */
	public function getTotalImages() {
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( 'lightbox', 'total_images' );
		$imageInfo = $this->wg->Memc->get( $memKey );
		if ( !is_array( $imageInfo ) ) {
			$db = wfGetDB( DB_SLAVE );

			$timestamp = $this->getTimestamp();
			$totalWikiImages = $db->selectField(
				array( 'image' ),
				array( 'count(*) cnt' ),
				array(
					"img_media_type in ('".MEDIATYPE_BITMAP."', '".MEDIATYPE_DRAWING."')",
					"img_timestamp < $timestamp",
				),
				__METHOD__
			);

			$imageInfo = array(
				'totalWikiImages' => intval( $totalWikiImages ),
				'timestamp' => $timestamp,
			);

			$this->wg->Memc->set( $memKey, $imageInfo, self::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );

		return $imageInfo;
	}

	/**
	 * Get minimum timestamp from LatestPhotosController or current timestamp ( image only )
	 * @return string $timestamp
	 */
	public function getTimestamp() {
		wfProfileIn( __METHOD__ );

		$response = $this->app->sendRequest( 'LatestPhotosController', 'getLatestThumbsUrls' );
		$latestPhotos = $response->getVal( 'thumbUrls', '' );

		$timestamp = wfTimestamp( TS_MW );
		if ( !empty( $latestPhotos ) && is_array( $latestPhotos ) ) {
			foreach ( $latestPhotos as $photo ) {
				$photoTimestamp = wfTimestamp( TS_MW, $photo['date'] );
				if ( $photoTimestamp < $timestamp ) {
					$timestamp = $photoTimestamp;
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $timestamp;
	}

}
