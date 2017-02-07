<?php
/**
 * Static functions called by various outside hooks, as well as by
 * extension.json.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

class SFHooks {

	public static function registerExtension() {
		if ( defined( 'SF_VERSION' ) ) {
			// Do not load Semantic Forms more than once.
			return 1;
		}

		define( 'SF_VERSION', '3.7' );

		if ( !defined( 'SF_NS_FORM' ) ) {
			// SMW defines these namespaces itself.
			define( 'SF_NS_FORM', 106 );
			define( 'SF_NS_FORM_TALK', 107 );
		}

		$GLOBALS['sfgIP'] = dirname( __DIR__ );

		// Constants for special properties
		define( 'SF_SP_HAS_DEFAULT_FORM', 1 );
		define( 'SF_SP_HAS_ALTERNATE_FORM', 2 );
		define( 'SF_SP_CREATES_PAGES_WITH_FORM', 3 );
		define( 'SF_SP_PAGE_HAS_DEFAULT_FORM', 4 );
		define( 'SF_SP_HAS_FIELD_LABEL_FORMAT', 5 );

		/**
		 * This is a delayed init that makes sure that MediaWiki is set
		 * up properly before we add our stuff.
		 */

		// This global variable is needed so that other
		// extensions can hook into it to add their own
		// input types.

		if ( defined( 'SMW_VERSION' ) ) {
			$GLOBALS['wgSpecialPages']['CreateProperty'] = 'SFCreateProperty';
			$GLOBALS['wgAutoloadClasses']['SFCreateProperty'] = __DIR__ . '/../specials/SF_CreateProperty.php';
		}

		/**
		 * Initialize a global language object for content language. This
		 * must happen early on, even before user language is known, to
		 * determine labels for additional namespaces. In contrast, messages
		 * can be initialised much later, when they are actually needed.
		 */
		if ( !empty( $GLOBALS['sfgContLang'] ) ) {
			return;
		}

		$cont_lang_class = 'SF_Language' . str_replace( '-', '_', ucfirst( $GLOBALS['wgLanguageCode'] ) );
		if ( file_exists( __DIR__ . '/../languages/' . $cont_lang_class . '.php' ) ) {
			include_once( __DIR__ . '/../languages/' . $cont_lang_class . '.php' );
		}

		// fallback if language not supported
		if ( !class_exists( $cont_lang_class ) ) {
			include_once( __DIR__ . '/../languages/SF_LanguageEn.php' );
			$cont_lang_class = 'SF_LanguageEn';
		}

		$GLOBALS['sfgContLang'] = new $cont_lang_class();

		// Allow for popup windows for file upload
		$GLOBALS['wgEditPageFrameOptions'] = 'SAMEORIGIN';

		// Necessary setting for SMW 1.9+
		$GLOBALS['smwgEnabledSpecialPage'][] = 'RunQuery';
	}

	public static function initialize() {
		$GLOBALS['sfgPartialPath'] = '/extensions/SemanticForms';
		$GLOBALS['sfgScriptPath'] = $GLOBALS['wgScriptPath'] . $GLOBALS['sfgPartialPath'];

		// Admin Links hook needs to be called in a delayed way so that it
		// will always be called after SMW's Admin Links addition; as of
		// SMW 1.9, SMW delays calling all its hook functions.
		$GLOBALS['wgHooks']['AdminLinks'][] = 'SFHooks::addToAdminLinks';

		// This global variable is needed so that other
		// extensions can hook into it to add their own
		// input types.
		$GLOBALS['sfgFormPrinter'] = new StubObject( 'sfgFormPrinter', 'SFFormPrinter' );
	}

	/**
	 * ResourceLoaderRegisterModules hook handler
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ResourceLoaderRegisterModules
	 *
	 * @param ResourceLoader &$resourceLoader The ResourceLoader object
	 * @return bool Always true
	 */
	public static function registerModules( ResourceLoader &$resourceLoader ) {
		if ( class_exists( 'WikiEditorHooks' ) ) {
			$resourceLoader->register( array(
				'ext.semanticforms.wikieditor' => array(
					'localBasePath' => __DIR__,
					'remoteExtPath' => 'SemanticForms',
					'scripts' => '/../libs/SF_wikieditor.js',
					'styles' => '/../skins/SF_wikieditor.css',
					'dependencies' => array(
						'ext.semanticforms.main',
						'jquery.wikiEditor'
					)
				),
			) );
		}

		if ( version_compare( $GLOBALS['wgVersion'], '1.26c', '>' ) && ExtensionRegistry::getInstance()->isLoaded( 'OpenLayers' ) ) {
			$resourceLoader->register( array(
				'ext.semanticforms.maps' => array(
					'localBasePath' => __DIR__,
					'remoteExtPath' => 'SemanticForms',
					'scripts' => '/../libs/SF_maps.offline.js',
					'dependencies' => array(
						'ext.openlayers.main',
					)
				),
			) );
		} else {
			$resourceLoader->register( array(
				'ext.semanticforms.maps' => array(
					'localBasePath' => __DIR__,
					'remoteExtPath' => 'SemanticForms',
					'scripts' => '/../libs/SF_maps.js',
				),
			) );
		}

		return true;
	}

	/**
	 * Register the namespaces for Semantic Forms.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/CanonicalNamespaces
	 *
	 * @since 2.4.1
	 *
	 * @param array $list
	 *
	 * @return true
	 */
	public static function registerNamespaces( array &$list ) {
		global $wgNamespacesWithSubpages;

		$list[SF_NS_FORM] = 'Form';
		$list[SF_NS_FORM_TALK] = 'Form_talk';

		// Support subpages only for talk pages by default
		$wgNamespacesWithSubpages[SF_NS_FORM_TALK] = true;

		return true;
	}

	static function registerFunctions( &$parser ) {
		$parser->setFunctionHook( 'default_form', array( 'SFParserFunctions', 'renderDefaultForm' ) );
		$parser->setFunctionHook( 'forminput', array( 'SFParserFunctions', 'renderFormInput' ) );
		$parser->setFunctionHook( 'formlink', array( 'SFParserFunctions', 'renderFormLink' ) );
		$parser->setFunctionHook( 'formredlink', array( 'SFParserFunctions', 'renderFormRedLink' ) );
		$parser->setFunctionHook( 'queryformlink', array( 'SFParserFunctions', 'renderQueryFormLink' ) );
		$parser->setFunctionHook( 'arraymap', array( 'SFParserFunctions', 'renderArrayMap' ), $parser::SFH_OBJECT_ARGS );
		$parser->setFunctionHook( 'arraymaptemplate', array( 'SFParserFunctions', 'renderArrayMapTemplate' ), $parser::SFH_OBJECT_ARGS );

		$parser->setFunctionHook( 'autoedit', array( 'SFParserFunctions', 'renderAutoEdit' ) );

		return true;
	}

	static function setGlobalJSVariables( &$vars ) {
		global $sfgAutocompleteValues, $sfgAutocompleteOnAllChars;
		global $sfgFieldProperties, $sfgCargoFields, $sfgDependentFields;
		global $sfgGridValues, $sfgGridParams;
		global $sfgShowOnSelect, $sfgScriptPath;
		global $edgValues, $sfgEDSettings;
		//global $sfgInitJSFunctions, $sfgValidationJSFunctions;

		$vars['sfgAutocompleteValues'] = $sfgAutocompleteValues;
		$vars['sfgAutocompleteOnAllChars'] = $sfgAutocompleteOnAllChars;
		$vars['sfgFieldProperties'] = $sfgFieldProperties;
		$vars['sfgCargoFields'] = $sfgCargoFields;
		$vars['sfgDependentFields'] = $sfgDependentFields;
		$vars['sfgGridValues'] = $sfgGridValues;
		$vars['sfgGridParams'] = $sfgGridParams;
		$vars['sfgShowOnSelect'] = $sfgShowOnSelect;
		$vars['sfgScriptPath'] = $sfgScriptPath;
		$vars['edgValues'] = $edgValues;
		$vars['sfgEDSettings'] = $sfgEDSettings;
		//$vars['sfgInitJSFunctions'] = $sfgInitJSFunctions;
		//$vars['sfgValidationJSFunctions'] = $sfgValidationJSFunctions;

		return true;
	}

	public static function registerProperty( $id, $typeid, $label ) {
		if ( class_exists( 'SMWDIProperty' ) ) {
			SMWDIProperty::registerProperty( $id, $typeid, $label, true );
		} else {
			SMWPropertyValue::registerProperty( $id, $typeid, $label, true );
		}
	}

	/**
	 * Register all the special properties, in both the wiki's
	 * language and, as a backup, in English.
	 */
	public static function initProperties() {
		global $sfgContLang;

		// For every special property, if it hasn't been translated
		// into the wiki's current language, use the English-language
		// value for both the main special property and the backup.
		$sf_props = $sfgContLang->getPropertyLabels();
		if ( array_key_exists( SF_SP_HAS_DEFAULT_FORM, $sf_props ) ) {
			self::registerProperty( '_SF_DF', '__spf', $sf_props[SF_SP_HAS_DEFAULT_FORM] );
		} else {
			self::registerProperty( '_SF_DF', '__spf', 'Has default form' );
		}
		if ( array_key_exists( SF_SP_HAS_ALTERNATE_FORM, $sf_props ) ) {
			self::registerProperty( '_SF_AF', '__spf', $sf_props[SF_SP_HAS_ALTERNATE_FORM] );
		} else {
			self::registerProperty( '_SF_AF', '__spf', 'Has alternate form' );
		}
		if ( array_key_exists( SF_SP_CREATES_PAGES_WITH_FORM, $sf_props ) ) {
			self::registerProperty( '_SF_CP', '__spf', $sf_props[SF_SP_CREATES_PAGES_WITH_FORM] );
		} else {
			self::registerProperty( '_SF_CP', '__spf', 'Creates pages with form' );
		}
		if ( array_key_exists( SF_SP_PAGE_HAS_DEFAULT_FORM, $sf_props ) ) {
			self::registerProperty( '_SF_PDF', '__spf', $sf_props[SF_SP_PAGE_HAS_DEFAULT_FORM] );
		} else {
			self::registerProperty( '_SF_PDF', '__spf', 'Page has default form' );
		}
		if ( array_key_exists( SF_SP_HAS_FIELD_LABEL_FORMAT, $sf_props ) ) {
			self::registerProperty( '_SF_FLF', '_str', $sf_props[SF_SP_HAS_FIELD_LABEL_FORMAT] );
		} else {
			self::registerProperty( '_SF_FLF', '_str', 'Has field label format' );
		}

		// Use hardcoded English values as a backup, in case it's a
		// non-English-language wiki.
		self::registerProperty( '_SF_DF_BACKUP', '__spf', 'Has default form' );
		self::registerProperty( '_SF_AF_BACKUP', '__spf', 'Has alternate form' );
		self::registerProperty( '_SF_CP_BACKUP', '__spf', 'Creates pages with form' );
		self::registerProperty( '_SF_PDF_BACKUP', '__spf', 'Page has default form' );
		self::registerProperty( '_SF_FLF_BACKUP', '_str', 'Has field label format' );

		return true;
	}

	public static function addToAdminLinks( &$admin_links_tree ) {
		$data_structure_label = wfMessage( 'smw_adminlinks_datastructure' )->text();
		$data_structure_section = $admin_links_tree->getSection( $data_structure_label );
		if ( is_null( $data_structure_section ) ) {
			$data_structure_section = new ALSection( wfMessage( 'sf-adminlinks-datastructure' )->text() );

			// If we are here, it most likely means that SMW is
			// not installed. Still, we'll refer to everything as
			// SMW, to make the rest of the code more
			// straightforward.
			$smw_row = new ALRow( 'smw' );
			$smw_row->addItem( ALItem::newFromSpecialPage( 'Categories' ) );
			$data_structure_section->addRow( $smw_row );
			$smw_admin_row = new ALRow( 'smw_admin' );
			$data_structure_section->addRow( $smw_admin_row );

			// If SMW is not installed, don't bother with a "links
			// to the documentation" row - it would only have one
			// link.
			//$smw_docu_row = new ALRow( 'smw_docu' );
			//$data_structure_section->addRow( $smw_docu_row );
			$admin_links_tree->addSection( $data_structure_section, wfMessage( 'adminlinks_browsesearch' )->text() );
		} else {
			$smw_row = $data_structure_section->getRow( 'smw' );
			$smw_admin_row = $data_structure_section->getRow( 'smw_admin' );
			$smw_docu_row = $data_structure_section->getRow( 'smw_docu' );
		}
		$smw_row->addItem( ALItem::newFromSpecialPage( 'Templates' ), 'Properties' );
		$smw_row->addItem( ALItem::newFromSpecialPage( 'Forms' ), 'SemanticStatistics' );
		$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateClass' ), 'SMWAdmin' );
		if ( class_exists( 'SFCreateProperty' ) ) {
			$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateProperty' ), 'SMWAdmin' );
		}
		$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateTemplate' ), 'SMWAdmin' );
		$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateForm' ), 'SMWAdmin' );
		$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateCategory' ), 'SMWAdmin' );
		if ( isset( $smw_docu_row ) ) {
			$sf_name = wfMessage( 'specialpages-group-sf_group' )->text();
			$sf_docu_label = wfMessage( 'adminlinks_documentation', $sf_name )->text();
			$smw_docu_row->addItem( ALItem::newFromExternalLink( "http://www.mediawiki.org/wiki/Extension:Semantic_Forms", $sf_docu_label ) );
		}

		return true;
	}

	public static function showFormPreview( EditPage $editpage, WebRequest $request ) {
		global $wgOut, $wgParser, $sfgFormPrinter;

		wfDebug( __METHOD__ . ": enter.\n" );

		// Exit if we're not in preview mode.
		if ( !$editpage->preview ) {
			return true;
		}
		// Exit if we aren't in the "Form" namespace.
		if ( $editpage->getArticle()->getTitle()->getNamespace() != SF_NS_FORM ) {
			return true;
		}

		$editpage->previewTextAfterContent .= Html::element( 'h2', null, wfMessage( 'sf-preview-header' )->text() ) . "\n" .
			'<div class="previewnote" style="font-weight: bold">' . $wgOut->parse( wfMessage( 'sf-preview-note' )->text() ) . "</div>\n<hr />\n";

		$form_definition = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $editpage->textbox1 );
		list ( $form_text, $data_text, $form_page_title, $generated_page_name ) =
			$sfgFormPrinter->formHTML( $form_definition, null, false, null, null, "Semantic Forms form preview dummy title", null );

		$parserOutput = $wgParser->getOutput();
		if( method_exists( $wgOut, 'addParserOutputMetadata' ) ){
			$wgOut->addParserOutputMetadata( $parserOutput );
		} else {
			$wgOut->addParserOutputNoText( $parserOutput );
		}

		SFUtils::addFormRLModules();
		$editpage->previewTextAfterContent .=
			'<div style="margin-top: 15px">' . $form_text . "</div>";

		return true;
	}

	/**
	 * Hook to add PHPUnit test cases.
	 * From https://www.mediawiki.org/wiki/Manual:PHP_unit_testing/Writing_unit_tests_for_extensions
	 *
	 * @return boolean
	 */
	public static function onUnitTestsList( &$files ) {
		$testDir = dirname( __DIR__ ) . '/tests/phpunit/includes';
		$files = array_merge( $files, glob( "$testDir/*Test.php" ) );
		return true;
	}
}
