<?php 

/**
 * Base test class for search extension.
 * All shared methods should go here.
 * @author Robert Elwell <robert@wikia-inc.com>
 *
 */

class WikiaSearchBaseTest extends WikiaBaseTest {
	
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
	    $this->setupFile = dirname(__FILE__) . '/../WikiaSearch.setup.php';
	    parent::setUp();
	}
	
}