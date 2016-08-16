<?php

namespace ParserHooks\Internal;

use ParamProcessor\Processor;
use Parser;
use ParserHooks\HookDefinition;
use ParserHooks\HookHandler;

/**
 * @since 1.1
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class Runner {

	/**
	 * @since 1.1
	 *
	 * @var HookDefinition
	 */
	protected $definition;

	/**
	 * @since 1.1
	 *
	 * @var HookHandler
	 */
	protected $handler;

	/**
	 * @since 1.1
	 *
	 * @var array
	 */
	private $options;

	/**
	 * @since 1.1
	 *
	 * @var Processor
	 */
	protected $paramProcessor;

	/**
	 * @since 1.1
	 *
	 * @param HookDefinition $definition
	 * @param HookHandler $handler
	 * @param array $options
	 * @param Processor|null $paramProcessor
	 */
	public function __construct( HookDefinition $definition, HookHandler $handler, array $options = array(), Processor $paramProcessor = null ) {
		$this->definition = $definition;
		$this->handler = $handler;

		$this->setParamProcessor( $paramProcessor );
		$this->setOptions( $options );
	}

	private function setParamProcessor( $paramProcessor ) {
		if ( $paramProcessor === null ) {
			$paramProcessor = Processor::newDefault();
		}

		$this->paramProcessor = $paramProcessor;
	}

	private function setOptions( array $options ) {
		$this->options = array_merge(
			$this->getDefaultOptions(),
			$options
		);
	}

	/**
	 * @since 1.1
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	protected function getOption( $name ) {
		return $this->options[$name];
	}

	/**
	 * @since 1.1
	 *
	 * @return array
	 */
	protected abstract function getDefaultOptions();

	/**
	 * @since 1.1
	 *
	 * @return HookHandler
	 */
	public function getHandler() {
		return $this->handler;
	}

	/**
	 * @since 1.1
	 *
	 * @return HookDefinition
	 */
	public function getDefinition() {
		return $this->definition;
	}

}
