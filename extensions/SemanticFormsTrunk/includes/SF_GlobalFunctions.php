<?php
/**
 * Global functions for Semantic Forms.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 *  Do the actual intialization of the extension. This is just a delayed init that makes sure
 *  MediaWiki is set up properly before we add our stuff.
 */
function sfgSetupExtension() {
	// this global variable is needed so that other extensions (such
	// as Semantic Google Maps) can hook into it to add their own input
	// types
	global $sfgFormPrinter;
	$sfgFormPrinter = new StubObject( 'sfgFormPrinter', 'SFFormPrinter' );
}

/**********************************************/
/***** namespace settings                 *****/
/**********************************************/

/**
 * Init the additional namespaces used by Semantic Forms. The
 * parameter denotes the least unused even namespace ID that is
 * greater or equal to 100.
 */
function sffInitNamespaces() {
	global $wgExtraNamespaces, $wgNamespaceAliases, $wgNamespacesWithSubpages, $wgLanguageCode, $sfgContLang;

	sffInitContentLanguage( $wgLanguageCode );

	// Register namespace identifiers
	if ( !is_array( $wgExtraNamespaces ) ) { $wgExtraNamespaces = array(); }
	$wgExtraNamespaces = $wgExtraNamespaces + $sfgContLang->getNamespaces();
	$wgNamespaceAliases = $wgNamespaceAliases + $sfgContLang->getNamespaceAliases();

	// Support subpages only for talk pages by default
	$wgNamespacesWithSubpages = $wgNamespacesWithSubpages + array(
		SF_NS_FORM_TALK => true
	);
}

/**********************************************/
/***** language settings                  *****/
/**********************************************/

/**
 * Initialize a global language object for content language. This
 * must happen early on, even before user language is known, to
 * determine labels for additional namespaces. In contrast, messages
 * can be initialised much later, when they are actually needed.
 */
function sffInitContentLanguage( $langcode ) {
	global $sfgIP, $sfgContLang;

	if ( !empty( $sfgContLang ) ) { return; }

	$cont_lang_class = 'SF_Language' . str_replace( '-', '_', ucfirst( $langcode ) );
	if ( file_exists( $sfgIP . '/languages/' . $cont_lang_class . '.php' ) ) {
		include_once( $sfgIP . '/languages/' . $cont_lang_class . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists( $cont_lang_class ) ) {
		include_once( $sfgIP . '/languages/SF_LanguageEn.php' );
		$cont_lang_class = 'SF_LanguageEn';
	}

	$sfgContLang = new $cont_lang_class();
}

/**
 * Initialize the global language object for user language. This
 * must happen after the content language was initialised, since
 * this language is used as a fallback.
 */
function sffInitUserLanguage( $langcode ) {
	global $sfgIP, $sfgLang;

	if ( !empty( $sfgLang ) ) { return; }

	$sfLangClass = 'SF_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if ( file_exists( $sfgIP . '/languages/' . $sfLangClass . '.php' ) ) {
		include_once( $sfgIP . '/languages/' . $sfLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists( $sfLangClass ) ) {
		global $sfgContLang;
		$sfgLang = $sfgContLang;
	} else {
		$sfgLang = new $sfLangClass();
	}
}

function sffAddToAdminLinks( &$admin_links_tree ) {
	$data_structure_label = wfMsg( 'smw_adminlinks_datastructure' );
	$data_structure_section = $admin_links_tree->getSection( $data_structure_label );
	if ( is_null( $data_structure_section ) )
		return true;
	$smw_row = $data_structure_section->getRow( 'smw' );
	$smw_row->addItem( ALItem::newFromSpecialPage( 'Templates' ), 'Properties' );
	$smw_row->addItem( ALItem::newFromSpecialPage( 'Forms' ), 'SemanticStatistics' );
	$smw_admin_row = $data_structure_section->getRow( 'smw_admin' );
	$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateClass' ), 'SMWAdmin' );
	$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateProperty' ), 'SMWAdmin' );
	$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateTemplate' ), 'SMWAdmin' );
	$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateForm' ), 'SMWAdmin' );
	$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateCategory' ), 'SMWAdmin' );
	$smw_docu_row = $data_structure_section->getRow( 'smw_docu' );
	$sf_name = wfMsg( 'specialpages-group-sf_group' );
	$sf_docu_label = wfMsg( 'adminlinks_documentation', $sf_name );
	$smw_docu_row->addItem( ALItem::newFromExternalLink( "http://www.mediawiki.org/wiki/Extension:Semantic_Forms", $sf_docu_label ) );

	return true;
}
