<?php
class PreviewFunctions {

	/** 
	 * Register the parser hook.
	 * @param $parser Parser
	 */
	public static function register( Parser $parser ) {
		$parser->setFunctionHook( 'ifpreview', 'PreviewFunctions::ifPreview', Parser::SFH_OBJECT_ARGS );
		$parser->setHook( 'previewwarning', 'PreviewFunctions::addWarning' );
		return true;
	}

	public static function ifPreview( $parser, $frame, $args ) {
		if ( $parser->getOptions()->getIsPreview() ) {
			# Is a preview. Return first
			return isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		} else {
			# Otherwise return second arg.
			return isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		}
	}

	/**
	 * Syntax: <previewwarning>Warning here</previewwarning>
	 * or: <previewwarning nodiv="true">Warning here</previewwarning>
	 * or: {{#tag:previewwarning|warning here}}
	 *
	 * Tried to do this as a parserfunction, but just couldn't get
	 * original wikitext back (even with PPFrame::RECOVER_ORIG )
	 * so doing a tag hook.
	 *
	 * This could also potentially record images/links used, but i think its
	 * better that it doesn't (undecided on that).
	 */
	public static function addWarning( $warning, $args, $parser, $frame ) {
		if ( $warning === '' ) return '';

		// Note, EditPage.php parses such warnings
		// (but with a different parser object)

		// To make it work when using {{#tag:...}} syntax. (or i suppose fail better...)
		$warning = preg_replace( '/' . preg_quote( $parser->uniqPrefix(), '/' ) . '.*?'
                	        . preg_quote( Parser::MARKER_SUFFIX, '/' ) . '/',
			'',
			$warning
		);


		// Could do something complicated here to expand {{{1}}} but not anything else
		// (aka new parser instance and then do Parser::preprocess on it, i think.
		// Don't want to do Parser::recursivePreprocess as that does extensions too)
		// but not doing that (at least for now).


		if ( !isset( $args['nodiv'] ) ) {
			$warning = Html::rawElement( 'div', array( 'class' => 'error mw-previewfunc-warning' ), $warning );
		}
		$parser->getOutput()->addWarning( $warning );
		return '';
	}
}
