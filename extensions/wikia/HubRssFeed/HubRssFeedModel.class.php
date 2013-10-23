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
	protected $marketingToolboxModel;

	protected $lang;

	public function __construct( $lang ) {
		parent::__construct();
		$this->setUpModel();
		$this->lang = $lang;
	}


	private function setUpModel() {
		$this->marketingToolboxModel = new MarketingToolboxModel($this->app);
	}


	public function isValidVerticalId( $verticalId ) {
		$ids = $this->marketingToolboxModel->getVerticalsIds();
		return in_array( $verticalId, $ids );

	}

	/**
	 * @param $verticalId
	 * @return array
	 */
	protected function getServices( $verticalId ) {

		return [
			'slider' => new MarketingToolboxModuleSliderService($this->lang, MarketingToolboxModel::SECTION_HUBS, $verticalId),
			'community' => new MarketingToolboxModuleFromthecommunityService($this->lang, MarketingToolboxModel::SECTION_HUBS, $verticalId)
		];

	}


	public function getRealData( $verticalId ) {

		$currentData = $this->getDataFromModules( $verticalId );
		$timestamp = $this->marketingToolboxModel->getLastPublishedTimestamp( $this->lang, MarketingToolboxModel::SECTION_HUBS, $verticalId );

		foreach ( $currentData as &$val ) {
			$val[ 'timestamp' ] = $timestamp;

		}

		$prevTimestamp = $timestamp - 1;

		for ( $i = 0; $i < self::MAX_DATE_LOOP; $i++ ) {
			$prevTimestamp = $this->marketingToolboxModel->getLastPublishedTimestamp( $this->lang, MarketingToolboxModel::SECTION_HUBS, $verticalId, $prevTimestamp );
			$prevData = $this->getDataFromModules( $verticalId, $prevTimestamp );

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
	protected function getDataFromModules( $verticalId, $timestamp = null ) {

		$services = $this->getServices( $verticalId );

		foreach ( $services as $k => &$v ) {
			$data[ $k ] = $v->loadData( $this->marketingToolboxModel, [
				'lang' => $this->lang,
				'vertical_id' => $verticalId,
				'ts' => $timestamp
			] );
		}


		$out = array();

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
