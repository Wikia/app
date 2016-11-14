<?php

class OasisLightController extends WikiaController {
	public function index() {
		$this->am = AssetsManager::getInstance();
		$this->skinVars = $this->app->getSkinTemplateObj()->data;
		$this->theme = [
			'backgroundImage' => $this->wg->OasisThemeSettings['background-image'] ?? '',
			'bodyColor' => $this->wg->OasisThemeSettings['color-body'] ?? '#fff',
			'pageColor' => $this->wg->OasisThemeSettings['color-page'] ?? '#fff',
		];
	}
}
