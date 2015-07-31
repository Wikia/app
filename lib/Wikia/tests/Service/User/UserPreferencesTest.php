<?php

namespace Wikia\Service\User\Preferences;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Wikia\Domain\User\Preference;

class UserPreferencesTest extends PHPUnit_Framework_TestCase {
	/** @var int */
	protected $userId = 1;

	/** @var string[string] */
	protected $savedPreferences = ["language" => "en", "marketingallowed" => "1"];

	/** @var PHPUnit_Framework_MockObject_MockObject */
	protected $service;

	protected function setUp() {
		$this->userId = 1;
		$this->service = $this->getMockBuilder(PreferenceService::class)
			->setMethods(['setPreferences', 'getPreferences'])
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();
	}

	public function testGetFromDefault() {
		$defaultPrefs = ["pref1" => "val1"];
		$preferences = new UserPreferences($this->service, [], $defaultPrefs, []);

		$this->assertEquals("val1", $preferences->getFromDefault("pref1"));
		$this->assertNull($preferences->getFromDefault("pref2"));
	}

	public function testGet() {
		$this->setupServiceExpects();
		$preferences = new UserPreferences($this->service, [], [], []);

		$this->assertEquals("en", $preferences->get($this->userId, "language"));
		$this->assertEquals("1", $preferences->get($this->userId, "marketingallowed"));
		$this->assertNull($preferences->get($this->userId, "unsetpreference"));
		$this->assertEquals("foo", $preferences->get($this->userId, "unsetpreference", "foo"));
		$this->assertEquals($this->savedPreferences, $preferences->getPreferences($this->userId));
	}

	public function testGetWithHiddenNoDefaults() {
		$this->setupServiceExpects();
		$preferences = new UserPreferences($this->service, ["marketingallowed"], [], []);
		$this->assertEquals("1", $preferences->get($this->userId, "marketingallowed", null, true));
		$this->assertNull($preferences->get($this->userId, "marketingallowed"));
	}

	public function testGetWithHiddenAndDefaults() {
		$this->setupServiceExpects();
		$preferences = new UserPreferences($this->service, ["marketingallowed"], ["marketingallowed" => "0"], []);
		$this->assertEquals("1", $preferences->get($this->userId, "marketingallowed", null, true));
		$this->assertEquals("0", $preferences->get($this->userId, "marketingallowed"));
		$this->assertNull($preferences->get($this->userId, "unsetpreference"));
	}
	
	public function testSet() {
		$this->setupServiceExpects();
		$preferences = new UserPreferences($this->service, [], [], []);
		$preferences->set($this->userId, "newpreference", "foo");
		$this->assertEquals("foo", $preferences->get($this->userId, "newpreference"));
	}

	public function testSetNullWithDefault() {
		$this->setupServiceExpects();
		$preferences = new UserPreferences($this->service, [], ["newpreference" => "foo"], []);
		$preferences->set($this->userId, "newpreference", null);
		$this->assertEquals("foo", $preferences->getPreferences($this->userId)["newpreference"]);
	}

	public function testSetNullWithoutDefault() {
		$this->setupServiceExpects();
		$preferences = new UserPreferences($this->service, [], [], []);
		$preferences->set($this->userId, "newpreference", null);
		$this->assertNull($preferences->getPreferences($this->userId)["newpreference"]);
	}

	protected function setupServiceExpects() {
		$this->service->expects($this->once())
			->method("getPreferences")
			->with($this->userId)
			->willReturn(array_map(function($k, $v) {
				return new Preference($k, $v);
			}, array_keys($this->savedPreferences), $this->savedPreferences));
	}
}
