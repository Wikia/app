<?php
/**
 * Getter for Varialbes coming form Resource Loade
 */
class ResourceVariablesGetter extends ResourceLoaderStartUpModule {

	/**
	 * @return array
	 */
	public function get(){
		$requestContext = RequestContext::getMain();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest(array(
			'skin' => $requestContext->getSkin()->getSkinName()
		)) );

		return parent::getConfig( $resourceLoaderContext );
	}
}
