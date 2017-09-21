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
	// TODO Clean up in XW-2393
	const STARTER_EN_TV = 'secondaryczechlab';

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
		// It's required here for dumpStarters.php
		'en:tv' => self::STARTER_EN_TV,
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
	 * Get the starter database for a given language code and vertical
	 *
	 * @param string $lang language code
	 * @param int $vertical vertical id
	 *
	 * @return string
	 */
	public static function getStarterByLanguageAndVertical( $lang, int $vertical ) {
		// TODO Clean up in XW-2393
		if ( $vertical === \WikiFactoryHub::VERTICAL_ID_TV && $lang === 'en' ) {
			return self::STARTER_EN_TV;
		} else {
			return ( isset( self::$mStarters[ $lang ] ) )
				? self::$mStarters[ $lang ]
				: self::$mStarters[ '*' ];
		}
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
