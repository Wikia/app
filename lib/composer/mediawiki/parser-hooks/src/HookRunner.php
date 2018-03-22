<?php

namespace ParserHooks;

use ParamProcessor\Processor;
use Parser;
use ParserHooks\Internal\Runner;
use PPFrame;

/**
 * Class that handles a parser hook hook call coming from MediaWiki
 * by processing the parameters as declared in the hook definition and
 * then passes the result to the hook handler.
 *
 * @since 1.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookRunner extends Runner {

	const OPT_DO_PARSE = 'parse'; // Boolean, since 1.1

	/**
	 * @var Parser
	 */
	private $parser;

	/**
	 * @var PPFrame
	 */
	private $frame;

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
	 * @since 1.1
	 *
	 * @param string $text
	 * @param string[] $arguments
	 * @param Parser $parser
	 * @param PPFrame $frame
	 *
	 * @return mixed
	 */
	public function run( $text, array $arguments, Parser &$parser, PPFrame $frame ) {
		$this->parser = $parser;
		$this->frame = $frame;

		$rawArgs = $this->getRawArgsList( $text, $arguments );
		$resultText = $this->getResultText( $rawArgs );

		return $this->getProcessedResultText( $resultText );
	}

	protected function getRawArgsList( $text, array $arguments ) {
		$defaultParameters = $this->definition->getDefaultParameters();
		$defaultParam = array_shift( $defaultParameters );

		// If there is a first default parameter, set the tag contents as its value.
		if ( !is_null( $defaultParam ) && !is_null( $text ) ) {
			$arguments[$defaultParam] = $text;
		}

		return $arguments;
	}

	protected function getResultText( array $rawArgs ) {
		return $this->handler->handle(
			$this->parser,
			$this->getProcessedArgs( $rawArgs )
		);
	}

	protected function getProcessedArgs( array $rawArgs ) {
		$this->paramProcessor->setParameters(
			$rawArgs,
			$this->definition->getParameters()
		);

		return $this->paramProcessor->processParameters();
	}

	protected function getProcessedResultText( $resultText ) {
		if ( $this->getOption( self::OPT_DO_PARSE ) ) {
			return $this->parser->recursiveTagParse( $resultText, $this->frame );
		}

		return $resultText;
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
