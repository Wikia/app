<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;

class SetupWikiCities extends Task {
	use Loggable;

	const DEFAULT_SLOT = "slot1";

	public function run() {
		if ( !$this->addToCityList() ) {
			$this->debug( implode( ":", [ __METHOD__, "Cannot set data in city_list table" ] ) );
			wfProfileOut( __METHOD__ );
			return TaskResult::createForError( 'Cannot add wiki to city_list' );
		}

		// set new city_id
		// check the insert ID of insert to city_list executed inside addToCityList method
		$cityId = $insertId = $this->taskContext->getSharedDBW()->insertId();

		$this->taskContext->setCityId( $insertId );

		if ( empty($insertId) ) {
			wfProfileOut( __METHOD__ );
			return TaskResult::createForError( 'Cannot set data in city_list table. city_id is empty after insert' );
		}

		$this->debug( implode( ":", [ __METHOD__, "Row added added into city_list table, city_id = {$cityId}" ] ) );

		// add domain and www.domain to the city_domains table
		if ( !$this->addToCityDomains() ) {
			wfProfileOut( __METHOD__ );
			return TaskResult::createForError( "Cannot set data in city_domains table" );
		}

		$this->debug(
			implode( ":",
				[ __METHOD__, "Row added into city_domains table, city_id = {$cityId}" ]
			)
		);

		$this->taskContext->getSharedDBW()->commit( __METHOD__ ); // commit shared DB changes

		return TaskResult::createForSuccess();
	}

	public function addToCityList() {
		global $wgCreateDatabaseActiveCluster, $wgWikiaBaseDomain, $wgFandomBaseDomain;
		$founder = $this->taskContext->getFounder();

		$insertFields = [
			'city_title' => $this->taskContext->getSiteName(),
			'city_dbname' => $this->taskContext->getDbName(),
			'city_url' => $this->taskContext->getURL(),
			'city_founding_user' => $founder->getId(),
			'city_founding_email' => $founder->getEmail(),
			'city_founding_ip_bin' => inet_pton( $this->taskContext->getIP() ),
			'city_path' => self::DEFAULT_SLOT,
			'city_description' => $this->taskContext->getSiteName(),
			'city_lang' => $this->taskContext->getLanguage(),
			'city_created' => wfTimestamp( TS_DB, time() ),
			'city_umbrella' => $this->taskContext->getWikiName()
		];

		$insertFields["city_cluster"] = $wgCreateDatabaseActiveCluster;

		return $this->taskContext->getSharedDBW()->insert( "city_list", $insertFields, __METHOD__ );
	}

	public function addToCityDomains() {
		global $wgFandomBaseDomain, $wgWikiaBaseDomain;
		$host = parse_url( $this->taskContext->getURL(), PHP_URL_HOST );
		$domains = [
			[
				'city_id' => $this->taskContext->getCityId(),
				'city_domain' => $this->taskContext->getDomain()
			]
		];
		if ( wfGetBaseDomainForHost( $host ) === $wgFandomBaseDomain ) {
			// for fandom.com wiki, create a secondary wikia.com domain for redirects
			$wikiaDomain = str_replace( '.' . $wgFandomBaseDomain,
				'.' . $wgWikiaBaseDomain,
				$this->taskContext->getDomain() );
			$domains[] = [
				'city_id' => $this->taskContext->getCityId(),
				'city_domain' => $wikiaDomain
			];
		} else {
			// legacy www. subdomain for wikia.com wikis
			$domains[] = [
				'city_id' => $this->taskContext->getCityId(),
				'city_domain' => sprintf( "www.%s", $this->taskContext->getDomain() )
			];
		}

		return $this->taskContext->getSharedDBW()->insert( "city_domains", $domains, __METHOD__ );
	}
}
