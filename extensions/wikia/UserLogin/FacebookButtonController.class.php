<?php

/**
 * MenuButton with facebook styling
 *
 * @author macbre
 */
class FacebookButtonController extends WikiaController {

	public function index() {
		$this->class = $this->request->getVal('class', '');
		$this->text = $this->request->getVal('text', '');
		$this->tooltip = $this->request->getVal('tooltip');
	}
}