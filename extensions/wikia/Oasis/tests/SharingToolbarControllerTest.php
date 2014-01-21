<?php

class SharingToolbarControllerTest extends WikiaBaseTest
{

	/**
	 * @dataProvider shareButtonDataProvider
	 */
	public function testShareButton($namespace, $required, array $globalVariables, $enableSharingToolbar, $returnValue)
	{
		if ($required) {
			$this->assertTrue(defined($namespace));
		} else if (!defined($namespace)) {
			return;
		}

		$mockTitle = $this->mockClassWithMethods('Title', array('getNamespace' => constant($namespace)));
		$this->mockGlobalVariable('wgTitle', $mockTitle);

		$this->mockGlobalVariable('wgEnableSharingToolbar', $enableSharingToolbar);

		foreach ($globalVariables as $name => $value) {
			$this->mockGlobalVariable($name, $value);
		}

		$testController = new SharingToolbarController();
		$this->assertEquals($testController->shareButton(), $returnValue);
	}

	public function shareButtonDataProvider()
	{
		// Is the namespace required (i.e. Does it always exist?)?
		// Does it have a variable that tells you if it's enabled?
		$namespaces = array(
			'NS_USER' => array(
				'required' => true,
			),
			'NS_USER_TALK' => array(
				'required' => true,
			),
			'NS_FILE' => array(
				'required' => true,
			),
			'NS_CATEGORY' => array(
				'required' => true,
			),
			'NS_VIDEO' => array(
				'required' => false,
			),
			'NS_BLOG_LISTING' => array(
				'required' => false,
			),
			'NS_FORUM' => array(
				'required' => false,
			),
			'NS_USER_WALL_MESSAGE' => array(
				'required' => false,
				'enabledVar' => 'wgEnableWallExt',
			),
			'NS_TOPLIST' => array(
				'required' => false,
				'enabledVar' => 'wgEnableTopListsExt'
			),
			'NS_WIKIA_PLAYQUIZ' => array(
				'required' => false,
				'enabledVar' => 'wgEnableWikiaQuiz'
			),
			'NS_WIKIA_FORUM_BOARD' => array(
				'required' => false,
				'enabledVar' => 'wgEnableForumExt'
			),
			'NS_WIKIA_FORUM_BOARD_THREAD' => array(
				'required' => false,
				'enabledVar' => 'wgEnableForumExt'
			),
			'NS_WIKIA_FORUM_TOPIC_BOARD' => array(
				'required' => false,
				'enabledVar' => 'wgEnableForumExt'
			),
		);

		$data = array();

		// Check every possible scenario (toolbar enabled/disabled, extension enabled/disabled, etc.).
		// These arrays get passed to `testShareButton()` as parameters.
		foreach ($namespaces as $namespace => $info) {
			if (isset($info['enabledVar'])) {
				$data[] = array($namespace, $info['required'], array($info['enabledVar'] => true), true, true);
				$data[] = array($namespace, $info['required'], array($info['enabledVar'] => true), false, false);
				$data[] = array($namespace, $info['required'], array($info['enabledVar'] => false), true, false);
				$data[] = array($namespace, $info['required'], array($info['enabledVar'] => false), false, false);
			} else {
				$data[] = array($namespace, $info['required'], array(), true, true);
				$data[] = array($namespace, $info['required'], array(), false, false);
			}
		}

		return $data;
	}

}
