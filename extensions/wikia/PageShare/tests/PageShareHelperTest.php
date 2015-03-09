<?php

class PageShareHelperTest extends WikiaBaseTest {

	protected function setUp () {
		require_once( __DIR__ . '/../PageShareHelper.class.php');
		parent::setUp();
	}

	public function testIsValidShareService() {
		$testCases = [
			[
				'service' => [
					'title' => 'Service',
					'url' => 'http://service.example.com',
					'name' => 'service',
					'languages:include' => ['en'],
					'languages:exclude' => [],
				],
				'language' => 'en',
				'out' => true,
			],
			[
				'service' => [
					'title' => 'Service',
					'url' => 'http://service.example.com',
					'name' => 'service',
				],
				'language' => 'en',
				'out' => true,
			],
			[
				'service' => [
					'url' => 'http://service.example.com',
					'name' => 'service',
				],
				'language' => 'en',
				'out' => false,
			],
			[
				'service' => [
					'title' => 'Service',
					'name' => 'service',
				],
				'language' => 'en',
				'out' => false,
			],
			[
				'service' => [
					'title' => 'Service',
					'url' => 'http://service.example.com',
				],
				'language' => 'en',
				'out' => false,
			],
			[
				'service' => [
					'title' => 'Service',
					'url' => 'http://service.example.com',
					'name' => 'service',
					'languages:exclude' => ['de'],
				],
				'language' => 'de',
				'out' => false,
			],
			[
				'service' => [
					'title' => 'Service',
					'url' => 'http://service.example.com',
					'name' => 'service',
					'languages:include' => ['en', 'de', 'zh'],
				],
				'language' => 'pl',
				'out' => false,
			],
		];

		foreach($testCases as $testCase) {
			$this->assertEquals(
				$testCase['out'],
				PageShareHelper::isValidShareService($testCase['service'], $testCase['language'])
			);
		}
	}
}
