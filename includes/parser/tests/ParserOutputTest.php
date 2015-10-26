<?php

class ParserOutputTest extends WikiaBaseTest {

	/**
	 * @dataProvider getParserOutputVars
	 */
	public function testMergeExternalParserOutputVars( $sourceVars, $externalVars, $expectedVars ) {
		$parserOutputSource = new ParserOutput();
		$parserOutputExternal = new ParserOutput();

		foreach ( $parserOutputSource::$varsToMerge as $var ) {
			$parserOutputSource->$var = $sourceVars[$var];
			$parserOutputExternal->$var = $externalVars[$var];
		}

		$parserOutputSource->mergeExternalParserOutputVars( $parserOutputExternal );

		foreach ( $parserOutputSource::$varsToMerge as $var ) {
			$this->assertSame( $expectedVars[$var], $parserOutputSource->$var );
		}
	}

	public function getParserOutputVars() {
		return [
			'Test case #1' => [
				'sourceVars' => [
					// Test merge of two flat arrays
					'mLanguageLinks' => [
						'es:Ayuda:Enlace interwiki',
						'fr:Aide:Lien interwiki',
						'it:Aiuto:Link interwiki',
					],
					// Test merge of two flat arrays
					'mCategories' => [
						'Pages_with_broken_file_links' => '',
						'Mods' => '',
					],
					// Test merge of two nested arrays
					'mLinks' => [
						0 => [
							'Combat_level' => 0,
							'Gender' => 0,
						],
						10 => [
							'CitePodcast' => 0,
							'CiteGeneral' => 0,
						],
						11 => [
							'Infobox_Deity' => 0
						],
					],
					// Test merge of two nested arrays
					'mTemplates' => [
						10 => [
							'Infobox_Deity' => 525824,
							'CiteGeneral' => 0,
						],
					],
					// Test merge of a nested source array with a string (should keep source)
					'mTemplateIds' => [
						10 => [
							'Infobox_Deity' => 706876,
							'CiteGeneral' => 0,
						]
					],
					// Test empty source array
					'mImages' => [],
					// Test empty external array
					'mFileSearchOptions' => [
						'Tuska_concept_art.png' => [
							'time' => false,
							'sha1' => false,
						],
						'Tuska_logo.png' => [
							'time' => false,
							'sha1' => false,
						],
					],
					// Test two empty arrays
					'mExternalLinks' => [],
					// Test merging of two nested arrays with string indexes
					'mInterwikiLinks' => [
						'w:' => [
							'c:Help:Flags' => 1,
							'c:starwars:Yoda' => 1,
						]
					],
					// Test a case where a key does not exist in source but exists externally
					'mModules' => [],
					'mModuleScripts' => [],
					'mModuleStyles' => [],
					'mModuleMessages' => [],
					'mWarnings' => [],
				],
				'externalVars' => [
					// Test merge of two flat arrays
					'mLanguageLinks' => [
						'nl:Help:Interwiki links',
						'pl:Pomoc:Linki interwiki',
					],
					// Test merge of two flat arrays
					'mCategories' => [
						'Editing' => '',
						'Source_editing' => '',
					],
					// Test merge of nested arrays
					'mLinks' => [
						12 => [
							'Contacting_Wikia' => '447598',
							'Contents' => '447621',
						],
						10 => [
							'Namespace' => '447655',
							'Shared_help' => '448108',
						]
					],
					// Test merge of nested arrays
					'mTemplates' => [
						10 => [
							'Help_and_feedback_section' => 446666,
						],
					],
					// Test merge of a nested source array with a string (should keep source)
					'mTemplateIds' => [
						10 => 'Just a random string',
					],
					// Test empty source array
					'mImages' => [
						'Search-local.png' => 1,
						'Search-local-media.png' => 1,
					],
					// Test merge of nested arrays where
					'mFileSearchOptions' => [],
					// Test two empty arrays
					'mExternalLinks' => [],
					// Test merging of two nested arrays with string indexes
					'mInterwikiLinks' => [
						'w:' => [
							'c:community:User_blog:Daniel_Baran\/Search_Developments:_Big_Picture' => 1,
						],
					],
					// Test a case where a key does not exist in source but exists externally
					'mWarnings' => [
						'Warning no 1' => 1,
						'Warning no 2' => 1,
					],
				],
				'expectedVars' => [
					// Test merge of two flat arrays
					'mLanguageLinks' => [
						'es:Ayuda:Enlace interwiki',
						'fr:Aide:Lien interwiki',
						'it:Aiuto:Link interwiki',
						'nl:Help:Interwiki links',
						'pl:Pomoc:Linki interwiki',
					],
					// Test merge of two flat arrays
					'mCategories' => [
						'Pages_with_broken_file_links' => '',
						'Mods' => '',
						'Editing' => '',
						'Source_editing' => '',
					],
					// Test merge of two nested arrays
					'mLinks' => [
						0 => [
							'Combat_level' => 0,
							'Gender' => 0,
						],
						10 => [
							'CitePodcast' => 0,
							'CiteGeneral' => 0,
							'Namespace' => '447655',
							'Shared_help' => '448108',
						],
						11 => [
							'Infobox_Deity' => 0
						],
						12 => [
							'Contacting_Wikia' => '447598',
							'Contents' => '447621',
						],
					],
					// Test merge of two nested arrays
					'mTemplates' => [
						10 => [
							'Infobox_Deity' => 525824,
							'CiteGeneral' => 0,
							'Help_and_feedback_section' => 446666,
						],
					],
					// Test merge of a nested source array with a string (should keep source)
					'mTemplateIds' => [
						10 => [
							'Infobox_Deity' => 706876,
							'CiteGeneral' => 0,
						],
					],
					// Test empty source array
					'mImages' => [
						'Search-local.png' => 1,
						'Search-local-media.png' => 1,
					],
					// Test empty external array
					'mFileSearchOptions' => [
						'Tuska_concept_art.png' => [
							'time' => false,
							'sha1' => false,
						],
						'Tuska_logo.png' => [
							'time' => false,
							'sha1' => false,
						],
					],
					// Test two empty arrays
					'mExternalLinks' => [],
					'mInterwikiLinks' => [
						'w:' => [
							'c:Help:Flags' => 1,
							'c:starwars:Yoda' => 1,
							'c:community:User_blog:Daniel_Baran\/Search_Developments:_Big_Picture' => 1,
						]
					],
					// Test a case where a key does not exist in source but exists externally
					'mWarnings' => [
						'Warning no 1' => 1,
						'Warning no 2' => 1,
					],
				],
			],
		];
	}
}
