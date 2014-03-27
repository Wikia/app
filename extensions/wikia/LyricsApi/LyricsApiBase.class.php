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

	private $baseConfig = [
		'adapter' => 'Solarium_Client_Adapter_Curl',
		'adapteroptions' => [
			'path' => '/solr/',
			'core' => 'lyricsapi'
		]
	];

	private $masterConfig = [
		'adapteroptions' => [
			'host' => 'search-s16',
			'port' => 8983,
		]
	];

	private $slaveConfig = [
		'adapteroptions' => [
			'host' => 'search',
			'port' => null,
			'proxy' => '127.0.0.1:6081'
		]
	];

	private $devboxConfig = [
		'adapteroptions' => [
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
		if( F::app()->wg->DevelEnvironment ) {
			return array_merge(
				$this->baseConfig['adapteroptions'],
				$this->devboxConfig['adapteroptions']
			);
		}

		if( $master ) {
			$adapterOptions = array_merge(
				$this->baseConfig['adapteroptions'],
				$this->masterConfig['adapteroptions']
			);
		} else {
			$adapterOptions = array_merge(
				$this->baseConfig['adapteroptions'],
				$this->slaveConfig['adapteroptions']
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
			[ 'adapteroptions' => $this->getAdapterOptions( $master ) ]
		);

		return $config;
	}

}
