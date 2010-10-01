<?php

/**
 * simple class for using titles across WikiFactory installation
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 *
 * @todo wgContLang simulation
 * @todo check if parameters working
 * @todo check if local namespaces works
 *
 */

class GlobalTitle {

	/**
	 * public, used in static constructor
	 */
	public $mText = false;
	public $mNamespace = false;
	public $mCityId = false;
	public $mTextform = false;
	public $mUrlform = false;

	/**
	 * others, private
	 */
	private $mServer = false;
	private $mContLang = false;
	private $mLang = false;
	private $mArticlePath = false;
	private $mNamespaceNames = false;
	private $mLastEdit = false;

	/**
	 * static constructor, Create new Title from name of page
	 */
	public static function newFromText( $text, $namespace, $city_id ) {

		$filteredText = Sanitizer::decodeCharReferences( $text );
		$title = new GlobalTitle();

		$title->mText = $filteredText;
		$title->mUrlform = wfUrlencode( str_replace( ' ', '_', $filteredText ) );
		$title->mTextform = str_replace( '_', ' ', $title->mText );
		$title->mNamespace = $namespace;
		$title->mCityId = $city_id;

		return $title;
	}

	/**
	 * static constructor, Create new Title from id of page 
	 */
	public static function newFromId( $id, $city_id, $dbname = "" ) {
		$title = null;
		$dbr = wfGetDB( DB_SLAVE, array(), ( $dbname ) ? $dbname : WikiFactory::IDtoDB($city_id) );
		$row = $dbr->selectRow( 'page', 
			array( 'page_namespace', 'page_title' ),
			array( 'page_id' => $id ), 
			__METHOD__ 
		);
		if ( $row !== false ) {
			$title = GlobalTitle::newFromText( $row->page_title, $row->page_namespace, $city_id );
		} else {
			$title = NULL;
		}

		return $title;
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

	public function getNamespace() {
		return $this->mNamespace;
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
	 * @param string $variant language variant of url (for sr, zh..)
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

		$url = str_replace( '$1', $namespace . $this->mUrlform, $this->mArticlePath );
		$url = wfAppendQuery( $this->mServer . $url, $query );

		return $url;
	}

	/**
	 * local url doesn't make sense in this context. we always return full URL
	 *
	 * @param string $query an optional query string
	 * @param string $variant language variant of url (for sr, zh..)
	 *
	 * @return string
	 */
	public function getLocalURL( $query = '', $variant = false ) {
		return $this->getFullURL( $query, $variant );
	}

	/**
	 * Get a date of last edit
	 *
	 * @return MW timestamp
	 */
	public function getLastEdit() {

		$this->loadAll();

		if ( $this->mLastEdit ) {
			return $this->mLastEdit;
		}

		$dbr = wfGetDB( DB_SLAVE, array(), WikiFactory::IDtoDB($this->mCityId) );
		
		$this->mLastEdit = $dbr->selectField(
			array( 'revision', 'page' ),
			array( 'rev_timestamp' ),
			array(
				'page_title' => $this->mText,
				'page_namespace' => $this->mNamespace,
				'page_latest=rev_id' 
			),
			__METHOD__ 
		);

		return $this->mLastEdit;
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
		if( $this->mServer ) {
			return $this->mServer;
		}

		/**
		 * get value from city_variables
		 */
		$server = WikiFactory::getVarValueByName( "wgServer", $this->mCityId );
		if( $server ) {
			$this->mServer = $server;
			return $server;
		}

		/**
		 * get value from city_list.city_url
		 */
		$city = WikiFactory::getWikiByID( $city_id );
		if( $city ) {
			$server = rtrim( $server->city_url, "/" );
			$this->mServer = $server;
			return $server;
		}

		return false;
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
	 * @return Lang object
	 */
	private function loadContLang() {

		/**
		 * don't do this twice
		 */
		if( $this->mContLang ) {
			return $this->mContLang;
		}

		/**
		 * maybe value from cache
		 */
		if( $this->mLang ) {
			$lang = $this->mLang;
		}
		else {
			/**
			 * so maybe value from database?
			 */
			$lang = WikiFactory::getVarValueByName( "wgLanguageCode", $this->mCityId );
			if( !$lang ) {
				/**
				 * nope, only default language which is english
				 */
				$lang = "en";
			}
		}
		$this->mContLang = Language::factory( $lang );

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
		global $wgSharedDB;

		return implode(":", array( $wgSharedDB, "globaltitle", $this->mCityId ) );
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
			$this->mLang = isset( $value[ "lang" ] ) ? $value[ "lang" ] : false;
			$this->mServer = isset( $values[ "server" ] ) ? $values[ "server" ] : false;
			$this->mArticlePath = isset( $values[ "path" ] ) ? $values[ "path" ] : false;
			$this->mNamespaceNames = isset( $value[ "namespaces" ] ) ? $value[ "namespaces" ] : false;
			$this->mLastEdit = isset( $value[ "lastedit" ] ) ? $value[ "lastedit" ] : false;

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
			3600
		);
	}
}
