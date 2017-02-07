<?php

namespace ParserHooks;

use ParamProcessor\Processor;
use Parser;
use ParserHooks\Internal\Runner;
use PPFrame;

/**
 * Class that handles a parser function hook call coming from MediaWiki
 * by processing the parameters as declared in the hook definition and
 * then passes the result to the hook handler.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FunctionRunner extends Runner {

	const OPT_DO_PARSE = 'parse'; // Boolean, since 1.1

	/**
	 * @since 1.1
	 *
	 * @param HookDefinition $definition
	 * @param HookHandler $handler
	 * @param array $options
	 * @param Processor|null $paramProcessor
	 */
	public function __construct( HookDefinition $definition, HookHandler $handler, array $options = array(), Processor $paramProcessor = null ) {
		parent::__construct( $definition, $handler, $options, $paramProcessor );
	}

	/**
	 * @since 1.0
	 *
	 * @param Parser $parser
	 * @param array $arguments
	 * @param PPFrame $frame
	 *
	 * @return array
	 */
	public function run( Parser &$parser, array $arguments, PPFrame $frame ) {
		$resultText = $this->handler->handle(
			$parser,
			$this->getProcessedParams( $this->getExpandedParams( $arguments, $frame ) )
		);

		return $this->getResultStructure( $resultText );
	}

	protected function getExpandedParams( array $rawArguments, PPFrame $frame ) {
		$rawArgList = array();

		foreach( $rawArguments as $arg ) {
			$rawArgList[] = $frame->expand( $arg );
		}

		return $rawArgList;
	}

	protected function getProcessedParams( array $expendedArgs ) {
		$this->paramProcessor->setFunctionParams(
			$expendedArgs,
			$this->definition->getParameters(),
			$this->definition->getDefaultParameters()
		);

		return $this->paramProcessor->processParameters();
	}

	protected function getResultStructure( $resultText ) {
		$result = array( $resultText );

		if ( !$this->getOption( self::OPT_DO_PARSE ) ) {
			$result['noparse'] = true;
			$result['isHTML'] = true;
		}

		return $result;
	}

	/**
	 * @see Runner::getDefaultOptions
	 *
	 * @since 1.1
	 *
	 * @return array
	 */
	protected function getDefaultOptions() {
		return array(
			self::OPT_DO_PARSE => true,
		);
	}

}
