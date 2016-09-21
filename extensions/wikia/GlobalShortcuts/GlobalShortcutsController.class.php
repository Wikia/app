<?php

class GlobalShortcutsController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function getHelp() {
		$this->overrideTemplate( 'help' );
	}
}
