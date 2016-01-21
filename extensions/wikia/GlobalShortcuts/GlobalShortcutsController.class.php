<?php

class GlobalShortcutsController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function getHelp() {
		$this->overrideTemplate( 'help' );
	}

	public function renderHelpEntryPoint() {
		$this->setVal( 'hint', wfMessage( 'global-shortcuts-title-help-entry-point' )->plain() );
	}
}
