<?php
class MapsParamImageOverlay extends MapsCommonParameterManipulation {

	protected $metaDataSeparator;

	public function __construct( $metaDataSeparator ) {
		parent::__construct();

		$this->metaDataSeparator = $metaDataSeparator;
	}

	/**
	 * Manipulate an actual value.
	 *
	 * @param string $value
	 * @param Parameter $parameter
	 * @param array $parameters
	 *
	 * @since 0.4
	 *
	 * @return mixed
	 */
	protected function doManipulation( &$value , Parameter $parameter , array &$parameters ) {
		$parts = explode( $this->metaDataSeparator , $value );
		$overlayData = explode( ':' , str_replace(
			array('https://','http://'),
			'//',
			array_shift( $parts ))
		);

		$value = new MapsImageOverlay( $overlayData[0] , $overlayData[1], $overlayData[2] );

		$this->handleCommonParams( $parts , $value );

		$value = $value->getJSONObject();
	}
}