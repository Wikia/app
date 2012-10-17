<?php
/**
 * @author ADi
 */
class SDElementRendererFactory {
	private $config = null;

	public function __construct(Array $config) {
		$this->config = $config;
	}

	public function getRenderer(SDObject $object, $context = 'default') {

		if(isset($this->config['renderers'][$object->getTypeName()])) {

			$templateName = $this->config['renderers'][$object->getTypeName()];
			$templatePath = $this->config['renderersPath'] . $templateName . '.php';
			if(file_exists( $templatePath )) {
				$view = F::app()->getView( 'StructuredData', $templateName, array( 'object' => $object, 'context' => $context ) );
				$view->setTemplatePath( $templatePath );
				return $view;
			}
			else {
				throw new WikiaException('SDElementRenderer not found for type: ' . $object->getTypeName() );
			}
		}

		return null;
	}
}
