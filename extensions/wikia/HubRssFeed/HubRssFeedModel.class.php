<?php

class HubRssFeedModel extends WikiaModel {

	const THUMB_MIN_SIZE = 200;

	const MAX_DATE_LOOP = 8; // Number of historical elements

	const MIN_DATE_FOUND = 1262300400; //2010-01-01
	
	/**
	 * @var MarketingToolboxModel
	 */
	protected $marketingToolboxV3Model;

	protected $lang;

	public function __construct( $lang ) {
		parent::__construct();
		$this->setUpModel();
		$this->lang = $lang;
	}

	/*
	 * Set up marketing toolbox model (HubsV3)
	 */
	private function setUpModel() {
		$this->marketingToolboxV3Model = new MarketingToolboxV3Model($this->app);
	}

	/**
	 * Get services to get data from (for HubsV3)
	 *
	 * @param $cityId
	 * @return array
	 */
	protected function getServicesV3( $cityId ) {
		$services =  [
			'slider' => new MarketingToolboxModuleSliderService($this->lang, MarketingToolboxV3Model::SECTION_HUBS, 0, $cityId, MarketingToolboxV3Model::VERSION),
			'community' => new MarketingToolboxModuleFromthecommunityService($this->lang, MarketingToolboxV3Model::SECTION_HUBS, 0, $cityId, MarketingToolboxV3Model::VERSION),
			'wikiaspicks' => new MarketingToolboxModuleWikiaspicksService($this->lang, MarketingToolboxV3Model::SECTION_HUBS, 0, $cityId, MarketingToolboxV3Model::VERSION),
			'explore'  => new MarketingToolboxModuleExploreService( $this->lang, MarketingToolboxV3Model::SECTION_HUBS, 0, $cityId, MarketingToolboxV3Model::VERSION )
		];
		return $services;
	}


	/*
	 * Get data from MarketingToolboxModelV3, sorted by timestamp DESC
	 *
	 * @param $cityId
	 * @return array
	 */
	public function getRealDataV3( $cityId, $prevTimestamp = null ) {
		if ( $cityId === 0 ) {
			return [];
		}

		$params = [
			'sectionId' => MarketingToolboxV3Model::SECTION_HUBS,
			'cityId' => $cityId,
		];

		$currentData = $this->getDataFromModulesV3( $cityId );
		$timestamp = $this->marketingToolboxV3Model->getLastPublishedTimestamp( $params,$prevTimestamp );

		foreach ( $currentData as &$val ) {
			$val[ 'timestamp' ] = $timestamp;

		}

		$prevTimestamp = $timestamp - 1;

		for ( $i = 0; $i < self::MAX_DATE_LOOP; $i++ ) {
			$prevTimestamp = $this->marketingToolboxV3Model->getLastPublishedTimestamp( $params, $prevTimestamp );

			$prevData = null;
			if( $prevTimestamp ){
				$prevData = $this->getDataFromModulesV3( $cityId, $prevTimestamp );
			}

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
		$currentData = $this->fakeOrderItems($currentData);

		return $currentData;
	}

	protected function fakeOrderItems( $currentData ){
		$prevTimestamp = 0;
		foreach($currentData as &$item){
			if($prevTimestamp === $item['timestamp']){
				$item['timestamp'] --;
			}elseif($prevTimestamp > 0 && $item['timestamp'] > $prevTimestamp){
				$item['timestamp'] = $prevTimestamp - 1;
			}
			$prevTimestamp = $item['timestamp'];
		}
		return $currentData;
	}



	/**
	 * Get normalized partial data from MarketingToolboxModelV3 from given timestamp
	 * @see normalizeDataFromModules
	 *
	 * @param $cityId
	 * @return array
	 */
	protected function getDataFromModulesV3( $cityId, $timestamp = null ) {

		$services = $this->getServicesV3( $cityId );
		$data = [];

		foreach ( $services as $k => &$v ) {
			$data[ $k ] = $v->loadData( $this->marketingToolboxV3Model, [
				'city_id' => $cityId,
				'ts' => $timestamp
			] );
		}

		if(array_key_exists('explore', $data)){
			$data['explore'] = ['links'=>$data['explore']['linkgroups'][1]['links']];
		}

		$ret =  $this->normalizeDataFromModules( $data, $cityId );

		$ret = $this->removeNonValidUrls($ret);

		return $ret;
	}

	public function removeNonValidUrls($data){
		foreach($data as $key=>&$item){
			if(preg_match('~(\.com$)|(/File:)|(/Image:)~',$key)){
				unset($data[$key]);
			}
		}
		return $data;
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
	protected function normalizeDataFromModules( $data, $cityId ) {
		$keysForUrl =  [ 'articleUrl', 'url', 'imageLink','href' ];
		$keysForTitle =  [ 'shortDesc' , 'articleTitle', 'title', 'anchor' ];
		$keysForDescription = ['longDesc', 'quote', 'text', 'anchor'];
		$keysForImage = [ 'photoName', 'imageAlt' ];
		
		$out = [];
		
		foreach ( $data as $module => &$result ) {
			
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
						'description' => self::getFirstValue($item, $keysForDescription),
						'module' => $module
					];

					$photoName = self::getFirstValue( $item, $keysForImage );
					if ( $photoName ) {
						$img = $this->getThumbData( $photoName, $cityId );
						if ( !empty($img['url']) ) {

							$width = $img['width'];
							$height = $img['height'];

							if ( $width < self::THUMB_MIN_SIZE ) {
								$height = round( ($img['height'] * $width) / $width, 0 );
								$width = self::THUMB_MIN_SIZE;
							}

							$out[ $url ][ 'img' ] = [
								'url' => $img[ 'url' ],
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
	 * @param $cityId
	 */
	protected function getThumbData( $fileName, $cityId ) {
		$f = GlobalFile::newFromText( $fileName, $cityId );
		if ( $f instanceof GlobalFile && $f->exists() ) {
			return [ 'url' => $f->getUrl(), 'width' => $f->getWidth(), 'height' => $f->getHeight() ];
		} else {
			return [ 'url' => '', 'width' => null, 'height' => null ];
		}
	}

}
