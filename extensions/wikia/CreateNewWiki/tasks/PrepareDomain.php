<?php

namespace Wikia\CreateNewWiki\Tasks;

class PrepareDomain implements Task {

	use \Wikia\Logger\Loggable;

	const DEFAULT_DOMAIN = "wikia.com";
	const LOCK_DOMAIN_TIMEOUT = 30;

	/** @var  TaskContext */
	private $taskContext;

	public function __construct( $taskContext ) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
		global $wgContLang;

		$wikiLanguage = $this->taskContext->getLanguage();

		$this->taskContext->setSiteName(
			$this->getSiteName( $wgContLang, $wikiLanguage, $this->taskContext->getInputWikiName() )
		);

		$domain = $this->getDomain( $this->taskContext->getInputDomain() );
		$this->taskContext->setWikiName( $domain );

		$subdomain = $domain;

		if ( !empty($wikiLanguage) && $wikiLanguage !== "en" ) {
			$subdomain = strtolower( $wikiLanguage ) . "." . $domain;
		}

		$this->taskContext->setDomain( sprintf( "%s.%s", $subdomain, self::DEFAULT_DOMAIN ) );
		$this->taskContext->setUrl( sprintf( "http://%s.%s/", $subdomain, self::DEFAULT_DOMAIN ) );

		return TaskResult::createForSuccess();
	}

	public function check() {
		$errorMsg = \CreateWikiChecks::checkDomainIsCorrect(
			$this->taskContext->getDomain(), $this->taskContext->getLanguage(), false, false
		);
		if ( !empty($errorMsg) ) {
			return TaskResult::createForError( 'DB is read only' );
		} else {
			return TaskResult::createForSuccess();
		}
	}

	public function run() {
		if ( $this->lockDomain( $this->taskContext->getDomain() ) ) {
			return TaskResult::createForSuccess();
		} else {
			return TaskResult::createForError( 'Failed to create a lock on domain name - domain taken' );
		}
	}

	/**
	 * Returns memcache key for locking given domain
	 * @param string $domain
	 * @return string
	 */
	public function getLockDomainKey( $domain ) {
		return wfSharedMemcKey( 'createwiki', 'domain', 'lock', urlencode( $domain ) );
	}

	/**
	 * Locks domain if possible for predefined amount of time
	 * Returns true if successful
	 *
	 * @param string $domain
	 * @return bool
	 */
	public function lockDomain( $domain ) {
		global $wgMemc;

		$key = $this->getLockDomainKey( $domain );
		$status = $wgMemc->add( $key, 1, self::LOCK_DOMAIN_TIMEOUT );

		return $status;
	}

	public function getSiteName( $contentLanguage, $wikiLanguage, $inputWikiName ) {
		$fixedTitle = trim( $inputWikiName );
		$fixedTitle = preg_replace( "/\s+/", " ", $fixedTitle );
		$fixedTitle = preg_replace( "/ (w|W)iki$/", "", $fixedTitle );
		$fixedTitle = $contentLanguage->ucfirst( $fixedTitle );
		$siteTitle = wfMessage( 'autocreatewiki-title-template', $fixedTitle );

		return $siteTitle->inLanguage( $wikiLanguage )->text();
	}

	public function getDomain( $inputDomain ) {
		$domain = preg_replace( "/(\-)+$/", "", $inputDomain );
		$domain = preg_replace( "/^(\-)+/", "", $domain );
		$domain = strtolower( trim( $domain ) );

		return $domain;
	}
}

