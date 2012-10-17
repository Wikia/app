<?php
/**
 * @author ADi
 */
abstract class SDElementRenderer {

	protected $object = null;

	public function __construct(SDObject $object) {
		$this->object = $object;
	}

	abstract public function render();
}
