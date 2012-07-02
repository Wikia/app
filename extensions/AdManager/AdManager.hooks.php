<?php

final class AdManagerHooks {

	static $catList = array();

	/**
	 * Schema update to set up the needed database tables.
	 */
	public static function onSchemaUpdate( /* DatabaseUpdater */ $updater = null ) {
		global $wgDBtype;

		if ( $wgDBtype == 'mysql' ) {
			// Set up the current schema.
			if ( $updater === null ) {
				// <= 1.16 support
				global $wgExtNewTables, $wgExtNewIndexes;

				$wgExtNewTables[] = array(
					AD_TABLE,
					dirname( __FILE__ ) . '/AdManager.sql',
					true
				);

				$wgExtNewTables[] = array(
					AD_ZONE_TABLE,
					dirname( __FILE__ ) . '/AdManager.sql',
					true
				);

				/* TODO: Do we need an index? */
			} else {
				// >= 1.17 support
				$updater->addExtensionUpdate( array(
					'addTable',
					AD_TABLE,
					dirname( __FILE__ ) . '/AdManager.sql',
					true
				) );
				$updater->addExtensionUpdate( array(
					'addTable',
					AD_ZONE_TABLE,
					dirname( __FILE__ ) . '/AdManager.sql',
					true
				) );
			}

		}

		return true;
	}

	/**
	 * Recursively walks through tree array.
	 * Creates array containing each input's level.
	 * (array_walk_recursive doesn't like when the value is an array)
	 * A lower count indicates a closer ancestor to the page, that is
	 * supercategories are assigned higher numbers than subcategories
	 */
	private static function assignLevel( $value, $catName, $count = 0 ) {
		$count++;

		if( !empty( $value ) ) {
			array_walk( $value, 'self::assignLevel', $count );
		}

		self::$catList[$catName] = $count;
	}

	// Pop some ads at the bottom of the sidebar
	public static function SkinBuildSidebar( $skin, &$sidebar ) {
		global $wgOut, $wgTitle, $wgAdManagerService, $wgAdManagerCode;

		$fullTableName = AD_TABLE;
		$dbr = wfGetDB( DB_SLAVE );
		if ( !$dbr->tableExists( $fullTableName ) ) {
			return $sidebar;
		}

		// check if an ad zone was set for this page.
		$thisPageID = $wgTitle->getArticleID();
		if ( $thisPageID <= 0 ) {
			return $sidebar;
		}

		$thisPageAdZonesDB = $dbr->select(
			$fullTableName,
			array( 'ad_zone' ),
			"ad_page_id = $thisPageID AND ad_page_is_category IS NOT TRUE",
			__METHOD__
		);

		$thisPageAdZones = array();
		if ( $thisPageAdZonesDB->numRows() !== 0 ) { // If there's a page zone set, it gets precedence.
			while ( $row = $thisPageAdZonesDB->fetchObject() ) {
				$thisPageAdZones[] = $row->ad_zone;
			}
		} else {
			// check if an ad zone was set for any of this page's categories
			$allCategories = $dbr->select(
				$fullTableName,
				array( 'ad_page_id', 'ad_zone' ),
				'ad_page_is_category IS TRUE',
				__METHOD__
			);

			$thisCategoryIDS = $wgTitle->getParentCategoryTree();
			array_walk( $thisCategoryIDS , 'self::assignLevel' );
			asort( self::$catList ); // give precedence to the closest ancestors

			if ( !empty( self::$catList ) ) {
				// find first match in this page's catlist that exists in the database
				foreach ( self::$catList as $catName => $level ) {
					// @todo FIXME: this is awfully hacky and specfic to
					// English; the correct way of doing this would be
					// constructing a Title object and calling getText() on it
					// or something like that to get the name of the category
					// without the namespace
					$catName = substr( $catName, 9 ); // strips Category: prefix
					$catID = Category::newFromName( $catName )->getID();
					$firstMatch = $dbr->select(
						$fullTableName,
						array( 'ad_zone' ),
						"ad_page_id = $catID AND ad_page_is_category IS TRUE",
						__METHOD__
					);
					if ( $firstMatch->numRows() !== 0 ) {
						break;
					}
				}

				while ( $row = $firstMatch->fetchObject() ) {
					$thisPageAdZones[] = $row->ad_zone;
				}
			}
		}

		// And finally, pop those ads in
		if ( empty( $thisPageAdZones ) ) { // No zone set for this page or its categories
			return true;
		}

		if ( in_array( null, $thisPageAdZones ) ) { // An entry in this array was set to "None" so show no ads
			return true;
		}

		if ( $wgAdManagerService == 'openx' ) {
			$wgAdManagerCode = "<a href='http://d1.openx.org/ck.php?cb=91238047' target='_blank'><img src='http://d1.openx.org/avw.php?zoneid=$1&amp;cb=1378957897235' border='0' alt='' /></a>";
		}

		if ( $wgAdManagerService == 'banman' ) {
			$wgAdManagerCode = <<<END
	<!-- Begin -  Site: AAO Zone: /eyewiki -->
	<script language="javascript"  type="text/javascript">
	<!--
	var browName = navigator.appName;
	var SiteID = 1;
	var ZoneID = $1;
	var browDateTime = (new Date()).getTime();
	if ( browName=='Netscape' ) {
		document.write('<s'+'cript lang' + 'uage="jav' + 'ascript" src="http://aaoads.enforme.com/a.aspx?ZoneID=' + ZoneID + '&amp;Task=Get&amp;IFR=False&amp;Browser=NETSCAPE4&amp;SiteID=' + SiteID + '&amp;Random=' + browDateTime  + '">'); document.write('</'+'scr'+'ipt>');
	}
	if ( browName != 'Netscape' ) {
		document.write('<s'+'cript lang' + 'uage="jav' + 'ascript" src="http://aaoads.enforme.com/a.aspx?ZoneID=' + ZoneID + '&amp;Task=Get&amp;IFR=False&amp;SiteID=' + SiteID + '&amp;Random=' + browDateTime  + '">'); document.write('</'+'scr'+'ipt>');
	}
	// -->
	</script>
	<noscript>
		<a href="http://aaoads.enforme.com/a.aspx?ZoneID=$1&amp;Task=Click&amp;Mode=HTML&amp;SiteID=1" target="_blank">
		<img src="http://aaoads.enforme.com/a.aspx?ZoneID=$1&amp;Task=Get&amp;Mode=HTML&amp;SiteID=1" border="0"  alt=""></a>
	</noscript>
	<!-- End -  Site: AAO Zone: /eyewiki_0 -->
END;
		}

		// Other ad services can be added here, with the same format as above

		if ( !isset( $wgAdManagerCode ) ) {
			return true; // TODO: show error
		}

		// Adds some CSS, but puts it in <body>
		$wgOut->addHTML( <<<EOT
<style type="text/css">
div[id*='AdManager'] h5 {
	display: none;
}
div[id*='AdManager'] .pBody {
	border: none;
	padding-left: 0;
}
</style>
EOT
		);

		$adNumber = 0;
		foreach ( $thisPageAdZones as $thisPageAdZone ) {
			$adNumber++;
			// Allows admins to use any ad service or inclusion code they
			// desire by inserting in LocalSettings.php
			$out = str_replace( '$1', $thisPageAdZone, $wgAdManagerCode );
			$sidebar["AdManager$adNumber"] = $out;
		}

		return true;
	}
}
