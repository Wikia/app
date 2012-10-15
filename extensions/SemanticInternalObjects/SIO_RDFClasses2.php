<?php

/**
 * Classes that enable correct RDF export of Semantic Internal Objects data.
 * This file holds the versions of these classes necessary for SMW >= 1.6.
 * 
 * @author Yaron Koren
 */

class SIOTitle {
	function __construct ($name, $namespace) {
		$this->mName = $name;
		$this->mNamespace = $namespace;
	}
}

/**
 * @TODO - should this take advantage of the "internal object"/sub-object/
 * blank-node functionality in SMW 1.6, put in place for use by the Record
 * type? For now, just ignore that.
 */
class SIOInternalObjectValue extends SMWDIWikiPage {
	function __construct($name, $namespace) {
		$this->mSIOTitle = new SIOTitle( $name, $namespace );
	}

	function getDBkey() {
		return $this->mSIOTitle->mName;
	}

	function getNamespace() {
		return $this->mSIOTitle->mNamespace;
	}
}
