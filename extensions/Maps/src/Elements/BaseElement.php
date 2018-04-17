<?php

namespace Maps\Elements;

use Maps\Element;
use Maps\ElementOptions;

/**
 * Base class for objects implementing the @see Element interface.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class BaseElement implements Element {

	/**
	 * @var ElementOptions
	 */
	protected $options;

	public function __construct() {
		$this->options = new ElementOptions();
	}

	public function setTitle( string $title ) {
		$this->options->setOption( 'title', $title );
	}

	public function setText( string $text ) {
		$this->options->setOption( 'text', $text );
	}

	public function setLink( string $link ) {
		$this->options->setOption( 'link', $link );
	}

	public function getArrayValue() {
		return $this->getJSONObject();
	}

	/**
	 * @deprecated
	 *
	 * @param string $defText
	 * @param string $defTitle
	 *
	 * @return array
	 */
	public function getJSONObject( string $defText = '', string $defTitle = '' ): array {
		$array = [];

		$array['text'] = $this->options->hasOption( 'text' ) ? $this->getText() : $defText;
		$array['title'] = $this->options->hasOption( 'title' ) ? $this->getTitle() : $defTitle;
		$array['link'] = $this->options->hasOption( 'link' ) ? $this->getLink() : '';

		return $array;
	}

	public function getText(): string {
		return $this->options->getOption( 'text' );
	}

	public function getTitle(): string {
		return $this->options->getOption( 'title' );
	}

	public function getLink(): string {
		return $this->options->getOption( 'link' );
	}

	public function getOptions(): ElementOptions {
		return $this->options;
	}

	public function setOptions( ElementOptions $options ) {
		$this->options = $options;
	}

}
