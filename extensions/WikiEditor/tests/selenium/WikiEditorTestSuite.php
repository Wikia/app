<?php

/**
 * To configure MW for these tests
 * 1) If you are running multiple test suites, add the following in LocalSettings.php
 * require_once("extensions/WikiEditor/tests/selenium/WikiEditorSeleniumConfig.php");
 * $wgSeleniumTestConfigs['WikiEditorTestSuite'] = 'WikiEditorSeleniumConfig::getSettings';
 * OR
 * 2) Add the following to your Localsettings.php
 * require_once( "$IP/extensions/Vector/Vector.php" );
 * require_once( "$IP/extensions/WikiEditor/WikiEditor.php" );
 * $wgDefaultSkin = 'vector';
 * $wgVectorFeatures['editwarning'] = array( 'global' => false, 'user' => false );
 * $wgWikiEditorFeatures['templateEditor'] = array( 'global' => false, 'user' => false );
 * $wgWikiEditorFeatures['toolbar'] = array( 'global' => true, 'user' => true );
 * $wgWikiEditorFeatures['toc'] = array( 'global' => false, 'user' => false );
 * $wgWikiEditorFeatures['highlight'] = array( 'global' => false, 'user' => false );
 * $wgWikiEditorFeatures['dialogs'] = array( 'global' => true, 'user' => true );
 *
 */
class WikiEditorTestSuite extends SeleniumTestSuite
{
	public function setUp() {
		$this->setLoginBeforeTests( false );
		parent::setUp();
	}
	public function addTests() {
		$testFiles = array(
			'extensions/WikiEditor/tests/selenium/WikiDialogs_Links.php'
		);
		parent::addTestFiles( $testFiles );
	}


}
