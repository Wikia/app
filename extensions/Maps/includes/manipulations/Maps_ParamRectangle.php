<?php
class MapsParamRectangle extends MapsCommonParameterManipulation {

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
		$rectData = explode( ':' , array_shift( $parts ) );

		$value = new MapsRectangle( $rectData[0] , $rectData[1] );

		$this->handleCommonParams( $parts , $value );

		$value = $value->getJSONObject();
	}
}