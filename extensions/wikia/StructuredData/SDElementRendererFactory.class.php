<?php
/**
 * @author ADi
 */
class SDElementRendererFactory {
	private $config = null;

	public function __construct(Array $config) {
		$this->config = $config;
	}

	public function getRenderer(SDObject $object, $context = SD_CONTEXT_DEFAULT) {
		foreach($object->getRendererNames() as $rendererName) {
			if(isset($this->config['renderers'][$rendererName])) {
				$templateName = $this->config['renderers'][$rendererName];
				$templatePath = $this->config['renderersPath'] . $templateName . '.php';
				if(file_exists( $templatePath )) {
					$view = F::app()->getView( 'StructuredData', $templateName, array( 'object' => $object, 'context' => $context ) );
					$view->setTemplatePath( $templatePath );
					return $view;
				}
				else {
					throw new WikiaException('SDElementRenderer not found for type: ' . $rendererName );
				}
			}
		}


		return null;
	}
}
