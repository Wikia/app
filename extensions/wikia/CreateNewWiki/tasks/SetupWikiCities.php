<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;

class SetupWikiCities extends Task {
	use Loggable;

	const DEFAULT_SLOT = "slot1";

	public function run() {
		if ( !$this->addToCityList() ) {
			$this->debug( implode( ":", [ __METHOD__, "Cannot set data in city_list table" ] ) );
			return TaskResult::createForError( 'Cannot add wiki to city_list' );
		}

		// set new city_id
		// check the insert ID of insert to city_list executed inside addToCityList method
		$wikiId = $this->taskContext->getSharedDBW()->insertId();

		$this->taskContext->setCityId( $wikiId );

		if ( empty( $wikiId ) ) {
			return TaskResult::createForError( 'Cannot set data in city_list table. city_id is empty after insert' );
		}

		$this->debug( implode( ":", [ __METHOD__, "Row added added into city_list table, city_id = {$wikiId}" ] ) );

		// add domain and www.domain to the city_domains table
		if ( !$this->addToCityDomains() ) {
			return TaskResult::createForError( "Cannot set data in city_domains table" );
		}

		$this->debug(
			implode( ":",
				[ __METHOD__, "Row added into city_domains table, city_id = {$wikiId}" ]
			)
		);

		$this->taskContext->getSharedDBW()->commit( __METHOD__ ); // commit shared DB changes

		$this->overrideLocalContext( $wikiId );

		return TaskResult::createForSuccess();
	}

	public function addToCityList() {
		global $wgCreateDatabaseActiveCluster;

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
			'city_umbrella' => $this->taskContext->getWikiName(),
			'city_cluster' => $wgCreateDatabaseActiveCluster,
		];

		if ( $this->taskContext->isFandomCreatorCommunity() ) {
			$insertFields['city_flags'] = \WikiFactory::FLAG_PROTECTED;
		}

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

			// Add *.fandom.com/en alias for English wikis
			if ( $this->taskContext->getLanguage() === 'en' ) {
				$domains[] = [
					'city_id' => $this->taskContext->getCityId(),
					'city_domain' => "{$this->taskContext->getDomain()}/en"
				];
			}
		} else {
			// legacy www. subdomain for wikia.com wikis
			$domains[] = [
				'city_id' => $this->taskContext->getCityId(),
				'city_domain' => sprintf( "www.%s", $this->taskContext->getDomain() )
			];
		}

		return $this->taskContext->getSharedDBW()->insert( "city_domains", $domains, __METHOD__ );
	}

	/**
	 * Extract the context data of the newly created wiki into the global scope.
	 * This effectively causes task execution to continue in the scope of the newly created wiki.
	 *
	 * @param int $wikiId ID of the newly created wiki
	 * @throws \Exception
	 */
	private function overrideLocalContext( int $wikiId ) {
		global $wgCityId, $wgDBname, $wgDBcluster, $wgLBFactoryConf, $wgServer, $wgScriptPath, $wgScript,
			   $wgArticlePath, $wgCreateDatabaseActiveCluster, $wgPreWikiFactoryValues, $wgLanguageCode;

		// Reinstate default variable values, removing WF overrides for community wiki
		foreach ( $wgPreWikiFactoryValues as $name => $value ) {
			if ( array_key_exists( $name, $GLOBALS ) ) {
				$GLOBALS[$name] = $value;
			}
		}

		$wgCityId = $wikiId;

		$language = $this->taskContext->getLanguage();

		if ( $language !== $wgLanguageCode ) {
			global $wgContLang;

			$wgLanguageCode = $language;

			$wgContLang = \Language::factory( $language );
			$wgContLang->initEncoding();
			$wgContLang->initContLang();
		}

		$url = $this->taskContext->getURL();

		$wgServer = \WikiFactory::getLocalEnvURL( \WikiFactory::cityUrlToDomain( $url ) );
		$wgScriptPath = \WikiFactory::cityUrlToLanguagePath( $url );
		$wgScript = \WikiFactory::cityUrlToWgScript( $url );
		$wgArticlePath = \WikiFactory::cityUrlToArticlePath( $url, $wikiId );

		// Ensure that we can connect to the new wiki DB via wfGetDB() and friends
		$wgDBname = $this->taskContext->getDbName();
		$wgDBcluster = $wgCreateDatabaseActiveCluster;
		$wgLBFactoryConf['serverTemplate']['dbname'] = $wgDBname;

		// destroy old load balancers
		\LBFactory::destroyInstance();
	}
}
