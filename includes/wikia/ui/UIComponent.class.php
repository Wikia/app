<?php
class UIComponent {

	const EXCEPTION_MSG_INVALID_TEMPLATE = 'Invalid template';

	/**
	 * @var $templateEngine \Wikia\Template\Engine
	 */
	private $templateEngine;

	/**
	 * @var Array $templateVarsConfig
	 */
	private $templateVarsConfig;

	/**
	 * @var String path to the template file
	 */
	private $templatePath;

	/**
	 * @var Array data passed to the template
	 */
	private $templateData;

	/**
	 * @desc Sets template variables from configuration
	 *
	 * @param $templateVarsConfig
	 */
	public function setTemplateVarsConfig( $templateVarsConfig ) {
		$this->templateVarsConfig = $templateVarsConfig;
	}

	/**
	 * @desc Validates if required values are set and renders component
	 *
	 * @param $params
	 * @return string
	 */
	public function render( $params ) {
		$this->setTemplate( $params['type'] ); // set template for rendering
		$this->setValues( $params['params'] ); // set mustache variables
		$this->validateTemplateVars(); // check if required vars are set

		return $this->getTemplateEngine()
			->setData( $this->getValues() )
			->render( $this->getTemplate() );
	}

	/**
	 * @param String $template "sub template" name of the component (i.e. a button component can have three
	 * "sub templates": button_input.mustache, button_link.mustache and button_button.mustache the part between _ and .
	 * is a "sub template" name
	 * @throws Exception
	 */
	private function setTemplate( $template ) {
		$mustacheTplPath = $this->templateVarsConfig['templatePath'] . '_' . $template . '.mustache';

		if ( file_exists( $mustacheTplPath ) ) {
			$this->templatePath = $mustacheTplPath;
		} else {
			throw new Exception( self::EXCEPTION_MSG_INVALID_TEMPLATE );
		}
	}

	public function getTemplate() {
		return $this->templatePath;
	}

	public function setValues( Array $varsArray ) {
		$this->templateData = $varsArray;
	}

	public function getValues() {
		return $this->templateData;
	}

	private function validateTemplateVars() {
		// TODO: this method will be implemented during work on DAR-935
		return true;
	}

	/**
	 * @return \Wikia\Template\Engine
	 */
	private function getTemplateEngine() {
		if ( empty( $this->templateEngine ) ) {
			$this->templateEngine = new Wikia\Template\MustacheEngine;
		}

		return $this->templateEngine;
	}

}
