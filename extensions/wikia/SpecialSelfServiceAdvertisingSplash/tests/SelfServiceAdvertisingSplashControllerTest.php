<?php

class SelfServiceAdvertisingSplashControllerTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../SelfServiceAdvertisingSplash.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider sendEmailsDataProvider
	 */
	public function testSendEmails($request, $expResponse) {
		$modelMock = $this->getMock('SelfServiceAdvertisingSplashModel', array('executeSendingFunction','getDstEmails'), array());
		$modelMock->expects($this->any())->method('executeSendingFunction')->will($this->returnValue(true));
		$modelMock->expects($this->any())->method('getDstEmails')->will($this->returnValue(array('test@example.com')));
		$this->mockClass('SelfServiceAdvertisingSplashModel', $modelMock);

		/* @var $response WikiaResponse */
		$response = $this->app->sendRequest('SelfServiceAdvertisingSplash', 'sendEmails', $request);

		$this->assertEquals($expResponse,$response->getData());
	}

	public function sendEmailsDataProvider() {
		return array(
			// case1: no email nor name
			array(
				'request' => array(
					'email' => null,
					'name' => null,
					'company' => null,
					'telephone' => null
				),
				'expResponse' =>
				array(
					"validationResult" => false,
					"validationMessages" => array(
						'email' => wfMsg('ssa-splash-please-enter-your-email-address'),
						'name' => wfMsg('ssa-splash-please-enter-your-name')
					)
				)
			),
			// case2: email, but no name
			array(
				'request' => array(
					'email' => 'noname@example.com',
					'name' => null,
					'company' => null,
					'telephone' => null
				),
				'expResponse' =>
				array(
					"validationResult" => false,
					"validationMessages" => array(
						'name' => wfMsg('ssa-splash-please-enter-your-name')
					)
				)
			),
			// case3: no email, but name given
			array(
				'request' => array(
					'email' => null,
					'name' => 'Noemail',
					'company' => null,
					'telephone' => null
				),
				'expResponse' =>
				array(
					"validationResult" => false,
					"validationMessages" => array(
						'email' => wfMsg('ssa-splash-please-enter-your-email-address')
					)
				)
			),
			// case4: both email and name given
			array(
				'request' => array(
					'email' => 'validemail@example.com',
					'name' => 'Valid Name',
					'company' => null,
					'telephone' => null
				),
				'expResponse' =>
				array(
					"validationResult" => true,
					"sendResult" => true,
					"sendMessage" => wfMsg('ssa-splash-message-sent')
				)
			)
		);
	}
}

