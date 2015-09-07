<?php

class AvatarServiceTest extends WikiaBaseTest {

	function testRenderLink() {
		$anonName = '10.10.10.10';
		$userName = 'WikiaBot';

		$this->mockGlobalVariable('wgVignetteUrl', 'http://images.foo.wikia-dev.com');
		$this->mockGlobalVariable('wgEnableVignette', true);

		// users
		$this->assertContains('width="32"', AvatarService::render($userName, 32));
		$this->assertContains('/scale-to-width-down/20', AvatarService::render($userName, 16));
		$this->assertContains('User:WikiaBot', AvatarService::renderLink($userName));
		$this->assertRegExp('/^<img src="http:\/\/images/', AvatarService::renderAvatar($userName));

		// anons
		$this->assertContains('Special:Contributions/', AvatarService::getUrl($anonName));
		$this->assertRegExp('/^<img src="/', AvatarService::renderAvatar($anonName));
		$this->assertContains('/20px-', AvatarService::renderAvatar($anonName, 20));
		$this->assertContains('Special:Contributions', AvatarService::renderLink($anonName));
	}
}
