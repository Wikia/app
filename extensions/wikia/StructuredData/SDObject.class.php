<?php
/**
 * @author ADi
 */
abstract class SDObject {
	/**
	 * @var SDElementRenderer
	 */
	private $renderer;

	abstract public function getTypeName();

	public function hasRenderer() {
		/** @var $rendererFactory SDElementRendererFactory */
		$rendererFactory = F::build( 'SDElementRendererFactory' );
		$this->renderer = $rendererFactory->getRenderer($this);

		return (bool) $this->renderer;
	}

	public function render() {
		return $this->hasRenderer() ? $this->renderer->render() : false;
	}

	public function setRenderer($renderer) {
		$this->renderer = $renderer;
	}

	public function getRenderer() {
		return $this->renderer;
	}

}
