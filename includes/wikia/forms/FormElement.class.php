<?php
abstract class FormElement {
	/**
	 * @return string relative path from /includes/wikia/forms/ to class template files directory
	 */
	abstract protected function getDirectory();

	/**
	 * @var Wikia\Template\PHPEngine template engine
	 */
	protected $templateEngine;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->templateEngine = new Wikia\Template\PHPEngine;
	}

	/**
	 * Convert array of html attributes into string
	 *
	 * @param array $attribs - array of HTML attributes
	 * @return string
	 */
	protected function prepareHtmlAttributes($attribs) {
		$out = '';

		foreach ($attribs as $name => $value) {
			$out .= $name . '="' . $value . '" ';
		}

		return $out;
	}

	/**
	 * Render template
	 *
	 * @param string $className template class name
	 * @param string $name render name
	 * @param array $data array of variables that should be passed into view
	 * @return string
	 */
	protected function renderView($className, $name, $data = []) {
		$data['element'] = $this;
		return $this->templateEngine
			->setData($data)
			->render( $this->getDirectory() . '/templates/' . $className . '_' . $name . '.php');
	}
}