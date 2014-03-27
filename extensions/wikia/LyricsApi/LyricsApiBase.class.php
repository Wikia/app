<?php

/**
 * Class LyricsApiBase
 *
 * @desc Keeps data and methods which are being reused in API controller and maintenance scripts
 */
class LyricsApiBase {
	/**
	 * @desc Field type in lyricsapi solr index which describes an artist
	 */
	const TYPE_ARTIST = 'artist';

	/**
	 * @desc Field type in lyricsapi solr index which describes an album
	 */
	const TYPE_ALBUM = 'album';

	/**
	 * @desc Field type in lyricsapi solr index which describes a song
	 */
	const TYPE_SONG = 'song';

	/**
	 * @desc Name of the adapter options configuration element in configuration array
	 */
	const ADAPTER_OPTIONS_ELEMENT_NAME = 'adapteroptions';

	/**
	 * @desc A flag which ignores if it's a dev environment or not; default === false
	 * @var bool
	 */
	private $skipDevboxCheck = false;

	private $baseConfig = [
		'adapter' => 'Solarium_Client_Adapter_Curl',
		self::ADAPTER_OPTIONS_ELEMENT_NAME => [
			'path' => '/solr/',
			'core' => 'lyricsapi'
		]
	];

	private $masterConfig = [
		self::ADAPTER_OPTIONS_ELEMENT_NAME => [
			'host' => 'search-s16',
			'port' => 8983,
		]
	];

	private $slaveConfig = [
		self::ADAPTER_OPTIONS_ELEMENT_NAME => [
			'host' => 'search',
			'port' => null,
			'proxy' => '127.0.0.1:6081'
		]
	];

	private $devboxConfig = [
		self::ADAPTER_OPTIONS_ELEMENT_NAME => [
			'host' => 'dev-search-s4',
			'port' => 8983,
		]
	];

	/**
	 * @desc Returns an array with adapteroptions for Solarium_Client config (on devboxes the $master doesn't count)
	 * @param bool $master a flag - return the options for master; default === false
	 *
	 * @return array
	 */
	public function getAdapterOptions( $master = false ) {
		if( F::app()->wg->DevelEnvironment && !$this->skipDevboxCheck ) {
			return array_merge(
				$this->baseConfig[ self::ADAPTER_OPTIONS_ELEMENT_NAME ],
				$this->devboxConfig[ self::ADAPTER_OPTIONS_ELEMENT_NAME ]
			);
		}

		if( $master ) {
			$adapterOptions = array_merge(
				$this->baseConfig[ self::ADAPTER_OPTIONS_ELEMENT_NAME ],
				$this->masterConfig[ self::ADAPTER_OPTIONS_ELEMENT_NAME ]
			);
		} else {
			$adapterOptions = array_merge(
				$this->baseConfig[ self::ADAPTER_OPTIONS_ELEMENT_NAME ],
				$this->slaveConfig[ self::ADAPTER_OPTIONS_ELEMENT_NAME ]
			);
		}

		return $adapterOptions;
	}

	/**
	 * @desc Returns configuration for Solarium_Client
	 * @param bool $master a flag which gets the config for master or slave; default === slave
	 *
	 * @return array
	 */
	public function getConfig( $master = false ) {
		$config = array_merge(
			$this->baseConfig,
			[ self::ADAPTER_OPTIONS_ELEMENT_NAME => $this->getAdapterOptions( $master ) ]
		);

		return $config;
	}

	/**
	 * @desc Sets skipDevboxCheck to true
	 */
	public function skipDevboxCheck() {
		$this->skipDevboxCheck = true;
	}

}
