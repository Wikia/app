<?php

namespace Maps\Elements;

/**
 * Class that holds metadata on WMS overlay layers on map
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Mathias Lidal < mathiaslidal@gmail.com >
 */
class WmsOverlay extends BaseElement {

	/**
	 * @var String Base url to WMS server
	 */
	private $wmsServerUrl;

	/**
	 * @var String WMS Layer name
	 */
	private $wmsLayerName;

	/**
	 * @var String WMS Stype name (default value: 'default')
	 */
	private $wmsStyleName;

	/**
	 * @since 3.0
	 *
	 * @param string $wmsServerUrl
	 * @param string $wmsLayerName
	 * @param string $wmsStyleName
	 */
	public function __construct( $wmsServerUrl, $wmsLayerName, $wmsStyleName="default" ) {
		parent::__construct();
		$this->setWmsServerUrl( $wmsServerUrl );
		$this->setWmsLayerName( $wmsLayerName );
		$this->setWmsStyleName( $wmsStyleName );
	}

	/**
	 * @since 3.0
	 *
	 * @param String $wmsLayerName
	 */
	public function setWmsLayerName( $wmsLayerName ) {
		$this->wmsLayerName = $wmsLayerName;
	}

	/**
	 * @since 3.0
	 *
	 * @return String
	 */
	public function getWmsLayerName() {
		return $this->wmsLayerName;
	}

	/**
	 * @since 3.0
	 *
	 * @param String $wmsServerUrl
	 */
	public function setWmsServerUrl( $wmsServerUrl ) {
		$this->wmsServerUrl = $wmsServerUrl;
	}

	/**
	 * @since 3.0
	 *
	 * @return String
	 */
	public function getWmsServerUrl() {
		return $this->wmsServerUrl;
	}

	/**
	 * @since 3.0
	 *
	 * @param String $wmsStyleName
	 */
	public function setWmsStyleName( $wmsStyleName ) {
		$this->wmsStyleName = $wmsStyleName;
	}

	/**
	 * @return String
	 */
	public function getWmsStyleName() {
		return $this->wmsStyleName;
	}

	public function getJSONObject ( $defText = "", $defTitle = "" ) {
		$parentArray = parent::getJSONObject( $defText , $defTitle );

		$array = array (
			'wmsServerUrl' => $this->getWmsServerUrl() ,
			'wmsLayerName' => $this->getWmsLayerName() ,
			'wmsStyleName' => $this->getWmsStyleName()
		);
		return array_merge( $parentArray, $array );
	}

}
