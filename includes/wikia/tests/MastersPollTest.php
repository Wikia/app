<?php

use Wikia\MastersPoll;

/**
 * Unit tests for LBFactory_Wikia::normalizeMultipleMasters
 *
 * @author macbre
 */
class MastersPollTest extends WikiaBaseTest {

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

		$poll = new MastersPoll($conf);

		$servers = $poll->getConf()['sectionLoads'];
		$mastersPoll = $poll->getConf()['mastersPoolBySection'];

		$selectedMaster = array_keys( $servers['c1'] )[0];

		# master selection
		$this->assertEquals( $slaves, array_slice( $servers['c1'], 1 ), 'List of slaves is maintained' );
		$this->assertContains( $selectedMaster, array_keys( $masters ), 'Master is randomized' );
		$this->assertEquals( $central, $servers['central'], 'central cluster config is left unchanged' );

		# masters poll
		$this->assertInternalType('array', $mastersPoll['c1'], 'Masters poll should be generated' );
		$this->assertNotContains( $selectedMaster, $mastersPoll['c1'], 'Masters poll should not contain selected master' );

		# next master for section
		$this->assertEquals( false, $poll->getNextMasterForSection('main-central'), 'This cluster has no secondary master defined' );

		$nextMaster = $poll->getNextMasterForSection( 'main-c1' );
		$mastersPollForC1 = array_keys( $mastersPoll['c1'] );

		$this->assertEquals( reset( $mastersPollForC1 ), $nextMaster['hostName'], 'Secondary master is returned' );
	}
}
