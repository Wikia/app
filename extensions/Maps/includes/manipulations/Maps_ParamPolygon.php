<?php
class MapsParamPolygon extends MapsParamLine {


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
		$polygonCoords = explode( ':' , array_shift( $parts ) );

		$value = new MapsPolygon( $polygonCoords );

		$this->handleCommonParams( $parts , $value );

		$value = $value->getJSONObject();
	}
}