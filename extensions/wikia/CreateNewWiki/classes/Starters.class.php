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
		'*'  => 'aastarter',
		'cs' => 'aastarter3',
		'de' => 'destarter',
		'en' => 'starter',
		'el' => 'aastarter6',
		'es' => 'esstarter',
		'fi' => 'fistarter',
		'fr' => 'starterbeta',
		'hu' => 'aastarter5',
		'id' => 'aastarter2',
		'it' => 'italianstarter',
		'ja' => 'jastarter',
		'ko' => 'starterko',
		'nl' => 'nlstarter',
		'pl' => 'plstarter',
		'pt' => 'aastarter1',
		'pt-br' => 'aastarter1',
		'ru' => 'rustarter',
		'sv' => 'aastarter8',
		'th' => 'aastarter7',
		'tl' => 'tlstartertl',
		'tr' => 'aastarter4',
		'vi' => 'vistarter287',
		'zh' => 'zhstarter',
		'zh-hk' => 'aastarterzhtw',
		'zh-tw' => 'aastarterzhtw'
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
			: self::$mStarters[ '*' ];
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
		return sprintf( 'starter/%s.xml.bz2', $starter );
	}

	/**
	 * Return a remote DFS path to the starter SQL dump file
	 *
	 * @param string $starter starter DB name
	 * @return string
	 */
	public static function getStarterSqlDumpPath( $starter ) {
		return sprintf( 'starter/%s.sql.bz2', $starter );
	}
}
