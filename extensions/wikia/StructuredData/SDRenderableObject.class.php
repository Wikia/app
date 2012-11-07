<?php
/**
 * @author ADi
 */
abstract class SDRenderableObject {

	abstract public function getRendererNames();

	public function render( $context = SD_CONTEXT_DEFAULT ) {
		$rendererFactory = F::build( 'SDElementRendererFactory' );
		$renderer = $rendererFactory->getRenderer( $this, $context );
		return ( !empty( $renderer ) ) ? trim($renderer->render()) : false;
	}
}
