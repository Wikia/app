<?php

namespace ParamProcessor\Definition;

use Exception;
use ParamProcessor\ParamDefinition;
use ParamProcessor\IParam;
use ParamProcessor\IParamDefinition;

/**
 * Defines the dimension parameter type.
 * This parameter describes the size of a dimension (ie width) in some unit (ie px) or a percentage.
 * Specifies the type specific validation and formatting logic.
 *
 * TODO: this class is silly, should be handled by a dedicated formatting object/function.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DimensionParam extends ParamDefinition {

	/**
	 * Formats the parameter value to it's final result.
	 * @see ParamDefinition::formatValue
	 *
	 * @since 1.0
	 *
	 * @param mixed $value
	 * @param IParam $param
	 * @param IParamDefinition[] $definitions
	 * @param IParam[] $params
	 *
	 * @return mixed
	 * @throws Exception
	 */
	protected function formatValue( $value, IParam $param, array &$definitions, array $params ) {
		if ( $value === 'auto' ) {
			return $value;
		}

		/**
		 * @var \ValueValidators\DimensionValidator $validator
		 */
		$validator = $this->getValueValidator();

		if ( get_class( $validator ) === 'ValueValidators\DimensionValidator' ) {
			foreach ( $validator->getAllowedUnits() as $unit ) {
				if ( $unit !== '' && strpos( $value, $unit ) !== false ) {
					return $value;
				}
			}

			return $value . $validator->getDefaultUnit();
		}
		else {
			throw new Exception(
				'ValueValidator of a DimensionParam should be a ValueValidators\DimensionValidator and not a '
					. get_class( $validator )
			);
		}
	}

}
