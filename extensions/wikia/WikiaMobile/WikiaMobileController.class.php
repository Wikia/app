<?php
/**
 * WikiaMobile public API
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <jolek(at)wikia-inc.com>
 */
class WikiaMobileController extends WikiaController{
	/**
	 * Fetches the requested batch for a specific index
	 * section in a category page
	 *
	 * @requestParam string $category The name of the category
	 * @requestParam string $index The index representing a section in the category's page
	 * @requestParam int $batch The number of the batch of items to load
	 *
	 * @responseParam array $batch
	 */
	public function getCategoryBatch(){
		//allow proxying request to a service (shared method implementation)
		$this->request->setInternal( true );
		$this->forward( 'WikiaMobileCategoryService', 'getBatch' );
	}
	
	public function getShareButtons(){
		$cacheDuration = 86400; //24h

		//allow proxying request to a service (shared method implementation)
		$this->request->setInternal( true );
		$this->forward( 'WikiaMobileSharingService', 'index' );

		/**
		 * chache the result in Varnish, in the browser we use loalStorage to avoid
		 * re-requesting this data, so no need to cripple the response with
		 * unneeded headers
		 */
		$this->response->setCacheValidity( $cacheDuration, $cacheDuration, array( WikiaResponse::CACHE_TARGET_VARNISH ) );
	}
	
	public function getLoginPage(){
		//allow proxying request to a service (shared method implementation)
		$this->request->setInternal( true );

		$this->forward( 'UserLoginSpecialController', 'index' );
	}
}