<?php
/**
 * @author dch
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

global $smwgNMIP;
include_once( $smwgNMIP . '/languages/SMW_NMLanguage.php' );

class SMW_NMLanguageEn extends SMW_NMLanguage {
	protected $smwContentMessages = array(

	);

	protected $smwUserMessages = array(
	/*Messages for Notify Me*/
	'notifyme' => 'Notify Me',
	'smw_notifyme' => 'Notify Me',

	'smw_qi_addNotify' => 'Notify me',
	'smw_qi_tt_addNotify' => 'Notify me when article-updates meet query condition',
	'smw_nm_tt_query' => 'Add #ask query to Notify Me',
	'smw_nm_tt_qtext' => 'Support query in {{#ask syntax',
	'smw_nm_tt_nmm' => 'Notify Me Manager enable you to control your notifications',
	'smw_nm_tt_clipboard' => 'Copies your RSS Feed URL to the clipboard so it can easily be inserted into any RSS reader',
	);


	protected $smwSpecialProperties = array(
	);


	var $smwSpecialSchemaProperties = array (
	);

	var $smwSpecialCategories = array (
	);

	var $smwNMDatatypes = array(
	);

	protected $smwNMNamespaces = array(
	);

	protected $smwNMNamespaceAliases = array(
	);

	/**
	 * Function that returns the namespace identifiers. This is probably obsolete!
	 */
	public function getNamespaceArray() {
		return array();
	}
}
