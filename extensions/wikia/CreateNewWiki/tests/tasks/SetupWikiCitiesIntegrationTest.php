<?php
namespace Wikia\CreateNewWiki\Tasks;

/**
 * @group Integration
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class SetupWikiCitiesIntegrationTest extends \WikiaDatabaseTest {

	const EXISTING_WIKI_ID = 1;

	const TEST_WIKIA_DOMAIN = 'integrationtest.wikia.com';
	const TEST_WIKIA_URL = 'http://integrationtest.wikia.com/';

	const TEST_FANDOM_DOMAIN = 'integrationtest.fandom.com';
	const TEST_FANDOM_URL = 'http://integrationtest.fandom.com/';

	const TEST_FOUNDING_IP = '1.1.1.1';

	const TEST_SITENAME = 'Integration Test Wiki';
	const TEST_LANGUAGE = 'en';
	const TEST_DBNAME = 'integrationtest';
	const TEST_WIKI_NAME = 'integrationtest';

	/** @var \User $founder */
	private $founder;

	/** @var TaskContext $taskContext */
	private $taskContext;

	/** @var SetupWikiCities $setupWikiCities */
	private $setupWikiCities;

	protected function setUp() {
		parent::setUp();

		require_once __DIR__ . '/../../CreateNewWiki_setup.php';

		$this->mockGlobalVariable( 'wgExternalSharedDB', $GLOBALS['wgDBname'] );

		$dbw = wfGetDB( DB_MASTER );

		$dbw->query( 'CREATE DATABASE '. static::TEST_DBNAME );

		$this->founder = \User::newFromId( 1 );

		$this->taskContext = new TaskContext( [] );
		$this->setupWikiCities = new SetupWikiCities( $this->taskContext );

		$this->taskContext->setTaskId( 'test' );

		$this->taskContext->setSharedDBW( $dbw );
		$this->taskContext->setFounder( $this->founder );

		$this->taskContext->setSiteName( static::TEST_SITENAME );
		$this->taskContext->setDbName( static::TEST_DBNAME );
		$this->taskContext->setDomain( static::TEST_WIKIA_DOMAIN );
		$this->taskContext->setURL( static::TEST_WIKIA_URL );
		$this->taskContext->setLanguage( static::TEST_LANGUAGE );
		$this->taskContext->setIp( static::TEST_FOUNDING_IP );
	}

	public function testShouldSetupWikiaDomainWikiCorrectly() {
		$taskResult = $this->setupWikiCities->run();
		$wikiId = $this->taskContext->getCityId();

		$this->assertTrue( $taskResult->isOk(), 'Task should complete successfully' );
		$this->assertNotEquals( static::EXISTING_WIKI_ID, $wikiId, 'Wiki should be created with new ID' );

		$wiki = \WikiFactory::getWikiByID( $wikiId );

		$this->assertEquals( $this->founder->getId(), $wiki->city_founding_user, 'Founder\'s user ID should be correct' );
		$this->assertEquals( $this->founder->getEmail(), $wiki->city_founding_email, 'Founder\'s email should be correct' );

		$this->assertEquals( static::TEST_FOUNDING_IP, inet_ntop( $wiki->city_founding_ip_bin ), 'Founding IP address should be correct' );

		$this->assertEquals( $this->taskContext->getSiteName(), $wiki->city_title, 'Sitename should be correctly set' );
		$this->assertEquals( $this->taskContext->getSiteName(), $wiki->city_description, 'Description should be correctly set' );
		$this->assertEquals( $this->taskContext->getURL(), $wiki->city_url, 'Wiki URL should be correctly set' );
		$this->assertEquals( $this->taskContext->getLanguage(), $wiki->city_lang, 'Wiki language should be correctly set' );

		$this->assertEquals( $GLOBALS['wgCreateDatabaseActiveCluster'], $wiki->city_cluster, 'Wiki should be created on active DB cluster' );

		$this->assertEquals( 0, $wiki->city_flags, 'Wiki should not have any flags set' );

		$domain = $this->taskContext->getDomain();
		$domains = \WikiFactory::getDomains( $wikiId );

		$this->assertCount( 2, $domains, 'Wiki with wikia.com domain should have two domain entries' );
		$this->assertContains( $domain, $domains, 'Wiki domain without www should have domain entry' );
		$this->assertContains( "www.$domain",  $domains,'Wiki domain with www should have domain entry' );
	}

	public function testShouldProtectFandomCreatorCommunity() {
		$this->taskContext->setFandomCreatorCommunityId( '1' );

		$this->setupWikiCities->run();

		$flags = \WikiFactory::getFlags( $this->taskContext->getCityId() );

		$this->assertEquals( \WikiFactory::FLAG_PROTECTED, $flags & \WikiFactory::FLAG_PROTECTED, 'Wiki with FANDOM Creator community should be protected' );
	}

	public function testWikiWithFandomDomainShouldHaveWikiaAlias() {
		$this->taskContext->setDomain( static::TEST_FANDOM_DOMAIN );
		$this->taskContext->setURL( static::TEST_FANDOM_URL );

		$this->setupWikiCities->run();

		$wikiId = $this->taskContext->getCityId();

		$domains = \WikiFactory::getDomains( $wikiId );

		$this->assertCount( 2, $domains, 'Wiki with fandom.com domain should have two domain entries' );
		$this->assertContains( static::TEST_FANDOM_DOMAIN, $domains, 'Wiki domain should have domain entry' );
		$this->assertContains( static::TEST_WIKIA_DOMAIN, $domains, 'Wiki with fandom.com domain should have wikia.com domain alias' );
	}

	protected function tearDown() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->query( 'DROP DATABASE ' . static::TEST_DBNAME );

		parent::tearDown();
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/setup_wikicities.yaml' );
	}
}
