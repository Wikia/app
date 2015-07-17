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
		$this->formAction = self::getLocalUrl('publish');
		$this->templateTitle = requestContext::getMain()->getTitle()->getPrefixedDBkey();

		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( self::EXTENSION_PATH . 'styles/PortableInfoboxBuilder.scss' ) );
		$this->response->getView()->setTemplatePath( $IP . self::EXTENSION_PATH . 'templates/PortableInfoboxBuilderIndex.mustache' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * publishes changes to infobox template made inside infobox builder UI
	 */
	public function publish() {
		global $wgTitle;

		$ep = new EditPage(Article::newFromTitle($wgTitle, RequestContext::getMain()));
		$ep->textbox1 = $this->getInfoboxMarkup();
		$ep->summary = 'InfoboxBuilder';
		$ep->attemptSave();

		$this->response->redirect( $wgTitle->getFullURL() );
	}

	/**
	 * returns infobox xml markup based on infobox build using infobox builder UI tool
	 * @todo returns temporary mock
	 * @return string
	 */
	private function getInfoboxMarkup() {
		return '<infobox>
				<title source="title" />
				<image source="image" />
				<data source="data"><label>I\'m label</label></data>
			</infobox>';
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