<?php

class PortableInfoboxBuilderController extends WikiaController {

	public function getAssets() {
		$dir = PortableInfoboxRenderService::getTemplatesDir();
		$result = array_map( function ( $template ) use ( $dir ) {
			return file_get_contents( "{$dir}/{$template}" );
		}, PortableInfoboxRenderService::getTemplates() );

		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );
		$response->setVal( "css", AssetsManager::getInstance()->getURL( "portable_infobox_scss" ) );
		$response->setVal( "templates", $result );
	}
}
