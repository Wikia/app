<?php
/**
 * Classes for the Page Schemas extension.
 *
 * @file
 * @ingroup Extensions
 */

/**
 * Class that holds utility functions for the Page Schemas extension.
 */
class PageSchemas {

	public static function getCategoriesWithPSDefined(){
		$cat_titles = array();
		$dbr = wfGetDB( DB_SLAVE );
		//get the result set, query : select page_props
		$res = $dbr->select( 'page_props',
			array(
				'pp_page',
				'pp_propname',
				'pp_value'
			),
			array(
				'pp_propname' => 'PageSchema'
			)
		);
		while ( $row = $dbr->fetchRow( $res ) ) {
			if( $row[2] != null ){
				$page_id_cat = $row[0];
				if( Title::newFromId($page_id_cat)->getNamespace() == NS_CATEGORY){
					$cat_text = Title::newFromId($page_id_cat)->getText();
					$cat_titles[] = $cat_text;
				}
			}
		}
		$dbr->freeResult( $res );
		return $cat_titles;
	}

	/**
	 * Includes the necessary Javascript and CSS files for the form
	 * to display and work correctly.
	 *
	 * Accepts an optional Parser instance, or uses $wgOut if omitted.
	 */
	public static function addJavascriptAndCSS( $parser = null ) {
		global $wgOut;

		if ( !$parser ) {
			$wgOut->addMeta( 'robots', 'noindex,nofollow' );
		}

		// Handling depends on whether or not this page is embedded
		// in another page.
		if ( !is_null( $parser ) ) {
			$output = $parser->getOutput();
		} else {
			global $wgOut;
			$output = $wgOut;
		}
		$output->addModules( 'ext.pageschemas.main' );
	}

	public static function titleString( $title ) {
		$namespace = $title->getNsText();
		if ( $namespace != '' ) {
			$namespace .= ':';
		}
		if ( MWNamespace::isCapitalized( $title->getNamespace() ) ) {
			global $wgContLang;
			return $namespace . $wgContLang->ucfirst( $title->getText() );
		} else {
			return $namespace . $title->getText();
		}
	}

	public static function validateXML( $xml, &$error_msg ) {
		$xmlDTD =<<<END
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE PageSchema [
<!ELEMENT PageSchema (Template*)>
<!ELEMENT PageSchema (semanticforms_Form*)>
<!ATTLIST PageSchema name CDATA #REQUIRED>
<!ELEMENT Template (Field*)>
<!ATTLIST Template name CDATA #REQUIRED>
<!ATTLIST semanticforms_Form name CDATA #REQUIRED>
<!ATTLIST Field name CDATA #REQUIRED>
]>

END;
		// <? - this little tag is here to restore syntax highlighting in vi

		// We are using the SimpleXML library to do the XML validation
		// for now - this may change later.
		// Hide parsing warnings.
		libxml_use_internal_errors(true);
		$xml_success = simplexml_load_string($xmlDTD.$xml);
		$errors = libxml_get_errors();
		$error_msg = $errors[0]->message;
		return $xml_success;
	}

	static function tableRowHTML( $css_class, $data_type, $value = null, $bgColor = null ) {
		$data_type = htmlspecialchars( $data_type );
		if ( !is_null( $bgColor ) ) {
			// We don't actually use the passed-in background color, except as an indicator
			// that this is a header row for extension data, and thus should have special
			// display.
			// In the future, the background color may get used, though.
			$data_type = HTML::element( 'span', array( 'style' => "color: #993333;" ), $data_type );
		}
		if ( $value == '' ) {
			$content = $data_type;
		} else {
			$content = "$data_type: " . HTML::element( 'span', array( 'class' => 'rowValue' ), $value );
		}
		$cellAttrs = array( 'colspan' => 2, 'class' => $css_class );
		$cell = HTML::rawElement( 'td', $cellAttrs, $content );
		$text = HTML::rawElement( 'tr', array( 'style' => 'border: 1px black solid; margin: 10px;' ), $cell );
		$text .= "\n";
		return $text;
	}

	static function attrRowHTML( $cssClass, $fieldName, $value ) {
		$fieldNameAttrs = array( 'class' => $cssClass, 'style' => 'font-weight: normal;' );
		$fieldNameCell = HTML::rawElement( 'td', $fieldNameAttrs, $fieldName );
		$valueCell = HTML::element( 'td', array( 'class' => 'msg', 'style' => 'font-weight: bold;' ), $value );
		$text = HTML::rawElement( 'tr', null, $fieldNameCell . "\n" . $valueCell );
		$text .= "\n";
		return $text;
	}

	// TODO - this should be a non-static method of the PSSchema class,
	// instead of taking in XML.
	static function displaySchema( $schemaXML ) {
		global $wgTitle, $wgPageSchemasHandlerClasses;

		if ( $wgTitle->getNamespace() != NS_CATEGORY ) {
			return '';
		}
		$text = "<table class=\"pageSchema mw-collapsible mw-collapsed\">\n";
		$name = $schemaXML->attributes()->name;
		$text .= self::tableRowHTML( 'pageSchemaHeader', 'Page schema' );

		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$returnVals = call_user_func( array( $psHandlerClass, 'getSchemaDisplayValues' ), $schemaXML );
			if ( count( $returnVals ) != 2 ) {
				continue;
			}
			list( $elementName, $values ) = $returnVals;
			$label = call_user_func( array( $psHandlerClass, 'getSchemaDisplayString' ) );
			$bgColor = call_user_func( array( $psHandlerClass, 'getDisplayColor' ) );
			$text .= self::tableRowHTML( 'schemaExtensionRow', $label, $elementName, $bgColor );
			foreach ( $values as $fieldName => $value ) {
				$text .= self::attrRowHTML( 'schemaAttrRow', $fieldName, $value );
			}
		}
		foreach ( $schemaXML->children() as $tag => $child ) {
			if ( $tag == 'Template') {
				$text .= self::displayTemplate( $child );
			}
		}
		$text .= "</table>\n";
		return $text;
	}

	static function displayTemplate ( $templateXML ) {
		global $wgPageSchemasHandlerClasses;

		$name = $templateXML->attributes()->name;
		$text = self::tableRowHTML( 'templateRow', 'Template', $name );
		$multiple = $templateXML->attributes()->multiple;
		if ( $multiple == 'multiple' ) {
			$text .= self::attrRowHTML( 'schemaAttrRow', 'multiple', null );
		}

		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$returnVals = call_user_func( array( $psHandlerClass, 'getTemplateDisplayValues' ), $templateXML );
			if ( count( $returnVals ) != 2 ) {
				continue;
			}
			list( $elementName, $values ) = $returnVals;
			$label = call_user_func( array( $psHandlerClass, 'getTemplateDisplayString' ) );
			$bgColor = call_user_func( array( $psHandlerClass, 'getDisplayColor' ) );
			$text .= self::tableRowHTML( 'fieldExtensionRow', $label, $elementName, $bgColor );
			foreach ( $values as $fieldName => $value ) {
				$text .= self::attrRowHTML( 'fieldAttrRow', $fieldName, $value );
			}
		}
		foreach ( $templateXML->children() as $child ) {
			$text .= self::displayField( $child );
		}
		return $text;
	}

	static function displayField ( $fieldXML ) {
		global $wgPageSchemasHandlerClasses;

		$name = $fieldXML->attributes()->name;
		$text = self::tableRowHTML( 'fieldRow', 'Field', $name );

		if( ((string) $fieldXML->attributes()->list) == "list" ) {
			$text .= self::attrRowHTML( 'fieldAttrRow', 'List', null );
		}
		$fieldDisplay = (string) $fieldXML->attributes()->display;
		if( $fieldDisplay != "" ) {
			$text .= self::attrRowHTML( 'fieldAttrRow', 'Display', $fieldDisplay );
		}
		foreach ( $fieldXML->children() as $tag => $child ) {
			if ( $tag == 'Label' ) {
				$text .= self::attrRowHTML( 'fieldAttrRow', 'Label', $child );
			}
		}

		// Let extensions that store data within the Page Schemas XML
		// each handle displaying their data, by adding to this array.
		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$returnVals = call_user_func( array( $psHandlerClass, 'getFieldDisplayValues' ), $fieldXML );
			if ( count( $returnVals ) != 2 ) {
				continue;
			}
			list( $elementName, $values ) = $returnVals;
			$label = call_user_func( array( $psHandlerClass, 'getFieldDisplayString' ) );
			$bgColor = call_user_func( array( $psHandlerClass, 'getDisplayColor' ) );
			$text .= self::tableRowHTML( 'fieldExtensionRow', $label, $elementName, $bgColor );
			foreach ( $values as $fieldName => $value ) {
				$text .= self::attrRowHTML( 'fieldAttrRow', $fieldName, $value );
			}
		}
		return $text;
	}

	public static function getValueFromObject( $object, $key ) {
		if ( is_null( $object ) ) {
			return null;
		} elseif ( !array_key_exists( $key, $object ) ) {
			return null;
		}
		return $object[$key];
	}
}

/**
 * Holds the data contained within the <PageSchema> XML tag.
 */
class PSSchema {
	private $mCategoryName = "";
	private $mPageXML = null;
	/* Stores the template objects */
	private $mTemplates = array();
	private $mIsPSDefined = true;

	function __construct ( $categoryName ) {
		$this->mCategoryName = $categoryName;
		$title = Title::newFromText( $categoryName, NS_CATEGORY );
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'page_props',
			array(
				'pp_page',
				'pp_propname',
				'pp_value'
			),
			array(
				'pp_page' => $title->getArticleID(),
				'pp_propname' => 'PageSchema'
			)
		);
		// first row of the result set
		$row = $dbr->fetchRow( $res );
		if ( $row == null) {
			$this->mIsPSDefined = false;
		} else {
			// retrieve the third attribute, which is pp_value
			$pageXMLstr = $row[2];
			$this->mPageXML = simplexml_load_string ( $pageXMLstr );
			// index for template objects
			$i = 0;
			$inherited_templates = array();
			foreach ( $this->mPageXML->children() as $tag => $child ) {
				if ( $tag == 'InheritsFrom ' ) {
					$schema_to_inherit = (string) $child->attributes()->schema;
					if( $schema_to_inherit !=null ){
						$inheritedSchemaObj = new PSSchema( $schema_to_inherit );
						$inherited_templates = $inheritedSchemaObj->getTemplates();
					}
				}
				if ( $tag == 'Template' ) {
					$ignore = (string) $child->attributes()->ignore;
					if ( count($child->children()) > 0 ) {
						$templateObj = new PSTemplate($child);
						$this->mTemplates[$i++]= $templateObj;
					} elseif ( $ignore != "true" ) {
						// Code to add templates from inherited templates
						$temp_name = (string) $child->attributes()->name;
						foreach( $inherited_templates as $inherited_template ) {
							if( $temp_name == $inherited_template->getName() ){
								$this->mTemplates[$i++] = $inherited_template;
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Generates all pages selected by the user, based on the Page Schemas XML.
	 */
	public function generateAllPages ( $selectedPageList ) {
		global $wgPageSchemasHandlerClasses;
		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			call_user_func( array( $psHandlerClass, 'generatePages' ), $this, $selectedPageList );
		}
	}

	public function getCategoryName() {
		return $this->mCategoryName;
	}

	public function getXML() {
		return $this->mPageXML;
	}

	public function isPSDefined() {
		return $this->mIsPSDefined;
	}

	/**
	 * Returns an array of PSTemplate objects.
	 */
	public function getTemplates() {
		return $this->mTemplates;
	}

	public function getObject( $objectName ) {
		global $wgPageSchemasHandlerClasses;
		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$object = call_user_func( array( $psHandlerClass, 'createPageSchemasObject' ), $objectName, $this->mPageXML );
			if ( !is_null( $object ) ) {
				return $object;
			}
		}
		return null;
	}
}

class PSTemplate {
	private $mFields = array();
	private $mTemplateName = "";
	private $mTemplateXML = null;
	private $mMultipleAllowed = false;

	function __construct( $templateXML ) {
		$this->mTemplateXML = $templateXML;
		$this->mTemplateName = (string) $templateXML->attributes()->name;
		if( ((string) $templateXML->attributes()->multiple) == "multiple" ) {
			$this->mMultipleAllowed = true;
		}
		// Index for template objects
		$i = 0 ;
		$inherited_fields = array();
		foreach ($templateXML->children() as $child) {
			if ( $child->getName() == 'InheritsFrom' ) {
				$schema_to_inherit = (string) $child->attributes()->schema;
				$template_to_inherit = (string) $child->attributes()->template;
				if ( $schema_to_inherit != null && $template_to_inherit != null ) {
					$inheritedSchemaObj = new PSSchema( $schema_to_inherit );
					$inherited_templates = $inheritedSchemaObj->getTemplates();
					foreach( $inherited_templates as $inherited_template ) {
						if( $template_to_inherit == $inherited_template->getName() ){
							$inherited_fields = $inherited_template->getFields();
						}
					}
				}
			} elseif ( $child->getName() == "Field" ) {
				$ignore = (string) $child->attributes()->ignore;
				if ( count($child->children()) > 0 ) { //@TODO :Can be dealt more efficiently
					$fieldObj = new PSTemplateField( $child );
					$this->mFields[$i++]= $fieldObj;
				} elseif ( $ignore != "true" ) {
					// Code to add fields from inherited templates
					$field_name = (string) $child->attributes()->name;
					foreach ( $inherited_fields as $inherited_field ) {
						if ( $field_name == $inherited_field->getName() ) {
							$this->mFields[$i++]= $inherited_field;
						}
					}
				}
			}
		}
	}

	public function getName() {
		return $this->mTemplateName;
	}

	public function getXML() {
		return $this->mTemplateXML;
	}

	public function isMultiple() {
		return $this->mMultipleAllowed;
	}

	public function getObject( $objectName ) {
		global $wgPageSchemasHandlerClasses;
		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$object = call_user_func( array( $psHandlerClass, 'createPageSchemasObject' ), $objectName, $this->mTemplateXML );
			if ( !empty( $object ) ) {
				return $object;
			}
		}
		return null;
	}

	public function getFields() {
		return $this->mFields;
	}
}

class PSTemplateField {
	private $mFieldName = "";
	private $mFieldXML = null;
	private $mFieldLabel = "";
	private $mIsList = false;
	private $mDelimiter = null;
	private $mDisplay = null;

	function __construct( $fieldXML ) {
		$this->mFieldXML = $fieldXML;
		$this->mFieldName = (string)$fieldXML->attributes()->name;
		if ( ((string)$fieldXML->attributes()->list) == "list") {
			$this->mIsList = true;
		}
		$this->mDelimiter = $fieldXML->attributes()->delimiter;
		$this->mDisplay = $fieldXML->attributes()->display;
		foreach ( $fieldXML->children() as $tag => $child ) {
			if ( $tag == 'Label' ) {
				$this->mFieldLabel = $child;
			}
		}
	}

	public function getDelimiter() {
		return $this->mDelimiter;
	}

	public function getDisplay() {
		return $this->mDisplay;
	}

	public function getName() {
		return $this->mFieldName;
	}

	public function getLabel() {
		return $this->mFieldLabel;
	}

	public function isList() {
		return $this->mIsList;
	}

	public function getObject( $objectName ) {
		global $wgPageSchemasHandlerClasses;

		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$object = call_user_func( array( $psHandlerClass, 'createPageSchemasObject' ), $objectName, $this->mFieldXML );
			if ( !is_null( $object ) ) {
				return $object;
			}
		}
		return null;
	}
}
