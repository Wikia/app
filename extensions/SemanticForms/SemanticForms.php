<?php
/**
 * Default settings for Semantic Forms.
 *
 * @file
 * @ingroup SF
 */

/**
 * Forms for adding and editing semantic data.
 *
 * @defgroup SF Semantic Forms
 */

/**
 * The module Form Inputs contains form input classes.
 * @defgroup SFFormInput Form Inputs
 * @ingroup SF
 */

/**
 * The module Special Pages contains all Special Pages defined by
 * Semantic Forms.
 *
 * @defgroup SFSpecialPages Special Pages
 * @ingroup SF
 */

/**
 * The module Language contains all language-related classes.
 *
 * @defgroup SFLanguage Language
 * @ingroup SF
 */


if ( !defined( 'MEDIAWIKI' ) ) die();

if ( defined( 'SF_VERSION' ) ) {
	// Do not load Semantic Forms more than once.
	return 1;
}

define( 'SF_VERSION', '3.3' );

if ( !defined( 'SMW_VERSION' ) ) {
	// SMW defines these namespaces itself.
	define( 'SF_NS_FORM', 106 );
	define( 'SF_NS_FORM_TALK', 107 );
}

$GLOBALS['wgExtensionCredits'][defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Forms',
	'version' => SF_VERSION,
	'author' => array( 'Yaron Koren', 'Stephan Gambke', '...' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Semantic_Forms',
	'descriptionmsg' => 'semanticforms-desc',
	'license-name' => 'GPL-2.0+'
);

# ##
# This is the path to your installation of Semantic Forms as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
# #
$GLOBALS['wgExtensionFunctions'][] = function() {
	$GLOBALS['sfgPartialPath'] = '/extensions/SemanticForms';
	$GLOBALS['sfgScriptPath'] = $GLOBALS['wgScriptPath'] . $GLOBALS['sfgPartialPath'];
};
# #

# ##
# This is the path to your installation of Semantic Forms as
# seen on your local filesystem. Used against some PHP file path
# issues.
# #
$GLOBALS['sfgIP'] = dirname( __FILE__ );
# #


// Constants for special properties
define( 'SF_SP_HAS_DEFAULT_FORM', 1 );
define( 'SF_SP_HAS_ALTERNATE_FORM', 2 );
define( 'SF_SP_CREATES_PAGES_WITH_FORM', 3 );
define( 'SF_SP_PAGE_HAS_DEFAULT_FORM', 4 );
define( 'SF_SP_HAS_FIELD_LABEL_FORMAT', 5 );

/**
 * This is a delayed init that makes sure that MediaWiki is set up
 * properly before we add our stuff.
 */
$GLOBALS['wgExtensionFunctions'][] = function() {
	// This global variable is needed so that other extensions can hook
	// into it to add their own input types.
	$GLOBALS['sfgFormPrinter'] = new StubObject( 'sfgFormPrinter', 'SFFormPrinter' );
};

$GLOBALS['wgHooks']['LinkEnd'][] = 'SFFormLinker::setBrokenLink';
// 'SkinTemplateNavigation' replaced 'SkinTemplateTabs' in the Vector skin
// Wikia change -- disable SkinTemplateTabs hooks
// $GLOBALS['wgHooks']['SkinTemplateTabs'][] = 'SFFormEditAction::displayTab';
$GLOBALS['wgHooks']['SkinTemplateNavigation'][] = 'SFFormEditAction::displayTab2';
// $GLOBALS['wgHooks']['SkinTemplateTabs'][] = 'SFHelperFormAction::displayTab';
$GLOBALS['wgHooks']['SkinTemplateNavigation'][] = 'SFHelperFormAction::displayTab2';
$GLOBALS['wgHooks']['smwInitProperties'][] = 'SFUtils::initProperties';
$GLOBALS['wgHooks']['ArticlePurge'][] = 'SFFormUtils::purgeCache';
$GLOBALS['wgHooks']['ArticleSave'][] = 'SFFormUtils::purgeCache';
$GLOBALS['wgHooks']['ParserFirstCallInit'][] = 'SFParserFunctions::registerFunctions';
$GLOBALS['wgHooks']['MakeGlobalVariablesScript'][] = 'SFFormUtils::setGlobalJSVariables';
$GLOBALS['wgHooks']['PageSchemasRegisterHandlers'][] = 'SFPageSchemas::registerClass';
$GLOBALS['wgHooks']['EditPage::importFormData'][] = 'SFUtils::showFormPreview';
$GLOBALS['wgHooks']['CanonicalNamespaces'][] = 'SFUtils::registerNamespaces';
$GLOBALS['wgHooks']['UnitTestsList'][] = 'SFUtils::onUnitTestsList';
$GLOBALS['wgHooks']['ResourceLoaderRegisterModules'][] = 'SFUtils::registerModules';

// Admin Links hook needs to be called in a delayed way so that it
// will always be called after SMW's Admin Links addition; as of
// SMW 1.9, SMW delays calling all its hook functions.
$GLOBALS['wgExtensionFunctions'][] = function() {
	$GLOBALS['wgHooks']['AdminLinks'][] = 'SFUtils::addToAdminLinks';
};

// New "actions"
$GLOBALS['wgActions']['formedit'] = 'SFFormEditAction';
$GLOBALS['wgActions']['formcreate'] = 'SFHelperFormAction';

// API modules
$GLOBALS['wgAPIModules']['sfautocomplete'] = 'SFAutocompleteAPI';
$GLOBALS['wgAPIModules']['sfautoedit'] = 'SFAutoeditAPI';

// register all special pages and other classes
$GLOBALS['wgSpecialPages']['Forms'] = 'SFForms';
$GLOBALS['wgAutoloadClasses']['SFForms'] = __DIR__ . '/specials/SF_Forms.php';
$GLOBALS['wgSpecialPageGroups']['Forms'] = 'pages';
$GLOBALS['wgSpecialPages']['CreateForm'] = 'SFCreateForm';
$GLOBALS['wgAutoloadClasses']['SFCreateForm'] = __DIR__ . '/specials/SF_CreateForm.php';
$GLOBALS['wgSpecialPageGroups']['CreateForm'] = 'sf_group';
$GLOBALS['wgSpecialPages']['Templates'] = 'SFTemplates';
$GLOBALS['wgAutoloadClasses']['SFTemplates'] = __DIR__ . '/specials/SF_Templates.php';
$GLOBALS['wgSpecialPageGroups']['Templates'] = 'pages';
$GLOBALS['wgSpecialPages']['CreateTemplate'] = 'SFCreateTemplate';
$GLOBALS['wgAutoloadClasses']['SFCreateTemplate'] = __DIR__ . '/specials/SF_CreateTemplate.php';
$GLOBALS['wgSpecialPageGroups']['CreateTemplate'] = 'sf_group';
if ( defined( 'SMW_VERSION' ) ) {
	$GLOBALS['wgSpecialPages']['CreateProperty'] = 'SFCreateProperty';
	$GLOBALS['wgAutoloadClasses']['SFCreateProperty'] = __DIR__ . '/specials/SF_CreateProperty.php';
	$GLOBALS['wgSpecialPageGroups']['CreateProperty'] = 'sf_group';
}
$GLOBALS['wgSpecialPages']['CreateClass'] = 'SFCreateClass';
$GLOBALS['wgAutoloadClasses']['SFCreateClass'] = __DIR__ . '/specials/SF_CreateClass.php';
$GLOBALS['wgSpecialPageGroups']['CreateClass'] = 'sf_group';
$GLOBALS['wgSpecialPages']['CreateCategory'] = 'SFCreateCategory';
$GLOBALS['wgAutoloadClasses']['SFCreateCategory'] = __DIR__ . '/specials/SF_CreateCategory.php';
$GLOBALS['wgSpecialPageGroups']['CreateCategory'] = 'sf_group';
$GLOBALS['wgSpecialPages']['FormStart'] = 'SFFormStart';
$GLOBALS['wgAutoloadClasses']['SFFormStart'] = __DIR__ . '/specials/SF_FormStart.php';
$GLOBALS['wgSpecialPageGroups']['FormStart'] = 'sf_group';
$GLOBALS['wgSpecialPages']['FormEdit'] = 'SFFormEdit';
$GLOBALS['wgAutoloadClasses']['SFFormEdit'] = __DIR__ . '/specials/SF_FormEdit.php';
$GLOBALS['wgSpecialPageGroups']['FormEdit'] = 'sf_group';
$GLOBALS['wgSpecialPages']['RunQuery'] = 'SFRunQuery';
$GLOBALS['wgAutoloadClasses']['SFRunQuery'] = __DIR__ . '/specials/SF_RunQuery.php';
$GLOBALS['wgSpecialPageGroups']['RunQuery'] = 'sf_group';
$GLOBALS['wgSpecialPages']['UploadWindow'] = 'SFUploadWindow';
$GLOBALS['wgAutoloadClasses']['SFUploadForm'] = __DIR__ . '/specials/SF_UploadWindow.php';
$GLOBALS['wgAutoloadClasses']['SFUploadSourceField'] = __DIR__ . '/specials/SF_UploadWindow.php';
$GLOBALS['wgAutoloadClasses']['SFUploadWindow'] = __DIR__ . '/specials/SF_UploadWindow.php';
$GLOBALS['wgAutoloadClasses']['SFTemplateField'] = __DIR__ . '/includes/SF_TemplateField.php';
$GLOBALS['wgAutoloadClasses']['TemplatesPage'] = __DIR__ . '/specials/SF_Templates.php';
$GLOBALS['wgAutoloadClasses']['FormsPage'] = __DIR__ . '/specials/SF_Forms.php';
$GLOBALS['wgAutoloadClasses']['SFForm'] = __DIR__ . '/includes/SF_Form.php';
$GLOBALS['wgAutoloadClasses']['SFTemplate'] = __DIR__ . '/includes/SF_Template.php';
$GLOBALS['wgAutoloadClasses']['SFTemplateInForm'] = __DIR__ . '/includes/SF_TemplateInForm.php';
$GLOBALS['wgAutoloadClasses']['SFFormField'] = __DIR__ . '/includes/SF_FormField.php';
$GLOBALS['wgAutoloadClasses']['SFFormPrinter'] = __DIR__ . '/includes/SF_FormPrinter.php';
$GLOBALS['wgAutoloadClasses']['SFFormUtils'] = __DIR__ . '/includes/SF_FormUtils.php';
$GLOBALS['wgAutoloadClasses']['SFUtils'] = __DIR__ . '/includes/SF_Utils.php';
$GLOBALS['wgAutoloadClasses']['SFFormLinker'] = __DIR__ . '/includes/SF_FormLinker.php';
$GLOBALS['wgAutoloadClasses']['SFPageSchemas'] = __DIR__ . '/includes/SF_PageSchemas.php';
$GLOBALS['wgAutoloadClasses']['SFParserFunctions'] = __DIR__ . '/includes/SF_ParserFunctions.php';
$GLOBALS['wgAutoloadClasses']['SFAutocompleteAPI'] = __DIR__ . '/includes/SF_AutocompleteAPI.php';
$GLOBALS['wgAutoloadClasses']['SFAutoeditAPI'] = __DIR__ . '/includes/SF_AutoeditAPI.php';
$GLOBALS['wgAutoloadClasses']['SFFormEditAction'] = __DIR__ . '/includes/SF_FormEditAction.php';
$GLOBALS['wgAutoloadClasses']['SFHelperFormAction'] = __DIR__ . '/includes/SF_HelperFormAction.php';
$GLOBALS['wgAutoloadClasses']['SFPageSection'] = __DIR__ . '/includes/SF_PageSection.php';

// Form inputs
$GLOBALS['wgAutoloadClasses']['SFFormInput'] = __DIR__ . '/includes/forminputs/SF_FormInput.php';
$GLOBALS['wgAutoloadClasses']['SFTextInput'] = __DIR__ . '/includes/forminputs/SF_TextInput.php';
$GLOBALS['wgAutoloadClasses']['SFTextWithAutocompleteInput'] = __DIR__ . '/includes/forminputs/SF_TextWithAutocompleteInput.php';
$GLOBALS['wgAutoloadClasses']['SFTextAreaInput'] = __DIR__ . '/includes/forminputs/SF_TextAreaInput.php';
$GLOBALS['wgAutoloadClasses']['SFTextAreaWithAutocompleteInput'] = __DIR__ . '/includes/forminputs/SF_TextAreaWithAutocompleteInput.php';
$GLOBALS['wgAutoloadClasses']['SFEnumInput'] = __DIR__ . '/includes/forminputs/SF_EnumInput.php';
$GLOBALS['wgAutoloadClasses']['SFMultiEnumInput'] = __DIR__ . '/includes/forminputs/SF_MultiEnumInput.php';
$GLOBALS['wgAutoloadClasses']['SFCheckboxInput'] = __DIR__ . '/includes/forminputs/SF_CheckboxInput.php';
$GLOBALS['wgAutoloadClasses']['SFCheckboxesInput'] = __DIR__ . '/includes/forminputs/SF_CheckboxesInput.php';
$GLOBALS['wgAutoloadClasses']['SFRadioButtonInput'] = __DIR__ . '/includes/forminputs/SF_RadioButtonInput.php';
$GLOBALS['wgAutoloadClasses']['SFDropdownInput'] = __DIR__ . '/includes/forminputs/SF_DropdownInput.php';
$GLOBALS['wgAutoloadClasses']['SFListBoxInput'] = __DIR__ . '/includes/forminputs/SF_ListBoxInput.php';
$GLOBALS['wgAutoloadClasses']['SFComboBoxInput'] = __DIR__ . '/includes/forminputs/SF_ComboBoxInput.php';
$GLOBALS['wgAutoloadClasses']['SFDateInput'] = __DIR__ . '/includes/forminputs/SF_DateInput.php';
$GLOBALS['wgAutoloadClasses']['SFDateTimeInput'] = __DIR__ . '/includes/forminputs/SF_DateTimeInput.php';
$GLOBALS['wgAutoloadClasses']['SFYearInput'] = __DIR__ . '/includes/forminputs/SF_YearInput.php';
$GLOBALS['wgAutoloadClasses']['SFTreeInput'] = __DIR__ . '/includes/forminputs/SF_TreeInput.php';
$GLOBALS['wgAutoloadClasses']['SFTree'] = __DIR__ . '/includes/forminputs/SF_TreeInput.php';
$GLOBALS['wgAutoloadClasses']['SFCategoryInput'] = __DIR__ . '/includes/forminputs/SF_CategoryInput.php';
$GLOBALS['wgAutoloadClasses']['SFCategoriesInput'] = __DIR__ . '/includes/forminputs/SF_CategoriesInput.php';
$GLOBALS['wgAutoloadClasses']['SFTokensInput'] = __DIR__ . '/includes/forminputs/SF_TokensInput.php';
$GLOBALS['wgAutoloadClasses']['SFGoogleMapsInput'] = __DIR__ . '/includes/forminputs/SF_GoogleMapsInput.php';
$GLOBALS['wgAutoloadClasses']['SFOpenLayersInput'] = __DIR__ . '/includes/forminputs/SF_OpenLayersInput.php';

$GLOBALS['wgJobClasses']['createPage'] = 'SFCreatePageJob';
$GLOBALS['wgAutoloadClasses']['SFCreatePageJob'] = __DIR__ . '/includes/SF_CreatePageJob.php';
require_once( __DIR__ . '/languages/SF_Language.php' );

$GLOBALS['wgMessagesDirs']['SemanticForms'] = __DIR__ . '/i18n';
$GLOBALS['wgExtensionMessagesFiles']['SemanticForms'] = __DIR__ . '/languages/SF_Messages.php';
$GLOBALS['wgExtensionMessagesFiles']['SemanticFormsAlias'] = __DIR__ . '/languages/SF_Aliases.php';
$GLOBALS['wgExtensionMessagesFiles']['SemanticFormsMagic'] = __DIR__ . '/languages/SF_Magic.php';
$GLOBALS['wgExtensionMessagesFiles']['SemanticFormsNS'] = __DIR__ . '/languages/SF_Namespaces.php';

// Allow for popup windows for file upload
$GLOBALS['wgEditPageFrameOptions'] = 'SAMEORIGIN';

// register client-side modules
if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
	$sfgResourceTemplate = array(
		'localBasePath' => __DIR__,
		'remoteExtPath' => 'SemanticForms'
	);
	$GLOBALS['wgResourceModules'] += array(
		'ext.semanticforms.main' => $sfgResourceTemplate + array(
			'scripts' => array(
				'libs/SemanticForms.js',
				'libs/SF_preview.js'
			),
			'styles' => array(
				'skins/SemanticForms.css',
				'skins/SF_jquery_ui_overrides.css',
			),
			'dependencies' => array(
				'jquery.ui.core',
				'jquery.ui.autocomplete',
				'jquery.ui.button',
				'jquery.ui.sortable',
				'jquery.ui.widget',
				'ext.semanticforms.fancybox',
				'ext.semanticforms.autogrow',
				'mediawiki.util',
				'ext.semanticforms.select2',
			),
			'messages' => array(
				'sf_formerrors_header',
				'sf_too_few_instances_error',
				'sf_too_many_instances_error',
				'sf_blank_error',
				'sf_not_unique_error',
				'sf_bad_url_error',
				'sf_bad_email_error',
				'sf_bad_number_error',
			),
		),
		'ext.semanticforms.browser' => $sfgResourceTemplate + array(
			'scripts' => 'libs/jquery.browser.js',
		),
		'ext.semanticforms.fancybox' => $sfgResourceTemplate + array(
			'scripts' => 'libs/jquery.fancybox.js',
			'styles' => 'skins/jquery.fancybox.css',
			'dependencies' => array( 'ext.semanticforms.browser' ),
		),
		'ext.semanticforms.dynatree' => $sfgResourceTemplate + array(
			'dependencies' => array( 'jquery.ui.widget' ),
			'scripts' => array(
				'libs/jquery.dynatree.js',
				'libs/ext.dynatree.js',
			),
			'styles' => 'skins/ui.dynatree.css',
		),
		'ext.semanticforms.autogrow' => $sfgResourceTemplate + array(
			'scripts' => 'libs/SF_autogrow.js',
		),
		'ext.semanticforms.popupformedit' => $sfgResourceTemplate + array(
			'scripts' => 'libs/SF_popupform.js',
			'styles' => 'skins/SF_popupform.css',
			'dependencies' => array( 'ext.semanticforms.browser' ),
		),
		'ext.semanticforms.autoedit' => $sfgResourceTemplate + array(
			'scripts' => 'libs/SF_autoedit.js',
			'styles' => 'skins/SF_autoedit.css',
			'messages' => array(
				'sf-autoedit-wait',
				'sf_autoedit_anoneditwarning',
			),
		),
		'ext.semanticforms.submit' => $sfgResourceTemplate + array(
			'scripts' => 'libs/SF_submit.js',
			'styles' => 'skins/SF_submit.css',
			'messages' => array(
				'sf_formedit_saveandcontinue_summary',
				'sf_formedit_saveandcontinueediting',
			),
		),
		'ext.semanticforms.collapsible' => $sfgResourceTemplate + array(
			'scripts' => 'libs/SF_collapsible.js',
			'styles' => 'skins/SF_collapsible.css',
		),
		'ext.semanticforms.imagepreview' => $sfgResourceTemplate + array(
			'scripts' => 'libs/SF_imagePreview.js',
		),
		'ext.semanticforms.checkboxes' => $sfgResourceTemplate + array(
			'scripts' => 'libs/SF_checkboxes.js',
			'styles' => 'skins/SF_checkboxes.css',
			'messages' => array(
				'sf_forminputs_checkboxes_select_all',
				'sf_forminputs_checkboxes_select_none',
			),
		),
		'ext.semanticforms.select2' => $sfgResourceTemplate + array(
			'scripts' => array(
				'libs/select2.js',
				'libs/ext.sf.select2.base.js',
				'libs/ext.sf.select2.combobox.js',
				'libs/ext.sf.select2.tokens.js',
			),
			'styles' => array(
				'skins/select2/select2.css',
				'skins/select2/select2-bootstrap.css',
				'skins/ext.sf.select2.css',
			),
			'dependencies' => array(
				'ext.semanticforms',
				'mediawiki.jqueryMsg',
			),
			'messages' => array(
				'sf-select2-no-matches',
				'sf-select2-searching',
				'sf-select2-input-too-short',
				'sf-select2-selection-too-big',
			),
		),
		'ext.semanticforms.maps' => $sfgResourceTemplate + array(
			'scripts' => 'libs/SF_maps.js',
		),
		'ext.semanticforms' => $sfgResourceTemplate + array(
			'scripts' => array(
				'libs/ext.sf.js',
			),
		),
	);
}

// PHP fails to find relative includes at some level of inclusion:
// $pathfix = $IP . $GLOBALS['sfgScriptPath;

// Global functions


/**
 * Initialize a global language object for content language. This
 * must happen early on, even before user language is known, to
 * determine labels for additional namespaces. In contrast, messages
 * can be initialised much later, when they are actually needed.
 */
call_user_func( function ( $langcode ) {
	if ( !empty( $GLOBALS['sfgContLang'] ) ) { return; }

	$cont_lang_class = 'SF_Language' . str_replace( '-', '_', ucfirst( $langcode ) );
	if ( file_exists( __DIR__ . '/languages/' . $cont_lang_class . '.php' ) ) {
		include_once( __DIR__ . '/languages/' . $cont_lang_class . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists( $cont_lang_class ) ) {
		include_once( __DIR__ . '/languages/SF_LanguageEn.php' );
		$cont_lang_class = 'SF_LanguageEn';
	}

	$GLOBALS['sfgContLang'] = new $cont_lang_class();
}, $GLOBALS['wgLanguageCode'] );

# ##
# The number of allowed values per autocomplete - too many might
# slow down the database, and Javascript's completion.
# ##
$GLOBALS['sfgMaxAutocompleteValues'] = 1000;

# ##
# The number of allowed values for local autocomplete - after which
# it will switch to remote autocompletion.
# ##
$GLOBALS['sfgMaxLocalAutocompleteValues'] = 100;

# ##
# Whether to autocomplete on all characters in a string, not just the
# beginning of words - this is especially important for Unicode strings,
# since the use of the '\b' regexp character to match on the beginnings
# of words fails for them.
# ##
$GLOBALS['sfgAutocompleteOnAllChars'] = false;

# ##
# Used for caching of autocompletion values.
# ##
$GLOBALS['sfgCacheAutocompleteValues'] = false;
$GLOBALS['sfgAutocompleteCacheTimeout'] = null;

# ##
# Global variables for handling the two edit tabs (for traditional editing
# and for editing with a form):
# $GLOBALS['sfgRenameEditTabs'] renames the edit-with-form tab to just "Edit", and
#   the traditional-editing tab, if it is visible, to "Edit source", in
#   whatever language is being used.
# $GLOBALS['sfgRenameMainEditTab'] renames only the traditional editing tab, to
#   "Edit source".
# The wgGroupPermissions 'viewedittab' setting dictates which types of
# visitors will see the "Edit" tab, for pages that are editable by form -
# by default all will see it.
# ##
$GLOBALS['sfgRenameEditTabs'] = false;
$GLOBALS['sfgRenameMainEditTab'] = false;

# ##
# List separator character
# ##
$GLOBALS['sfgListSeparator'] = ",";

# ##
# Use 24-hour time format in forms, e.g. 15:30 instead of 3:30 PM
# ##
$GLOBALS['sfg24HourTime'] = false;

# ##
# Cache parsed form definitions in the page_props table, to improve loading
# speed
# ##
$GLOBALS['sfgCacheFormDefinitions'] = false;

/**
 * The cache type for storing form definitions. This cache is similar in
 * function to the parser cache. Is is used to store form data which is
 * expensive to regenerate, and benefits from having plenty of storage space.
 *
 * If this setting remains at null the setting for the $wgParserCacheType will
 * be used.
 *
 * For available types see $wgMainCacheType.
 */
$GLOBALS['sfgFormCacheType'] = null;

# ##
# Point all red links to "action=formedit", instead of "action=edit", so
# that users can choose which form to use to create each new page.
# ##
$GLOBALS['sfgLinkAllRedLinksToForms'] = false;

# ##
# When modifying red links to potentially point to a form to edit that page,
# check only the properties pointing to that missing page from the page the
# user is currently on, instead of from all pages in the wiki.
# ##
$GLOBALS['sfgRedLinksCheckOnlyLocalProps'] = false;

# ##
# Show the "create with form" tab for uncreated templates and categories.
# ##
$GLOBALS['sfgShowTabsForAllHelperForms'] = true;

# ##
# Displays the form above, instead of below, the results, in the
# Special:RunQuery page.
# (This is actually an undocumented variable, used by the code.)
# ##
$GLOBALS['sfgRunQueryFormAtTop'] = false;

# ##
# Page properties, used for the API
# ##
$GLOBALS['wgPageProps']['formdefinition'] = 'Definition of the semantic form used on the page';

# ##
# Global variables for Javascript
# ##
$GLOBALS['sfgShowOnSelect'] = array();
$GLOBALS['sfgAutocompleteValues'] = array();
// SMW
$GLOBALS['sfgFieldProperties'] = array();
// Cargo
$GLOBALS['sfgCargoFields'] = array();
$GLOBALS['sfgDependentFields'] = array();

/**
 * Minimum number of values in a checkboxes field to show the 'Select all'/'Select none' switches
 */
$GLOBALS['sfgCheckboxesSelectAllMinimum'] = 10;

// Necessary setting for SMW 1.9+
$GLOBALS['smwgEnabledSpecialPage'][] = 'RunQuery';

