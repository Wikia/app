<?php

/**
 * Class LyricsApiBase
 *
 * @desc Keeps data and methods which are being reused in API controller and maintenance scripts
 */
class LyricsApiBase {
	const TYPE_ARTIST = 'artist';
	const TYPE_ALBUM = 'album';
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

	public function getAdapterOptions( $master = false ) {
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

	public function getConfig( $master = false ) {
		$config = array_merge(
			$this->baseConfig,
			[ 'adapteroptions' => $this->getAdapterOptions( $master ) ]
		);

		return $config;
	}

}
