<?php
require_once 'WikiDialogs_Links_Setup.php';
/**
 * Description of WikiNewPageDialogs
 *
 * @author bhagyag, pdhanda
 *
 * This test case is part of the WikiEditorTestSuite.
 * Configuration for these tests are dosumented as part of extensions/WikiEditor/tests/selenium/WikiEditorTestSuite.php
 *
 */
class WikiDialogs_Links extends WikiDialogs_Links_Setup {
    // Set up the testing environment
    function setup() {
        parent::setUp();
        parent::doCreateInternalTestPageIfMissing();
    }

	function tearDown() {
		parent::doLogout();
        parent::tearDown();
    }

     // Create a new page temporary
    function createNewPage() {
       parent::doOpenLink();
       parent::login();
       parent::doCreateNewPageTemporary();
    }

     // Add a internal link and verify
    function testInternalLink() {
       $this->createNewPage();
       parent::verifyInternalLink();
    }

     // Add a internal link with different display text and verify
    function testInternalLinkWithDisplayText() {
       $this->createNewPage();
       parent::verifyInternalLinkWithDisplayText();
    }

     // Add a internal link with blank display text and verify
    function testInternalLinkWithBlankDisplayText() {
       $this->createNewPage();
       parent::verifyInternalLinkWithBlankDisplayText();
    }

    // Add external link and verify
    function testExternalLink() {
       $this->createNewPage();
       parent::verifyExternalLink();
    }

     // Add external link with different display text and verify
    function testExternalLinkWithDisplayText( ) {
       $this->createNewPage();
       parent::verifyExternalLinkWithDisplayText();
    }

     // Add external link with Blank display text and verify
    function testExternalLinkWithBlankDisplayText() {
       $this->createNewPage();
       parent::verifyExternalLinkWithBlankDisplayText();
    }

}
?>
