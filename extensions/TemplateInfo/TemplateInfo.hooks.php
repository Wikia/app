<?php
/**
 * Hooks for TemplateInfo extension
 *
 * @file
 * @ingroup Extensions
 */

class TemplateInfoHooks {

	/* Functions */

	// Initialization
	public static function register( &$parser ) {
		// Register the hook with the parser
		$parser->setHook( 'templateinfo', array( 'TemplateInfoHooks', 'render' ) );
		// add the CSS
		global $wgOut, $wgScriptPath;
		$wgOut->addStyle($wgScriptPath . '/extensions/TemplateInfo/TemplateInfo.css');

		// Continue
		return true;
	}


	// Render the displayed XML, if any
	public static function render( $input, $args, $parser, $frame ) {
		// if this call is contained in a transcluded page or template,
		// or if the input is empty, display nothing
		if ( !$frame->title->equals( $parser->getTitle() ) || $input == '' )
			return;
	
		// TODO: Do processing here, like parse to an array
		$error_msg = null;

		// recreate the top-level <templateinfo> tag, with whatever
		// attributes it contained, because that was actually a tag-
		// function call, as opposed to a real XML tag
		$input = Xml::tags('templateinfo', $args, $input);

		// if 'type=' was specified, and it wasn't set to one of the
		// allowed values (currently just 'auto'),  don't validate -
		// just display the XML
		if (array_key_exists('type', $args) && $args['type'] != 'auto') {
			// Store XML in the page_props table - the Javascript
			// can figure out on its own whether or not to handle it
			$parser->getOutput()->setProperty( 'templateinfo', $input );
			// TODO - a hook should be called here, to allow other
			// XML handlers to parse and display this
			$text = Html::element('p', null, "The (unhandled) XML definition for this template is:") . "\n";
			$text .= Html::element('pre', null, $input);
			return $text;
		}

 		if ( $xml_object = TemplateInfo::validateXML( $input, $error_msg ) ) {
			// Store XML in the page_props table
			$parser->getOutput()->setProperty( 'templateinfo', $input );
			$text = TemplateInfo::parseTemplateInfo($xml_object);
		} else {
			// Store error message in the page_props table
			$parser->getOutput()->setProperty( 'templateinfo', $error_msg );
			$text = Html::element('p', null, "The (incorrect) XML definition for this template is:") . "\n";
			$text .= Html::element('pre', null, $input);
		}

		// return output
		return $text;
    	}
}
