<?php
/**
 * @author ADi
 */
abstract class SDRenderableObject {

	abstract public function getRendererNames();

	public function render( $context = SD_CONTEXT_DEFAULT, array $params = array() ) {
		$rendererFactory = F::build( 'SDElementRendererFactory' );
		$renderer = $rendererFactory->getRenderer( $this, $context, $params );
		return ( !empty( $renderer ) ) ? trim($renderer->render()) : false;
	}
}
