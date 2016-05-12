<?php

class TemplateTypesParserTest extends WikiaBaseTest {
	const TEST_TEMPLATE_TEXT = 'test-template-test';

	/**
	 * @param $config array
	 * @param $templateText string
	 * @param $expectedValue string
	 *
	 * @dataProvider TemplateParsingDataProvider
	 */
	public function testTemplateParsing( $config, $templateText, $expectedValue, $message ) {
		$this->mockClassWithMethods(
			'Title',
			[ 'getArticleId' => $config[ 'templateId' ] ]
		);

		$this->mockClassWithMethods(
			'TemplateClassificationService',
			[ 'getType' => $config[ 'templateType' ] ]
		);

		foreach($config['globals'] as $globalVarName => $globalVarValue) {
			$this->mockGlobalVariable( $globalVarName, $globalVarValue );
		}

		TemplateTypesParser::onFetchTemplateAndTitle( $templateText, new Title );

		$this->assertEquals( $expectedValue, $templateText, $message );
	}

	public function TemplateParsingDataProvider() {
		return [
			[
				[
					'templateId' => 1,
					'templateType' => 'navbox',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => false,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => false
					]
				],
				self::TEST_TEMPLATE_TEXT,
				self::TEST_TEMPLATE_TEXT
			],
			[
				[
					'templateId' => 2,
					'templateType' => 'navbox',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => false
					]
				],
				self::TEST_TEMPLATE_TEXT,
				self::TEST_TEMPLATE_TEXT
			],
			[
				[
					'templateId' => 3,
					'templateType' => 'navbox',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => false,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => true
					]
				],
				self::TEST_TEMPLATE_TEXT,
				self::TEST_TEMPLATE_TEXT
			],
			// Revert after navigation experiment is over. Contact West-Wing team.
			// https://wikia-inc.atlassian.net/browse/DAT-4186
//			[
//				[
//					'templateId' => 4,
//					'templateType' => 'navbox',
//					'globals' => [
//						'wgCityId' => 12345,
//						'wgEnableTemplateTypesParsing' => true,
//						'wgEnableNavboxTemplateParsing' => true,
//						'wgEnableNavigationTemplateParsing' => true,
//						'wgEnableNoticeTemplateParsing' => true,
//						'wgEnableReferencesTemplateParsing' => true,
//						'wgArticleAsJson' => true
//					]
//				],
//				'navbox text',
//				''
//			],
			[
				[
					'templateId' => 5,
					'templateType' => 'notice',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => false,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => true
					]
				],
				self::TEST_TEMPLATE_TEXT,
				self::TEST_TEMPLATE_TEXT
			],
			[
				[
					'templateId' => 6,
					'templateType' => 'notice',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => false
					]
				],
				self::TEST_TEMPLATE_TEXT,
				self::TEST_TEMPLATE_TEXT
			],
			[
				[
					'templateId' => 7,
					'templateType' => 'notice',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => false,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => true
					]
				],
				self::TEST_TEMPLATE_TEXT,
				self::TEST_TEMPLATE_TEXT
			],
			[
				[
					'templateId' => 8,
					'templateType' => 'notice',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => true
					]
				],
				'notice text',
				''
			],
			[
				[
					'templateId' => 9,
					'templateType' => 'references',
					'wgCityId' => 12345,
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => false,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => true
					]
				],
				'<div class="wrapped-references"><references /></div>',
				'<div class="wrapped-references"><references /></div>'
			],
			[
				[
					'templateId' => 10,
					'templateType' => 'references',
					'wgCityId' => 12345,
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => false
					]
				],
				'<div class="wrapped-references"><references /></div>',
				'<div class="wrapped-references"><references /></div>'
			],
			[
				[
					'templateId' => 11,
					'templateType' => 'references',
					'wgCityId' => 12345,
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => false,
						'wgArticleAsJson' => true
					]
				],
				'<div class="wrapped-references"><references /></div>',
				'<div class="wrapped-references"><references /></div>'
			],
			[
				[
					'templateId' => 12,
					'templateType' => 'references',
					'wgCityId' => 12345,
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => true
					]
				],
				'<div class="wrapped-references"><references /></div>',
				'<references />'
			],
			[
				[
					'templateId' => 13,
					'templateType' => 'references',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => true
					]
				],
				'<div class="wrapped-references">NOT A REFERENCE LIST</div>',
				'<div class="wrapped-references">NOT A REFERENCE LIST</div>'
			],
			[
				[
					'templateId' => 14,
					'templateType' => 'references',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => false,
						'wgArticleAsJson' => true
					]
				],
				'<div class="wrapped-references"><references /></div>',
				'<div class="wrapped-references"><references /></div>',
				'References should not be parsed under wgEnableReferencesTemplateParsing disabled'
			],
			[
				[
					'templateId' => 15,
					'templateType' => 'navigation',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => false,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => true
					]
				],
				self::TEST_TEMPLATE_TEXT,
				self::TEST_TEMPLATE_TEXT
			],
			[
				[
					'templateId' => 16,
					'templateType' => 'navigation',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => true,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => false
					]
				],
				self::TEST_TEMPLATE_TEXT,
				self::TEST_TEMPLATE_TEXT
			],
			[
				[
					'templateId' => 16,
					'templateType' => 'navigation',
					'globals' => [
						'wgCityId' => 12345,
						'wgEnableTemplateTypesParsing' => true,
						'wgEnableNavboxTemplateParsing' => true,
						'wgEnableNavigationTemplateParsing' => false,
						'wgEnableNoticeTemplateParsing' => true,
						'wgEnableReferencesTemplateParsing' => true,
						'wgArticleAsJson' => true
					]
				],
				self::TEST_TEMPLATE_TEXT,
				self::TEST_TEMPLATE_TEXT
			]
		];
	}
}
