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

		// Site custom CSS
		if ( $this->wg->UseSiteCss ) {
			$out = $this->getContext()->getOutput();
			$css = $out->makeResourceLoaderLink( 'site', ResourceLoaderModule::TYPE_STYLES );
			$this->siteCssLink = $css;
		}
	}
}
