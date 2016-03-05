<?php

/**
 * simple class for using titles across WikiFactory installation
 *
 * NOTE: it is not full replacement for Title class, You can't expect that all
 * method from Title will work there. For example You can't build proper Article
 * from this class
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 *
 * @todo wgContLang simulation
 * @todo check if parameters working
 * @todo check if local namespaces works
 *
 */

class GlobalTitle extends Title {

	/**
	 * Default wgArticlePath
	 */
	const DEFAULT_ARTICLE_PATH = '/wiki/$1';

	/**
	 * public, used in static constructor
	 */
	public $mText = false;
	public $mNamespace = false;
	public $mCityId = false;
	public $mTextform = false;
	public $mUrlform = false;
	public $mArticleID = false;

	/**
	 * others, private
	 */
	private $mServer = false;
	/**
	 * @var Language $mContLang
	 */
	private $mContLang = false;
	private $mLang = false;
	private $mArticlePath = false;
	private $mNamespaceNames = false;
	private $mLastEdit = false;
	private $mExists = null;
	private $mContent = false;
	private $mIsRedirect = null;
	private $mRedirectTarget = null;
	private $mDbName = null;

	static protected $cachedObjects = array();

	/**
	 * @desc Static constructor, Create new Title from name of page
	 *
	 * @param String $text
	 * @param Integer $namespace (default NS_MAIN)
	 * @param Integer|null $city_id a wiki id; we allow null because of compatibility with Title::newFromText()
	 *
	 * @throws Exception when $city_id parameter is null
	 *
	 * @return GlobalTitle
	 */
	public static function newFromText( $text, $namespace = NS_MAIN, $city_id = null ) {
		if( $city_id === null ) {
		// we allow to pass null in the method definition because of Strict Compatibility with Title::newFromText()
			throw new \Exception( 'Invalid $city_id.' );
		}

		$filteredText = Sanitizer::decodeCharReferences( $text );
		$title = new GlobalTitle();

		$title->mText = $filteredText;
		$title->mDbkeyform = str_replace( ' ', '_', $filteredText );
		$title->mUrlform = wfUrlencode( $title->mDbkeyform );
		$title->mTextform = str_replace( '_', ' ', $title->mText );
		$title->mNamespace = $namespace;
		$title->mCityId = $city_id;

		return $title;
	}
	
	/**
	 * @desc Create a new Title for the Main Page
	 *
	 * @param Integer $city_id a wiki id; we allow null because of compatibility with Title::newMainPage()
	 *
	 * @throws Exception when $city_id parameter is null
	 *
	 * @return GlobalTitle
	 */
	public static function newMainPage( $city_id = null ) {
		if( $city_id === null ) {
		// we allow to pass null in the method definition because of Strict Compatibility with Title::newFromText()
			throw new \Exception( 'Invalid $city_id.' );
		}

		// sure hope this redirects for the most part
		$title = self::newFromText( 'Main Page', NS_MAIN, $city_id );
		return $title;
	}

	/**
	 * @desc static constructor, Create new Title from id of page
	 *
	 * @param Integer $id
	 * @param Integer $city_id a wiki id; we allow null because of compatibility with Title::newFromId()
	 * @param String $dbname
	 *
	 * @throws Exception
	 *
	 * @returns GlobalTitle|null
	 */
	public static function newFromId( $id, $city_id = null, $dbname = "" ) {
		global $wgMemc;
		$title = null;

		if( $city_id === null ) {
		// we allow to pass 0 in the method definition because of Strict Compatibility with Title::newFromText()
			throw new \Exception( 'Invalid $city_id.' );
		}

		$memkey = wfSharedMemcKey( "GlobalTitle", $id, $city_id );
		$res = $wgMemc->get( $memkey );
		if ( empty($res) && WikiFactory::isPublic($city_id) ) {
			$dbname = ( $dbname ) ? $dbname : WikiFactory::IDtoDB($city_id);
			$dbr = wfGetDB( DB_SLAVE, array(), $dbname );
			$row = $dbr->selectRow( 'page',
				array( 'page_namespace', 'page_title' ),
				array( 'page_id' => $id ),
				__METHOD__
			);
			if ( !empty( $row->page_title ) ) {
				$res = array( 'title' => $row->page_title, 'namespace' => $row->page_namespace );
				$wgMemc->set($memkey, $res, 60 * 60);
			}
		}

		if ( isset( $res['title'] ) && isset($res['namespace']) ) {
			$title = GlobalTitle::newFromText( $res['title'], $res['namespace'], $city_id );
		} else {
			$title = NULL;
		}

		if ( !empty($title) && !empty($dbname) ) {
			$title->mDbName = $dbname;
		}

		return $title;
	}

	public static function newFromTextCached( $text, $namespace, $city_id ) {
		if ( !isset( self::$cachedObjects[$city_id][$namespace][$text] ) ) {
			self::$cachedObjects[$city_id][$namespace][$text] =
				GlobalTitle::newFromText( $text, $namespace, $city_id );
		}
		return self::$cachedObjects[$city_id][$namespace][$text];
	}

	/**
	 * @param $wikiId
	 * @return string
	 */
	protected static function getWgArticlePath( $wikiId ) {
		$destinationWgArticlePath = WikiFactory::getVarValueByName( 'wgArticlePath', $wikiId );

		if ( !isset( $destinationWgArticlePath ) ) {
			$destinationWgArticlePath = self::DEFAULT_ARTICLE_PATH;
		}

		return $destinationWgArticlePath;
	}

	/**
	 * loadAll
	 *
	 *  constructor doesnt load anything from database. This is the place
	 *  for that kind of things
	 */
	private function loadAll() {
		$old = $this->loadFromCache();
		$this->loadServer();
		$this->loadArticlePath();
		$this->loadContLang();
		$this->loadNamespaceNames();
		if( ! $old ) {
			$this->storeInCache();
		}
	}

	/**
	 * Get database name that this object belongs to
	 *
	 * @return string
	 */
	public function getDatabaseName() {
		if ( empty( $this->mDbName ) ) {
			$this->mDbName = WikiFactory::IDtoDB( $this->mCityId );
		}
		return $this->mDbName;
	}

	/**
	 * Get a database connection to this object database
	 *
	 * @param $type string Master or slave constants
	 * @param $groups array Query group
	 * @return DatabaseBase
	 */
	protected function getConnection( $type, $groups = array() ) {
		return wfGetDB( $type, $groups, $this->getDatabaseName() );
	}

	/**
	 * Get the namespace text
	 * @return string
	 */
	public function getNsText() {

		$this->loadAll();

		if( isset( $this->mNamespaceNames[ $this->mNamespace ] ) ) {
			return $this->mNamespaceNames[ $this->mNamespace ];
		}

		return $this->mContLang->getNsText( $this->mNamespace );
	}

	/**
	 * Get the text form (spaces not underscores) of the main part
	 * @return string
	 */
	public function getText() {
		return $this->mTextform;
	}

	/**
	 * Get the text form (spaces not underscores of the title with namespace
	 * @return string
	 * @author tor
	 */
	public function getPrefixedText() {
		$ns = $this->getNsText();
		$text = $this->getText();

		if ( empty( $ns ) ) {
			return $text;
		} else {
			return $ns . ':' . $text;
		}
	}

	public function getCityId() {
		return $this->mCityId;
	}

	/**
	 * Get the server name
	 * @return string
	 */
	public function getServer() {
		$this->loadAll();
		return $this->mServer;
	}

	/**
	 * Get article path
	 * @return string
	 */
	public function getArticleName() {
		$this->loadAll();

		$namespace = wfUrlencode( $this->getNsText() );

		if( $this->mNamespace != NS_MAIN ) {
			$namespace .= ":";
		}
		/**
		 * replace $1 with article title with namespace
		 */

		return $namespace . $this->mUrlform;
	}

	/**
	 * Get a real URL referring to this title
	 *
	 * @param string $query an optional query string
	 * @param string|bool $variant language variant of url (for sr, zh..)
	 *
	 * @return string the URL
	 */
	public function getFullURL( $query = '', $variant = false ) {

		$this->loadAll();
		$namespace = wfUrlencode( $this->getNsText() );

		if( $this->mNamespace != NS_MAIN ) {
			$namespace .= ":";
		}
		/**
		 * replace $1 with article title with namespace
		 */

		if( is_array( $query ) ) {
			$query = wfArrayToCGI( $query );
		}

		$url = str_replace( '$1', $namespace . $this->mUrlform, $this->mArticlePath );
		$url = wfAppendQuery( $this->mServer . $url, $query );

		return $url;
	}

	/**
	 * Get url for squid-related code
	 * For wikia system InternalURL is the same as FullURL
	 * getInternalUrl from Title is not working corretly with GlobalTitle so it is fixed by getting FullURL
	 *
	 * @param string $query an optional query string
	 * @param string|bool $query2 (deprecated) language variant of url (for sr, zh..)
	 *
	 * @return string
	 */
	public function getInternalURL( $query = '', $query2 = false ) {
		return $this->getFullURL($query, $query2);
	}

	/**
	 * local url doesn't make sense in this context. we always return full URL
	 *
	 * @param string $query an optional query string
	 * @param string|bool $variant language variant of url (for sr, zh..)
	 *
	 * @return string
	 */
	public function getLocalURL( $query = '', $variant = false ) {
		return $this->getFullURL( $query, $variant );
	}

	/**
	 * Get a date of last edit
	 *
	 * @return string MW timestamp
	 */
	public function getLastEdit() {
		$this->loadAll();

		if ( $this->mLastEdit ) {
			return $this->mLastEdit;
		}

		if( WikiFactory::isPublic($this->mCityId) ) {
			$dbName = WikiFactory::IDtoDB($this->mCityId);

			$dbr = wfGetDB( DB_SLAVE, array(), $dbName );

			$this->mLastEdit = $dbr->selectField(
				array( 'revision', 'page' ),
				array( 'rev_timestamp' ),
				array(
					'page_title' => $this->mDbkeyform,
					'page_namespace' => $this->mNamespace,
					'page_latest=rev_id'
				),
				__METHOD__
			);
		} else {
			$this->mLastEdit = false;
		}

		return $this->mLastEdit;
	}

	/**
	 * Returns text contents by given text_id from foreign wiki
	 *
	 * @see Revision::loadText
	 * @param $textId int Foreign wiki text id
	 * @return String|false
	 */
	protected function getContentByTextId( $textId ) {
		global $wgMemc;
		$key = wfForeignMemcKey( $this->getDatabaseName(), null, 'revisiontext', 'textid', $textId );
		$text = $wgMemc->get( $key );
		if ( !empty( $text ) ) {
			return $text;
		}

		$row = null;

		// copied from Article::loadText()
		if( !$row ) {
			// Text data is immutable; check slaves first.
			$dbr = $this->getConnection( DB_SLAVE );
			$row = $dbr->selectRow( 'text',
				array( 'old_text', 'old_flags' ),
				array( 'old_id' => $textId ),
				__METHOD__ );
		}

		if( !$row && wfGetLB()->getServerCount() > 1 ) {
			// Possible slave lag!
			$dbw = $this->getConnection( DB_MASTER );
			$row = $dbw->selectRow( 'text',
				array( 'old_text', 'old_flags' ),
				array( 'old_id' => $textId ),
				__METHOD__ );
		}

		$text = Revision::getRevisionText( $row );

		if ( !is_string($text) ) {
			$text = false;
		}
		return $text;
	}

	/**
	 * Returns text from revision id
	 *
	 * @param int $revisionId
	 * @return false|String
	 */
	public function getRevisionText( $revisionId ) {
		$db = wfGetDB( DB_SLAVE, [], $this->getDatabaseName() );
		$revision = Revision::loadRawRevision( $revisionId, $db );

		/**
		 * If no records were found - return an empty string.
		 */
		if ( !$revision ) {
			return '';
		}

		$text = $this->getContentByTextId( $revision->getTextId() );

		return $text;
	}

	/**
	 * Get the most recent content of the given title
	 * Returns false on any failure (incl. when title doesn't exist)
	 *
	 * @return string|bool
	 */
	public function getContent() {
		$this->loadAll();

		if ( $this->mContent ) {
			return $this->mContent;
		}

		if( WikiFactory::isPublic($this->mCityId) ) {
			$dbName = WikiFactory::IDtoDB($this->mCityId);

			$dbr = wfGetDB( DB_SLAVE, array(), $dbName );

			$textId = $dbr->selectField(
				array( 'revision', 'page' ),
				array( 'rev_text_id' ),
				array(
					'page_title' => $this->mDbkeyform,
					'page_namespace' => $this->mNamespace,
					'page_latest=rev_id'
				),
				__METHOD__
			);

			$this->mContent = !empty( $textId ) ? $this->getContentByTextId($textId) : false;
		} else {
			$this->mContent = false;
		}

		return $this->mContent;
	}

	/**
	 * Get redirect target
	 *
	 * @return GlobalTitle|false
	 */
	public function getRedirectTarget() {
		$this->loadAll();

		if ( !is_null( $this->mRedirectTarget ) ) {
			return $this->mRedirectTarget;
		}

		$this->mRedirectTarget = false;
		if( WikiFactory::isPublic($this->mCityId) ) {
			$dbName = WikiFactory::IDtoDB($this->mCityId);

			$dbr = wfGetDB( DB_SLAVE, array(), $dbName );

			$id = $dbr->selectField(
				array( 'page' ),
				array( 'page_id' ),
				array(
					'page_title' => $this->mDbkeyform,
					'page_namespace' => $this->mNamespace,
				),
				__METHOD__
			);

			if ( $id ) {
				$row = $dbr->selectRow( 'redirect',
					array( 'rd_namespace', 'rd_title', 'rd_fragment', 'rd_interwiki' ),
					array( 'rd_from' => $id ),
					__METHOD__
				);

				if ( $row ) {
					$this->mRedirectTarget = GlobalTitle::newFromText($row->rd_title,$row->rd_namespace,$this->mCityId);
				}
			}
		}

		return $this->mRedirectTarget;
	}

	/**
	 * Is this title a redirect?
	 *
	 * @param Integer $flags -- flags for query, not used but needed for PHP Strict Standards
	 *
	 * @return bool
	 */
	public function isRedirect( $flags = 0 ) {
		$this->loadAll();

		if ( !is_null( $this->mIsRedirect ) ) {
			return $this->mIsRedirect;
		}

		if( WikiFactory::isPublic($this->mCityId) ) {
			$dbName = WikiFactory::IDtoDB($this->mCityId);

			$dbr = wfGetDB( DB_SLAVE, array(), $dbName );

			$this->mIsRedirect = (bool)$dbr->selectField(
				array( 'page' ),
				array( 'page_is_redirect' ),
				array(
					'page_title' => $this->mDbkeyform,
					'page_namespace' => $this->mNamespace,
				),
				__METHOD__
			);
		} else {
			$this->mIsRedirect = false;
		}

		return $this->mIsRedirect;
	}

	/**
	 * Get the article ID for this Title from the link cache,
	 * adding it if necessary
	 *
	 * @param $flags Int a bit field; may be Title::GAID_FOR_UPDATE to select
	 *  for update
	 * @return Int the ID
	 */
	public function getArticleID( $flags = 0 ) {
		if ( $this->getNamespace() < 0 ) {
			return $this->mArticleID = 0;
		}

		if (empty($this->mArticleID)) {
			$dbName = WikiFactory::IDtoDB($this->mCityId);
			$db = wfGetDB( DB_SLAVE, array(), $dbName );

			$row = $db->selectRow( 'page',
				array( 'page_id' ),
				array( 'page_namespace' => $this->mNamespace, 'page_title' => $this->mDbkeyform ),
				__METHOD__);

			$this->mArticleID = $row->page_id;
		}

		return $this->mArticleID;
	}

	/*
	 * @author Marooned
	 *
	 * This function is written to be fast. It assumes that we may have 3 different types of URLs (/index.php?title=A, /A or /wiki/A)
	 * If new variation of URL will be introduced in the future, function should check wgArticlePath for particular wiki
	 *
	 * This is a helper function, it doesn't return GlobalTitle (to be honest, it's more like ReversedGlobalTitle)
	 */
	public static function explodeURL( $url ) {
		global $wgDevelEnvironment;

		$urlParts = parse_url( $url );

		if ( $wgDevelEnvironment ){
			$explodedServer = explode( '.', $url );
			$url = $explodedServer[0].'.wikia.com';
		}
		$wikiId = WikiFactory::UrlToID( $url );

		if ( isset( $urlParts['query'] ) ) {
			parse_str( $urlParts['query'], $queryParts );
		}
		if ( isset( $queryParts['title'] ) ) {
			$articleName = $queryParts['title'];
		} else {
			$destinationWgArticlePath = self::getWgArticlePath( $wikiId );
			$articleName = self::stripArticlePath($urlParts['path'], $destinationWgArticlePath );
		}

		$result = array(
			'wikiId' => $wikiId,
			'articleName' => $articleName
		);

		return $result;
	}

	public static function stripArticlePath($path, $articlePath) {
		$articlePath = preg_replace( '!/\$1$!i', '', $articlePath );
		return preg_replace( '!^' . $articlePath . '/!i', '', $path );
	}

	/**
	 * check if page exists
	 *
	 * @return int 0/1
	 */
	public function exists() {
		$this->loadAll();

		if ( !is_null( $this->mExists ) ) {
			return $this->mExists;
		}

		if( WikiFactory::isPublic($this->mCityId) ) {
			$dbName = WikiFactory::IDtoDB($this->mCityId);

			$dbr = wfGetDB( DB_SLAVE, array(), $dbName );

			$oRow = $dbr->selectRow(
				array( 'page' ),
				array( 'page_id' ),
				array(
					'page_title' => $this->mText,
					'page_namespace' => $this->mNamespace
				),
				__METHOD__
			);
			$this->mExists = intval( $oRow ? ($oRow->page_id > 0) : 0 );
		} else {
			$this->mExists = 0;
		}

		return $this->mExists;
	}

	/**
	 * loadServer
	 *
	 * Determine wgServer value from WikiFactory variables
	 *
	 * @return string
	 */
	private function loadServer() {
		/**
		 * don't do this twice
		 */
		if ( $this->mServer ) {
			return $this->mServer;
		}

		/**
		 * get value from city_variables
		 */
		$server = WikiFactory::getVarValueByName( "wgServer", $this->mCityId );
		if ( $server ) {
			$this->mServer = self::normalizeEnvURL( $server );
			return $server;
		}

		/**
		 * get value from city_list.city_url
		 */
		$city = WikiFactory::getWikiByID( $this->mCityId );

		/**
		 * if we got this far and not have a value, ask master
		 */
		if ( empty( $city ) ) {
			$city = WikiFactory::getWikiByID( $this->mCityId, true );
		}

		if ( $city ) {
			$server = rtrim( $city->city_url, "/" );
			$this->mServer = self::normalizeEnvURL( $server );
			return $server;
		}

		return false;
	}

	/**
	 *
	 * Normalizes URL passed to this method to generate environment-specific paths
	 *
	 * @param $server
	 * @return string
	 */
	private static function normalizeEnvURL( $server ) {
		global $wgWikiaEnvironment;
		if ( $wgWikiaEnvironment != WIKIA_ENV_PROD ) {
			return WikiFactory::getLocalEnvURL( $server );
		}

		return $server;
	}

	/**
	 * loadArticlePath
	 *
	 * Determine wgArticlePath value from WikiFactory variables
	 *
	 * @return string
	 */
	private function loadArticlePath() {
		global $wgArticlePath;

		/**
		 * don't do this twice
		 */
		if( $this->mArticlePath ) {
			return $this->mArticlePath;
		}

		/**
		 * get value from city_variables
		 */
		$path = WikiFactory::getVarValueByName( "wgArticlePath", $this->mCityId );
		if( ! $path ) {
			/**
			 * it's 100% true but it's at least something
			 */
			$path = $wgArticlePath;
		}

		/**
		 * replace all variables with proper values (for example wgScriptPath)
		 */
		preg_match_all( '/(\$\w+)[^\w]*/', $path, $vars );
		if( is_array( $vars[1] ) ) {
			foreach( $vars[1] as $var ) {
				$key = ltrim( $var, '$' );
				if( ! is_numeric( $key) ) {
					$replace = WikiFactory::getVarValueByName( $key, $this->mCityId );
					if( !$replace ) {
						$replace = $$key;
					}
					$path = str_replace( $var, $replace, $path  );
				}
			}
		}
		$this->mArticlePath = $path;
		return $path;
	}

	/**
	 * loadContLang
	 *
	 * Determine wgContLang value from WikiFactory variables
	 *
	 * @return Language lang object
	 */
	private function loadContLang() {

		/**
		 * don't do this twice
		 */
		if( $this->mContLang instanceof Language ) {
			return $this->mContLang;
		}

		/**
		 * maybe value from cache
		 */
		if( !$this->mLang ) {
			/**
			 * so maybe value from database?
			 */
			$this->mLang = WikiFactory::getVarValueByName( "wgLanguageCode", $this->mCityId );
			if( !$this->mLang ) {
				/**
				 * nope, only default language which is english
				 */
				$this->mLang = "en";
			}
		}
		$this->mContLang = Language::factory( $this->mLang );

		return $this->mContLang;
	}

	/**
	 * loadNamespaceNames
	 *
	 * Determine $wgCanonicalNamespaceNames value from WikiFactory variables
	 *
	 * @return Array
	 */
	private function loadNamespaceNames() {
		global $wgCanonicalNamespaceNames;

		/**
		 * don't do this twice
		 */
		if( $this->mNamespaceNames ) {
			return $this->mNamespaceNames;
		}

		$this->mNamespaceNames = array();

		/**
		 * get extra namespaces for city_id, they have to be defined in
		 * $wgExtraNamespacesLocal variable
		 */
		$namespaces = WikiFactory::getVarValueByName( "wgExtraNamespacesLocal", $this->mCityId );
		if( is_array( $namespaces ) ) {
			$this->mNamespaceNames =  $wgCanonicalNamespaceNames + $namespaces;
		}
		else {
			$this->mNamespaceNames = $wgCanonicalNamespaceNames;
		}
		return $this->mNamespaceNames;
	}

	/**
	 * memcKey
	 *
	 * combine/prepare cache keys
	 *
	 * @return string
	 */
	private function memcKey() {
		return wfSharedMemcKey( 'globaltitle', $this->mCityId );
	}

	/**
	 * loadFromCache
	 *
	 * load from cache values used widely
	 *
	 * @return boolean
	 */
	private function loadFromCache() {
		global $wgMemc;

		$values = $wgMemc->get( $this->memcKey() );
		if( is_array( $values ) ) {
			$this->mLang = isset( $values[ "lang" ] ) ? $values[ "lang" ] : false;
			$this->mServer = isset( $values[ "server" ] ) ? $values[ "server" ] : false;
			$this->mArticlePath = isset( $values[ "path" ] ) ? $values[ "path" ] : false;
			$this->mNamespaceNames = isset( $values[ "namespaces" ] ) ? $values[ "namespaces" ] : false;
			$this->mLastEdit = isset( $values[ "lastedit" ] ) ? $values[ "lastedit" ] : false;

			return true;
		}
		return false;
	}

	/**
	 * storeInCache
	 *
	 * store in cache values used widely
	 *
	 * @return boolean
	 */
	private function storeInCache() {
		global $wgMemc;

		return $wgMemc->set(
			$this->memcKey(),
			array(
				"path" => $this->mArticlePath,
				"lang" => $this->mLang,
				"server" => $this->mServer,
				"namespaces" => $this->mNamespaceNames,
				"lastedit" => $this->mLastEdit,
			),
			WikiaResponse::CACHE_SHORT
		);
	}
}
