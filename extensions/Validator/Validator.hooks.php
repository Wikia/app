<?php

/**
 * Static class for hooks handled by the Validator extension.
 * 
 * @since 0.4.8
 * 
 * @file Validator.hooks.php
 * @ingroup Validator
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class ValidatorHooks {
	
	/**
	 * Hook to add PHPUnit test cases.
	 * 
	 * @since 0.4.8
	 * 
	 * @param array $files
	 *
	 * @return boolean
	 */
	public static function registerUnitTests( array &$files ) {
		$testFiles = array(
			'definitions/BoolParam',
			'definitions/CharParam',
			'definitions/DimensionParam',
			'definitions/FloatParam',
			'definitions/IntParam',
			'definitions/StringParam',
			'definitions/TitleParam',

			'ValidatorOptions',
			'Validator',
		);

		foreach ( $testFiles as $file ) {
			$files[] = dirname( __FILE__ ) . '/tests/' . $file . 'Test.php';
		}

		return true;
	}
	
} 
