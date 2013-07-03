<?php
class UIComponent {

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
	 * @throws WikiaUIDataException
	 */
	public function render( $params ) {
		$this->setTemplatePath( $params['type'] ); // set template for rendering
		$this->setValues( $params['params'] ); // set mustache variables
		$this->validateTemplateVars(); // check if required vars are set

		return $this->getTemplateEngine()
			->setData( $this->getValues() )
			->render( $this->getTemplatePath() );
	}

	/**
	 * @param String $template "sub template" name of the component (i.e. a button component can have three
	 * "sub templates": button_input.mustache, button_link.mustache and button_button.mustache the part between _ and .
	 * is a "sub template" name
	 * 
	 * @throws Exception
	 */
	private function setTemplatePath( $template ) {
		$mustacheTplPath = $this->templateVarsConfig['templatePath'] . '_' . $template . '.mustache';

		if ( file_exists( $mustacheTplPath ) ) {
			$this->templatePath = $mustacheTplPath;
		} else {
			throw new WikiaUITemplateException();
		}
	}

	/**
	 * @desc Returns template path
	 * @return String
	 */
	public function getTemplatePath() {
		return $this->templatePath;
	}

	/**
	 * @desc Sets template variables and theri values
	 * 
	 * @param array $varsArray an array with key=>value structure; 
	 * key is the template variable name and the second is its value
	 */
	public function setValues( Array $varsArray ) {
		$this->templateData = $varsArray;
	}

	/**
	 * @desc Gets template variables and their values
	 * 
	 * @return Array
	 */
	public function getValues() {
		return $this->templateData;
	}

	/**
	 * @desc Checks if all required variables are set; throws an exception if not
	 * 
	 * @throws WikiaUIDataException
	 */
	private function validateTemplateVars() {
		foreach ( $this->templateVarsConfig['required'] as $templateRequiredVarName ) {
			if ( ! isset( $this->templateData[ $templateRequiredVarName ] ) ) {
				$exceptionMessage = sprintf( WikiaUIDataException::EXCEPTION_MSG_INVALID_DATA_FOR_PARAMETER, $templateRequiredVarName );
				throw new WikiaUIDataException( $exceptionMessage );
			}
		}
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
