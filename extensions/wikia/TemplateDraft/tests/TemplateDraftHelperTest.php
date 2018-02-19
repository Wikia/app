<?php

use PHPUnit\Framework\TestCase;

class TemplateDraftHelperTest extends TestCase {
	const TEMPLATE_DRAFT_MSG_EN = 'DraftY7123277';
	const TEMPLATE_DRAFT_MSG_PL = 'SzkicQ7123278';

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		require_once __DIR__ . '/../TemplateDraft.setup.php';

		$overrides = [
			'templatedraft-subpage' => [
				'en' => static::TEMPLATE_DRAFT_MSG_EN,
				'pl' => static::TEMPLATE_DRAFT_MSG_PL
			]
		];

		MessageCache::setupForTesting( $overrides );
	}

	/**
	 * @dataProvider isTitleDraftProvider
	 *
	 * @param int $namespace
	 * @param string $title
	 * @param bool $isTitleDraftExpected
	 */
	public function testIsTitleDraft( int $namespace, string $title, bool $isTitleDraftExpected ) {
		$title = Title::makeTitle( $namespace, $title );

		$this->assertEquals( $isTitleDraftExpected, TemplateDraftHelper::isTitleDraft( $title ) );
	}

	public function isTitleDraftProvider() {
		$defaultEnDraftName = static::TEMPLATE_DRAFT_MSG_EN;
		$plDraftName = static::TEMPLATE_DRAFT_MSG_PL;
		$randomPageName = 'SomeNameRE2342233';

		yield 'EN template draft page' => [ NS_TEMPLATE, "$randomPageName/$defaultEnDraftName", true ];
		yield 'PL template draft page' => [ NS_TEMPLATE, "$randomPageName/$plDraftName", true ];
		yield 'non-draft template page' => [ NS_TEMPLATE, $randomPageName, false ];
		yield 'template page with same title as EN draft' => [ NS_TEMPLATE, $defaultEnDraftName, false ];
		yield 'template page with same title as PL draft' => [ NS_TEMPLATE, $plDraftName, false ];
		yield 'main namespace subpage' => [ NS_MAIN, "$randomPageName/$defaultEnDraftName", true ];
		yield 'main namespace subpage PL title' => [ NS_MAIN, "$randomPageName/$plDraftName", true ];
	}

	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();
		MessageCache::destroyInstance();
	}
}
