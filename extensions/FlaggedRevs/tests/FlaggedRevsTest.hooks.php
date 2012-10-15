<?php
/**
 * Class containing test related event-handlers for FlaggedRevs
 */
class FlaggedRevsTestHooks {
	public static function getUnitTests( &$files ) {
		$files[] = dirname( __FILE__ ) . '/FRInclusionManagerTest.php';
		$files[] = dirname( __FILE__ ) . '/FRUserCountersTest.php';
		$files[] = dirname( __FILE__ ) . '/FRUserActivityTest.php';
		$files[] = dirname( __FILE__ ) . '/FRParserCacheStableTest.php';
		$files[] = dirname( __FILE__ ) . '/FlaggablePageTest.php';
		$files[] = dirname( __FILE__ ) . '/FlaggedRevsSetupTest.php';
		return true;
	}

	public static function onParserTestTables( array &$tables ) {
		$tables[] = 'flaggedpages';
		$tables[] = 'flaggedrevs';
		$tables[] = 'flaggedpage_pending';
		$tables[] = 'flaggedpage_config';
		$tables[] = 'flaggedtemplates';
		$tables[] = 'flaggedimages';
		$tables[] = 'flaggedrevs_promote';
		$tables[] = 'flaggedrevs_tracking';
		$tables[] = 'valid_tag'; // we need this core table
		return true;
	}
}
