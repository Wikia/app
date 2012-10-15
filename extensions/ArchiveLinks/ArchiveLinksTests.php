<?php

class ArchiveLinksTests extends PHPUnit_Framework_TestCase {
	public function testLinksRewrittenCorrectly( ) {
		global $wgArchiveLinksConfig;
		
		ArchiveLinks::rewriteLinks( 'http://test.com', 'test.com', &$rewritten_link, array( 'rel' => 'nofollow', 'class' => 'external free' ) );
		
		switch ( $wgArchiveLinksConfig['archive_service'] ) {
			case 'local':
				//spider is not fully implmented, until it is we can't test this
				break;
			case 'wikiwix':
				$this->assertEquals( '<a rel="nofollow" class="external free" href="http://test.com">http://test.com</a><sup><small>&#160;' .
						'<a rel="nofollow" href="http://archive.wikiwix.com/cache/?url=http://test.com">[cache]</a></small></sup>',
						$rewritten_link );
				break;
			case 'webcitation':
				$this->assertEquals( '<a rel="nofollow" class="external free" href="http://test.com">http://test.com</a><sup><small>&#160;' .
						'<a rel="nofollow" href="http://webcitation.org/query?url=http://test.com">[cache]</a></small></sup>',
						$rewritten_link );
				break;
			case 'internet_archive':
			default:
				$this->assertEquals( 'http://wayback.archive.org/web/*/test.com',
						$rewritten_link );
				break;
		}
		
		//$this->assertRegex( '%%', $rewritten_link );
	}
}