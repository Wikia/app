<?php 

/**
 * Controller for Wikia's Special:Version page
 * We use a custom extension for this because we deploy via package, not via repo.
 * @author relwell
 *
 */
class WikiaSpecialVersionController extends WikiaSpecialPageController 
{

	/**
	 * Constructor method. Overrides the original Special:Version page.
	 */
	public function __construct() {
		$this->version = F::build( 'WikiaSpecialVersion' );
		parent::__construct( 'Version', 'Version', false );
	}
	
	public function index() {
		
	}
}