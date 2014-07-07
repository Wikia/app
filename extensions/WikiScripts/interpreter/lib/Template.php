<?php

class WSTemplateLibrary extends WSLibraryModuleBase {
	public function getFunctions() {
		return array(
			'parse' => array( 'parse', 1 ),
			'arg' => array( 'arg', 1 ),
			'named_args' => array( 'namedArgs', 0 ),
			'numbered_args' => array( 'numberedArgs', 0 ),
			'is_transcluded' => array( 'isTranscluded', 0 ),
		);
	}

	public function parse( $args, $context, $line ) {
		$text = $args[0]->toString();

		// Push into stack for tracking purposes
		$context->mInterpreter->mCallStack->addParse( $text );

		// Imitate OT_PREPROCESS
		$oldOT = $context->mParser->mOutputType;
		$context->mParser->setOutputType( Parser::OT_PREPROCESS );	// FIXME: is that legit way to do this?
		$parsed = $context->mParser->replaceVariables( $text, $context->mFrame );
		$parsed = $context->mParser->mStripState->unstripBoth( $parsed );
		$context->mParser->setOutputType( $oldOT );

		$context->mInterpreter->mCallStack->pop();
		return new WSData( WSData::DString, $parsed );
	}

	public function arg( $args, $context, $line ) {
		$argName = $args[0]->toString();
		$default = isset( $args[1] ) ? $args[1] : new WSData();
		if( $context->mFrame->getArgument( $argName ) === false )
			return $default;
		else
			return new WSData( WSData::DString, $context->mFrame->getArgument( $argName ) );
	}

	public function namedArgs( $args, $context, $line ) {
		return WSData::newFromPHPVar( $context->mFrame->getNamedArguments() );
	}

	public function numberedArgs( $args, $context, $line ) {
		return WSData::newFromPHPVar( $context->mFrame->getNumberedArguments() );
	}

	public function isTranscluded( $args, $context, $line ) {
		return new WSData( WSData::DBool, $context->mFrame->isTemplate() );
	}
}
