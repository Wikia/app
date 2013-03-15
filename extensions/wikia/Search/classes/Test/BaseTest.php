<?php 
namespace Wikia\Search\Test;
use \WikiaBaseTest as WikiaBaseTest;
/**
 * Base test class for search extension.
 * All shared methods should go here.
 * @author Robert Elwell <robert@wikia-inc.com>
 */
abstract class BaseTest extends WikiaBaseTest {
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		global $IP;
	    $this->setupFile = "{$IP}/extensions/wikia/Search/WikiaSearch.setup.php";
	    
	    // hack to overwrite irritating static logging functions
	    $wikia = $this->getMock( 'Wikia', array( 'log', 'logBacktrace' ) );
	    $this->proxyClass( 'Wikia', $wikia, 'logBacktrace' );
	    $this->proxyClass( 'Wikia', $wikia, 'log' );
	    
	    parent::setUp();
	}
}