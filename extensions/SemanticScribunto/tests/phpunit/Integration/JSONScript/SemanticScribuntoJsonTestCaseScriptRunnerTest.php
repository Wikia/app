<?php

namespace SMW\Scribunto\Integration\JSONScript;

use SMW\DIWikiPage;
use SMW\Scribunto\HookRegistry;
use SMW\Tests\JsonTestCaseFileHandler;
use SMW\Tests\JsonTestCaseScriptRunner;
use SMW\Tests\Utils\Validators\SemanticDataValidator;
use SMW\Tests\Utils\Validators\StringValidator;


/**
 * @see https://github.com/SemanticMediaWiki/SemanticMediaWiki/tree/master/tests#write-integration-tests-using-json-script
 *
 * `JsonTestCaseScriptRunner` provisioned by SMW is a base class allowing to use a JSON
 * format to create test definitions with the objective to compose "real" content
 * and test integration with MediaWiki, Semantic MediaWiki, and Scribunto.
 *
 * The focus is on describing test definitions with its content and specify assertions
 * to control the expected base line.
 *
 * `JsonTestCaseScriptRunner` will handle the tearDown process and ensures that no test
 * data are leaked into a production system but requires an active DB connection.
 *
 * @group semantic-scribunto
 * @group medium
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class SemanticScribuntoJsonTestCaseScriptRunnerTest extends JsonTestCaseScriptRunner {

	/**
	 * @var SemanticDataValidator
	 */
	private $semanticDataValidator;

	/**
	 * @var StringValidator
	 */
	private $stringValidator;

	/**
	 * @var HookRegistry
	 */
	private $hookRegistry;

	protected function setUp() {
		parent::setUp();

		$validatorFactory = $this->testEnvironment->getUtilityFactory()->newValidatorFactory();

		$this->semanticDataValidator = $validatorFactory->newSemanticDataValidator();
		$this->stringValidator = $validatorFactory->newStringValidator();

		$this->hookRegistry = new HookRegistry();

		$this->hookRegistry->clear();
		$this->hookRegistry->register();
	}

	/**
	 * @see JsonTestCaseScriptRunner::getRequiredJsonTestCaseMinVersion
	 * @return string
	 */
	protected function getRequiredJsonTestCaseMinVersion() {
		return '1';
	}

	/**
	 * @see JsonTestCaseScriptRunner::getTestCaseLocation
	 * @return string
	 */
	protected function getTestCaseLocation() {
		return __DIR__ . '/TestCases';
	}

	/**
	 * Returns a list of files, an empty list is a sign to run all registered
	 * tests.
	 *
	 * @see JsonTestCaseScriptRunner::getListOfAllowedTestCaseFiles
	 */
	protected function getAllowedTestCaseFiles() {
		return [];
	}

	/**
	 * @see JsonTestCaseScriptRunner::runTestCaseFile
	 *
	 * @param JsonTestCaseFileHandler $jsonTestCaseFileHandler
	 */
	protected function runTestCaseFile( JsonTestCaseFileHandler $jsonTestCaseFileHandler ) {

		$this->checkEnvironmentToSkipCurrentTest( $jsonTestCaseFileHandler );

		// Setup
		$this->prepareTest( $jsonTestCaseFileHandler );

		// Run test cases
		$this->doRunParserTests( $jsonTestCaseFileHandler );
	}

	/**
	 * @param JsonTestCaseFileHandler $jsonTestCaseFileHandler
	 */
	private function doRunParserTests( JsonTestCaseFileHandler $jsonTestCaseFileHandler ) {

		foreach ( $jsonTestCaseFileHandler->findTestCasesByType( 'parser' ) as $case ) {

			if ( !isset( $case['subject'] ) ) {
				break;
			}

			// Assert function are defined individually by each TestCaseRunner
			// to ensure a wide range of scenarios can be supported.
			$this->assertSemanticDataForCase( $case, $jsonTestCaseFileHandler->getDebugMode() );
			$this->assertParserOutputForCase( $case );
		}
	}

	/**
	 * Prepares the test case: setting of global configuration changes (json section "settings",
	 * creation of defined pages (json section "setup")
	 *
	 * @param JsonTestCaseFileHandler $jsonTestCaseFileHandler
	 */
	private function prepareTest( JsonTestCaseFileHandler $jsonTestCaseFileHandler ) {

		// Defines settings that can be altered during a test run with each test
		// having the possibility to change those values, settings will be reset to
		// the original value (from before the test) after the test has finished.
		$permittedSettings = [
			'smwgNamespacesWithSemanticLinks',
			'smwgPageSpecialProperties',
			'smwgMaxNonExpNumber',
			'wgLanguageCode',
			'wgContLang',
			'wgLang'
		];

		foreach ( $permittedSettings as $key ) {
			$this->changeGlobalSettingTo(
				$key,
				$jsonTestCaseFileHandler->getSettingsFor( $key )
			);
		}

		$this->createPagesFrom(
			$jsonTestCaseFileHandler->getPageCreationSetupList(),
			NS_MAIN
		);
	}

	/**
	 * Assert the SemanticData object if available after a entity/page has been
	 * created.
	 *
	 * ```
	 * "assert-store": {
	 *    "semantic-data": {
	 *        "strictPropertyValueMatch": false,
	 *        "propertyCount": 4,
	 *        "propertyKeys": [
	 *            "Testproperty1",
	 *            "Testproperty2",
	 *            "_SKEY",
	 *            "_MDAT"
	 *        ],
	 *        "propertyValues": [
	 *            "200"
	 *        ],
	 *     "inproperty-keys": [
	 *         "roperty1",
	 *         "EY",
	 *     ],
	 *     "inproperty-values": [
	 *         "Test Ca",
	 *         "00",
	 *     ]
	 * }
	 * ```
	 * @param array $case
	 * @param bool $debugMode
	 */
	private function assertSemanticDataForCase( array $case, $debugMode ) {

		// Allows for data to be re-read from the DB instead of being fetched
		// from the store-id-cache
		if ( isset( $case['store']['clear-cache'] ) && $case['store']['clear-cache'] ) {
			$this->getStore()->clear();
		}

		if ( !isset( $case['assert-store'] ) || !isset( $case['assert-store']['semantic-data'] ) ) {
			return;
		}

		$subject = DIWikiPage::newFromText(
			$case['subject'],
			isset( $case['namespace'] ) ? constant( $case['namespace'] ) : NS_MAIN
		);

		/** @var \SMW\SemanticData $semanticData */
		$semanticData = $this->getStore()->getSemanticData( $subject );

		if ( $debugMode ) {
			print_r( $semanticData );
		}

		if ( isset( $case['errors'] ) && $case['errors'] !== [] ) {
			$this->assertNotEmpty(
				$semanticData->getErrors()
			);
		}

		$this->semanticDataValidator->assertThatPropertiesAreSet(
			$case['assert-store']['semantic-data'],
			$semanticData,
			$case['about']
		);

		$this->assertInProperties(
			$subject,
			$case['assert-store']['semantic-data'],
			$case['about']
		);
	}

	/**
	 * Assert the text content if available from the parse process and
	 * accessible using the ParserOutput object.
	 *
	 * ```
	 * "assert-output": {
	 * 	"to-contain": [
	 * 		"Foo"
	 * 	],
	 * 	"not-contain": [
	 * 		"Bar"
	 * 	]
	 * }
	 * ```
	 * @param array $case
	 */
	private function assertParserOutputForCase( array $case ) {

		if ( !isset( $case['assert-output'] ) ) {
			return;
		}

		$subject = DIWikiPage::newFromText(
			$case['subject'],
			isset( $case['namespace'] ) ? constant( $case['namespace'] ) : NS_MAIN
		);

		/** @var \ParserOutput $parserOutput */
		$parserOutput = $this->testEnvironment->getUtilityFactory()->newPageReader()->getEditInfo( $subject->getTitle() )->output;

		if ( isset( $case['assert-output']['to-contain'] ) ) {
			$this->stringValidator->assertThatStringContains(
				$case['assert-output']['to-contain'],
				$parserOutput->getText(),
				$case['about']
			);
		}

		if ( isset( $case['assert-output']['not-contain'] ) ) {
			$this->stringValidator->assertThatStringNotContains(
				$case['assert-output']['not-contain'],
				$parserOutput->getText(),
				$case['about']
			);
		}
	}

	/**
	 * @param DIWikiPage $subject
	 * @param array $semanticdata
	 * @param string $about
	 */
	private function assertInProperties( DIWikiPage $subject, array $semanticdata, $about ) {

		if ( !isset( $semanticdata['inproperty-keys'] ) ) {
			return;
		}

		$inProperties = $this->getStore()->getInProperties( $subject );

		$this->assertCount(
			count( $semanticdata['inproperty-keys'] ),
			$inProperties,
			'Failed asserting count for "inproperty-keys" in ' . $about . ' ' . implode( ',', $inProperties )
		);

		$inpropertyValues = [];

		/** @var \SMW\DIProperty $property */
		foreach ( $inProperties as $property ) {

			$this->assertContains(
				$property->getKey(),
				$semanticdata['inproperty-keys'],
				'Failed asserting key for "inproperty-keys" in ' . $about
			);

			if ( !isset( $semanticdata['inproperty-values'] ) ) {
				continue;
			}

			$values = $this->getStore()->getPropertySubjects( $property, $subject );

			foreach ( $values as $value ) {
				$inpropertyValues[] = $value->getSerialization();
			}
		}

		foreach ( $inpropertyValues as $value ) {
			$this->assertContains(
				$value,
				$semanticdata['inproperty-values'],
				'Failed asserting values for "inproperty-values" in ' . $about
			);
		}
	}}
