<?php
/**
 * @author ADi
 */
abstract class SDObject {
	/**
	 * @var SDElementRenderer
	 */
	private $renderer;

	abstract public function getName();
	abstract public function getTypeName();

	public function hasRenderer( $context = 'default' ) {
		/** @var $rendererFactory SDElementRendererFactory */
		$rendererFactory = F::build( 'SDElementRendererFactory' );
		$this->renderer = $rendererFactory->getRenderer($this, $context);

		return (bool) $this->renderer;
	}

	public function render( $context = 'default' ) {
		return $this->hasRenderer($context) ? $this->renderer->render() : false;
	}

	public function setRenderer($renderer) {
		$this->renderer = $renderer;
	}

	public function getRenderer() {
		return $this->renderer;
	}

}
