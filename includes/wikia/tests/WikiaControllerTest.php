<?php
global $wgAutoloadClasses;
$wgAutoloadClasses['TestController'] = dirname(__FILE__) . '/_fixtures/TestController.php';
//require_once dirname(__FILE__) . '/_fixtures/TestController.php';

/**
 * @group mwabstract
 */
class WikiaControllerTest extends PHPUnit_Framework_TestCase {
	public function testGenerateHelpInJsonFormat() {
		$this->markTestIncomplete();
		$response = F::build('App')->dispatch(array('controller' => 'Test', 'method' => 'help', 'format' => 'json'));
		$response->setTemplatePath('non');
		print $response;
	}
}
