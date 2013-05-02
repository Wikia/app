<?php


/**
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */
class ImageServingIndexerTest extends WikiaBaseTest {
	
	public function setUp( ) {
		$this->setupFile =  dirname(__FILE__) . '/../imageServing.setup.php';
		wfDebug( __METHOD__ . ': '  .$this->setupFile );
		parent::setUp();
	}

	/**
	 * test function ImageServingHelper::buildIndex
	 *
	 * @see ImageServingHelper::buildIndex
	 */
	public function testBuildIndex( ) {

		/**
		 * buildIndex( $articleId, $images, $ignoreEmpty = false )
		 *
		 * @param integer $articleId - page id
		 * @param Array $images - list of images found in article
		 * @param boolean $ignoreEmpty default false - break if size of images is 0
		 */

	}
}


