<?php

class GlobalShortcutsController extends WikiaController {
	public function getHelp() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->overrideTemplate( 'help' );
	}
	public function renderHelpEntryPoint() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
