<?php
namespace RecentChanges;

use PHPUnit\Framework\TestCase;

class SpecialPageTest extends TestCase {
	/** @var SpecialPage $specialPage */
	private $specialPage;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../WikiaRecentChanges.setup.php';

		$this->specialPage = new SpecialPage();
	}

	public function testBuildsProperNamespaceConds() {
		$logTypes = [ 'upload', 'block' ];
		$opts = $this->specialPage->getDefaultOptions();
		$opts->setValue( 'logtype', $logTypes );

		$conds = $this->specialPage->buildMainQueryConds( $opts );

		$this->assertContains( 'rc_log_type IN (upload,block)', $conds );
	}
}
