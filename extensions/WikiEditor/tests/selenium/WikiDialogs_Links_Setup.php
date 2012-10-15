<?php
include( "WikiEditorConstants.php" );
/**
 * This test case will be handling the Wiki Tool bar Dialog functions
 * Date : Apr - 2010
 * @author : BhagyaG - Calcey
 */
class WikiDialogs_Links_Setup extends SeleniumTestCase {

	// Open the page.
	function doOpenLink() {
		$this->open( $this->getUrl() . '/index.php' );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
	}

	// Expand advance tool bar section if its not
	function doExpandAdvanceSection() {
		if ( !$this->isTextPresent( TEXT_HEADING ) ) {
			$this->click( LINK_ADVANCED );
		}
	}

	// Log out from the application
	function doLogout() {
		$this->open( $this->getUrl() . '/index.php' );
		if ( $this->isTextPresent( TEXT_LOGOUT ) ) {
			$this->click( LINK_LOGOUT );
			$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
			$this->assertEquals( TEXT_LOGOUT_CONFIRM, $this->getText( LINK_LOGIN ) );
			$this->open( $this->getUrl() . '/index.php' );
			$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		}
	}

	// Create a temporary fixture page
	function doCreateInternalTestPageIfMissing() {
		$this->type( INPUT_SEARCH_BOX,  WIKI_INTERNAL_LINK );
		$this->click( BUTTON_SEARCH );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->click( LINK_START . WIKI_INTERNAL_LINK );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$location =  $this->getLocation() . "\n";
		if ( strpos( $location, '&redlink=1' ) !== false  ) {
			$this->type( TEXT_EDITOR,  "Test fixture page. No real content here" );
			$this->click( BUTTON_SAVE_WATCH );
			$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
			$this->assertTrue( $this->isTextPresent( WIKI_INTERNAL_LINK ),
				$this->getText( TEXT_PAGE_HEADING ) );
		}
	}

	// Create a temporary new page
	function doCreateNewPageTemporary() {
		$this->type( INPUT_SEARCH_BOX,  WIKI_TEMP_NEWPAGE );
		$this->click( BUTTON_SEARCH );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->click( LINK_START . WIKI_TEMP_NEWPAGE );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
	}

	// Add a internal link and verify
	function verifyInternalLink() {
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDLINK );
		$this->waitForPopup( 'addLink', WIKI_TEST_WAIT_TIME );
		$this->type( TEXT_LINKNAME, ( WIKI_INTERNAL_LINK ) );
		$this->assertTrue( $this->isElementPresent( ICON_PAGEEXISTS ), 'Element ' . ICON_PAGEEXISTS . 'Not found' );
		$this->assertEquals( "on", $this->getValue( OPT_INTERNAL ) );
		$this->click( BUTTON_INSERTLINK );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( ( WIKI_INTERNAL_LINK ), $this->getText( LINK_START . WIKI_INTERNAL_LINK ) );
		$this->click( LINK_START . WIKI_INTERNAL_LINK );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertTrue( $this->isTextPresent( WIKI_INTERNAL_LINK ), $this->getText( TEXT_PAGE_HEADING ) );
	}

	// Add a internal link with different display text and verify
	function verifyInternalLinkWithDisplayText() {
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDLINK );
		$this->waitForPopup( 'addLink', WIKI_TEST_WAIT_TIME );
		$this->type( TEXT_LINKNAME, WIKI_INTERNAL_LINK );
		$this->type ( TEXT_LINKDISPLAYNAME, WIKI_INTERNAL_LINK . TEXT_LINKDISPLAYNAME_APPENDTEXT );
		$this->assertTrue( $this->isElementPresent( ICON_PAGEEXISTS ) );
		$this->assertEquals( "on", $this->getValue( OPT_INTERNAL ) );
		$this->click( BUTTON_INSERTLINK );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( WIKI_INTERNAL_LINK . TEXT_LINKDISPLAYNAME_APPENDTEXT,
			$this->getText( LINK_START . WIKI_INTERNAL_LINK . TEXT_LINKDISPLAYNAME_APPENDTEXT ) );
		$this->click( LINK_START . WIKI_INTERNAL_LINK . TEXT_LINKDISPLAYNAME_APPENDTEXT );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertTrue( $this->isTextPresent( WIKI_INTERNAL_LINK ), $this->getText( TEXT_PAGE_HEADING ) );

	}

	// Add a internal link with blank display text and verify
	function verifyInternalLinkWithBlankDisplayText() {
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDLINK );
		$this->waitForPopup( 'addLink', WIKI_TEST_WAIT_TIME );
		$this->type( TEXT_LINKNAME, WIKI_INTERNAL_LINK );
		$this->type( TEXT_LINKDISPLAYNAME, "" );
		$this->assertTrue( $this->isElementPresent( ICON_PAGEEXISTS ) );
		$this->assertEquals( "on", $this->getValue( OPT_INTERNAL ) );
		$this->click( BUTTON_INSERTLINK );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( WIKI_INTERNAL_LINK, $this->getText( LINK_START . WIKI_INTERNAL_LINK ) );
		$this->click( LINK_START . WIKI_INTERNAL_LINK );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( WIKI_INTERNAL_LINK, $this->getText( TEXT_PAGE_HEADING ) );

	}

	// Add external link and verify
	function verifyExternalLink() {
		$this->type( LINK_PREVIEW, "" );
		$this->click( LINK_ADDLINK );
		$this->type( TEXT_LINKNAME, WIKI_EXTERNAL_LINK );
		$this->assertTrue( $this->isElementPresent( ICON_PAGEEXTERNAL ) );
		$this->assertEquals( "on", $this->getValue( OPT_EXTERNAL ) );
		$this->click( BUTTON_INSERTLINK );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( WIKI_EXTERNAL_LINK, $this->getText( LINK_START . WIKI_EXTERNAL_LINK ) );

		$this->click( LINK_START . WIKI_EXTERNAL_LINK );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( WIKI_EXTERNAL_LINK_TITLE, $this->getTitle() );
	}

	// Add external link with different display text and verify
	function verifyExternalLinkWithDisplayText() {
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDLINK );
		$this->type( TEXT_LINKNAME, WIKI_EXTERNAL_LINK );
		$this->type( TEXT_LINKDISPLAYNAME, WIKI_EXTERNAL_LINK_TITLE );
		$this->assertTrue( $this->isElementPresent( ICON_PAGEEXTERNAL ) );
		$this->assertEquals( "on", $this->getValue( OPT_EXTERNAL ) );
		$this->click( BUTTON_INSERTLINK );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( WIKI_EXTERNAL_LINK_TITLE, $this->getText( LINK_START . WIKI_EXTERNAL_LINK_TITLE ) );
		$this->click( LINK_START . ( WIKI_EXTERNAL_LINK_TITLE ) );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( WIKI_EXTERNAL_LINK_TITLE , $this->getTitle() );
	}

	// Add external link with Blank display text and verify
	function verifyExternalLinkWithBlankDisplayText() {
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDLINK );
		$this->type( TEXT_LINKNAME, WIKI_EXTERNAL_LINK );
		$this->type( TEXT_LINKDISPLAYNAME, "" );
		$this->assertTrue( $this->isElementPresent( ICON_PAGEEXTERNAL ) );
		$this->assertEquals( "on", $this->getValue( OPT_EXTERNAL ) );
		$this->click( BUTTON_INSERTLINK );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( "[1]", $this->getText( LINK_START . "[1]" ) );
		$this->click( LINK_START . "[1]" );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertEquals( WIKI_EXTERNAL_LINK_TITLE, $this->getTitle() );
	}

	// Add a table and verify
	function verifyCreateTable() {
		$WIKI_TABLE_ROW = 2;
		$WIKI_TABLE_COL = "5";
		$this->doExpandAdvanceSection();
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDTABLE );
		$this->click( CHK_SORT );
		$this->type( TEXT_ROW, $WIKI_TABLE_ROW );
		$this->type( TEXT_COL, $WIKI_TABLE_COL );
		$this->click( BUTTON_INSERTABLE );
		$this->click( CHK_SORT );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$WIKI_TABLE_ROW = $WIKI_TABLE_ROW + 1;
		$this->assertTrue( $this->isElementPresent( TEXT_TABLEID_OTHER .
			TEXT_VALIDATE_TABLE_PART1 . $WIKI_TABLE_ROW .
			TEXT_VALIDATE_TABLE_PART2 .  $WIKI_TABLE_COL .
			TEXT_VALIDATE_TABLE_PART3 ) );
	}

	// Add a table and verify only with head row
	function verifyCreateTableWithHeadRow() {
		$WIKI_TABLE_ROW = 3;
		$WIKI_TABLE_COL = "4";
		$this->doExpandAdvanceSection();
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDTABLE );
		$this->click( CHK_BOARDER );
		$this->type( TEXT_ROW, $WIKI_TABLE_ROW );
		$this->type( TEXT_COL, $WIKI_TABLE_COL );
		$this->click( BUTTON_INSERTABLE );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$WIKI_TABLE_ROW = $WIKI_TABLE_ROW + 1;
		$this->assertTrue( $this->isElementPresent( TEXT_TABLEID_OTHER .
			TEXT_VALIDATE_TABLE_PART1 . $WIKI_TABLE_ROW .
			TEXT_VALIDATE_TABLE_PART2 . $WIKI_TABLE_COL .
			TEXT_VALIDATE_TABLE_PART3 ) );
	}

	// Add a table and verify only with borders
	function verifyCreateTableWithBorders() {
		$WIKI_TABLE_ROW = "4";
		$WIKI_TABLE_COL = "6";
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDTABLE );
		$this->click( CHK_HEADER );
		$this->type( TEXT_ROW, $WIKI_TABLE_ROW );
		$this->type( TEXT_COL, $WIKI_TABLE_COL );
		$this->click( BUTTON_INSERTABLE );
		$this->click( CHK_HEADER );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertTrue( $this->isElementPresent( TEXT_TABLEID_OTHER .
			TEXT_VALIDATE_TABLE_PART1 . $WIKI_TABLE_ROW .
			TEXT_VALIDATE_TABLE_PART2 . $WIKI_TABLE_COL .
			TEXT_VALIDATE_TABLE_PART3 ) );
	}

	// Add a table and verify only with sort row
	function verifyCreateTableWithSortRow() {
		$WIKI_TABLE_ROW = "2";
		$WIKI_TABLE_COL = "5";
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDTABLE );
		$this->click( CHK_HEADER );
		$this->click( CHK_BOARDER );
		$this->click( CHK_SORT );
		$this->type( TEXT_ROW, $WIKI_TABLE_ROW );
		$this->type( TEXT_COL, $WIKI_TABLE_COL );
		$this->click( BUTTON_INSERTABLE );
		$this->click( CHK_HEADER );
		$this->click( CHK_BOARDER );
		$this->click( CHK_SORT );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertTrue( $this->isElementPresent( TEXT_TABLEID_WITHALLFEATURES .
			TEXT_VALIDATE_TABLE_PART1 . $WIKI_TABLE_ROW .
			TEXT_VALIDATE_TABLE_PART2 . $WIKI_TABLE_COL .
			TEXT_VALIDATE_TABLE_PART3 ) );
	}

	// Add a table without headers,borders and sort rows
	function verifyCreateTableWithNoSpecialEffects() {
		$WIKI_TABLE_ROW = "6";
		$WIKI_TABLE_COL = "2";
		$this->
		$this->doExpandAdvanceSection();
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDTABLE );
		$this->click( CHK_BOARDER );
		$this->click( CHK_HEADER );
		$this->type( TEXT_ROW, $WIKI_TABLE_ROW );
		$this->type( TEXT_COL, $WIKI_TABLE_COL );
		$this->click( BUTTON_INSERTABLE );
		$this->click( CHK_BOARDER );
		$this->click( CHK_HEADER );
		$this->click( INK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$this->assertTrue( $this->isElementPresent( TEXT_TABLEID_OTHER .
			TEXT_VALIDATE_TABLE_PART1 . $WIKI_TABLE_ROW .
			TEXT_VALIDATE_TABLE_PART2 . $WIKI_TABLE_COL .
			TEXT_VALIDATE_TABLE_PART3 ) );
	}

	// Add a table with headers,borders and sort rows
	function verifyCreateTableWithAllSpecialEffects() {
		$WIKI_TABLE_ROW = 6;
		$WIKI_TABLE_COL = "2";
		$this->doExpandAdvanceSection();
		$this->type( TEXT_EDITOR, "" );
		$this->click( LINK_ADDTABLE );
		$this->click( CHK_SORT );
		$this->type( TEXT_ROW, $WIKI_TABLE_ROW );
		$this->type( TEXT_COL, $WIKI_TABLE_COL );
		$this->click( BUTTON_INSERTABLE );
		$this->click( CHK_SORT );
		$this->click( LINK_PREVIEW );
		$this->waitForPageToLoad( WIKI_TEST_WAIT_TIME );
		$WIKI_TABLE_ROW = $WIKI_TABLE_ROW + 1;
		$this->assertTrue(	$this->isElementPresent( TEXT_TABLEID_WITHALLFEATURES .
			TEXT_VALIDATE_TABLE_PART1 . $WIKI_TABLE_ROW .
			TEXT_VALIDATE_TABLE_PART2 . $WIKI_TABLE_COL .
			TEXT_VALIDATE_TABLE_PART3 ) );
	}

}
?>