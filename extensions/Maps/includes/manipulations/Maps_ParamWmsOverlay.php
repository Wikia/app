<?php
class MapsParamWmsOverlay extends MapsCommonParameterManipulation {

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
		if ($value) {
			$parts = explode( $this->metaDataSeparator , $value );

			$value = new MapsWmsOverlay( $parts[0] , $parts[1] );

			$value = $value->getJSONObject();
		}
	}
}
