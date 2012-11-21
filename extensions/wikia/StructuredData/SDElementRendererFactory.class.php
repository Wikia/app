<?php
/**
 * @author ADi
 */
class SDElementRendererFactory {
	private $config = null;

	public function __construct(Array $config) {
		$this->config = $config;
	}

	public function getRenderer(SDRenderableObject $object, $context = SD_CONTEXT_DEFAULT, array $params = array()) {

		foreach( $object->getRendererNames() as $rendererName ) {
			if(isset($this->config['renderers'][$rendererName])) {
				$templateName = $this->config['renderers'][$rendererName];
				return $this->renderTemplate( $templateName, $rendererName, $object, $context, $params );
			}
		}
		return null;
	}

	public function renderTemplate( $templateName, $rendererName, SDRenderableObject $object, $context = SD_CONTEXT_DEFAULT, array $params = array() ) {

		$templatePath = $this->config['renderersPath'] . $templateName . '.php';
		if(file_exists( $templatePath )) {
			$view = F::app()->getView( 'StructuredData', $templateName, array( 'object' => $object, 'context' => $context, 'rendererName' => $rendererName, 'params' => $params, 'renderer' => $this ) );
			$view->setTemplatePath( $templatePath );
			return $view;
		}
		else {
			throw new WikiaException('SDElementRenderer not found for type: ' . $rendererName );
		}
	}

}
