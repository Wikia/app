<?php

class FlaggedRevsSetupTest extends PHPUnit_Framework_TestCase {
	/**
	 * Constructs the test case.
	 */
	public function __construct() {}

	public function testDefineSourcePaths() {
		$autoloadClasses = $messagesFiles = $aliasesFiles = array();
		FlaggedRevsSetup::defineSourcePaths( $autoloadClasses, $messagesFiles );
		$fileLists = array(
			'$autoloadClasses' => $autoloadClasses,
			'$messageFiles'    => $messagesFiles,
		);
		foreach ( $fileLists as $listName => $list ) {
			$this->assertNotEmpty( $list, "$listName variable is not empty" );
			foreach ( $list as $name => $file ) {
				$this->assertEquals( true, file_exists( $file ), "$file exists" );
			}
		}
	}
}
