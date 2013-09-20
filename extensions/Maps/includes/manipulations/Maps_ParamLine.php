<?php
class MapsParamLine extends MapsCommonParameterManipulation {


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
	public function doManipulation( &$value , Parameter $parameter , array &$parameters ) {
		$parts = explode( $this->metaDataSeparator , $value );
		$lineCoords = explode( ':' , array_shift( $parts ) );

		$value = new MapsLine( $lineCoords );
		$this->handleCommonParams( $parts , $value );

		$value = $value->getJSONObject();
	}
}