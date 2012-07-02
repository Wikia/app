<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

global $smwgExtTabIP;
include_once( $smwgExtTabIP . '/languages/ET_Language.php' );

class ET_LanguageEn extends ET_Language {

	protected $smwContentMessages = array(

	);


	protected $smwUserMessages = array(
	);


	protected $smwSpecialProperties = array(
	);


	var $smwSpecialSchemaProperties = array (
	);

	var $smwSpecialCategories = array (
	);

	var $smwExtTabDatatypes = array(
	);

	protected $smwExtTabNamespaces = array(
	);

	protected $smwExtTabNamespaceAliases = array(
	);

	/**
	 * Function that returns the namespace identifiers. This is probably obsolete!
	 */
	public function getNamespaceArray() {
		return array();
	}


}


