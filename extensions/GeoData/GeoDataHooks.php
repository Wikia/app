<?php

class GeoDataHooks {
	/**
	 * LoadExtensionSchemaUpdates hook handler
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/LoadExtensionSchemaUpdates
	 * @param DatabaseUpdater $updater
	 */
	public static function onLoadExtensionSchemaUpdates( DatabaseUpdater $updater ) {
		switch ( $updater->getDB()->getType() ) {
			case 'mysql':
			case 'sqlite':
				$updater->addExtensionTable( 'geo_tags', dirname( __FILE__ ) . '/GeoData.sql' );
				break;
			default:
				throw new MWException( 'GeoData extension currently supports only MySQL and SQLite' );
		}
		return true;
	}

	/**
	 * UnitTestsList hook handler
	 * @see: https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
	 * @param Array $files 
	 */
	public static function onUnitTestsList( &$files ) {
		$dir = dirname( __FILE__ ) . "/tests";
		$files[] = "$dir/ParseCoordTest.php";
		$files[] = "$dir/GeoMathTest.php";
		$files[] = "$dir/TagTest.php";
		$files[] = "$dir/MiscGeoDataTest.php";
		return true;
	}

	/**
	 * ParserFirstCallInit hook handler
	 * @see: https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
	 * @param Parser $parser 
	 */
	public static function onParserFirstCallInit( &$parser ) {
		$parser->setFunctionHook( 'coordinates', 
			array( new CoordinatesParserFunction( $parser ), 'coordinates' ),
			SFH_OBJECT_ARGS
		);
		return true;
	}

	/**
	 * ArticleDeleteComplete hook handler
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ArticleDeleteComplete
	 *
	 * @param Article $article
	 * @param User $user
	 * @param String $reason
	 * @param int $id
	 */
	public static function onArticleDeleteComplete( &$article, User &$user, $reason, $id ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'geo_tags', array( 'gt_page_id' => $id ), __METHOD__ );
		return true;
	}

	/**
	 * LinksUpdate hook handler
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/LinksUpdate
	 * @param LinksUpdate $linksUpdate
	 */
	public static function onLinksUpdate( &$linksUpdate ) {
		global $wgUseDumbLinkUpdate;
		$out = $linksUpdate->getParserOutput();
		$data = array();
		if ( isset( $out->geoData ) ) {
			$geoData = $out->geoData;
			$data = $geoData->getAll();
		}
		if ( $wgUseDumbLinkUpdate || !count( $data ) ) {
			self::doDumbUpdate( $data, $linksUpdate->mId );
		} else {
			self::doSmartUpdate( $data, $linksUpdate->mId );
		}
		return true;
	}

	private static function doDumbUpdate( $coords, $pageId ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'geo_tags', array( 'gt_page_id' => $pageId ), __METHOD__ );
		$rows = array();
		foreach ( $coords as $coord ) {
			$rows[] = $coord->getRow( $pageId );
		}
		$dbw->insert( 'geo_tags', $rows, __METHOD__ );
	}

	private static function doSmartUpdate( $coords, $pageId ) {
		$prevCoords = GeoData::getAllCoordinates( $pageId, array(), DB_MASTER );
		$add = array();
		$delete = array();
		foreach ( $prevCoords as $old ) {
			$delete[$old->id] = $old;
		}
		foreach ( $coords as $new ) {
			$match = false;
			foreach ( $delete as $id => $old ) {
				if ( $new->fullyEqualsTo( $old ) ) {
					unset( $delete[$id] );
					$match = true;
					break;
				}
			}
			if ( !$match ) {
				$add[] = $new->getRow( $pageId );
			}
		}
		$dbw = wfGetDB( DB_MASTER );
		if ( count( $delete) ) {
			$dbw->delete( 'geo_tags', array( 'gt_id' => array_keys( $delete ) ), __METHOD__ );
		}
		if ( count( $add ) ) {
			$dbw->insert( 'geo_tags', $add, __METHOD__ );
		}
	}
}
