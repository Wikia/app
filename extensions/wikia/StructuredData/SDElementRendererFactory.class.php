<?php
/**
 * @author ADi
 */
class SDElementRendererFactory {
	private $config = null;

	public function __construct(Array $config = null) {
		global $wgStructuredDataConfig;
		if( is_null($config) ) {
			$config = $wgStructuredDataConfig;
		}
		$this->config = $config;
	}

	/**
	 * Try to find a return a view for a given SDRenderableObject instance
	 * @param SDRenderableObject $object - object to be rendered
	 * @param int $context SD rendering context
	 * @param array $params - template parameters
	 * @return null|WikiaView
	 */
	public function getRenderer(SDRenderableObject $object, $context = SD_CONTEXT_DEFAULT, array $params = array()) {

		foreach( $object->getRendererNames() as $rendererName ) {
			if (is_array($rendererName)) {
				$renderingSubject = $rendererName['renderingSubject'];
				$rendererName = $rendererName['rendererName'];
			} else {
				$renderingSubject = $object;
			}
			if(isset($this->config['renderers'][$rendererName])) {
				$templateName = $this->config['renderers'][$rendererName];
				return $this->renderTemplate( $templateName, $rendererName, $renderingSubject, $context, $params );
			}
		}
		return null;
	}

	/**
	 * Return a given view template for SDRenderableObject $object
	 * @param $templateName - name of the template defined in extension's config
	 * @param $rendererName - name of the renderer which was mapped to given template, passed as a parameter to view
	 * @param SDRenderableObject $object - object that will be rendered using the template
	 * @param int $context - SD rendering context
	 * @param array $params - template parameters
	 * @return WikiaView
	 * @throws WikiaException
	 */
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
