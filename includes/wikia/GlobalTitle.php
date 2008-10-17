<?php

/**
 * simple class for using titles across WikiFactory installation
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

class GlobalTitle {

	public $mDefaultText = false;
	public $mNamespace = false;
	public $mCityId = false;

	/**
	 * static constructor, Create new Title from name of page
	 */
	public static function newFromText( $text, $defaultNamespace = NS_MAIN, $city_id = false ) {

		$filteredText = Sanitizer::decodeCharReferences( $text );
		$title = new GlobalTitle();

		$title->mDefaultText = $filteredText;
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
}
