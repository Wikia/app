<?
abstract class FormElement {

	protected $templateEngine;

	public function __construct() {
		$this->templateEngine = new Wikia\Template\PHPEngine;
	}

	abstract protected function getDirectory();


	protected function prepareHtmlAttributes($attribs) {
		$out = '';

		foreach ($attribs as $name => $value) {
			$out .= $name . '="' . $value . '" ';
		}

		return $out;
	}

	protected function renderView($className, $name, $data = []) {
		$data['element'] = $this;
		return $this->templateEngine
			->setData($data)
			->render( $this->getDirectory() . '/templates/' . $className . '_' . $name . '.php');
	}
}