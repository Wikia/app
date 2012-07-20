<?php

/*
 Wiki Feed Generator for MediaWiki
 Gregory Szorc <gregory.szorc@gmail.com>

 This library is free software; you can redistribute it and/or
 modify it under the terms of the GNU Lesser General Public
 License as published by the Free Software Foundation; either
 version 2.1 of the License, or (at your option) any later version.

 This library is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 Lesser General Public License for more details.

 You should have received a copy of the GNU Lesser General Public
 License along with this library; if not, write to the Free Software
 Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA


 Directions:
 This script requires MediaWiki 1.5+ and PHP 5 to run.  It was developed against MediaWiki
 1.8.2 and PHP 5.1.6.  If it doesn't work, upgrade!

 To use this script, copy it to your extensions/ subdirectory inside the MediaWiki install.
 Add the following in LocalSettings.php:

 include_once('SpecialWikiFeeds.php');

 This script also needs my GenericXmlSyndicationFeed class, which can be found at
 http://opensource.case.edu/svn/MediaWikiHacks/classes/GenericXmlSyndicationFeed/GenericXmlSyndicationFeed.php

 You will need to manually include this file before the require/include SpecialWikiFeeds.php
 in LocalSettings.php or else when this file loads, you will get a big, fat error message.

 Example LocalSettings.php entry:

 require("$IP/extensions/GenericXmlSyndicationFeed.php");
 require("$IP/extensions/SpecialWikiFeeds.php");
 $wgWikiFeedsSettings['cacheEnable'] = true;

 Once WikiFeeds is enabled in LocalSettings.php,
 go to Special:WikiFeeds in your wiki.  Everything should be set!

 WikiFeeds can be slightly customized.  Settings which can be changed are located
 in the $wgWikiFeedsSettings array (defined and documentation below).  If you wish
 to change a setting, re-set it in LocalSettings.php, after including this file
 (see above example)

 If you encounter a bug, please file it at http://opensource.case.edu/projects/MediaWikiHacks
 or e-mail me.

 Other:
 The script supports ATOM 1.0 better than RSS 2.0.  ATOM is the future.  I'm not
 wasting my time adding full support for RSS.

 ToDo:
 Use MediaWiki language support through system messages (partially done)
 Better error checking
 Optimize SQL queries

 */

if (!defined('MEDIAWIKI')) die();

$wgExtensionFunctions[] = 'wfWikiFeeds';
$wgExtensionCredits['specialpage'][] = array(
  'name'=>'Wiki Feeds',
  'author'=>'Gregory Szorc <gregory.szorc@gmail.com>',
  'url'=>'http://wiki.case.edu/User:Gregory.Szorc',
  'description'=>'Produces syndicated feeds for MediaWiki.',
  'version'=>'0.5'
);

/**
 * Holds default settings for WikiFeeds
 *
 * Override values in LocalSettings.php after you include this file
 */
$wgWikiFeedsSettings = array(
	'cacheEnable' => false, //whether to enable the cache
	'cacheRoot'		=> '/nfsn/content/ds-x/public/tmp/', //cache directory, with trailing slash
	'cacheMaxAge'	=> 600, //max age of cached files, in seconds
	'cachePruneFactor' => 100, //prune stale cache entries 1 out of every this many requests
    'watchlistPrivate' => false, //when true, make per-user watchlists require special access token
);

function wfWikiFeeds() {
	global $wgHooks;

	if (!class_exists('GenericXmlSyndicationFeed')) {
		throw new MWException('GenericXmlSyndicationFeed class not loaded.  Please read the install directions!');
	}

	require_once('SpecialPage.php');

	$wgHooks['ParserAfterTidy'][] = 'wfWikiFeeds_Linker';

	class SpecialWikiFeeds extends SpecialPage {
		const FEED_NEWESTARTICLES = 1;
		const FEED_RECENTARTICLECHANGES = 2;
		const FEED_RECENTUSERCHANGES = 3;
		const FEED_USERWATCHLIST = 4;
		const FEED_RECENTCATEGORYCHANGES = 5;
		const FEED_NEWESTCATEGORYARTICLES = 6;
		const FEED_NEWESTARTICLESBYUSER = 7;

		const DEFAULT_COUNT = 15;

		protected $_settings = array();

		public function __construct() {
			global $wgWikiFeedsSettings;
			$this->_settings = $wgWikiFeedsSettings;

			parent::__construct('WikiFeeds');

			//we automatically prune the cache randomly
			if ($this->_settings['cacheEnable']) {
				if (rand(1, $this->_settings['cachePruneFactor']) === 1) {
					$this->_cachePrune();
				}
			}

		}

		public function execute($par = null) {
			global $wgOut, $wgRequest, $wgServer, $wgWikiFeedsSettings, $wgUser;

			$request = isset($par) ? $par : $wgRequest->getText('request');

			if (!$request) {
				$wgOut->addWikiText(wfMsg('wikifeeds_mainpage'));

				// do special voodoo if private watchlist is enabled
				if ($wgWikiFeedsSettings['watchlistPrivate'] && $wgUser->isLoggedIn()) {
					if (!$wgUser->getOption('watchlistToken')) {
						$token = md5(microtime() . $wgUser->getID());

						$wgUser->setOption('watchlistToken', $token);
						$wgUser->saveSettings();
					}

					$token = $wgUser->getOption('watchlistToken');

					$privateFeedUrl = Title::newFromText('WikiFeeds/atom/watchlist/user/' . $wgUser->getName() . '/token/' . $token, NS_SPECIAL);

					// and display blurb about token
					$wgOut->addWikiText(wfMsg('wikifeeds_tokeninfo', $token, $privateFeedUrl->getFullUrl()));
				}
			}
			else {
				$arr = explode('/', $request);


				//might have a valid request for a feed
				if (count($arr) >= 2) {
					$format = null;
					$feed = null;
					$count = self::DEFAULT_COUNT;
					$params = array();
					$areSane = true;

					if (strtolower($arr[0]) == 'atom') {
						$format = GenericXmlSyndicationFeed::FORMAT_ATOM10;
					}
					else if (strtolower($arr[0]) == 'rss') {
						$format = GenericXmlSyndicationFeed::FORMAT_RSS20;
					}
					else {
						$wgOut->addWikiText(wfMsg('wikifeeds_unknownformat'));
						$areSane = false;
					}

					switch (strtolower($arr[1])) {
						case 'newestarticles':
							$feed = self:: FEED_NEWESTARTICLES;
							break;

						case 'recentarticlechanges':
							$feed = self::FEED_RECENTARTICLECHANGES;
							break;

						case 'recentuserchanges':
							$feed = self::FEED_RECENTUSERCHANGES;
							break;

						case 'newestuserarticles':
							$feed = self::FEED_NEWESTARTICLESBYUSER;
							break;

						case 'watchlist':
							$feed = self::FEED_USERWATCHLIST;
							break;

						case 'recentcategorychanges':
							$feed = self::FEED_RECENTCATEGORYCHANGES;
							break;

						case 'newestcategoryarticles':
							$feed = self::FEED_NEWESTCATEGORYARTICLES;
							break;

						default:
							$wgOut->addWikiText(wfMsg('wikifeeds_unknownfeed'));
							$areSane = false;
					}

					//now we look for additional parameters
					if ( (count($arr) > 3) && ((count($arr) % 2) == 0) ) {
						for ($i = 2; $i < count($arr); $i += 2) {
							$params[$arr[$i]] = $arr[$i+1];
						}
					}

					//if we are dealing with a category feed, we need a category specified
					if ($feed === self::FEED_RECENTCATEGORYCHANGES || $feed === self::FEED_NEWESTCATEGORYARTICLES) {
						if (!array_key_exists('category', $params)) {
							$wgOut->addWikiText(wfMsg('wikifeeds_undefinedcategory'));
							$areSane = false;
						}
						else {
							//verify category is valid
							if (!$this->categoryExists($params['category'])) {
								$wgOut->addWikiText(wfMsg('wikifeeds_categorynoexist'));
								$areSane = false;
							}
						}
					}

					//if we are asking for a user feed, we need the user parameter
					if ($feed === self::FEED_RECENTUSERCHANGES || $feed === self::FEED_USERWATCHLIST || $feed === self::FEED_NEWESTARTICLESBYUSER) {
						if (!array_key_exists('user', $params)) {
							$wgOut->addWikiText(wfMsg('wikifeeds_undefineduser'));
							$areSane = false;
						}
						else {
							//verify the user exists
							$userId = User::idFromName($params['user']);

							if (is_null($userId) || $userId === 0) {
								$wgOut->addWikiText(wfMsg('wikifeeds_unknownuser'));
								$areSane = false;
							} else if ($feed === self::FEED_USERWATCHLIST && $wgWikiFeedsSettings['watchlistPrivate']) {
								if (!array_key_exists('token', $params)) {
									$wgOut->addWikiText(wfMsg('wikifeeds_nowatchlisttoken'));
									$areSane = false;
								} else {
									$token = $params['token'];

									// verify token is sane
									$user = User::newFromId($userId);

									if ($token != $user->getOption('watchlistToken')) {
										$wgOut->addWikiText(wfMsg('wikifeeds_invalidwatchlisttoken'));
										$areSane = false;
									}
								}
							}
						}
					}

					if (array_key_exists('count', $params) && ctype_digit($params['count']) && $params['count'] > 0) {
						$count = $params['count'];
					}

					if (array_key_exists('unique', $params) && $params['count'] != 'false') {
						$unique = true;
					} else {
						$unique = false;
					}

					//we are sane, so let's create a feed
					if ($areSane) {
						$wgOut->disable();


						//if we successfully fetched a feed from the cache
						if ($this->_settings['cacheEnable'] && $cached = $this->_cacheFetchFeed($feed, $format, $params)) {
							//$cached is an array containing feed text and some metadata
							header('Content-Type: ' . $cached['content-type']);
							print $cached['content'];

						} else { //no cache was hit, assemble the feed

							$Feed = new GenericXmlSyndicationFeed($format);

							switch ($feed) {
								case self::FEED_NEWESTARTICLES:
									$this->makeNewestArticles($Feed, $count);
									break;

								case self::FEED_RECENTARTICLECHANGES:
									$this->makeRecentArticleChanges($Feed, $count, $unique);
									break;

								case self::FEED_NEWESTARTICLESBYUSER:
									$this->makeNewestArticleByUser($Feed, $params['user'], $count);
									break;

								case self::FEED_RECENTUSERCHANGES:
									$this->makeRecentUserChanges($Feed, $params['user'], $count);
									break;

								case self::FEED_USERWATCHLIST:
									$this->makeUserWatchlist($Feed, $params['user'], $count);
									break;

								case self::FEED_RECENTCATEGORYCHANGES:
									$this->makeRecentCategoryPageChanges($Feed, $params['category'], $count);
									break;

								case self::FEED_NEWESTCATEGORYARTICLES:
									$this->makeNewestArticlesInCategory($Feed, $params['category'], $count);
									break;

								default:

									echo 'unknown feed';
							}

							$feedDate = 0;
							foreach ($Feed->items as $i) {
								if ($i->mArticle->getTimestamp() > $feedDate) {
									$feedDate = $i->mArticle->getTimestamp();
								}
							}

							$Feed->lastUpdated = wfTimestamp(TS_UNIX, $feedDate);

							$Feed->linkSelf = $wgServer.$_SERVER['REQUEST_URI'];

							$Feed->sendOutput();

							//finally, cache the feed
							if ($this->_settings['cacheEnable']) {
								$this->_cacheSaveFeed($Feed, $feed, $format, $params);
							}
						}
					}
				}

			}


			$this->setHeaders();

		}

		/**
		 * This function checks to see if a category exists
		 * It would be really nice if MediaWiki had this method available, but all the SQL is inline
		 * Comparison is case sensitive
		 */
		protected function categoryExists($cat) {
			$dbr =& wfGetDB( DB_SLAVE );
			$categorylinks = $dbr->tableName( 'categorylinks' );
			if ($result = $dbr->safeQuery("SELECT count(*) FROM $categorylinks WHERE cl_to=?", $cat)) {
				if ($row = $dbr->fetchRow($result)) {
					return $row[0] > 0 ? true : false;
				}
			}

			return false;

		}

		/**
		 * Create a feed for newest articles in the wiki
		 */
		protected function makeNewestArticles(GenericXmlSyndicationFeed &$feed, $count = self::DEFAULT_COUNT) {
			$feed->title = wfMsg('wikifeeds_feed_newestarticles_title');
			$feed->description = wfMsg('wikifeeds_feed_newestarticles_description');

			$altUrlTitle = Title::makeTitle(NS_SPECIAL, 'Newpages');
			$feed->linkAlternate = $altUrlTitle->getFullURL();

			$dbr = wfGetDB(DB_SLAVE);

			extract($dbr->tableNames('recentchanges', 'page', 'text'));

			$sql = "SELECT 'Newpages' as type, rc_namespace AS namespace, rc_title AS value, rc_user AS user,
        rc_user_text AS user_text,
        rc_comment AS comment,
        rc_timestamp AS timestamp,
        rc_id AS rcid,
        page_id AS page,
        page_len AS length,
        page_latest AS latest
        FROM $recentchanges,$page
        WHERE rc_cur_id=page_id AND rc_new=1 AND page_is_redirect=0
        ORDER BY rc_timestamp DESC LIMIT $count";

			if ($result = $dbr->query($sql,__METHOD__)) {
				if ($dbr->numRows($result)) {
					while ($row = $dbr->fetchRow($result)) {
						$title = Title::newFromID($row['page']);
						$item = new MediaWikiFeedItem($title);
						$feed->addItem($item);
					}
				}
			}
		}

		/**
		 * Feed for recently changed articles
		 *
		 * @todo Implement $unique changes to SQL query
		 */
		protected function makeRecentArticleChanges(GenericXmlSyndicationFeed &$feed, $count = self::DEFAULT_COUNT, $unique = false) {
			$feed->title = wfMsg('wikifeeds_feed_recentarticlechanges_title');
			$feed->description = wfMsg('wikifeeds_feed_recentarticlechanges_description');

			$altUrlTitle = Title::makeTitle(NS_SPECIAL, 'Recentchanges');
			$this->linkAlternate = $altUrlTitle->getFullURL();

			$db = wfGetDB(DB_SLAVE);

			extract($db->tableNames('recentchanges','page', 'revision'));

			$sql = "SELECT rev_id AS revid, rev_page AS page, rev_user_text as user, rc_id AS rcid
      FROM $recentchanges, $revision
      WHERE rc_this_oldid=rev_id AND rev_deleted=0
      ORDER BY rev_id DESC LIMIT $count";

			if ($result = $db->query($sql,__METHOD__)) {
				if ($db->numRows($result)) {
					while ($row = $db->fetchRow($result)) {
						$title = Title::newFromID($row['page']);
						$item = new MediaWikiFeedItem($title, $row['revid'], $row['rcid']);

						$feed->addItem($item);
					}
				}
			}
		}

		/**
		 * Recent articles created by a specified user
		 */
		protected function makeNewestArticleByUser(GenericXmlSyndicationFeed &$feed, $user, $count = self::DEFAULT_COUNT) {

			$u = User::newFromName($user);

			if (!$u) return;

			$feed->title = wfMsg('wikifeeds_feed_newestarticlesbyuser_title', $user);
			$feed->description = wfMsg('wikifeeds_feed_newestarticlesbyuser_description', $user);

			$altUrlTitle = Title::makeTitle(NS_SPECIAL, "Contributions/$user");
			$feed->linkAlternate = $altUrlTitle->getFullURL();

			$author = array();
			$author['name'] = $user;
			$author['email'] = $u->getEmail();
			$userPage = $u->getUserPage();
			$author['uri'] = $userPage->getFullURL();

			$feed->addAuthor($author);

			$db = wfGetDB(DB_SLAVE);

			extract($db->tableNames('recentchanges','page', 'revision'));

			$sql = "SELECT
      rc_id AS rcid,
      page_id AS page,
      page_latest AS latest
      FROM $recentchanges,$page
      WHERE rc_cur_id=page_id AND rc_new=1 AND page_is_redirect=0 AND rc_user_text='{$u->getName()}'
      ORDER BY rc_timestamp DESC LIMIT $count";

			if ($result = $db->query($sql,__METHOD__)) {
				if ($db->numRows($result)) {
					while ($row = $db->fetchRow($result)) {
						$title = Title::newFromID($row['page']);
						$item = new MediaWikiFeedItem($title);

						$feed->addItem($item);
					}
				}
			}
		}

		/**
		 * Recent article changes by a specified user
		 */
		protected function makeRecentUserChanges(GenericXmlSyndicationFeed &$feed, $user, $count = self::DEFAULT_COUNT) {
			$u = User::newFromName($user);

			if (!$u) return;

			$feed->title = wfMsg('wikifeeds_feed_recentuserchanges_title', $user);
			$feed->description = wfMsg('wikifeeds_feed_recentuserchanges_description', $user);

			$altUrlTitle = Title::makeTitle(NS_SPECIAL, "Contributions/$user");
			$feed->linkAlternate = $altUrlTitle->getFullURL();

			$author = array();
			$author['name'] = $user;
			$author['email'] = $u->getEmail();
			$userPage = $u->getUserPage();
			$author['uri'] = $userPage->getFullURL();

			$feed->addAuthor($author);

			$db = wfGetDB(DB_SLAVE);

			extract($db->tableNames('recentchanges', 'page', 'revision'));

			$sql = "SELECT rev_id AS revid, rev_page AS page, rev_user_text as user, rc_id AS rcid
      FROM $recentchanges, $revision
      WHERE rc_this_oldid=rev_id AND rev_deleted=0 AND rev_user_text='{$u->getName()}'
      ORDER BY rev_id DESC LIMIT $count";

			if ($result = $db->query($sql,__METHOD__)) {
				if ($db->numRows($result)) {
					while ($row = $db->fetchRow($result)) {
						$title = Title::newFromID($row['page']);
						$item = new MediaWikiFeedItem($title, $row['revid'], $row['rcid']);

						$feed->addItem($item);
					}
				}
			}
		}

		/**
		 * Watchlist for a specified user
		 */
		protected function makeUserWatchlist(GenericXmlSyndicationFeed &$feed, $user, $count = self::DEFAULT_COUNT) {
			$feed->title = wfMsg('wikifeeds_feed_userwatchlist_title', $user);
			$feed->description = wfMsg('wikifeeds_feed_userwatchlist_description', $user);

			$u = User::newFromName($user);

			if (!$u) return;

			$author = array();
			$author['name'] = $user;
			$author['email'] = $u->getEmail();
			$userPage = $u->getUserPage();
			$author['uri'] = $userPage->getFullURL();

			$feed->addAuthor($author);

			$db = wfGetDB(DB_SLAVE);

			extract($db->tableNames('recentchanges', 'page', 'revision', 'watchlist'));

			$sql = "SELECT rev_id as revid, rev_page AS page, rc_id AS rcid
      FROM $recentchanges, $revision, $watchlist
      WHERE wl_user={$u->getID()} AND rc_namespace=wl_namespace AND rc_title=wl_title
      AND rev_id=rc_this_oldid
      ORDER BY rev_id DESC LIMIT $count";

			if ($result = $db->query($sql,__METHOD__)) {
				if ($db->numRows($result)) {
					while ($row = $db->fetchRow($result)) {
						$title = Title::newFromID($row['page']);
						$item = new MediaWikiFeedItem($title, $row['revid'], $row['rcid']);
						$feed->addItem($item);
					}
				}
			}
		}

		/**
		 * Recently changes articles in a specified category
		 */
		protected function makeRecentCategoryPageChanges(GenericXmlSyndicationFeed &$feed, $category, $count = self::DEFAULT_COUNT) {
			$feed->title = wfMsg('wikifeeds_feed_recentcategorychanges_title', $category);
			$feed->description = wfMsg('wikifeeds_feed_recentcategorychanges_description', $category);

			$pagesIn = $this->getPagesInCategory($category);

			$db = wfGetDB(DB_SLAVE);
			extract($db->tableNames('recentchanges', 'page', 'revision'));

			$sql = "SELECT rev_id AS revid, rev_page AS page, rc_id AS rcid
      FROM $recentchanges, $revision
      WHERE rev_page IN (".implode(',', $pagesIn).")
      AND rev_deleted=0 AND rc_this_oldid=rev_id
      ORDER BY rev_id DESC LIMIT $count";

			if ($result = $db->query($sql,__METHOD__)) {
				if ($db->numRows($result)) {
					while ($row = $db->fetchRow($result)) {
						$title = Title::newFromID($row['page']);
						$item = new MediaWikiFeedItem($title, $row['revid'], $row['rcid']);
						$feed->addItem($item);
					}
				}
			}

		}

		/**
		 * Newest articles in a specified category
		 */
		protected function makeNewestArticlesInCategory(GenericXmlSyndicationFeed &$feed, $category, $count = self::DEFAULT_COUNT) {
			$catTitle = Title::newFromText($category, NS_CATEGORY);

			$feed->title = wfMsg('wikifeeds_feed_newestarticlesincategory_title', $catTitle->getText());
			$feed->description = wfMsg('wikifeeds_feed_newestarticlesincategory_description', $catTitle->getText());

			$db = wfGetDB(DB_SLAVE);

			extract($db->tableNames('page','categorylinks'));

			$sql = "SELECT
      page_id AS page
      FROM $page,$categorylinks
      WHERE cl_to='{$catTitle->getDBkey()}' AND cl_from=page_id
      ORDER BY cl_timestamp DESC LIMIT $count";

			if ($result = $db->query($sql,__METHOD__)) {
				if ($db->numRows($result)) {
					while ($row = $db->fetchRow($result)) {
						$title = Title::newFromID($row['page']);
						$item = new MediaWikiFeedItem($title);

						$feed->addItem($item);
					}
				}
			}
		}

		/**
		 * Return all the pages in a given category
		 */
		protected function getPagesInCategory($catName) {
			$db = wfGetDB(DB_SLAVE);

			$catTitle = Title::newFromText($catName, NS_CATEGORY);

			$db = wfGetDB(DB_SLAVE);

			extract($db->tableNames('categorylinks'));

			$sql = "SELECT cl_from AS page FROM $categorylinks WHERE cl_to='{$catTitle->getDBkey()}'";

			$r = array();

			if ($result = $db->query($sql,__METHOD__)) {
				if ($db->numRows($result)) {
					while ($row = $db->fetchRow($result)) {
						$r[] = $row['page'];
					}
				}
			}

			return $r;

		}

		/**
		 * Fetch a feed from the cache
		 *
		 * This function will try to fetch a feed specified by type, format
		 * and parameters from the cache.  If the feed does not exist in the
		 * cache or if the cache entry is stale, we don't return anything
		 *
		 * @param $feed Feed type constant
		 * @param $format Feed format constant
		 * @param array $params Parameters to pass to the feed constructor
		 *
		 * @return array Array that describes the feed|false on failure
		 */
		protected function _cacheFetchFeed($feed, $format, $params) {
			$filename = $this->_cacheFilename($feed, $format, $params);

			if (file_exists($filename) && is_readable($filename)) {
				if ( (time() - filemtime($filename)) < $this->_settings['cacheMaxAge']) {
					$content = unserialize(file_get_contents($filename));

					if (is_array($content)) {
						return $content;
					}
				} else {
					//the file is old, we might as well prune it now
					//to save a few system calls
					unlink($filename);
				}
			}

			return false;
		}

		/**
		 * Save a specified feed object corresponding to given parameters to the
		 * cache
		 */
		protected function _cacheSaveFeed(GenericXmlSyndicationFeed $feedObj, $feed, $format, $params) {
			$filename = $this->_cacheFilename($feed, $format, $params);

			$cacheContent = array(
    		'content-type' => $feedObj->contentType,
    		'content' => $feedObj->getContent(false)
			);

			file_put_contents($filename, serialize($cacheContent), LOCK_EX);
		}


		/**
		 * Returns the filename a specified feed should have
		 *
		 * @param $feed Feed type constant
		 * @param $foramt Feed format constant
		 * @param array $params Array of feed parameters
		 */
		protected function _cacheFilename($feed, $format, $params) {
			$s = $this->_settings['cacheRoot'] . 'wikifeeds_cache-';

			$s .= md5($feed.$format.serialize($params));

			return $s;
		}

		/**
		 * Prune the cache of stale entries
		 */
		protected function _cachePrune() {
			foreach ($this->_getCacheFiles() as $file) {
				if ((time() - filemtime($file)) > $this->_settings['cacheMaxAge']) {
					unlink($file);
				}

			}
		}

		/**
		 * Purge the cache of all entries
		 */
		protected function _cachePurge() {
			foreach ($this->_getCacheFiles() as $file) {
				unlink($file);
			}
		}

		/**
		 * Returns an array of all files in the cache
		 */
		protected function _getCacheFiles() {
			$return = array();

			$directory = new DirectoryIterator($this->_settings['cacheRoot']);

			foreach ($directory as $file) {
				if ($file->isFile()) {
					if (strpos($file->getPathname(), $this->_settings['cacheRoot'] . 'wikifeeds_cache-') === 0) {
						$return[] = $file->getPathname();
					}
				}
			}

			return $return;
		}

	}

	/**
	 * This is a MediaWiki-specific definition of a feed item
	 */
	class MediaWikiFeedItem extends GenericXmlSyndicationFeedItem {

		public function __construct($title, $revId = 0, $rcid = 0) {
			parent::__construct();

			$this->allowedVars = array_merge($this->allowedVars, array(
        'mTitle','mRevId','mRCid','mArticle'
        )
        );

        $this->mTitle = $title;
        $this->mRevId = $revId;
        $this->mRCid = $rcid;

        $this->mArticle = new Article($this->mTitle);

        $this->mArticle->fetchContent($this->mRevId);

        $this->publishTime = wfTimestamp(TS_UNIX, $this->mArticle->getTimestamp());
        $this->title = $this->mTitle->getFullText();

        if ($rcid == 0) {
        	$this->guid = $this->mTitle->getFullURL();
        }
        else {
        	$this->guid = $this->mTitle->escapeFullURL("oldid={$this->mRevId}");
        }

        $this->linkSelf = $this->_guid;
        $this->linkAlternate = $this->mTitle->getFullURL();

        $author = array();

        $author['name'] = $this->mArticle->getUserText();

        if ($u = User::newFromName($author['name'])) {
        	$author['email'] = $u->getEmail();

        	$userPage = $u->getUserPage();
        	$author['uri'] = $userPage->getFullURL();
        }

        $this->_vars['authors'][] = $author;

        //create a new default user to invoke the parser
        $u = new User();

        global $wgParser;

        $output = $wgParser->parse($this->mArticle->getContent(false), $this->mTitle, ParserOptions::newFromuser($u));
        $text = $output->mText;

        //$this->_content = html_entity_decode($text);
        $this->content = $text;

        $categories = $this->mTitle->getParentCategories();

        if (is_array($categories)) {

        	foreach ($categories as $c=>$v) {
          $categoryTitle = Title::newFromText($c);

          $this->_vars['categories'][] = $categoryTitle->getText();
        	}
        }
		}

	}

	SpecialPage::addPage(new SpecialWikiFeeds);
}

/**
 * Hooks registered on ParserAfterTidy hook
 *
 * Injects links to feeds in HTML <head>
 *
 */
function wfWikiFeeds_Linker($a, $b) {
	global $wgWikiFeedsSettings, $wgTitle;

	// only link against each article once
	if (!array_key_exists('__linkerTracker', $wgWikiFeedsSettings)) {
		$wgWikiFeedsSettings['__linkerTracker'] = array();
	}

	/** Wikia change start, author Federico "Lox" Lucignano **/
	if ( !( $wgTitle instanceof Title ) ) {
		//$wgTitle is not set, skip processing
		return true;
	}
	/** Wikia change end **/

	// if we have already processed this title, don't do it again
	if (in_array($wgTitle->getFullText(), $wgWikiFeedsSettings['__linkerTracker'])) {
		return true;
	} else {
		// mark as processed
		$wgWikiFeedsSettings['__linkerTracker'][] = $wgTitle->getFullText();
	}

	switch ($wgTitle->getNamespace()) {
		case NS_USER:
		case NS_USER_TALK:
			{
				$username = $wgTitle->getPartialURL();

				//strip out subpage if we are on one
				if ($pos = strpos($username, '/')) {
					$username = substr($username, 0, $pos);
				}

				$t0 = Title::newFromText("WikiFeeds/atom/recentuserchanges/user/$username", NS_SPECIAL);
				$t1 = Title::newFromText("WikiFeeds/rss/recentuserchanges/user/$username", NS_SPECIAL);
				$t2 = Title::newFromText("WikiFeeds/atom/newestuserarticles/user/$username", NS_SPECIAL);
				$t3 = Title::newFromText("WikiFeeds/rss/newestuserarticles/user/$username", NS_SPECIAL);
				$t4 = Title::newFromText("WikiFeeds/atom/watchlist/user/$username", NS_SPECIAL);
				$t5 = Title::newFromText("WikiFeeds/rss/watchlist/user/$username", NS_SPECIAL);

				/* Wikia change begin - @author: macbre */
				/* $username can contain illegal characters detected by Title::secureAndSplit() - BugId:8126 */
				if (!empty($t0)) {
					wfWikiFeeds_AddLink('atom', "Recently changed articles by $username (ATOM 1.0)", $t0->getFullUrl());
					wfWikiFeeds_AddLink('atom', "Latest articles created by $username (ATOM 1.0)", $t2->getFullUrl());
					wfWikiFeeds_AddLink('atom', "Watchlist for $username (ATOM 1.0)", $t4->getFullUrl());
					wfWikiFeeds_AddLink('rss', "Recently changes articles by $username (RSS 2.0)", $t1->getFullUrl());
					wfWikiFeeds_AddLink('rss', "Latest articles created by $username (RSS 2.0)", $t3->getFullUrl());
					wfWikiFeeds_AddLink('rss', "Watchlist for $username (RSS 2.0)", $t5->getFullUrl());
				}
				/* Wikia change end */

			}
			break;

		case NS_CATEGORY:
		case NS_CATEGORY_TALK:
			{
				$category = $wgTitle->getPartialURL();
				$catName = $wgTitle->getText();

				$atomCatNew = Title::newFromText("WikiFeeds/atom/newestcategoryarticles/category/$catName", NS_SPECIAL);
				$rssCatNew = Title::newFromText("WikiFeeds/rss/newestcategoryarticles/category/$catName", NS_SPECIAL);
				$atomCatRecent = Title::newFromText("WikiFeeds/atom/recentcategorychanges/category/$catName", NS_SPECIAL);
				$rssCatRecent = Title::newFromText("WikiFeeds/rss/recentcategorychanges/category/$catName", NS_SPECIAL);

				/* Wikia change begin - @author: macbre */
				/* $username can contain illegal characters detected by Title::secureAndSplit() - BugId:8126 */
				if (!empty($atomCatNew)) {
					wfWikiFeeds_AddLink('atom', "Newest pages to join the $catName category (ATOM 1.0)", $atomCatNew->getFullUrl());
					wfWikiFeeds_AddLink('atom', "Recently changed articles in the $catName category (ATOM 1.0)", $atomCatRecent->getFullUrl());
					wfWikiFeeds_AddLink('rss', "Newest pages to join the $catName category (RSS 2.0)", $rssCatNew->getFullUrl());
					wfWikiFeeds_AddLink('rss', "Recently changed articles in the $catName category (RSS 2.0)", $rssCatRecent->getFullUrl());
				}
				/* Wikia change end */
			}
	}

	$atomRecentChanges = Title::newFromText("WikiFeeds/atom/recentarticlechanges", NS_SPECIAL);
	$atomNewestArticles = Title::newFromText("WikiFeeds/atom/newestarticles", NS_SPECIAL);
	$rssRecentChanges = Title::newFromText("WikiFeeds/rss/recentarticlechanges", NS_SPECIAL);
	$rssNewestArticles = Title::newFromText("WikiFeeds/rss/newestarticles", NS_SPECIAL);

	wfWikiFeeds_AddLink('atom', 'Recently changed articles (ATOM 1.0)', $atomRecentChanges->getFullUrl());
	wfWikiFeeds_AddLink('atom', 'Newest articles (ATOM 1.0)', $atomNewestArticles->getFullUrl());
	wfWikiFeeds_AddLink('rss', 'Recently changed articles (RSS 2.0)', $rssRecentChanges->getFullUrl());
	wfWikiFeeds_AddLink('rss', 'Newest articles (RSS 2.0)', $rssNewestArticles->getFullUrl());

	return true;
}

/**
 * Helper function for wfWikiFeeds_Linker
 */
function wfWikiFeeds_AddLink($format, $title, $url) {
	global $wgOut;

	$typeApp = 'application/atom+xml';

	if ($format == 'rss') {
		$typeApp = 'application/rss+xml';
	}

	//else
	$wgOut->addLink(array('rel'=>'alternate', 'type'=>$typeApp, 'title'=>$title, 'href'=>$url));
}
