<?php
	/**
	 * Renders left menu (vertical tabs)
	 *
	 * @author Damian Jóźwiak
	 */

class LeftMenuController extends WikiaService {
	public function executeIndex($data) {
		$this->response->addAsset( '/skins/oasis/css/modules/LeftMenu.scss' );

		$this->menuItems = $data['menuItems'];
	}
}
