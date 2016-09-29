<?php

class DiscussionsVarToggler {

	// Discussions related wg variables
	const ENABLE_DISCUSSIONS_NAV = 'wgEnableDiscussionsNavigation';
	const ENABLE_DISCUSSIONS = 'wgEnableDiscussions';
	const ENABLE_FORUMS = 'wgEnableForumExt';
	const ARCHIVE_WIKI_FORUMS = 'wgArchiveWikiForums';

	private $discussionsVarMap;
	private $logger;

	public function __construct() {
		$this->logger = Wikia\Logger\WikiaLogger::instance();
		$this->discussionsVarMap = [
			self:: ENABLE_DISCUSSIONS => null,
			self::ENABLE_DISCUSSIONS_NAV => null,
			self::ENABLE_FORUMS => null,
			self::ARCHIVE_WIKI_FORUMS => null
		];
	}

	public function setEnableDiscussions( bool $val ) : DiscussionsVarToggler {
		$this->discussionsVarMap[self::ENABLE_DISCUSSIONS] = $val;
		return $this;
	}

	public function setEnableDiscussionsNav( bool $val ) : DiscussionsVarToggler {
		$this->discussionsVarMap[self::ENABLE_DISCUSSIONS_NAV] = $val;
		return $this;
	}

	public function setEnableForums( bool $val ) : DiscussionsVarToggler {
		$this->discussionsVarMap[self::ENABLE_FORUMS] = $val;
		return $this;
	}

	public function setArchiveWikiForums( bool $val ) : DiscussionsVarToggler {
		$this->discussionsVarMap[self::ARCHIVE_WIKI_FORUMS] = $val;
		return $this;
	}

	public function save() {
		$siteId = F::app()->wg->CityId;
		foreach ( $this->discussionsVarMap as $varName => $value ) {
			if ( !is_null( $value ) ) {
				$success = WikiFactory::setVarByName( $varName, $siteId, $value );
				if ( !$success ) {
					$this->logAndThrowError( $varName, $siteId, $value );
				}
			}
		}
	}

	private function logAndThrowError( $varName, $siteId, $value ) {
		$this->logger->error(
			'Error setting Discussions related wg variable',
			[
				'siteId' => $siteId,
				'varName' => $varName,
				'varValue' => $value,
			]
		);
		throw new DiscussionsVarTogglerException();
	}
}

class DiscussionsVarTogglerException extends Exception {}
