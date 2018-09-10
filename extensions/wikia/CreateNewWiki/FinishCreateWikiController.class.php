<?php

class FinishCreateWikiController extends WikiaController {

	public function WikiWelcomeModal() {
		wfProfileIn( __METHOD__ );

		$buttonParams = [
			'type' => 'button',
			'vars' => [
				'type' => 'button',
				'classes' => [ 'wikia-button', 'big', 'createpage' ],
				'value' => wfMessage( 'oasis-navigation-v2-create-page' )->escaped(),
				'imageClass' => 'new',
				'data' => [
					'key' => 'event',
					'value' => 'createpage'
				]
			]
		];

		$this->title = wfMessage( 'cnw-welcome-headline', $this->app->wg->Sitename )->text();
		$this->instruction1 = wfMessage( 'cnw-welcome-instruction1' )->text();
		$this->button = \Wikia\UI\Factory::getInstance()->init( 'button' )->render( $buttonParams );
		$this->help = wfMessage( 'cnw-welcome-help' )->text();

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		wfProfileOut( __METHOD__ );
	}

}
