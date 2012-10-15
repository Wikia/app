<?php
/**
 * Displays an interface to let users create and edit the <PageSchema> XML.
 *
 * @author Ankit Garg
 * @author Yaron Koren
 */

class PSEditSchema extends IncludableSpecialPage {
	function __construct() {
		parent::__construct( 'EditSchema', 'edit' );
	}

	/**
	 * Returns a nicely-formatted version of the XML passed in.
	 *
	 * Code based on
	 * http://coffeecoders.de/2011/03/how-to-pretty-print-a-simplexmlobject-in-php/
	 */
	static function prettyPrintXML( $xml ){
		// Turn the XML string into a DOMDocument object, and then
		// back again, to have it displayed nicely.
		$domDocument = new DOMDocument('1.0');
		$domDocument->preserveWhiteSpace = false;
		$domDocument->formatOutput = true;
		$domDocument->loadXML( $xml );
		return $domDocument->saveXML( $domDocument->documentElement );
	}

	/**
	 * Creates full <PageSchema> XML text, based on what was passed in by
	 * the form.
	 */
	static function createPageSchemaXMLFromForm() {
		global $wgRequest, $wgPageSchemasHandlerClasses;

		// Generate the XML from the form elements.
		$psXML = '<PageSchema>';
		$additionalXML = $wgRequest->getText( 'ps_add_xml' );
		$psXML .= $additionalXML;
		$fieldName = "";
		$fieldNum = -1;
		$templateNum = -1;
		// Arrays to store the extension-specific XML entered in the form
		$schemaXMLFromExtensions = array();
		$templateXMLFromExtensions = array();
		$fieldXMLFromExtensions = array();
		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$schemaXMLFromExtensions[] = call_user_func( array( $psHandlerClass, 'createSchemaXMLFromForm' ) );
			$templateXMLFromExtensions[] = call_user_func( array( $psHandlerClass, 'createTemplateXMLFromForm' ) );
			$fieldXMLFromExtensions[] = call_user_func( array( $psHandlerClass, 'createFieldXMLFromForm' ) );
		}
		foreach ( $schemaXMLFromExtensions as $xml ) {
			if ( !empty( $xml ) ) {
				$psXML .= $xml;
			}
		}
		foreach ( $wgRequest->getValues() as $var => $val ) {
			// Ignore fields from the hidden/starter div
			if ( substr( $var, 0, 7 ) == 't_name_' ) {
				$templateNum = substr( $var, 7 );
				$templateAttrs = array( 'name' => $val );
				if ( $wgRequest->getCheck( 'is_multiple_' . $templateNum ) ) {
					$templateAttrs['multiple'] = 'multiple';
				}
				$psXML .= Xml::openElement( 'Template', $templateAttrs );

				// Get XML created by extensions for this template
				foreach ( $templateXMLFromExtensions as $extensionName => $xmlPerTemplate ) {
					if ( !empty( $xmlPerTemplate[$templateNum] ) ) {
						$psXML .= $xmlPerTemplate[$templateNum];
					}
				}
			} elseif ( substr( $var, 0, 7 ) == 'f_name_' ) {
				$fieldNum = substr( $var, 7 );
				$fieldName = $val;
				$fieldAttrs = array( 'name' => $fieldName );
				if ( $wgRequest->getCheck( 'f_is_list_' . $fieldNum ) ) {
					$fieldAttrs['list'] = 'list';
					$delimiter = $wgRequest->getText( 'f_delimiter_' . $fieldNum );
					if ( $delimiter != '' ) {
						$fieldAttrs['delimiter'] = $delimiter;
					}
				}
				$fieldDisplay = $wgRequest->getText( 'f_display_' . $fieldNum );
				if ( $fieldDisplay != 'show' ) {
					$fieldAttrs['display'] = $fieldDisplay;
				}
				$psXML .= Xml::openElement( 'Field', $fieldAttrs );
			} elseif ( substr( $var, 0, 8 ) == 'f_label_' ) {
				if ( !empty( $val ) ) {
					$psXML .= '<Label>' . $val . '</Label>';
				}

				// Get XML created by extensions for this field
				foreach ( $fieldXMLFromExtensions as $extensionName => $xmlPerField ) {
					if ( !empty( $xmlPerField[$fieldNum] ) ) {
						$psXML .= $xmlPerField[$fieldNum];
					}
				}
			} elseif ( substr( $var, 0, 10 ) == 'f_add_xml_' ) {
				$psXML .= $val;
				$psXML .= '</Field>';
			} elseif ( substr( $var, 0, 10 ) == 't_add_xml_' ) {
				$psXML .= $val;
				$psXML .= '</Template>';
			}
		}
		$psXML .= '</PageSchema>';
		return self::prettyPrintXML( $psXML );
	}

	/**
	 * Displays a list of links to categories that have a page schema
	 * defined; for use in Special:EditSchema, if no category is specified.
	 */
	static function showLinksToCategories() {
		$cat_titles = array();
		$count_title = 0;
		$text = "";
		$dbr = wfGetDB( DB_SLAVE );
		//get the result set, query : slect page_props
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
		$editSchemaPage = SpecialPage::getTitleFor( 'EditSchema' );
		$text .= "<ul>\n";
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( $row[2] == null ) {
				continue;
			}
			$catTitle = Title::newFromID( $row[0] );
			if ( $catTitle->getNamespace() !== NS_CATEGORY ) {
				continue;
			}
			$catName = $catTitle->getText();
			$url = $catTitle->getFullURL( 'action=editschema' );
			$text .= Html::rawElement( 'li',
				null,
				Html::element( 'a', array( 'href' => $url ), $catName )
			);
		}
		$text .= "</ul>\n";
		$dbr->freeResult( $res );
		return $text;
	}

	/**
	 * Returns the HTML for one section of the EditSchema form.
	 */
	static function printFormSection( $label, $headerColor, $mainHTML, $sectionClass, $hasExistingValues = true ) {
		// Section header
		$headerContents = '';
		if ( empty( $sectionClass ) ) {
			$checkboxAttrs = array( 'class' => 'sectionCheckbox' );
			if ( $hasExistingValues ) {
				$checkboxAttrs['checked'] = true;
			}
			$headerContents .= "\n\t\t" . Html::input( 'show_section', null, 'checkbox', $checkboxAttrs ) . ' ';
		}
		$headerContents .= $label . "\n";
		$sectionHTML = "\n\t\t\t\t\t" . Html::rawElement( 'div', array(
			'class' => 'sectionHeader',
			'style' => "background: $headerColor;"
		), $headerContents );

		// Body of section, with all the inputs.
		$sectionHTML .= "\n\t" . Html::rawElement( 'div', array( 'class' => 'sectionBody' ), "\n" . $mainHTML );

		// Wrapper around the whole thing.
		$className = "editSchemaSection $sectionClass";
		$text = "\n\t\t\t\t" . Html::rawElement( 'div', array( 'class' => $className ), $sectionHTML ) . "\n";
		return $text;
	}

	/**
	 * Returns the HTML for a form section coming from a specific extension.
	 */
	static function printFieldHTMLForExtension( $valuesFromExtension, $label, $color ) {
		list( $html, $hasExistingValues ) = $valuesFromExtension;
		return self::printFormSection( $label, $color, $html, null, $hasExistingValues );
	}

	/**
	 * Returns the HTML for a section of the form comprising one
	 * template field.
	 */
	static function printFieldSection( $field_xml = null, $psField = null ) {
		global $wgPageSchemasHandlerClasses;

		if ( is_null( $field_xml ) ) {
			$fieldNum = 'fnum';
		} else {
			global $wgPageSchemasFieldNum;
			$fieldNum = $wgPageSchemasFieldNum;
			$wgPageSchemasFieldNum++;
		}

		$fieldName = '';
		$delimiter = '';
		$fieldLabel = '';
		$isListAttrs = array( 'class' => 'isListCheckbox' );
		$delimiterAttrs = array( 'class' => 'delimiterInput' );
		$fieldDisplay = '';
		$text = "\n\t\t\t";
		if ( is_null( $field_xml ) ) {
			$text .= '<div class="fieldBox" id="starterField" style="display: none" >';
		} else {
			$text .= '<div class="fieldBox" >';
			$fieldName = (string)$field_xml->attributes()->name;
			if ( ((string)$field_xml->attributes()->delimiter) != null || ((string)$field_xml->attributes()->delimiter) != '' ) {
				$delimiter = (string)$field_xml->attributes()->delimiter;
			}
			foreach ( $field_xml->children() as $tag => $child ) {
				if ( $tag == 'Label' ) {
					$fieldLabel = (string)$child;
				}
			}
			if ( ((string)$field_xml->attributes()->list) == "list" ) {
				$isListAttrs['checked'] = 'checked';
			}
			$fieldDisplay = (string)$field_xml->attributes()->display;
		}
		$fieldHTML = wfMsg( 'ps-namelabel' ) . ' ';
		$fieldHTML .= Html::input( 'f_name_' . $fieldNum, $fieldName, 'text', array( 'size' => 25 ) ) . ' ';
		$fieldHTML .= wfMsg( 'ps-displaylabel' ) . ' ';
		$fieldHTML .= Html::input( 'f_label_' . $fieldNum, $fieldLabel, 'text', array( 'size' => 25 ) );
		$fieldHTML = Html::rawElement( 'p', null, $fieldHTML ) . "\n";
		$fieldIsListInput = Html::input( 'f_is_list_' . $fieldNum, null, 'checkbox', $isListAttrs );
		$fieldHTML .= Html::rawElement( 'p', null, $fieldIsListInput . ' ' . wfMsg( 'ps-field-list-label' ) );
		$fieldDelimiterInput = Html::input ( 'f_delimiter_' . $fieldNum, $delimiter, 'text', array( 'size' => 3 ) );
		$fieldHTML .= "\n" . Html::rawElement( 'p', $delimiterAttrs, wfMsg( 'ps-delimiter-label' ) . ' ' . $fieldDelimiterInput );
		// Create radiobutton for display of field
		$displayShownAttrs = array();
		$displayIfNonEmptyAttrs = array();
		$displayHiddenAttrs = array();
		// Now set which of the values should be checked
		if ( $fieldDisplay == '' ) {
			$displayShownAttrs['checked'] = true;
		} elseif ( $fieldDisplay == 'nonempty' ) {
			$displayIfNonEmptyAttrs['checked'] = true;
		} elseif ( $fieldDisplay == 'hidden' ) {
			$displayHiddenAttrs['checked'] = true;
		}
		$groupName = 'f_display_' . $fieldNum;
		$fieldDisplayShownInput = Html::input( $groupName, 'show', 'radio', $displayShownAttrs );
		$fieldDisplayIfNonEmptyInput = Html::input( $groupName, 'nonempty', 'radio', $displayIfNonEmptyAttrs );
		$fieldDisplayHiddenInput = Html::input( $groupName, 'hidden', 'radio', $displayHiddenAttrs );
		$fieldHTML .= Html::rawElement( 'p', null, $fieldDisplayShownInput . ' ' . "Display this field always" . ' ' . $fieldDisplayIfNonEmptyInput . ' ' . "Display if not empty" . ' ' . $fieldDisplayHiddenInput . ' ' . "Hide" );

		// Insert HTML text from extensions
		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$valuesFromExtension = call_user_func( array( $psHandlerClass, "getFieldEditingHTML" ), $psField );
			if ( is_null( $valuesFromExtension ) ) {
				continue;
			}
			$label = call_user_func( array( $psHandlerClass, "getFieldDisplayString" ) );
			$color = call_user_func( array( $psHandlerClass, "getDisplayColor" ) );
			$html = self::printFieldHTMLForExtension( $valuesFromExtension, $label, $color );
			// We use 'num' here, instead of 'fnum', to distinguish
			// between field names from Page Schemas (which get
			// their number set via Javascript) and field names from
			// other extensions (which get their number set via PHP).
			// Is this important to do? Probably not.
			$fieldHTML .= str_replace( 'num', $fieldNum, $html );
		}

		// TODO - this needs to get set.
		$field_add_xml = null;
		$additionalXMLInput = "\n\t\t\t\t" . Html::textarea( "f_add_xml_$fieldNum", $field_add_xml, array( 'rows' => 4, 'style' => 'width: 100%;' ) );
		$fieldHTML .= "<p>" . wfMsg('ps-add-xml-label') . $additionalXMLInput . "</p>\n";
		$fieldHTML .= Html::input( 'remove-field', wfMsg( 'ps-remove-field' ), 'button',
			array( 'class' => 'deleteField' )
		);
		$text .= "\n" . self::printFormSection( wfMsg( 'ps-field' ), '#AAA', $fieldHTML, 'editSchemaFieldSection' );
		$text .= "\t</div><!-- fieldBox -->\n";
		return $text;
	}

	/**
	 * Returns the HTML for a section of the form comprising one template.
	 */
	static function printTemplateSection( $template_num = 'tnum', $templateXML = null, $psTemplate = null ) {
		global $wgPageSchemasHandlerClasses;

		if ( is_null( $psTemplate ) ) {
			$psTemplateFields = array();
		} else {
			$psTemplateFields = $psTemplate->getFields();
		}
		$attrs = array();
		$templateXMLElements = array();
		$text = "\t";
		if ( is_null( $templateXML ) ) {
			$text .= '<div class="templateBox" id="starterTemplate" style="display: none">' . "\n";
			$templateName = '';
		} else {
			$text .= '<div class="templateBox" >' . "\n";
			$templateName = (string) $templateXML->attributes()->name;
			if ( ( (string)$templateXML->attributes()->multiple ) == "multiple" ) {
				$attrs['checked'] = 'checked';
			}
			$templateXMLElements = $templateXML->children();
		}
		$templateNameInput = wfMsg( 'ps-namelabel' ) . ' ';
		$templateNameInput .= Html::input( 't_name_' . $template_num, $templateName, 'text' );
		$templateHTML = "\t\t" . Html::rawElement( 'p', null, $templateNameInput ) . "\n";
		$templateIsMultipleInput = Html::input( 'is_multiple_' . $template_num, null, 'checkbox', $attrs );
		$templateHTML .= "\t\t" . Html::rawElement( 'p', null, $templateIsMultipleInput . ' ' . wfMsg( 'ps-multiple-temp-label' ) );
		$template_add_xml = "";
		// TODO - set this correctly.
		/*
		foreach ( $templateXMLElements as $templateXMLElement ) {
			if ( !empty( $templateXMLElement ) && $templateXMLElement->getName() != 'Field' ) {
				$template_add_xml .= (string)$templateXMLElement->asXML();
			}
		}
		 */

		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$valuesFromExtension = call_user_func( array( $psHandlerClass, "getTemplateEditingHTML" ), $psTemplate );
			if ( is_null( $valuesFromExtension ) ) {
				continue;
			}
			$label = call_user_func( array( $psHandlerClass, "getTemplateDisplayString" ) );
			$color = call_user_func( array( $psHandlerClass, "getDisplayColor" ) );
			$html = self::printFieldHTMLForExtension( $valuesFromExtension, $label, $color );
			$templateHTML .= str_replace( 'num', $template_num, $html );
		}

		$templateHTML .= "\n\t\t" . '<div class="fieldsList">';
		$fieldNumInTemplate = 0;
		// If this is a "starter" template, create the starter
		// field HTML.
		if ( is_null( $psTemplate ) ) {
			$templateHTML .= self::printFieldSection();
		}
		foreach ( $templateXMLElements as $templateXMLElement ) {
			if ( empty( $templateXMLElement ) ) {
				// Do nothing (?)
			} elseif ( $templateXMLElement->getName() == "Field" ) {
				$psTemplateField = $psTemplateFields[$fieldNumInTemplate];
				$templateHTML .= self::printFieldSection( $templateXMLElement, $psTemplateField );
				$fieldNumInTemplate++;
			}
		}
		$templateHTML .= "\t</div><!-- fieldsList -->\n";
		$add_field_button = Xml::element( 'input',
			array(
				'type' => 'button',
				'class' => 'editSchemaAddField',
				'value' => wfMsg( 'ps-add-field' ),
			)
		);
		$templateHTML .= Xml::tags( 'p', null, $add_field_button ) . "\n";
		$templateHTML .= "<hr />\n";
		$additionalXMLInput = "\n\t\t\t\t" . Html::textarea( "t_add_xml_$template_num", $template_add_xml, array( 'rows' => 4, 'style' => 'width: 100%;' ) );
		$templateHTML .= "\n<p>" . wfMsg('ps-add-xml-label') . "\n\t\t\t\t" . $additionalXMLInput . "\n\t\t\t</p>";
		$templateHTML .= '<p>' . Html::input( 'remove-template', 'Remove template', 'button', array( 'class' => 'deleteTemplate' ) ) . "</p>\n";
		$text .= self::printFormSection( wfMsg( 'ps-template' ), '#CCC', $templateHTML, 'editSchemaTemplateSection' );
		$text .= "\t</div><!-- templateBox-->\n";
		return $text;
	}

	/**
	 * Returns the HTML to display an entire form.
	 */
	static function printForm( $pageSchemaObj = null, $pageXML = null ) {
		global $wgPageSchemasHandlerClasses;

		if ( is_null( $pageSchemaObj ) ) {
			$psTemplates = array();
		} else {
			$psTemplates = $pageSchemaObj->getTemplates();
		}

		if ( is_null( $pageXML ) ) {
			$pageXMLChildren = array();
		} else {
			$pageXMLChildren = $pageXML->children();
		}

		$ps_add_xml = '';
		// TODO - set this correctly.
		/*
		foreach ( $pageXMLChildren as $template_xml ) {
			if ( $template_xml->getName() != 'Template') {
				$ps_add_xml .= (string)$template_xml->asXML();
			}
		}
		 */

		$text = '<form id="editSchemaForm" action="" method="post">' . "\n";
		$additionalXMLInput = "\n\t\t\t\t" . Html::textarea( 'ps_add_xml', $ps_add_xml, array( 'rows' => 4, 'style' => 'width: 100%;' ) );
		$text .= '<p>' . wfMsg('ps-add-xml-label') . $additionalXMLInput . "\n</p>";

		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$valuesFromExtension = call_user_func( array( $psHandlerClass, "getSchemaEditingHTML" ), $pageSchemaObj );
			if ( is_null( $valuesFromExtension ) ) {
				continue;
			}
			$label = call_user_func( array( $psHandlerClass, "getSchemaDisplayString" ) );
			$color = call_user_func( array( $psHandlerClass, "getDisplayColor" ) );
			$text .= self::printFieldHTMLForExtension( $valuesFromExtension, $label, $color );
		}

		$text .= '<div id="templatesList">' . "\n";

		$templateNum = 0;

		// Add 'starter', hidden template section.
		$text .= self::printTemplateSection();
		/* index for template objects */
		foreach ( $pageXMLChildren as $tag => $pageXMLChild ) {
			if ( $tag == 'Template' ) {
				$psTemplate = $psTemplates[$templateNum];
				$text .= self::printTemplateSection( $templateNum, $pageXMLChild, $psTemplate );
				$templateNum++;
			}
		}
		$add_template_button = Xml::element( 'input',
			array(
				'type' => 'button',
				'class' => 'editSchemaAddTemplate',
				'value' => wfMsg( 'ps-add-template' ),
			)
		);
		$text .= "\t</div><!-- templatesList -->\n";
		$text .= Xml::tags( 'p', null, $add_template_button ) . "\n";
		$text .= "\t\t<hr />\n";
		$label = wfMsg( 'summary' );
		$text .= <<<END
	<p>
	<span id='wpSummaryLabel'><label for='wpSummary'>$label</label></span>
	<input type='text' value="" name='wpSummary' id='wpSummary' maxlength='200' size='60' />
	</p>

END;
		$attr = array(
			'id'        => 'wpSave',
			'accesskey' => wfMsg( 'accesskey-save' ),
			'title'     => wfMsg( 'tooltip-save' ),
		);
		$saveButton = Html::input( 'wpSave', wfMsg( 'savearticle' ), 'submit', $attr );
		$text .= "\t\t" . Html::rawElement( 'div', array( 'class' => 'editButtons' ),
			$saveButton ) . "\n";
		$text .= "\t</form>\n";

		return $text;
	}

	function execute( $category ) {
		global $wgRequest, $wgOut, $wgUser, $wgTitle;

		// If a category has been selected (i.e., it's not just
		// Special:EditSchema), only display this if the user is
		// allowed to edit the category page.
		if ( !is_null( $category ) && ( !$wgUser->isAllowed( 'edit' ) || !$wgTitle->userCan( 'edit' ) ) ) {
			$wgOut->permissionRequired( 'edit' );
			return;
		}


		$this->setHeaders();
		$text = '<p>' . wfMsg( 'ps-page-desc-edit-schema' ) . '</p>';
		PageSchemas::addJavascriptAndCSS();

		$save_page = $wgRequest->getCheck( 'wpSave' );
		if ( $save_page ) {
			$psXML = self::createPageSchemaXMLFromForm();
			$categoryTitle = Title::newFromText( $category, NS_CATEGORY );
			$categoryArticle = new Article( $categoryTitle );
			if ( $categoryTitle->exists() ) {
				$pageText = $categoryArticle->getContent();
				$pageSchemaObj = new PSSchema( $category );
				if ( $pageSchemaObj->isPSDefined() ) {
					// Do some preg_replace magic.
					// This is necessary if the <PageSchema> tag
					// accepts any attributes - which it currently
					// does not, but it may well in the future.
					$tag = "PageSchema";
					$pageText = preg_replace( '{<' . $tag . '[^>]*>([^@]*?)</' . $tag . '>' . '}', $psXML, $pageText );
				} else {
					$pageText = $psXML . $pageText;
				}
			} else {
				$pageText = $psXML;
			}
			$editSummary = $wgRequest->getVal( 'wpSummary' );
			$categoryArticle->doEdit( $pageText, $editSummary );
			$redirectURL = $categoryTitle->getLocalURL();
			$text = <<<END
		<script type="text/javascript">
		window.onload = function() {
			window.location="$redirectURL";
		}
		</script>

END;
			$wgOut->addHTML( $text );
			return true;
		}

		if ( $category == "" ) {
			// No category was specified - show the list of
			// categories with a page schema defined.
			$text = self::showLinksToCategories();
			$wgOut->addHTML( $text );
			return true;
		}

		// We have a category - show a form.
		// See if a page schema has already been defined for this category.
		$title = Title::newFromText( $category, NS_CATEGORY );
		$pageId = $title->getArticleID();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'page_props',
			array(
				'pp_page',
				'pp_propname',
				'pp_value'
			),
			array(
				'pp_page' => $pageId,
			)
		);

		$row = $dbr->fetchRow( $res );
		if ( $row == null && !$title->exists() ) {
			// Category doesn't exist.
			$wgOut->setPageTitle( wfMsg( 'createschema' ) );
			$text = '<p>' . wfMsg( 'ps-page-desc-cat-not-exist' ) . '</p>';
			$text .= self::printForm();
		} elseif ( ( $row[1] != 'PageSchema' ) || ( $row[2] == null ) ) {
			// Category exists, but has no page schema.
			$text = '<p>' . wfMsg( 'ps-page-desc-ps-not-exist' ) . '</p>';
			$wgOut->setPageTitle( wfMsg( 'createschema' ) );
			$text .= self::printForm();
		} else {
			// It's a category with an existing page schema -
			// populate the form with its values.
			$pageSchemaObj = new PSSchema( $category );
			$pageXMLstr = $row[2];
			$pageXML = simplexml_load_string( $pageXMLstr );
			$text = self::printForm( $pageSchemaObj, $pageXML );
		}
		$wgOut->addHTML( $text );
		return true;
	}
}
