<?php
/**
 * Hooks for InputBox extension
 *
 * @file
 * @ingroup Extensions
 */

// InputBox hooks
class InputBoxHooks {

	/* Functions */

	// Initialization
	public static function register( &$parser ) {
		// Register the hook with the parser
		$parser->setHook( 'inputbox', array( 'InputBoxHooks', 'render' ) );

		// Continue
		return true;
	}

	// Render the input box
	public static function render( $input, $args, $parser ) {
		// Create InputBox
		$inputBox = new InputBox( $parser );

		// Configure InputBox
		$inputBox->extractOptions( $parser->replaceVariables( $input ) );

		// Return output
		return $inputBox->render();
	}
}
