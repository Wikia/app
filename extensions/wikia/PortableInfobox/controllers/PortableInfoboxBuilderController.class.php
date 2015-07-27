<?php

class PortableInfoboxBuilderController extends WikiaController {
	const EXTENSION_PATH = 'extensions/wikia/PortableInfobox/';
	const INFOBOX_BUILDER_TEMPLATE_PATH = 'templates/PortableInfoboxBuilderIndex.mustache';
	const INFOBOX_BUILDER_STYLES_PATH = 'styles/PortableInfoboxBuilder.scss';

	/**
	 * creates portable infobox builder UI
	 */
	public function index() {
		$this->optionsPlaceholder = wfMessage( 'portable-infobox-builder-edit-element-options-placeholder' )->text();
		$this->publishBtn = wfMessage( 'portable-infobox-builder-publish-button' )->text();
		$this->infoboxBuilderHeader = wfMessage( 'portable-infobox-builder-title' )->text();
		$this->formAction = self::getLocalUrl( 'publish' );
		$this->templateTitle = requestContext::getMain()->getTitle()->getPrefixedDBkey();
		$this->infoboxContent = ( new PortableInfoboxRenderService() )
			->renderInfobox( $this->getInfoboxData(), null, 'portable-infobox-layout-tabular' );

		$this->response->getView()->setTemplatePath( $IP . self::EXTENSION_PATH . self::INFOBOX_BUILDER_TEMPLATE_PATH );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->wg->out->addStyle(
			AssetsManager::getInstance()->getSassCommonURL( self::EXTENSION_PATH . self::INFOBOX_BUILDER_STYLES_PATH )
		);
	}

	/**
	 * publishes changes to infobox template made inside infobox builder UI and redirects to template page
	 */
	public function publish() {
		$title = $this->getContext()->getTitle();

		$this->editInfoboxTemplate(
			$title,
			$this->getInfoboxMarkup(),
			wfMessage( 'portable-infobox-builder-edit-summary' )->text()
		);

		$this->response->redirect( $title->getFullURL() );
	}

	/**
	 * does edit on the infobox template
	 *
	 * @param Title $title
	 * @param String $markup
	 * @param String $summary
	 *
	 * @throws PermissionsError
	 * @throws ReadOnlyError
	 * @throws ThrottledError
	 * @throws UserBlockedError
	 *
	 * @todo add error handling
	 */
	private function editInfoboxTemplate( $title, $markup, $summary ) {
		$wikiPage = new WikiPage( $title );
		$wikiPage->doEdit( $markup, $summary );
	}

	/**
	 * returns infobox xml markup based on infobox build using infobox builder UI tool
	 *
	 * @return string
	 *
	 * @todo returns temporary mock
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
	 *
	 * @return array
	 *
	 * @todo returns temporary data mock for simple infobox
	 */
	private function getInfoboxData() {
		return [
			[
				'type' => 'title',
				'data' => [
					'value' => wfMessage( 'portable-infobox-builder-infobox-title-element-placeholder' )->text()
				]
			],
			[
				'type' => 'image',
				'data' => [
					'name' => 'WallPaperHD 001.jpg',
				]
			],
			[
				'type' => 'data',
				'data' => [
					'label' => wfMessage( 'portable-infobox-builder-infobox-data-label-element-placeholder' )->text(),
					'value' => wfMessage( 'portable-infobox-builder-infobox-data-value-element-placeholder' )->text()
				]
			]
		];
	}
}
