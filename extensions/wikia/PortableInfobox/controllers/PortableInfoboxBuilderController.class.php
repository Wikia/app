<?php

class PortableInfoboxBuilderController extends WikiaController {
	const EXTENSION_PATH = 'extensions/wikia/PortableInfobox/';

	/**
	 * creates portable infobox builder UI
	 */
	public function index() {
		$this->infoboxContent = ( new PortableInfoboxRenderService() )->renderInfobox( $this->getInfoboxData(), null,
			'portable-infobox-layout-tabular' );
		$this->optionsPlaceholder = 'options placeholder';
		$this->publishBtn = 'Publish';
		$this->infoboxBuilderHeader = 'Infobox Builder';

		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( self::EXTENSION_PATH . 'styles/PortableInfoboxBuilder.scss' ) );
		$this->response->getView()->setTemplatePath( $IP . self::EXTENSION_PATH . 'templates/PortableInfoboxBuilderIndex.mustache' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	public function publish() {

	}

	/**
	 * returns infobox data for rendering
	 * @todo temporary returns data mock for simple infobox
	 *
	 * @return array
	 */
	private function getInfoboxData() {
		return [
			[
				'type' => 'title',
				'data' => [
					'value' => 'I\'m  Title'
				]
			],
			[
				'type' => 'image',
				'data' => [
					'name' => 'Flower.jpg',
				]
			],
			[
				'type' => 'data',
				'data' => [
					'label' => 'I\'m label',
					'value' => 'I\'m value'
				]
			]
		];
	}
}