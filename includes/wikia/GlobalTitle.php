<?php

/**
 * simple class for using titles across WikiFactory installation
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

class GlobalTitle {

	/**
	 * public, used in static constructor
	 */
	public $mDefaultText = false;
	public $mNamespace = false;
	public $mCityId = false;
	public $mTextform = false;

	/**
	 * others, private
	 */
	private $mServer = false;
	private $mContLang = false;

	/**
	 * static constructor, Create new Title from name of page
	 */
	public static function newFromText( $text, $defaultNamespace = NS_MAIN, $city_id = false ) {

		$filteredText = Sanitizer::decodeCharReferences( $text );
		$title = new GlobalTitle();

		$title->mDefaultText = $filteredText;
		$title->mTextform = str_replace( '_', ' ', $title->mDefaultText );
		$title->mNamespace = $defaultNamespace;
		$title->mCityId = $city_id;

		return $title;
	}

	public function getNamespace() {
		return $this->mNamespace;
	}

	/**
	 * Get the namespace text
	 * @return string
	 */
	public function getNsText() {
		global $wgContLang, $wgCanonicalNamespaceNames;

		if( isset( $wgCanonicalNamespaceNames[ $this->mNamespace ] ) ) {
			return $wgCanonicalNamespaceNames[ $this->mNamespace ];
		}

		/**
		 * get extra namespaces for city_id, they have to be defined in
		 * $wgExtraNamespacesLocal variable
		 */
		$localNamespaces = WikiFactory::getVarValueByName( "wgExtraNamespacesLocal", $this->mCityId );

		if( isset( $localNamespaces[ $this->mNamespace ] ) ) {
			return $localNamespaces[ $this->mNamespace ];
		}

		return $wgContLang->getNsText( $this->mNamespace );
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

		if( ! $this->mServer ) {
			$this->loadServer();
		}
	}


	/**
	 * loadServer
	 *
	 * Determine wgServer value from WikiFactory variables
	 *
	 * @return string, $wgServer for $city_id
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
}
