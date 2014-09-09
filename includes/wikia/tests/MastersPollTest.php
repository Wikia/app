<?php

use Wikia\MastersPoll;

/**
 * A simple memcache mock
 */
class DummyMemcache {
	private $storage = [];

	function set( $key, $value ) {
		$this->storage[$key] = $value;
	}

	function get( $key ) {
		if ( isset( $this->storage[$key] ) ) {
			return $this->storage[$key];
		}
		else {
			return null;
		}
	}
}

/**
 * Unit tests for LBFactory_Wikia::normalizeMultipleMasters
 *
 * @author macbre
 */
class MastersPollTest extends WikiaBaseTest {

	/* @var DummyMemcache $memc */
	private $memc;

	public function setUp() {
		parent::setUp();

		$this->memc = new DummyMemcache();
		$this->mockGlobalVariable( 'wgMemc', $this->memc );
	}

	public function testNormalizeMultipleMasters() {
		$masters = [
			'db-c1-a1' => 1,
			'db-c1-a2' => 1,
		];

		$slaves = [
			'db-c1-a3' => 1,
			'db-c1-a4' => 1,
		];

		$central = [
			'db-c1' => 1,
			'db-c2' => 1,
		];

		$conf = [
			'sectionLoads' => array(
				'central' => $central,
				'c1' => [
					'masters' => $masters,
					'slaves' => $slaves,
				],
				'c2' => [
					'db-c2-a1' => 1,
					'db-c2-a2' => 1,
				],
			),
		];

		$poll = new MastersPoll( $conf );

		$servers = $poll->getConf()['sectionLoads'];
		$mastersPoll = $poll->getConf()['mastersPoolBySection'];

		$selectedMaster = array_keys( $servers['c1'] )[0];

		# master selection
		$this->assertEquals( $slaves, array_slice( $servers['c1'], 1 ), 'List of slaves is maintained' );
		$this->assertContains( $selectedMaster, array_keys( $masters ), 'Master is randomized' );
		$this->assertEquals( $central, $servers['central'], 'central cluster config is left unchanged' );

		# masters poll
		$this->assertInternalType( 'array', $mastersPoll['c1'], 'Masters poll should be generated' );
		$this->assertNotContains( $selectedMaster, $mastersPoll['c1'], 'Masters poll should not contain selected master' );

		# next master for section
		$this->assertEquals( false, $poll->getNextMasterForSection( 'main-central' ), 'This cluster has no secondary master defined' );

		$nextMaster = $poll->getNextMasterForSection( 'main-c1' );
		$mastersPollForC1 = array_keys( $mastersPoll['c1'] );

		$this->assertEquals( reset( $mastersPollForC1 ), $nextMaster['hostName'], 'Secondary master is returned' );
	}

	public function testMarkAsBroken() {
		$hostName = 'db-foo';
		$serverEntry = [
			'hostName' => $hostName
		];

		$poll = new MastersPoll( [] );
		$key = MastersPoll::getStatusKeyForServer( $hostName );

		$this->assertEquals( false, $poll->isMasterBroken( $serverEntry ) );

		// mark the host as broken and check memcache entry
		$poll->markMasterAsBroken( $serverEntry );

		$this->assertEquals( 1, $this->memc->get( $key ) );
		$this->assertEquals( false, $poll->isMasterBroken( $serverEntry ) );

		// now add more broken connection until we reach the threshold
		for ( $i = 1; $i < MastersPoll::SERVER_IS_BROKEN_THRESHOLD; $i++ ) {
			$poll->markMasterAsBroken( $serverEntry );
		}

		// now the host should be marked as broken
		$this->assertEquals( 5, $this->memc->get( $key ) );
		$this->assertEquals( true, $poll->isMasterBroken( $serverEntry ) );
	}
}
