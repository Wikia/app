<?php

namespace ValueFormatters;

/**
 * Base class for ValueFormatters.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ValueFormatterBase implements ValueFormatter {

	/**
	 * @since 0.1
	 *
	 * @var FormatterOptions
	 */
	protected $options;

	/**
	 * @since 0.1
	 *
	 * @param FormatterOptions|null $options
	 */
	public function __construct( FormatterOptions $options = null ) {
		$this->options = $options ?: new FormatterOptions();

		$this->options->defaultOption( ValueFormatter::OPT_LANG, 'en' );
	}

	/**
	 * Shortcut to $this->options->getOption.
	 *
	 * @since 0.1
	 *
	 * @param string $option
	 *
	 * @return mixed
	 */
	protected final function getOption( $option ) {
		return $this->options->getOption( $option );
	}

	/**
	 * Shortcut to $this->options->requireOption.
	 *
	 * @param string $option
	 */
	protected final function requireOption( $option ) {
		$this->options->requireOption( $option );
	}

	/**
	 * Shortcut to $this->options->defaultOption.
	 *
	 * @since 0.1
	 *
	 * @param string $option
	 * @param mixed $default
	 */
	protected final function defaultOption( $option, $default ) {
		$this->options->defaultOption( $option, $default );
	}

}
