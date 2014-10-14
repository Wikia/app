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
	    
	    // hack to overwrite irritating static logging functions
	    $wikia = $this->getMock( 'Wikia', array( 'log', 'logBacktrace' ) );
	    $this->proxyClass( 'Wikia', $wikia, 'logBacktrace' );
	    $this->proxyClass( 'Wikia', $wikia, 'log' );
	    
	    parent::setUp();
	}
	
}