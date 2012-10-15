<?php

/**
 * Static class for hooks handled by the Validator extension.
 * 
 * @since 0.4.8
 * 
 * @file Validator.hooks.php
 * @ingroup Validator
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class ValidatorHooks {
	
	/**
	 * Hook to add PHPUnit test cases.
	 * 
	 * @since 0.4.8
	 * 
	 * @param array $files
	 */
	public static function registerUnitTests( array &$files ) {
		$testDir = dirname( __FILE__ ) . '/test/';
		
		$files[] = $testDir . 'ValidatorCriteriaTests.php';
		
		return true;
	}
	
} 
