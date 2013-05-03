<?php
/**
 * @author ADi
 */
abstract class SDRenderableObject {

	/**
	 * return a list of renderer names that can be used to render this object. The first existing renderer will be used.
	 * a single renderer can be a string or an array with 'renderingSubject' and 'rendererName' keys. In case of an
	 * array, the renderingSubject allows to change the subject that will be passed as $object parameter to the
	 * renderer
	 * @return array
	 */
	abstract public function getRendererNames();

	public function render( $context = SD_CONTEXT_DEFAULT, array $params = array() ) {
		$rendererFactory = (new SDElementRendererFactory);
		$renderer = $rendererFactory->getRenderer( $this, $context, $params );
		return ( !empty( $renderer ) ) ? trim($renderer->render()) : false;
	}
}
