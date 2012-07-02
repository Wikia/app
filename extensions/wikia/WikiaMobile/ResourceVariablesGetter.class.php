<?php
class ResourceVariablesGetter extends ResourceLoaderStartUpModule {

	public function get(){
		$requestContext = RequestContext::getMain();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest(array(
			'skin' => $requestContext->getSkin()->getSkinName()
		)) );

		return parent::getConfig( $resourceLoaderContext );
	}
}
