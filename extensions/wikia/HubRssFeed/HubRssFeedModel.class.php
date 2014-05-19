<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 04.10.13
 * Time: 13:21
 * To change this template use File | Settings | File Templates.
 */

class HubRssFeedModel extends WikiaModel {

	const THUMB_MIN_SIZE = 200;

	const MAX_DATE_LOOP = 8; // Number of historical elements

	const MIN_DATE_FOUND = 1262300400; //2010-01-01

	protected $editHubModel;

	protected $lang;

	public function __construct( $lang ) {
		parent::__construct();
		$this->setUpModel();
		$this->lang = $lang;
	}

	/*
	 * Set up EditHubModel
	 */
	private function setUpModel() {
		$this->editHubModel = new EditHubModel($this->app);
	}

	/**
	 * Get services to get data from
	 *
	 * @param $cityId
	 * @return array
	 */
	protected function getServicesV3( $cityId ) {
		return [
			'slider' => new WikiaHubsModuleSliderService( $cityId ),
			'community' => new WikiaHubsModuleFromthecommunityService( $cityId ),
			'wikiaspicks' => new WikiaHubsModuleWikiaspicksService( $cityId ),
		];
	
	}

	/*
	 * Get data from EditHubModel, sorted by timestamp DESC
	 *
	 * @param $cityId
	 * @return array
	 */
	public function getRealDataV3( $cityId ) {
		if ( $cityId === 0 ) {
			return [];
		}

		$currentData = $this->getDataFromModulesV3( $cityId );
		$timestamp = $this->editHubModel->getLastPublishedTimestamp( $cityId );

		foreach ( $currentData as &$val ) {
			$val[ 'timestamp' ] = $timestamp;

		}

		$prevTimestamp = $timestamp - 1;

		for ( $i = 0; $i < self::MAX_DATE_LOOP; $i++ ) {
			$prevTimestamp = $this->editHubModel->getLastPublishedTimestamp( $cityId, $prevTimestamp );
			$prevData = $this->getDataFromModulesV3( $cityId, $prevTimestamp );

			if ( $prevData === null ) {
				$prevTimestamp--;
				continue;
			}

			foreach ( $currentData as $url => &$val ) {
				if ( array_key_exists( $url, $prevData ) ) {
					$val[ 'timestamp' ] = $prevTimestamp;
				}
			}

			$prevTimestamp--;

		}

		$prevTimestamp++;

		foreach ( $currentData as $url => &$val ) {
			if ( $val[ 'timestamp' ] === $prevTimestamp ) {
				$val[ 'timestamp' ] = self::MIN_DATE_FOUND;
			}
		}

		$timestamps = [];
		// Obtain a list of columns
		foreach ($currentData as $key => $row) {
			$timestamps[$key]  = $row['timestamp'];
		}

		array_multisort($timestamps, SORT_DESC, $currentData);


		return $currentData;
	}

	/**
	 * Get normalized partial data from EditHubModel from given timestamp
	 * @see normalizeDataFromModules
	 *
	 * @param $cityId
	 * @return array
	 */
	protected function getDataFromModulesV3( $cityId, $timestamp = null ) {

		$services = $this->getServicesV3( $cityId );
		$data = [];

		foreach ( $services as $k => &$v ) {
			$data[ $k ] = $v->loadData( $this->editHubModel, [
				'city_id' => $cityId,
				'ts' => $timestamp
			] );
		}

		return $this->normalizeDataFromModules( $data );
	}
	
	public static function getFirstValue($data, $keys) {
		foreach ($keys as $key) {
			if (isset($data[$key])) return $data[$key];
		}
		return null;		
	}

	/**
	 * Normalize data (remove duplicates, populate title, description and image fields).
	 *
	 * @param $data
	 * @return array
	 */
	protected function normalizeDataFromModules( $data ) {
		$keysForUrl =  [ 'articleUrl', 'url', 'imageLink' ];
		$keysForTitle =  [ 'shortDesc' , 'articleTitle', 'title' ];
		$keysForDescription = ['longDesc', 'quote', 'text'];
		$keysForImage = ['photoName', 'imageAlt'];
		
		$out = [];
		
		foreach ( $data as &$result ) {
			
			if (array_key_exists("title", $result)) {
				// a single item from wikiaspicks service, which returns data in different format than others
				$itemList = [$result];
			} else {
				$itemList = array_pop( $result );
			}

			if ( is_array( $itemList ) ) {
				foreach ( $itemList as &$item ) {
					
					//removing duplicates
					$url = self::getFirstValue($item, $keysForUrl);

					if ( isset($out[ $url ]) ) {
						continue;
					}

					$out[ $url ] = [
						'title' => self::getFirstValue($item, $keysForTitle),
						'description' => self::getFirstValue($item, $keysForDescription)
					];

					$photoName = self::getFirstValue($item, $keysForImage);
					if ( $photoName ) {
						$img = $this->getThumbData( $photoName );

						if ( !empty($img->url) ) {

							$width = $img->width;
							$height = $img->height;

							if ( $width < self::THUMB_MIN_SIZE ) {
								$height = round( ($img->height * $width) / $width, 0 );
								$width = self::THUMB_MIN_SIZE;
							}

							$out[ $url ][ 'img' ] = [
								'url' => $img->url,
								'width' => $width,
								'height' => $height
							];
						}
					}
				}
			}
		}

		return $out;
	}

	/**
	 * Get thumbnail for given image.
	 *
	 * @param $fileName
	 * @return stdClass
	 */
	public function getThumbData( $fileName ) {
		return ImagesService::getLocalFileThumbUrlAndSizes($fileName, 0, ImagesService::EXT_JPG);

	}

}
