<?php

/**
 * Classes that enable correct RDF export of Semantic Internal Objects data.
 * This file holds the versions of these classes necessary for SMW 1.5 only.
 * 
 * @author Yaron Koren
 */

class SIOTitle {
	function __construct ($name, $namespace) {
		$this->mName = $name;
		$this->mNamespace = $namespace;
	}

	/**
	 * Based on functions in Title class
	 */
	function getPrefixedName() {
		$s = '';
		if ( 0 != $this->mNamespace ) {
			global $wgContLang;
			$s .= $wgContLang->getNsText( $this->mNamespace ) . ':';
		}
		$s .= $this->mName;
		return $s;
	}

	function getPrefixedURL() {
		$s = $this->getPrefixedName();
		return wfUrlencode( str_replace( ' ', '_', $s ) );
	}
}

class SIOInternalObjectValue extends SMWWikiPageValue {
	function __construct($name, $namespace) {
		$this->mSIOTitle = new SIOTitle( $name, $namespace );
	}
	
	function getExportData() {
		global $smwgNamespace;
		return new SMWExpData( new SMWExpResource( SIOExporter::getResolverURL() . $this->mSIOTitle->getPrefixedURL() ) );
	}

	function getTitle() {
		return $this->mSIOTitle;
	}

	function getWikiValue() {
		return $this->mSIOTitle->getPrefixedName();
	}
}

/**
 * Class to work around the fact that SMWExporter::$m_ent_wiki is protected.
 **/
class SIOExporter extends SMWExporter {

	static function getResolverURL() {
		return SMWExporter::$m_ent_wiki;
	}
}
