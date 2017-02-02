<?php

namespace ParserHooks;

use Parser;
use PPFrame;

/**
 * Parser hook runner registrant.
 * Registers hook runners to a parser.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookRegistrant {

	/**
	 * @since 1.0
	 *
	 * @var Parser
	 */
	protected $parser;

	/**
	 * @since 1.0
	 *
	 * @param Parser $parser
	 */
	public function __construct( Parser &$parser ) {
		$this->parser = $parser;
	}

	/**
	 * @since 1.0
	 *
	 * @param FunctionRunner $runner
	 */
	public function registerFunction( FunctionRunner $runner ) {
		foreach ( $runner->getDefinition()->getNames() as $name ) {
			$this->parser->setFunctionHook(
				$name,
				function( Parser $parser, PPFrame $frame, array $arguments ) use ( $runner ) {
					return $runner->run( $parser, $arguments, $frame );
				},
				Parser::SFH_OBJECT_ARGS
			);
		}
	}

	/**
	 * Register a parser function.
	 *
	 * @since 1.1
	 *
	 * @param HookDefinition $definition
	 * @param HookHandler $handler
	 */
	public function registerFunctionHandler( HookDefinition $definition, HookHandler $handler ) {
		$this->registerFunction( new FunctionRunner( $definition, $handler ) );
	}

	/**
	 * @since 1.0
	 *
	 * @param HookRunner $runner
	 */
	public function registerHook( HookRunner $runner ) {
		foreach ( $runner->getDefinition()->getNames() as $name ) {
			$this->parser->setHook(
				$name,
				function( $text, array $arguments, Parser $parser, PPFrame $frame ) use ( $runner ) {
					return $runner->run( $text, $arguments, $parser, $frame );
				}
			);
		}
	}

	/**
	 * Register a tag function.
	 *
	 * @since 1.1
	 *
	 * @param HookDefinition $definition
	 * @param HookHandler $handler
	 */
	public function registerHookHandler( HookDefinition $definition, HookHandler $handler ) {
		$this->registerHook( new HookRunner( $definition, $handler ) );
	}

}