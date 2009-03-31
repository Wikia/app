<?php
/**
 * Global functions and constants for Semantic Forms.
 *
 * @author Yaron Koren
 * @author Harold Solbrig
 * @author Louis Gerbarg
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define('SF_VERSION','1.4.1');

$wgExtensionCredits['specialpage'][]= array(
	'name' => 'Semantic Forms',
	'version' => SF_VERSION,
	'author' => 'Yaron Koren and others',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Semantic_Forms',
	'description' => 'Forms for adding and editing semantic data',
	'descriptionmsg'  => 'semanticforms-desc',
);

// constants for special properties
define('SF_SP_HAS_DEFAULT_FORM', 1);
define('SF_SP_HAS_ALTERNATE_FORM', 2);

$wgExtensionFunctions[] = 'sfgSetupExtension';
$wgExtensionFunctions[] = 'sfgParserFunctions';

$wgHooks['LanguageGetMagic'][] = 'SFParserFunctions::languageGetMagic';
// the 'BrokenLink' hook exists only in MediaWiki v1.13 - it was replaced
// by 'LinkBegin' and 'LinkEnd'
$wgHooks['BrokenLink'][] = 'SFLinkUtils::setBrokenLink_1_13';
$wgHooks['LinkEnd'][] = 'SFLinkUtils::setBrokenLink';
$wgHooks['UnknownAction'][] = 'SFFormEditTab::displayForm';
$wgHooks['SkinTemplateTabs'][] = 'SFFormEditTab::displayTab';
$wgHooks['smwInitProperties'][] = 'SFUtils::initProperties';

$wgAPIModules['sfautocomplete'] = 'SFAutocompleteAPI';

// register all special pages and other classes
$wgSpecialPages['Forms'] = 'SFForms';
$wgAutoloadClasses['SFForms'] = $sfgIP . '/specials/SF_Forms.php';
$wgSpecialPageGroups['Forms'] = 'sf_group';
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
$wgSpecialPages['AddPage'] = 'SFAddPage';
$wgAutoloadClasses['SFAddPage'] = $sfgIP . '/specials/SF_AddPage.php';
$wgSpecialPageGroups['AddPage'] = 'sf_group';
$wgSpecialPages['AddData'] = 'SFAddData';
$wgAutoloadClasses['SFAddData'] = $sfgIP . '/specials/SF_AddData.php';
$wgSpecialPageGroups['AddData'] = 'sf_group';
$wgSpecialPages['EditData'] = 'SFEditData';
$wgAutoloadClasses['SFEditData'] = $sfgIP . '/specials/SF_EditData.php';
$wgSpecialPageGroups['EditData'] = 'sf_group';
$wgSpecialPages['UploadWindow'] = 'SFUploadWindow';
$wgAutoloadClasses['SFUploadWindow'] = $sfgIP . '/specials/SF_UploadWindow.php';

$wgAutoloadClasses['FormEditPage'] = $sfgIP . '/includes/SF_FormEditPage.php';
$wgAutoloadClasses['SFTemplateField'] = $sfgIP . '/includes/SF_TemplateField.inc';
$wgAutoloadClasses['SFForm'] = $sfgIP . '/includes/SF_FormClasses.inc';
$wgAutoloadClasses['SFTemplateInForm'] = $sfgIP . '/includes/SF_FormClasses.inc';
$wgAutoloadClasses['SFFormTemplateField'] = $sfgIP . '/includes/SF_FormClasses.inc';
$wgAutoloadClasses['SFFormPrinter'] = $sfgIP . '/includes/SF_FormPrinter.inc';
$wgAutoloadClasses['SFFormInputs'] = $sfgIP . '/includes/SF_FormInputs.inc';
$wgAutoloadClasses['SFFormUtils'] = $sfgIP . '/includes/SF_FormUtils.inc';
$wgAutoloadClasses['SFFormEditTab'] = $sfgIP . '/includes/SF_FormEditTab.php';
$wgAutoloadClasses['SFUtils'] = $sfgIP . '/includes/SF_Utils.inc';
$wgAutoloadClasses['SFLinkUtils'] = $sfgIP . '/includes/SF_LinkUtils.inc';
$wgAutoloadClasses['SFParserFunctions'] = $sfgIP . '/includes/SF_ParserFunctions.php';
$wgAutoloadClasses['SFAutocompleteAPI'] = $sfgIP . '/includes/SF_AutocompleteAPI.php';

require_once($sfgIP . '/languages/SF_Language.php');

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
	if( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
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
	global $sfgNamespaceIndex, $wgExtraNamespaces, $wgNamespaceAliases, $wgNamespacesWithSubpages, $wgLanguageCode, $sfgContLang;

	if (!isset($sfgNamespaceIndex)) {
		$sfgNamespaceIndex = 106;
	}

	// these namespaces are defined in versions 1.4 and later of SMW
	if (! defined('SF_NS_FORM'))
		define('SF_NS_FORM',       $sfgNamespaceIndex);
	if (! defined('SF_NS_FORM_TALK'))
		define('SF_NS_FORM_TALK',  $sfgNamespaceIndex+1);

	sffInitContentLanguage($wgLanguageCode);

	// Register namespace identifiers
	if (!is_array($wgExtraNamespaces)) { $wgExtraNamespaces=array(); }
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
function sffInitContentLanguage($langcode) {
	global $sfgIP, $sfgContLang;

	if (!empty($sfgContLang)) { return; }

	$sfContLangClass = 'SF_Language' . str_replace( '-', '_', ucfirst( $langcode ) );
	if (file_exists($sfgIP . '/languages/'. $sfContLangClass . '.php')) {
		include_once( $sfgIP . '/languages/'. $sfContLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($sfContLangClass)) {
		include_once($sfgIP . '/languages/SF_LanguageEn.php');
		$sfContLangClass = 'SF_LanguageEn';
	}

	$sfgContLang = new $sfContLangClass();
}

/**
 * Initialize the global language object for user language. This
 * must happen after the content language was initialised, since
 * this language is used as a fallback.
 */
function sffInitUserLanguage($langcode) {
	global $sfgIP, $sfgLang;

	if (!empty($sfgLang)) { return; }

	$sfLangClass = 'SF_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if (file_exists($sfgIP . '/languages/'. $sfLangClass . '.php')) {
		include_once( $sfgIP . '/languages/'. $sfLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($sfLangClass)) {
		global $sfgContLang;
		$sfgLang = $sfgContLang;
	} else {
		$sfgLang = new $sfLangClass();
	}
}
