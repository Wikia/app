<?php
/**
 * Constants and initializations for Semantic Forms.
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'SF_VERSION', '1.9' );

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Forms',
	'version' => SF_VERSION,
	'author' => 'Yaron Koren and others',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Semantic_Forms',
	'descriptionmsg'  => 'semanticforms-desc',
);

// constants for special properties
define( 'SF_SP_HAS_DEFAULT_FORM', 1 );
define( 'SF_SP_HAS_ALTERNATE_FORM', 2 );
define( 'SF_SP_CREATES_PAGES_WITH_FORM', 3 );
define( 'SF_SP_PAGE_HAS_DEFAULT_FORM', 4 );
define( 'SF_SP_HAS_FIELD_LABEL_FORMAT', 5 );

$wgExtensionFunctions[] = 'sfgSetupExtension';
$wgExtensionFunctions[] = 'sfgParserFunctions';

// FIXME: Can be removed when new style magic words are used (introduced in r52503)
$wgHooks['LanguageGetMagic'][] = 'SFParserFunctions::languageGetMagic';
// the 'BrokenLink' hook exists only in MediaWiki v1.13 - it was replaced
// by 'LinkBegin' and 'LinkEnd'
$wgHooks['BrokenLink'][] = 'SFLinkUtils::setBrokenLink_1_13';
$wgHooks['LinkEnd'][] = 'SFLinkUtils::setBrokenLink';
$wgHooks['UnknownAction'][] = 'SFFormEditTab::displayForm';
// 'SkinTemplateNavigation' replaced 'SkinTemplateTabs' in the 'Vector' skin
// for MediaWiki v1.16
$wgHooks['SkinTemplateTabs'][] = 'SFFormEditTab::displayTab';
$wgHooks['SkinTemplateNavigation'][] = 'SFFormEditTab::displayTab2';
$wgHooks['smwInitProperties'][] = 'SFUtils::initProperties';
$wgHooks['AdminLinks'][] = 'sffAddToAdminLinks';
$wgHooks['ParserBeforeStrip'][] = 'SFUtils::cacheFormDefinition';

$wgAPIModules['sfautocomplete'] = 'SFAutocompleteAPI';

// register all special pages and other classes
$wgSpecialPages['Forms'] = 'SFForms';
$wgAutoloadClasses['SFForms'] = $sfgIP . '/specials/SF_Forms.php';
$wgSpecialPageGroups['Forms'] = 'pages';
$wgSpecialPages['CreateForm'] = 'SFCreateForm';
$wgAutoloadClasses['SFCreateForm'] = $sfgIP . '/specials/SF_CreateForm.php';
$wgSpecialPageGroups['CreateForm'] = 'sf_group';
$wgSpecialPages['Templates'] = 'SFTemplates';
$wgAutoloadClasses['SFTemplates'] = $sfgIP . '/specials/SF_Templates.php';
$wgSpecialPageGroups['Templates'] = 'pages';
$wgSpecialPages['CreateTemplate'] = 'SFCreateTemplate';
$wgAutoloadClasses['SFCreateTemplate'] = $sfgIP . '/specials/SF_CreateTemplate.php';
$wgSpecialPageGroups['CreateTemplate'] = 'sf_group';
$wgSpecialPages['CreateProperty'] = 'SFCreateProperty';
$wgAutoloadClasses['SFCreateProperty'] = $sfgIP . '/specials/SF_CreateProperty.php';
$wgSpecialPageGroups['CreateProperty'] = 'sf_group';
$wgSpecialPages['CreateCategory'] = 'SFCreateCategory';
$wgAutoloadClasses['SFCreateCategory'] = $sfgIP . '/specials/SF_CreateCategory.php';
$wgSpecialPageGroups['CreateCategory'] = 'sf_group';
$wgSpecialPages['CreateClass'] = 'SFCreateClass';
$wgAutoloadClasses['SFCreateClass'] = $sfgIP . '/specials/SF_CreateClass.php';
$wgSpecialPageGroups['CreateClass'] = 'sf_group';
$wgSpecialPages['FormStart'] = 'SFFormStart';
$wgAutoloadClasses['SFFormStart'] = $sfgIP . '/specials/SF_FormStart.php';
$wgSpecialPageGroups['FormStart'] = 'sf_group';
$wgSpecialPages['FormEdit'] = 'SFFormEdit';
$wgAutoloadClasses['SFFormEdit'] = $sfgIP . '/specials/SF_FormEdit.php';
$wgSpecialPageGroups['FormEdit'] = 'sf_group';
$wgSpecialPages['RunQuery'] = 'SFRunQuery';
$wgAutoloadClasses['SFRunQuery'] = $sfgIP . '/specials/SF_RunQuery.php';
$wgSpecialPageGroups['RunQuery'] = 'sf_group';
// different upload-window class for MW 1.16+
if ( class_exists( 'HTMLTextField' ) ) { // added in MW 1.16
	$wgSpecialPages['UploadWindow'] = 'SFUploadWindow2';
	$wgAutoloadClasses['SFUploadWindow2'] = $sfgIP . '/specials/SF_UploadWindow2.php';
} else {
	$wgSpecialPages['UploadWindow'] = 'SFUploadWindow';
	$wgAutoloadClasses['SFUploadWindow'] = $sfgIP . '/specials/SF_UploadWindow.php';
}
$wgAutoloadClasses['SFTemplateField'] = $sfgIP . '/includes/SF_TemplateField.inc';
$wgAutoloadClasses['SFForm'] = $sfgIP . '/includes/SF_FormClasses.inc';
$wgAutoloadClasses['SFTemplateInForm'] = $sfgIP . '/includes/SF_FormClasses.inc';
$wgAutoloadClasses['SFFormField'] = $sfgIP . '/includes/SF_FormField.inc';
$wgAutoloadClasses['SFFormPrinter'] = $sfgIP . '/includes/SF_FormPrinter.inc';
$wgAutoloadClasses['SFFormInputs'] = $sfgIP . '/includes/SF_FormInputs.inc';
$wgAutoloadClasses['SFFormUtils'] = $sfgIP . '/includes/SF_FormUtils.inc';
$wgAutoloadClasses['SFFormEditTab'] = $sfgIP . '/includes/SF_FormEditTab.php';
$wgAutoloadClasses['SFFormEditPage'] = $sfgIP . '/includes/SF_FormEditPage.php';
$wgAutoloadClasses['SFUtils'] = $sfgIP . '/includes/SF_Utils.inc';
$wgAutoloadClasses['SFLinkUtils'] = $sfgIP . '/includes/SF_LinkUtils.inc';
$wgAutoloadClasses['SFParserFunctions'] = $sfgIP . '/includes/SF_ParserFunctions.php';
$wgAutoloadClasses['SFAutocompleteAPI'] = $sfgIP . '/includes/SF_AutocompleteAPI.php';
$wgJobClasses['createPage'] = 'SFCreatePageJob';
$wgAutoloadClasses['SFCreatePageJob'] = $sfgIP . '/includes/SF_CreatePageJob.php';
require_once( $sfgIP . '/languages/SF_Language.php' );

$wgExtensionMessagesFiles['SemanticForms'] = $sfgIP . '/languages/SF_Messages.php';
$wgExtensionAliasesFiles['SemanticForms'] = $sfgIP . '/languages/SF_Aliases.php';

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

function sfgParserFunctions() {
	global $wgHooks, $wgParser;
	if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
		$wgHooks['ParserFirstCallInit'][] = 'SFParserFunctions::registerFunctions';
	} else {
		if ( class_exists( 'StubObject' ) && !StubObject::isRealObject( $wgParser ) ) {
			$wgParser->_unstub();
		}
		SFParserFunctions::registerFunctions( $wgParser );
	}
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
