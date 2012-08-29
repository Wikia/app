<?php
require_once __DIR__.'/../WikiaBar.setup.php';

/**
 * @desc Unit test(s) for WikiaBar extension
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */
class WikiaBarTest extends WikiaBaseTest {
	/**
	 * @dataProvider executeIndexDataProvider
	 */
	public function testExecuteIndex($mockParamData, $expStatus, $expBarContents) {
		$this->markTestIncomplete('work in progress...');
		/*
		$wikiaBarModelStub = $this->getMock('WikiaBarModel', array('parseBarConfigurationMessage'));
		$wikiaBarModelStub->expects($this->any())->method('parseBarConfigurationMessage')->will($this->returnValue($e));
		$this->mockClass('WikiaBarModel', $wikiaBarModelStub);
		*/

		$wgMemcStub = $this->getMock('stdClass', array('get','set'));
		$wgMemcStub->expects($this->any())->method('get')->will($this->returnValue(false));
		$wgMemcStub->expects($this->any())->method('set')->will($this->returnValue(true));
		$this->mockGlobalVariable('wgMemc', $wgMemcStub);
		$this->mockApp();

		$response = $this->app->sendRequest('WikiaBarController', 'executeIndex', $mockParamData);
		$status = $response->getVal('status');
		$this->assertEquals($expStatus, $status);

		$barContents = $response->getVal('barContents');
		$this->assertEquals($expBarContents, $barContents);
	}

	public function executeIndexDataProvider() {
		return array(
			//everything is OK
			array(
				array(
					'lang' => 'de',
					'vertical' => 3,
				),
				true,
				array(),
			),
			//everything lang is not set
			array(
				array(
					'lang' => 'de',
					'vertical' => 3,
				),
				true,
				array(),
			),
			//everything vertical is not set
			array(
				array(
					'lang' => 'de',
					'vertical' => 3,
				),
				true,
				array(),
			),
			//nothing's set
			array(
				array(),
				true,
				array(),
			),
			//all set but invalid
			array(
				array(
					'lang' => 'long long long string',
					'vertical' => false,
				),
				true,
				array(),
			)
		);
	}

}