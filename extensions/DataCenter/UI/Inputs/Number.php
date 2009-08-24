<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterInputNumber extends DataCenterInput {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'number',
		/**
		 * XML name attribute
		 * @datatype	string
		 */
		'name' => 'number',
		/**
		 * XML value attribute
		 * @datatype	scalar
		 */
		'value' => null,
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'input-number',
		/**
		 * JavaScript to run when changed
		 * @datatype	string
		 */
		'effect' => array(),
		/**
		 * Lowest value allowed
		 * @datatype	integer
		 */
		'min' => 1,
		/**
		 * Highest value allowed
		 * @datatype	integer
		 */
		'max' => 100,
		/**
		 * Amount to increase or decrease by
		 * @datatype	integer
		 */
		'step' => 1,
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins input
		$xmlOutput = parent::begin( $parameters['class'] );
		// Adds number
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'text',
				'id' => $parameters['id'],
				'name' => $parameters['name'],
				'class' => 'number',
				'value' => $parameters['value'],
				'autocomplete' => 'off',
			)
		);
		// Adds decriment button
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'button',
				'id' => $parameters['id'] . '_dec',
				'name' => $parameters['name'],
				'class' => 'button-dec',
				'value' => '-',
			)
		);
		// Adds incriment button
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'button',
				'id' => $parameters['id'] . '_inc',
				'name' => $parameters['name'],
				'class' => 'button-inc',
				'value' => '+',
			)
		);
		// Calculates the minimum value
		$min = min( $parameters['min'], $parameters['max'] );
		// Calculates the maximum value
		$max = max( $parameters['min'], $parameters['max'] );
		// Clamps the step value
		$step = max( min ( $parameters['step'], 1000 ), 1 );
		// Builds effect
		$effect = DataCenterJs::buildEffect(
			$parameters['effect'],
			array(
				'this' => sprintf(
					"document.getElementById( %s )",
					DataCenterJs::toScalar( $parameters['id'] )
				),
			)
		);
		// Builds javascript to connect buttons to number
		$jsOutput = <<<END

			addHandler(
				document.getElementById( '{$parameters['id']}' ),
				'change',
				function() {
					var input = document.getElementById( '{$parameters['id']}' );
					var value = parseInt( input.value );
					if ( !isNaN( value ) ) {
						input.value = Math.min(
							Math.max( value, {$min} ), {$max}
						);
						{$effect}
					}
				}
			)
			addHandler(
				document.getElementById( '{$parameters['id']}' ),
				'keyup',
				function() {
					var input = document.getElementById( '{$parameters['id']}' );
					var value = parseInt( input.value );
					if ( !isNaN( value ) ) {
						input.value = Math.min(
							Math.max( value, {$min} ), {$max}
						);
						{$effect}
					}
				}
			)
			addHandler(
				document.getElementById( '{$parameters['id']}_dec' ),
				'click',
				function() {
					var input = document.getElementById( '{$parameters['id']}' );
					var value = parseInt( input.value );
					if ( !isNaN( value ) ) {
						input.value = Math.max( value - {$step}, {$min} );
					}
					{$effect}
				}
			);
			addHandler(
				document.getElementById( '{$parameters['id']}_inc' ),
				'click',
				function() {
					var input = document.getElementById( '{$parameters['id']}' );
					var value = parseInt( input.value );
					if ( !isNaN( value ) ) {
						input.value = Math.min( value + {$step}, {$max} );
					}
					{$effect}
				}
			);
END;
		// Adds JavaScript
		$xmlOutput .= DataCenterXml::script( $jsOutput );
		// Ends input
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}
}