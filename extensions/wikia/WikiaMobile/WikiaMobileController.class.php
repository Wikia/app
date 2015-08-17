<?php
/**
 * WikiaMobile public API
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <jolek(at)wikia-inc.com>
 */
class WikiaMobileController extends WikiaController{
	function __construct() {
		//Some internal methods called from this controller need the skin to be wikiamobile
		//It makes sense to set it explicitly here as other skins shouldn't use it anyway
		RequestContext::getMain()->setSkin(
			Skin::newFromKey( 'wikiamobile' )
		);

		parent::__construct();
	}

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

	public function getNavigation(){
		global $wgLang;
		$this->request->setInternal( true );

		$lang = $this->request->getVal( 'lang' );

		//set proper language so this can be properly cached
		$wgLang = !empty( $lang ) ? Language::factory( $lang ) : $this->wg->Lang;

		//Cache on Varnish for 15 minutes
		$this->response->setCacheValidity(900);

		$this->forward( 'WikiaMobileNavigationService', 'navMenu' );
	}
}