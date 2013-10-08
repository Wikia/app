<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 04.10.13
 * Time: 13:21
 * To change this template use File | Settings | File Templates.
 */

class HubRssFeedModel extends WikiaModel {


	const MAX_DATE_LOOP = 8;

	const MIN_DATE_FOUND = 1262300400; //2010-01-01

	/**
	 * @var MarketingToolboxModel
	 */
	private $marketingToolboxModel;

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
	private function getServices( $verticalId ) {

		return [
			'slider' => new MarketingToolboxModuleSliderService('en', MarketingToolboxModel::SECTION_HUBS, $verticalId),
			'community' => new MarketingToolboxModuleFromthecommunityService('en', MarketingToolboxModel::SECTION_HUBS, $verticalId)
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


		return $currentData;

	}


	/**
	 * @param $verticalId
	 *
	 */
	public function getDataFromModules( $verticalId, $timestamp = null ) {

		$services = $this->getServices( $verticalId );

		foreach ( $services as $k => &$v ) {
			$data[ $k ] = $v->loadData( $this->marketingToolboxModel, [
				'lang' => 'en',
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

					$out[ $url ] = [
						'title' => isset($item[ 'shortDesc' ]) ? $item[ 'shortDesc' ] : $item[ 'articleTitle' ],
						'description' => isset($item[ 'longDesc' ]) ? $item[ 'longDesc' ] : $item[ 'quote' ],
						'img' => isset($item[ 'photoUrl' ]) ? $item[ 'photoUrl' ] : $item[ 'imageUrl' ],
					];
				}
			}
		}

		return $out;
	}

}
