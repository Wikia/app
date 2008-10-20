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
	private $mArticlePath = false;
	private $mNamespaceNames = false;

	/**
	 * static constructor, Create new Title from name of page
	 */
	public static function newFromText( $text, $namespace, $city_id ) {

		$filteredText = Sanitizer::decodeCharReferences( $text );
		$title = new GlobalTitle();

		$title->mText = $filteredText;
		$title->mUrlform = $filteredText;
		$title->mTextform = str_replace( '_', ' ', $title->mText );
		$title->mNamespace = $namespace;
		$title->mCityId = $city_id;

		return $title;
	}

	/**
	 * loadAll
	 *
	 *  constructor doesnt load anything from database. This is the place
	 *  for that kind of things
	 */
	private function loadAll() {
		$this->loadServer();
		$this->loadArticlePath();
		$this->loadContLang();
		$this->loadNamespaceNames();
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
	 * Get a real URL referring to this title
	 *
	 *
	 * @param string $query an optional query string
	 * @param string $variant language variant of url (for sr, zh..)
	 * @return string the URL
	 */
	public function getFullURL( $query = '', $variant = false ) {

		$this->loadAll();
		$namespace = wfUrlencode( $this->getNsText() );

		if( $this->mNamespace !== NS_MAIN ) {
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

		$lang = WikiFactory::getVarValueByName( "wgLanguageCode", $this->mCityId );
		if( !$lang ) {
			/**
			 * default language is english
			 */
			$lang = "en";
		}
		$this->mContLang = Language::factory( $lang );

		return $this->mContLang;
	}

	/**
	 * loadContLang
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
}
