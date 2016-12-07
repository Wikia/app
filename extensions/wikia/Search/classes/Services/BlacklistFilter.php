<?php

namespace Wikia\Search\Services;

class BlacklistFilter {
	// null is not callable but to be able to still set null function, default value must be provided
	// SIGH: php
	public static function unionSetProvider( callable $fn1 = null, callable $fn2 = null ) {
		if ( empty( $fn1 ) ) {
			return $fn2;
		} elseif ( empty( $fn2 ) ) {
			return $fn1;
		} else {
			return function () use ( $fn1, $fn2 ) {
				return array_values( array_unique( array_merge( $fn1(), $fn2() ) ) );
			};
		}
	}

	public static function staticProvider( array $ids ) {
		return function () use ( $ids ) {
			return $ids;
		};
	}

	public static function materializeProvider( callable $provider = null ) {
		if ( !empty( $provider ) ) {
			return $provider();
		} else {
			return null;
		}
	}

	/**
	 * @var callable
	 */
	protected $blacklistedIdsProvider;

	/**
	 * @var callable
	 */
	protected $blacklistedHostsProvider;

	protected $coreName;

	function __construct( $coreName ) {
		$this->coreName = $coreName;
		// licenced should be used by default because we are not able to syndicate
		// non CC content
		$this->blacklistedIdsProvider = $this->getLicensedWikisIdsProvider();
	}

	public function getLicensedWikisIdsProvider() {
		if ( class_exists( 'LicensedWikisService' ) ) {
			return function () {
				$licencedService = new \LicensedWikisService();

				return array_keys( $licencedService->getCommercialUseNotAllowedWikis() );
			};
		} else {
			return null;
		}
	}

	public function addBlacklistedHostsProvider( callable $newProvider = null ) {
		$this->blacklistedHostsProvider = self::unionSetProvider(
			$this->blacklistedHostsProvider,
			$newProvider
		);
	}

	public function addBlacklistedIdsProvider( callable $newProvider = null ) {
		$this->blacklistedIdsProvider = self::unionSetProvider(
			$this->blacklistedIdsProvider,
			$newProvider
		);
	}

	public function setBlacklistedHostsProvider( callable $provider = null ) {
		$this->blacklistedHostsProvider = $provider;
	}

	public function setBlacklistedIdsProvider( callable $provider = null ) {
		$this->blacklistedIdsProvider = $provider;
	}

	public function getBlacklistedHostsProvider() {
		return $this->blacklistedHostsProvider;
	}

	public function getBlacklistedIdsProvider() {
		return $this->blacklistedIdsProvider;
	}

	/**
	 * Apply excluded wiki IDs and HOSTs.
	 *
	 * @param $select \Solarium_Query_Select
	 *
	 * @return \Solarium_Query_Select
	 */
	public function applyFilters( \Solarium_Query_Select $select ) {
		$blackHostsQuery = $this->getBlacklistedHostsQuery();
		if ( !empty( $blackHostsQuery ) ) {
			$select->createFilterQuery( 'excl' )->setQuery( $blackHostsQuery );
		}

		$blacklistIdsQuery = $this->getBlacklistedWikiIdsQuery();
		if ( !empty( $blacklistIdsQuery ) ) {
			$select->createFilterQuery( "widblacklist" )->setQuery( $blacklistIdsQuery );
		}

		return $select;
	}

	public function getBlacklistedHostsQuery() {
		$coreFieldNames = SearchCores::getCoreFieldNames( $this->coreName );
		$blacklistedWikiHosts = self::materializeProvider( $this->blacklistedHostsProvider );

		if ( !empty( $blacklistedWikiHosts ) ) {
			$excluded = [];
			foreach ( $blacklistedWikiHosts as $ex ) {
				$excluded[] = "-({$coreFieldNames[SearchCores::F_WIKI_HOST]}:{$ex})";
			}

			return implode( ' AND ', $excluded );
		} else {
			return null;
		}
	}

	public function getBlacklistedWikiIdsQuery() {
		$coreFieldNames = SearchCores::getCoreFieldNames( $this->coreName );
		$blacklistedWikiIds = self::materializeProvider( $this->blacklistedIdsProvider );

		if ( !empty( $blacklistedWikiIds ) ) {
			$excluded = [];
			foreach ( $blacklistedWikiIds as $wikiId ) {
				$excluded[] = "-({$coreFieldNames[SearchCores::F_WIKI_ID]}:{$wikiId})";
			}

			return implode( ' AND ', $excluded );
		} else {
			return null;
		}
	}
}
