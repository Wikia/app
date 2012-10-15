<?php

class FeaturedFeeds {
	private static $allInContLang = null;

	/**
	 * Returns the list of feeds
	 * 
	 * @param $langCode string|bool Code of language to use or false if default
	 * @return array Feeds in format of 'name' => array of FeedItem
	 */
	public static function getFeeds( $langCode ) {
		global $wgMemc, $wgLangCode;

		if ( !$langCode || self::allInContentLanguage() ) {
			$langCode = $wgLangCode;
		}
		static $cache = array();
		if ( isset( $cache[$langCode] ) ) {
			return $cache[$langCode];
		}

		$key = self::getCacheKey( $langCode );
		$feeds = $wgMemc->get( $key );
		
		if ( !$feeds ) {
			$feeds = self::getFeedsInternal( $langCode );
			$wgMemc->set( $key, $feeds, self::getMaxAge() );
		}
		$cache[$langCode] = $feeds;
		return $feeds;
	}

	/**
	 * Returns cache key for a given language
	 * @param String $langCode: Feed language code
	 * @return String
	 */
	private static function getCacheKey( $langCode ) {
		return wfMemcKey( 'featured-feeds', $langCode );
	}

	/**
	 * Returns fully prepared feed definitions
	 * @return Array
	 */
	private static function getFeedDefinitions() {
		global $wgFeaturedFeeds, $wgFeaturedFeedsDefaults;
		static $feedDefs = false;
		if ( $feedDefs === false ) {
			$feedDefs = $wgFeaturedFeeds;
			wfRunHooks( 'FeaturedFeeds::getFeeds', array( &$feedDefs ) );

			// fill defaults
			self::$allInContLang = true;
			foreach ( $feedDefs as $name => $opts ) {
				foreach ( $wgFeaturedFeedsDefaults as $setting => $value ) {
					if ( !isset( $opts[$setting] ) ) {
						$feedDefs[$name][$setting] = $value;
					}
				}
				self::$allInContLang = self::$allInContLang && !$feedDefs[$name]['inUserLanguage'];
			}
		}
		return $feedDefs;
	}

	/**
	 * Returns whether all feeds are in content language
	 * @return Boolean
	 */
	public static function allInContentLanguage() {
		if ( is_null( self::$allInContLang ) ) {
			self::getFeedDefinitions();
		}
		return self::$allInContLang;
	}

	/**
	 * Adds feeds to the page header
	 * 
	 * @param OutputPage $out
	 * @return bool
	 */
	public static function beforePageDisplay( OutputPage &$out ) {
		global $wgAdvertisedFeedTypes;
		if ( $out->getTitle()->isMainPage() ) {
			foreach ( self::getFeeds( $out->getLanguage()->getCode() ) as $feed ) {
				foreach ( $wgAdvertisedFeedTypes as $type ) {
					$out->addLink( array(
						'rel' => 'alternate',
						'type' => "application/$type+xml",
						'title' => $feed->title,
						'href' => $feed->getURL( $type ),
					) );
				}
			}
		}
		return true;
	}

	/**
	 * SkinTemplateOutputPageBeforeExec hook handler
	 * @param Skin $sk
	 * @param QuickTemplate $tpl
	 * @return Boolean
	 */
	public static function skinTemplateOutputPageBeforeExec( &$sk, &$tpl ) {
		global $wgDisplayFeedsInSidebar, $wgAdvertisedFeedTypes;

		if ( ( $wgDisplayFeedsInSidebar 
			|| !wfMessage( 'ffeed-enable-sidebar-links' )->inContentLanguage()->isDisabled() )
				&& $sk->getContext()->getTitle()->isMainPage() )
		{
			$feeds = self::getFeeds( $sk->getContext()->getLanguage()->getCode() );
			$links = array();
			$format = $wgAdvertisedFeedTypes[0]; // @fixme:
			foreach ( $feeds as $feed ) {
				$links[] = array(
					'href' => $feed->getURL( $format ),
					'title' => $feed->title,
					'text' => $feed->shortTitle,
				);
			}
			if ( count( $links ) ) {
				$tpl->data['sidebar']['ffeed-sidebar-section'] = $links;
			}
		}
		return true;
	}

	/**
	 * Purges cache on message edit
	 *
	 * @param Article $article
	 * @return bool
	 */
	public static function articleSaveComplete( $article ) {
		global $wgFeaturedFeeds, $wgMemc, $wgLanguageCode;
		$title = $article->getTitle();
		// Although message names are configurable and can be set not to start with 'Ffeed', we
		// make a shortcut here to avoid running these checks on every NS_MEDIAWIKI edit
		if ( $title->getNamespace() == NS_MEDIAWIKI && strpos( $title->getText(), 'Ffeed-' ) === 0 ) {
			$baseTitle = Title::makeTitle( NS_MEDIAWIKI, $title->getBaseText() );
			$messages  = array( 'page', 'title', 'short-title', 'description', 'entryName' );
			foreach ( self::getFeedDefinitions() as $feed ) {
				foreach ( $messages as $msgType ) {
					$nt = Title::makeTitleSafe( NS_MEDIAWIKI, $feed[$msgType] );
					if ( $nt->equals( $baseTitle ) ) {
						wfDebug( "FeaturedFeeds-related page {$title->getFullText()} edited, purging cache\n" );
						$wgMemc->delete( self::getCacheKey( $wgLanguageCode ) );
						$lang = $title->getSubpageText();
						// Sorry, users of multilingual feeds, we can't purge cache for every possible language
						if ( $lang != $baseTitle->getText() ) {
							$wgMemc->delete( $lang );
						}
						return true;
					}
				}
			}
		}
		return true;
	}

	/**
	 * @param $langCode string
	 * @return array
	 * @throws MWException
	 */
	private static function getFeedsInternal( $langCode ) {
		wfProfileIn( __METHOD__ );
		$feedDefs = self::getFeedDefinitions();
		
		$feeds = array();
		$requestedLang = Language::factory( $langCode );
		foreach ( $feedDefs as $name => $opts ) {
			$feed = new FeaturedFeedChannel( $name, $opts, $requestedLang );
			if ( !$feed->isOK() ) {
				continue;
			}
			$feed->getFeedItems();
			$feeds[$name] = $feed;
		}
		wfProfileOut( __METHOD__ );

		return $feeds;
	}

	

	/**
	 * Returns the Unix timestamp of current day's first second
	 * 
	 * @return int Timestamp
	 */
	public static function todaysStart() {
		static $time = false;
		if ( !$time ) {
			$time = self::startOfDay( time() );
		}
		return $time;
	}

	/**
	 * Returns the Unix timestamp of current day's first second
	 * 
	 * @return int Timestamp
	 */
	public static function startOfDay( $timestamp ) {
		global $wgLocaltimezone;
		if ( isset( $wgLocaltimezone ) ) {
			$tz = new DateTimeZone( $wgLocaltimezone );
		} else {
			$tz = new DateTimeZone( date_default_timezone_get() );
		}
		$dt = new DateTime( "@$timestamp", $tz );
		$dt->setTime( 0, 0, 0 );
		return $dt->getTimestamp();
	}

	/**
	 * Returns the number of seconds a feed should stay in cache
	 * 
	 * @return int: Time in seconds
	 */
	public static function getMaxAge() {
		// add 10 seconds to cater for time deviation between servers
		$expiry = self::todaysStart() + 24 * 3600 - wfTimestamp() + 10;
		return min( $expiry, 3600 );
	}
}

class FeaturedFeedChannel {
	/**
	 * @var ParserOptions
	 */
	private static $parserOptions = null;
	/**
	 * @var Parser
	 */
	private static $parser;

	/**
	 * @var Language
	 */
	private $language;

	private $name;
	private $options;
	private $items = false;
	private $page = false;
	private $entryName;

	public $title = false;
	public $shortTitle;
	public $description;

	public function __construct( $name, $options, $lang ) {
		global $wgContLang;
		if ( !self::$parserOptions ) {
			self::$parserOptions = new ParserOptions();
			self::$parserOptions->setEditSection( false );
			self::$parser = new Parser();
		}
		$this->name = $name;
		$this->options = $options;
		if ( $options['inUserLanguage'] ) {
			$this->language = $lang;
		} else {
			$this->language = $wgContLang;
		}
	}

	/**
	 * @param $key string
	 * @return Message
	 */
	private function msg( $key ) {
		return wfMessage( $key )->inLanguage( $this->language );
	}

	/**
	 * @return bool
	 */
	public function isOK() {
		$this->init();
		return $this->page !== false;
	}

	/**
	 * Returns language used by the feed
	 * @return Language
	 */
	public function getLanguage() {
		return $this->language;
	}

	public function init() {
		global $wgLanguageCode;
		if ( $this->title !== false ) {
			return;
		}
		$this->title = $this->msg( $this->options['title'] )->text();
		$this->shortTitle = $this->msg( $this->options['short-title'] );
		$this->description = $this->msg( $this->options['description'] )->text();
		$pageMsg = $this->msg( $this->options['page'] )->params( $this->language->getCode() );
		if ( $pageMsg->isDisabled() ) {
			// fall back manually, messages can be existent but empty
			if ( $this->language->getCode() != $wgLanguageCode ) {
				$pageMsg = wfMessage( $this->options['page'] )
					->params( $this->language->getCode() )
					->inContentLanguage();
			}
		}
		if ( $pageMsg->isDisabled() ) {
			return;
		}
		$this->page = $pageMsg->plain();
		$this->entryName = $this->msg( $this->options['entryName'] )->plain();
	}

	/**
	 * @return array
	 */
	public function getFeedItems() {
		$this->init();
		if ( $this->items === false ) {
			$this->items = array();
			for ( $i = 1 - $this->options['limit']; $i <= 0; $i++ ) {
				$timestamp = FeaturedFeeds::todaysStart() + $i * 24 * 3600;
				$item = $this->getFeedItem( $timestamp );
				if ( $item ) {
					$this->items[] = $item;
				}
			}
		}
		return $this->items;
	}

	/**
	 *
	 * @param int $date
	 * @return FeaturedFeedItem
	 */
	public function getFeedItem( $date ) {
		self::$parserOptions->setTimestamp( $date );
		self::$parserOptions->setUserLang( $this->language );

		$titleText = self::$parser->transformMsg( $this->page, self::$parserOptions );
		$title = Title::newFromText( $titleText );
		if ( !$title ) {
			return false;
		}
		$rev = Revision::newFromTitle( $title );
		if ( !$rev ) {
			return false; // page does not exist
		}
		$text = $rev->getText();
		if ( !$text ) {
			return false;
		}
		$text = self::$parser->parse( $text, $title, self::$parserOptions )->getText();
		$url = SpecialPage::getTitleFor( 'FeedItem' , 
			$this->name . '/' . wfTimestamp( TS_MW, $date ) . '/' . $this->language->getCode()
		)->getFullURL();

		return new FeaturedFeedItem(
			self::$parser->transformMsg( $this->entryName, self::$parserOptions ),
			wfExpandUrl( $url ),
			$text,
			$date
		);
	}

	/**
	 * Returns a URL to the feed
	 * 
	 * @param $format string Feed format, 'rss' or 'atom'
	 * @return String 
	 */
	public function getURL( $format ) {
		global $wgContLang;

		$options = array(
			'action' => 'featuredfeed',
			'feed' => $this->name,
			'feedformat' => $format,
		);
		if ( $this->options['inUserLanguage'] && $this->language->getCode() != $wgContLang->getCode() ) {
			$options['language'] = $this->language->getCode();
		}
		return wfScript( 'api' ) . '?' . wfArrayToCGI( $options );
	}
}

class FeaturedFeedItem extends FeedItem {
	const CACHE_VERSION = 1;

	public function __construct( $title, $url, $text, $date ) {
		parent::__construct( $title, $text, $url, $date );
	}

	public function getRawDate() {
		return $this->date;
	}

	public function getRawTitle() {
		return $this->title;
	}

	public function getRawUrl() {
		return $this->url;
	}

	public function getRawText() {
		return $this->description;
	}
}
