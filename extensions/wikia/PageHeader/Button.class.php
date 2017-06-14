<?php

namespace Wikia\PageHeader;

class Button {
	/**
	 * @var string
	 */
	public $label;

	/**
	 * @var string
	 */
	public $icon;

	/**
	 * @var string
	 */
	public $href;

	/**
	 * @var string
	 */
	public $class;

	/**
	 * @var string
	 */
	public $id;

	public function __construct( string $label, string $icon, string $href, string $class = '', string $id = '' ) {
		$this->label = $label;
		$this->icon = $icon;
		$this->href = $href;
		$this->class = $class;
		$this->id = $id;
	}

}
