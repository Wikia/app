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

	const MAX_DATE_LOOP = 8;

	const MIN_DATE_FOUND = 1262300400; //2010-01-01

	/**
	 * @var MarketingToolboxModel
	 */
	protected $marketingToolboxV2Model;
	protected $marketingToolboxV3Model;

	protected $lang;

	public function __construct( $lang ) {
		parent::__construct();
		$this->setUpModel();
		$this->lang = $lang;
	}


	private function setUpModel() {
		$this->marketingToolboxV2Model = new MarketingToolboxModel($this->app);
		$this->marketingToolboxV3Model = new MarketingToolboxV3Model($this->app);
	}


	public function isValidVerticalId( $verticalId ) {
		$ids = $this->marketingToolboxV2Model->getVerticalsIds();
		return in_array( $verticalId, $ids );

	}

	/**
	 * @param $cityId
	 * @return array
	 */
	protected function getServicesV3( $cityId ) {

		return [
			'slider' => new MarketingToolboxModuleSliderService($this->lang,
					MarketingToolboxV3Model::SECTION_HUBS, null, $cityId, MarketingToolboxV3Model::VERSION),
			'community' => new MarketingToolboxModuleFromthecommunityService($this->lang,
					MarketingToolboxV3Model::SECTION_HUBS, null, $cityId, MarketingToolboxV3Model::VERSION)
		];
	}

	/**
	 * @param $verticalId
	 * @return array
	 */
	protected function getServicesV2( $verticalId ) {

		return [
			'slider' => new MarketingToolboxModuleSliderService($this->lang, MarketingToolboxModel::SECTION_HUBS, $verticalId),
			'community' => new MarketingToolboxModuleFromthecommunityService($this->lang, MarketingToolboxModel::SECTION_HUBS, $verticalId)
		];

	}

	public function getRealDataV3( $cityId ) {
		if ( $cityId === 0 ) {
			return [];
		}

		$params = [
			'sectionId' => MarketingToolboxModel::SECTION_HUBS,
			'cityId' => $cityId,
		];

		$currentData = $this->getDataFromModulesV3( $cityId );
		$timestamp = $this->marketingToolboxV3Model->getLastPublishedTimestamp( $params );

		foreach ( $currentData as &$val ) {
			$val[ 'timestamp' ] = $timestamp;

		}

		$prevTimestamp = $timestamp - 1;

		for ( $i = 0; $i < self::MAX_DATE_LOOP; $i++ ) {
			$prevTimestamp = $this->marketingToolboxV3Model->getLastPublishedTimestamp( $params, $prevTimestamp );
			$prevData = $this->getDataFromModulesV3( $cityId, $prevTimestamp );

			if ( $prevData === null ) {
				$prevTimestamp--;
				continue;
			}

			/*$keysFound = 0;*/

			foreach ( $currentData as $url => &$val ) {
				if ( array_key_exists( $url, $prevData ) ) {
					/*		$keysFound++; */
					$val[ 'timestamp' ] = $prevTimestamp;
				}
			}

			/*if ( $keysFound === 0 ) {
				break;
			}*/
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


	public function getRealDataV2( $verticalId ) {
		if ( $verticalId == 0 ) {
			return [];
		}

		$params = [
			'langCode' => $this->lang,
			'sectionId' => MarketingToolboxModel::SECTION_HUBS,
			'verticalId' => $verticalId,
		];

		$currentData = $this->getDataFromModulesV2( $verticalId );
		$timestamp = $this->marketingToolboxV2Model->getLastPublishedTimestamp( $params );

		foreach ( $currentData as &$val ) {
			$val[ 'timestamp' ] = $timestamp;

		}

		$prevTimestamp = $timestamp - 1;

		for ( $i = 0; $i < self::MAX_DATE_LOOP; $i++ ) {
			$prevTimestamp = $this->marketingToolboxV2Model->getLastPublishedTimestamp( $params, $prevTimestamp );
			$prevData = $this->getDataFromModulesV2( $verticalId, $prevTimestamp );

			if ( $prevData === null ) {
				$prevTimestamp--;
				continue;
			}

			/*$keysFound = 0;*/

			foreach ( $currentData as $url => &$val ) {
				if ( array_key_exists( $url, $prevData ) ) {
					/*		$keysFound++; */
					$val[ 'timestamp' ] = $prevTimestamp;
				}
			}

			/*if ( $keysFound === 0 ) {
				break;
			}*/
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
	 * @param $verticalId
	 *
	 */
	protected function getDataFromModulesV2( $verticalId, $timestamp = null ) {

		$services = $this->getServicesV2( $verticalId );
		$data = [];

		foreach ( $services as $k => &$v ) {
			$data[ $k ] = $v->loadData( $this->marketingToolboxV2Model, [
				'lang' => $this->lang,
				'vertical_id' => $verticalId,
				'ts' => $timestamp
			] );
		}

		return $this->normalizeDataFromModules( $data );
	}


	/**
	 * @param $cityId
	 *
	 */
	protected function getDataFromModulesV3( $cityId, $timestamp = null ) {

		$services = $this->getServicesV2( $cityId );
		$data = [];

		foreach ( $services as $k => &$v ) {
			$data[ $k ] = $v->loadData( $this->marketingToolboxV3Model, [
				'city_id' => $cityId,
				'ts' => $timestamp
			] );
		}

		return $this->normalizeDataFromModules( $data );
	}



	protected function normalizeDataFromModules( $data ) {
		$out = [];

		foreach ( $data as &$result ) {

			$itemList = array_pop( $result );

			if ( is_array( $itemList ) ) {
				foreach ( $itemList as &$item ) {
					//removing duplicates
					$url = isset($item[ 'articleUrl' ]) ? $item[ 'articleUrl' ] : $item[ 'url' ];

					if ( isset($out[ $url ]) ) {
						continue;
					}

					$out[ $url ] = [
						'title' => isset($item[ 'shortDesc' ]) ? $item[ 'shortDesc' ] : $item[ 'articleTitle' ],
						'description' => isset($item[ 'longDesc' ]) ? $item[ 'longDesc' ] : $item[ 'quote' ],
					];

					if ( !empty($item[ 'photoName' ]) ) {
						$img = $this->getThumbData( $item[ 'photoName' ] );

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


	public function getThumbData( $image ) {
		return ImagesService::getLocalFileThumbUrlAndSizes($image, 0, ImagesService::EXT_JPG);

	}

}
