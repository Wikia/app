<?php

class PortableInfoboxBuilderController extends WikiaController {
	const EXTENSION_PATH = 'extensions/wikia/PortableInfobox/';

	public function index() {


		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( self::EXTENSION_PATH . 'styles/PortableInfoboxBuilder.scss' ) );
		$this->response->getView()->setTemplatePath( $IP . self::EXTENSION_PATH . 'templates/PortableInfoboxBuilderIndex.mustache' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}