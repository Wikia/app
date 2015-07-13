<?php

namespace Wikia\CreateNewWiki;

use Wikia\SwiftStorage;

/**
 * A helper class for getting a proper starter wiki based on a given language
 *
 * @author macbre
 */
class Starters {

	const STARTER_DUMPS_BUCKET = 'starter';

	/**
	 * starters map: langcode => database name
	 *
	 * "*" is default
	 */
	static private $mStarters = [
		"*"  => "aastarter",
		"de" => "destarter",
		"en" => "starter",
		"es" => "esstarter",
		"fi" => "fistarter",
		"fr" => "starterbeta",
		"it" => "italianstarter",
		"ja" => "jastarter",
		"ko" => "starterko",
		"nl" => "nlstarter",
		"pl" => "plstarter",
		"ru" => "rustarter",
	];

	/**
	 * Get the starter database for a given language code
	 *
	 * @param string $lang language code
	 * @return string
	 */
	public static function getStarterByLanguage( $lang ) {
		return ( isset( self::$mStarters[ $lang ] ) )
			? self::$mStarters[ $lang ]
			: self::$mStarters[ "*" ];
	}

	/**
	 * @return array
	 */
	public static function getAllStarters() {
		return self::$mStarters;
	}

	/**
	 * Return a remote DFS path to the starter content XML dump file
	 *
	 * @param string $starter starter DB name
	 * @return string
	 */
	public static function getStarterContentDumpPath( $starter ) {
		return sprintf( '/dumps/%s.xml.bz2', $starter );
	}

	/**
	 * Return a remote DFS path to the starter SQL dump file
	 *
	 * @param string $starter starter DB name
	 * @return string
	 */
	public static function getStarterSqlDumpPath( $starter ) {
		return sprintf( '/dumps/%s.sql.bz2', $starter );
	}

	/**
	 * Return SwiftStorage instance used to upload and fetch XML dumps
	 *
	 * @return SwiftStorage
	 */
	public static function getStarterDumpStorage() {
		return SwiftStorage::newFromContainer( self::STARTER_DUMPS_BUCKET );
	}
}
