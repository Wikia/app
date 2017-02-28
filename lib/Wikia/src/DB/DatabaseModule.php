<?php
namespace Wikia\DB;

use DI\Scope;
use \Wikia\DependencyInjection\{Module, InjectorBuilder};

class DatabaseModule implements Module {
	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( Database::DB_SLAVE )->to( function () {
				return wfGetDB( DB_SLAVE );
			} )
			->bind( Database::DB_MASTER )->to( \DI\factory( function () {
				return wfGetDB( DB_MASTER );
			} )->scope( Scope::PROTOTYPE ) )
			->bind( ExternalSharedDatabase::DB_SLAVE )->to( function () {
				global $wgExternalSharedDB;
				return wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
			} )
			->bind( ExternalSharedDatabase::DB_MASTER )->to( \DI\factory( function () {
				global $wgExternalSharedDB;
				return wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
			})->scope( Scope::PROTOTYPE ) )
			->bind( DatawareDatabase::DB_SLAVE )->to( function () {
				global $wgExternalDatawareDB;
				return wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
			} )
			->bind( DatawareDatabase::DB_MASTER )->to( \DI\factory( function () {
				global $wgExternalDatawareDB;
				return wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
			} )->scope( Scope::PROTOTYPE ) )
			->bind( SpecialsDatabase::DB_SLAVE )->to( function () {
				global $wgSpecialsDB;
				return wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
			} )
			->bind( SpecialsDatabase::DB_MASTER )->to( \DI\factory( function () {
				global $wgSpecialsDB;
				return wfGetDB( DB_MASTER, [], $wgSpecialsDB );
			} )->scope( Scope::PROTOTYPE ) )
			->bind( StatsDatabase::DB_SLAVE )->to( function () {
				global $wgStatsDB;
				return wfGetDB( DB_SLAVE, [], $wgStatsDB );
			} )
			->bind( StatsDatabase::DB_MASTER )->to( \DI\factory( function () {
				global $wgStatsDB;
				return wfGetDB( DB_MASTER, [], $wgStatsDB );
			} )->scope( Scope::PROTOTYPE ) );
	}
}
