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
	 * @var String WMS Style name (default value: 'default')
	 */
	private $wmsStyleName;

	public function __construct( string $wmsServerUrl, string $wmsLayerName, string $wmsStyleName = "default" ) {
		parent::__construct();
		$this->setWmsServerUrl( $wmsServerUrl );
		$this->setWmsLayerName( $wmsLayerName );
		$this->setWmsStyleName( $wmsStyleName );
	}

	public function getJSONObject( string $defText = '', string $defTitle = '' ): array {
		$parentArray = parent::getJSONObject( $defText, $defTitle );

		$array = [
			'wmsServerUrl' => $this->getWmsServerUrl(),
			'wmsLayerName' => $this->getWmsLayerName(),
			'wmsStyleName' => $this->getWmsStyleName()
		];
		return array_merge( $parentArray, $array );
	}

	public function getWmsServerUrl(): string {
		return $this->wmsServerUrl;
	}

	public function setWmsServerUrl( string $wmsServerUrl ) {
		$this->wmsServerUrl = $wmsServerUrl;
	}

	public function getWmsLayerName(): string {
		return $this->wmsLayerName;
	}

	public function setWmsLayerName( string $wmsLayerName ) {
		$this->wmsLayerName = $wmsLayerName;
	}

	public function getWmsStyleName(): string {
		return $this->wmsStyleName;
	}

	public function setWmsStyleName( string $wmsStyleName ) {
		$this->wmsStyleName = $wmsStyleName;
	}

}
