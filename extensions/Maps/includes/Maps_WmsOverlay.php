<?php

/**
 * Class that holds metadata on WMS overlay layers on map
 *
 * @since 2.0
 *
 * @file Maps_WmsOverlay.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Mathias Lidal < mathiaslidal@gmail.com >
 */
class MapsWmsOverlay {

	/**
	 * @since 2.0
	 * @var String Base url to WMS server
	 */
	protected $wmsServerUrl;

	/**
	 * @since 2.0
	 * @var String WMS Layer name
	 */
	protected $wmsLayerName;

	/**
	 * @since 2.0
	 *
	 * @param string $wmsServerUrl
	 * @param string $wmsLayerName
	 */
	public function __construct( $wmsServerUrl, $wmsLayerName  ) {
		$this->setWmsServerUrl( $wmsServerUrl );
		$this->setWmsLayerName( $wmsLayerName );
	}

	/**
	 * @since 2.0
	 *
	 * @param String $wmsLayerName
	 */
	public function setWmsLayerName( $wmsLayerName ) {
		$this->wmsLayerName = $wmsLayerName;
	}

	/**
	 * @since 2.0
	 *
	 * @return String
	 */
	public function getWmsLayerName() {
		return $this->wmsLayerName;
	}

	/**
	 * @since 2.0
	 *
	 * @param String $wmsServerUrl
	 */
	public function setWmsServerUrl( $wmsServerUrl ) {
		$this->wmsServerUrl = $wmsServerUrl;
	}

	/**
	 * @since 2.0
	 *
	 * @return String
	 */
	public function getWmsServerUrl() {
		return $this->wmsServerUrl;
	}

	/**
	 * @since 2.0
	 *
	 * @return array
	 */
	public function getJSONObject() {
		return array(
			'wmsServerUrl' => $this->getWmsServerUrl(),
			'wmsLayerName' => $this->getWmsLayerName(),
		);
	}

}
