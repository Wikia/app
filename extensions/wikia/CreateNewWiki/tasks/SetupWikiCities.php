<?php

namespace Wikia\CreateNewWiki\Tasks;

use CreateWikiException;

class SetupWikiCities implements Task {

	const DEFAULT_SLOT = "slot1";
	const ERROR_DATABASE_WIKI_FACTORY_TABLES_BROKEN = 10;
	const ERROR_DATABASE_WRITE_TO_CITY_DOMAINS_BROKEN = 11;
	const ERROR_DATABASE_WRITE_TO_CITY_LIST_BROKEN = 15;

	private $taskContext;

	public function __construct(TaskContext $taskContext ) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
	}

	public function check() {
	}

	public function run() {
		if ( !$this->addToCityList() ) {
			wfDebugLog( "createwiki", __METHOD__ .": Cannot set data in city_list table\n", true );
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException(
				'Cannot add wiki to city_list',
				self::ERROR_DATABASE_WRITE_TO_CITY_LIST_BROKEN
			);
		}

		// set new city_id
		// check the insert ID of insert to city_list executed inside addToCityList method
		$insertId = $this->taskContext->getSharedDBW()->insertId();

		$this->taskContext->setCityId($insertId);
		if ( empty( $insertId ) ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException(
				'Cannot set data in city_list table. city_id is empty after insert',
				self::ERROR_DATABASE_WIKI_FACTORY_TABLES_BROKEN
			);
		}

		wfDebugLog(
			"createwiki", __METHOD__ . ": Row added added into city_list table, city_id = {$this->taskContext->getCityId()}\n",
			true
		);

		 // add domain and www.domain to the city_domains table
		if ( !$this->addToCityDomains() ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException(
				'Cannot set data in city_domains table',
				self::ERROR_DATABASE_WRITE_TO_CITY_DOMAINS_BROKEN
			);
		}

		wfDebugLog(
			"createwiki", __METHOD__ . ": Row added into city_domains table, city_id = {$this->taskContext->getCityId()}\n",
			true
		);
	}

	private function addToCityList() {
		global $wgRequest;
		$founder = $this->taskContext->getFounder();

		$insertFields = array(
			'city_title'          => $this->taskContext->getSiteName(),
			'city_dbname'         => $this->taskContext->getDbName(),
			'city_url'            => $this->taskContext->getURL(),
			'city_founding_user'  => $founder->getId(),
			'city_founding_email' => $founder->getEmail(),
			'city_founding_ip'    => ip2long($wgRequest->getIP()),
			'city_path'           => self::DEFAULT_SLOT,
			'city_description'    => $this->taskContext->getSiteName(),
			'city_lang'           => $this->taskContext->getLanguage(),
			'city_created'        => wfTimestamp( TS_DB, time() ),
			'city_umbrella'       => $this->taskContext->getWikiName()
		);
		if ( TaskContext::ACTIVE_CLUSTER ) {
			$insertFields[ "city_cluster" ] = TaskContext::ACTIVE_CLUSTER;
		}

		return $this->taskContext->getSharedDBW()->insert( "city_list", $insertFields, __METHOD__ );
	}

	private function addToCityDomains() {
		return $this->taskContext->getSharedDBW()->insert(
			"city_domains",
			[
				[
					'city_id'     => $this->taskContext->getCityId(),
					'city_domain' => $this->taskContext->getDomain()
				], [
					'city_id'     => $this->taskContext->getCityId(),
					'city_domain' => sprintf( "www.%s", $this->taskContext->getDomain() )
				]
			],
			__METHOD__
		);
	}
}
