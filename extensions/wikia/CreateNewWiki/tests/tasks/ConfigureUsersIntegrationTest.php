<?php
namespace Wikia\CreateNewWiki\Tasks;

/**
 * @group Integration
 */
class ConfigureUsersIntegrationTest extends \WikiaDatabaseTest {

	/** @var \User $founder */
	private $founder;

	/** @var TaskContext $taskContext */
	private $taskContext;

	/** @var ConfigureUsers $configureUsers */
	private $configureUsers;

	protected function setUp() {
		parent::setUp();

		require_once __DIR__ . '/../../CreateNewWiki_setup.php';

		$this->founder = \User::newFromId( 1 );

		$this->taskContext = new TaskContext( [] );
		$this->configureUsers = new ConfigureUsers( $this->taskContext );

		$this->taskContext->setWikiDBW( wfGetDB( DB_MASTER ) );
		$this->taskContext->setFounder( $this->founder );
	}

	public function testCheckShouldFailWhenFounderIsAnon() {
		$this->taskContext->setFounder( new \User() );

		$taskResult = $this->configureUsers->check();

		$this->assertFalse( $taskResult->isOk(), 'Check should fail when founder is anon' );
	}

	public function testCheckShouldReturnSuccessWhenFounderIsValidUser() {
		$taskResult = $this->configureUsers->check();

		$this->assertTrue( $taskResult->isOk(), 'Check should succeed when founder is valid user' );
	}

	public function testShouldPromoteFounderToBureaucratAndSysopGroups() {
		$taskResult = $this->configureUsers->run();

		$this->assertTrue( $taskResult->isOk(), 'Operation should succeed' );

		$groups = $this->founder->getGroups();

		$this->assertCount( 2, $groups, 'Founder should have exactly two local groups' );
		$this->assertContains( 'sysop', $groups, 'Founder should have "sysop" group' );
		$this->assertContains( 'bureaucrat', $groups, 'Founder should have "bureaucrat" group' );
	}


	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/configure_users.yaml' );
	}
}
