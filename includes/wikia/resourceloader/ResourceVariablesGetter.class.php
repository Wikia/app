<?php
/**
 * Getter for Variables coming form Resource Loader
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
