<?php

/**
 * Unit tests for LBFactory_Wikia::normalizeMultipleMasters
 *
 * @author macbre
 */
class LoadBalancerTest extends WikiaBaseTest {

	public function testNormalizeMultipleMasters() {
		$masters = [
			'db-c1-a1' => 1,
			'db-c1-a2' => 1,
		];

		$slaves = [
			'db-c1-a3' => 1,
			'db-c1-a4' => 1,
		];

		$central = array(
			'db-c1' => 1,
			'db-c2' => 1,
		);

		$conf = [
			'class' => 'LBFactory_Wikia',
			'sectionLoads' => array(
				'central' => $central,
				'c1' => array(
					'masters' => $masters,
					'slaves' => $slaves,
				),
				'c2' => array(
					'db-c2-a1' => 1,
					'db-c2-a2' => 1,
				),
			),
		];

		LBFactory_Wikia::normalizeMultipleMasters( $conf );
		$servers = $conf['sectionLoads'];

		$this->assertEquals( $slaves, array_slice( $servers['c1'], 1 ), 'List of slaves is maintained' );
		$this->assertContains( array_keys( $servers['c1'] )[0], array_keys( $masters ), 'Master is randomized' );
		$this->assertEquals( $central, $servers['central'], 'central cluster config is left unchanged' );
	}
}
