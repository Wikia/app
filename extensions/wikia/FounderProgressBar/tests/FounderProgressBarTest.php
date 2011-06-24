<?php
require_once dirname(__FILE__) . '/../FounderProgressBar.setup.php';
wfLoadAllExtensions();

class FounderProgressBarTest extends PHPUnit_Framework_TestCase {
        const TEST_DATA = 1;
        const TEST_CITY_ID = 79860;

        /**
         * FounderProgressBarTest class object
         * @var FounderProgressBarTest
         */
        protected $object = null;
        protected $app = null;

        protected function setUp() {
                $this->object = F::build( 'FounderProgressBarController' );
                $this->app = F::build( 'App' );
        }
		
		public function testNothing() {
			$this->assertEquals(true, true);			
		}
}
