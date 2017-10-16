<?php

class DiscussionsVarToggler {

	// Discussions related wg variables
	const ENABLE_DISCUSSIONS_NAV = 'wgEnableDiscussionsNavigation';
	const ENABLE_DISCUSSIONS = 'wgEnableDiscussions';
	const ENABLE_FORUMS = 'wgEnableForumExt';
	const ARCHIVE_WIKI_FORUMS = 'wgArchiveWikiForums';
	const ENABLE_RECIRC_DISCUSSIONS = 'wgEnableRecirculationDiscussions';

	private $discussionsVarMap;
	private $cityId;

	public function __construct( int $cityId ) {
		$this->cityId = $cityId;
		$this->discussionsVarMap = [
			self::ENABLE_DISCUSSIONS => null,
			self::ENABLE_DISCUSSIONS_NAV => null,
			self::ENABLE_FORUMS => null,
			self::ARCHIVE_WIKI_FORUMS => null,
			self::ENABLE_RECIRC_DISCUSSIONS => null
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

	public function setEnableRecircDiscussions( bool $val ) : DiscussionsVarToggler {
		$this->discussionsVarMap[self::ENABLE_RECIRC_DISCUSSIONS] = $val;
		return $this;
	}

	public function save() {
		foreach ( $this->discussionsVarMap as $varName => $value ) {
			if ( !is_null( $value ) ) {
				$success = WikiFactory::setVarByName( $varName, $this->cityId, $value );
				if ( !$success ) {
					$this->logAndThrowError( $varName, $this->cityId, $value );
				}
			}
		}
	}

	private function logAndThrowError( $varName, $siteId, $value ) {
		Wikia\Logger\WikiaLogger::instance()->error(
			'DISCUSSIONS Error setting Discussions related wg variable',
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
