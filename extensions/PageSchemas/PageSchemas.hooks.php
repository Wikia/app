<?php
/**
 * Hook functions for the Page Schemas extension
 *
 * @file
 * @ingroup Extensions
 */

class PageSchemasHooks {

	// Initialization
	public static function register( &$parser ) {
		// Register the hook with the parser
		$parser->setHook( 'PageSchema', array( 'PageSchemasHooks', 'render' ) );
		// Initialize the global array of "handler" classes
		wfRunHooks( 'PageSchemasRegisterHandlers' );
		return true;
	}

	// Render the displayed XML, if any
	public static function render( $input, $args, $parser, $frame ) {
		// Disable cache so that CSS will get loaded
		$parser->disableCache();

		// If this call is contained in a transcluded page or template,
		// or if the input is empty, display nothing.
		if ( !$frame->title->equals( $parser->getTitle() ) || $input == '' ) {
			return;
		}

		// TODO: Do processing here, like parse to an array
		$error_msg = null;

		// recreate the top-level <PageSchema> tag, with whatever
		// attributes it contained, because that was actually a tag-
		// function call, as opposed to a real XML tag
		$input = Xml::tags( 'PageSchema', $args, $input );

 		if ( $xml_object = PageSchemas::validateXML( $input, $error_msg ) ) {
			// Store the XML in the page_props table
			$parser->getOutput()->setProperty( 'PageSchema', $input );
			// Display the schema on the screen
			global $wgOut, $wgScriptPath;
			$wgOut->addStyle( $wgScriptPath . '/extensions/PageSchemas/PageSchemas.css' );
			$text = PageSchemas::displaySchema( $xml_object );
		} else {
			// Store error message in the page_props table
			$parser->getOutput()->setProperty( 'PageSchema', $error_msg );
			$text = Html::element( 'p', null, "The (incorrect) XML definition for this template is:" ) . "\n";
			$text .= Html::element( 'pre', null, $input );
		}

		// return output
		return $text;
	}
}
