<?php

class GlobalShortcutsController extends WikiaController {
	public function getHelp() {
		$templateTypes = [];
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->overrideTemplate( 'help' );
	}
}
