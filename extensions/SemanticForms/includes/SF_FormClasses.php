<?php
/**
 * Two classes - SFForm and SFTemplateInForm - that represent a user-defined
 * form and a template contained within that form, respectively.
 *
 * @author Yaron Koren
 */

class SFForm {
	var $form_name;
	var $templates;

	static function create( $form_name, $templates ) {
		$form = new SFForm();
		$form->form_name = ucfirst( str_replace( '_', ' ', $form_name ) );
		$form->templates = $templates;
		return $form;
	}

	function creationHTML() {
		$text = "";
		foreach ( $this->templates as $i => $ft ) {
			$text .= $ft->creationHTML( $i );
		}
		return $text;
	}

	function createMarkup() {
		$title = Title::makeTitle( SF_NS_FORM, $this->form_name );
		$fs = SpecialPage::getPage( 'FormStart' );
		$form_start_url = SFUtils::titleURLString( $fs->getTitle() ) . "/" . $title->getPartialURL();
		$form_description = wfMsgForContent( 'sf_form_docu', $this->form_name, $form_start_url );
		$form_input = "{{#forminput:form=" . $this->form_name . "}}\n";
		$text = <<<END
<noinclude>
$form_description


$form_input
</noinclude><includeonly>
<div id="wikiPreview" style="display: none; padding-bottom: 25px; margin-bottom: 25px; border-bottom: 1px solid #AAAAAA;"></div>

END;
		foreach ( $this->templates as $template ) {
			$text .= $template->createMarkup() . "\n";
		}
		$free_text_label = wfMsgForContent( 'sf_form_freetextlabel' );
		$text .= <<<END
'''$free_text_label:'''

{{{standard input|free text|rows=10}}}


{{{standard input|summary}}}

{{{standard input|minor edit}}} {{{standard input|watch}}}

{{{standard input|save}}} {{{standard input|preview}}} {{{standard input|changes}}} {{{standard input|cancel}}}
</includeonly>

END;

		return $text;
	}

}

class SFTemplateInForm {
	var $template_name;
	var $label;
	var $allow_multiple;
	var $max_allowed;
	var $fields;

	/**
	 * For a field name and its attached property name located in the
	 * template text, create an SFTemplateField object out of it, and
	 * add it to the $templateFields array.
	 */
	function handlePropertySettingInTemplate( $fieldName, $propertyName, $isList, &$templateFields, $templateText ) {
		global $wgContLang;
		$templateField = SFTemplateField::create( $fieldName, $wgContLang->ucfirst( $fieldName ) );
		$templateField->setSemanticProperty( $propertyName );
		$templateField->is_list = $isList;
		$cur_pos = stripos( $templateText, $fieldName );
		$templateFields[$cur_pos] = $templateField;
	}

	/**
	 * Get the fields of the template, along with the semantic property
	 * attached to each one (if any), by parsing the text of the template.
	 */
	function getAllFields() {
		global $wgContLang;
		$templateFields = array();
		$fieldNamesArray = array();

		// The way this works is that fields are found and then stored
		// in an array based on their location in the template text, so
		// that they can be returned in the order in which they appear
		// in the template, not the order in which they were found.
		// Some fields can be found more than once (especially if
		// they're part of an "#if" statement), so they're only
		// recorded the first time they're found.
		$template_title = Title::makeTitleSafe( NS_TEMPLATE, $this->template_name );
		$template_article = null;
		if ( isset( $template_title ) ) $template_article = new Article( $template_title );
		if ( isset( $template_article ) ) {
			$templateText = $template_article->getContent();
			// Ignore 'noinclude' sections and 'includeonly' tags.
			$templateText = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $templateText );
			$templateText = strtr( $templateText, array( '<includeonly>' => '', '</includeonly>' => '' ) );
	
			// First, look for "arraymap" parser function calls
			// that map a property onto a list.
			if ( preg_match_all( '/{{#arraymap:{{{([^|}]*:?[^|}]*)[^\[]*\[\[([^:]*:?[^:]*)::/mis', $templateText, $matches ) ) {
				foreach ( $matches[1] as $i => $field_name ) {
					if ( ! in_array( $field_name, $fieldNamesArray ) ) {
						$propertyName = $matches[2][$i];
						self::handlePropertySettingInTemplate( $field_name, $propertyName, true, $templateFields, $templateText );
						$fieldNamesArray[] = $field_name;
					}
				}
			}
	
			// Second, look for normal property calls.
			if ( preg_match_all( '/\[\[([^:|\[\]]*:*?[^:|\[\]]*)::{{{([^\]\|}]*).*?\]\]/mis', $templateText, $matches ) ) {
				foreach ( $matches[1] as $i => $propertyName ) {
					$field_name = trim( $matches[2][$i] );
					if ( ! in_array( $field_name, $fieldNamesArray ) ) {
						$propertyName = trim( $propertyName );
						self::handlePropertySettingInTemplate( $field_name, $propertyName, false, $templateFields, $templateText );
						$fieldNamesArray[] = $field_name;
					}
				}
			}

			// Then, get calls to #set and #set_internal
			// (thankfully, they have basically the same syntax).
			if ( preg_match_all( '/#(set|set_internal):(.*?}}})\s*}}/mis', $templateText, $matches ) ) {
				foreach ( $matches[2] as $i => $match ) {
					if ( preg_match_all( '/([^|{]*?)=\s*{{{([^|}]*)/mis', $match, $matches2 ) ) {
						foreach ( $matches2[1] as $i => $propertyName ) {
							$fieldName = trim( $matches2[2][$i] );
							if ( ! in_array( $fieldName, $fieldNamesArray ) ) {
								$propertyName = trim( $propertyName );
								self::handlePropertySettingInTemplate( $fieldName, $propertyName, false, $templateFields, $templateText );
								$fieldNamesArray[] = $fieldName;
							}
						}
					}
				}
			}

			// Then, get calls to #declare.
			if ( preg_match_all( '/#declare:(.*?)}}/mis', $templateText, $matches ) ) {
				foreach ( $matches[1] as $i => $match ) {
					$setValues = explode( '|', $match );
					foreach( $setValues as $valuePair ) {
						$keyAndVal = explode( '=', $valuePair );
						if ( count( $keyAndVal ) == 2) {
							$propertyName = trim( $keyAndVal[0] );
							$fieldName = trim( $keyAndVal[1] );
							if ( ! in_array( $fieldName, $fieldNamesArray ) ) {
								self::handlePropertySettingInTemplate( $fieldName, $propertyName, false, $templateFields, $templateText );
								$fieldNamesArray[] = $fieldName;
							}
						}
					}
				}
			}
	
			// Finally, get any non-semantic fields defined.
			if ( preg_match_all( '/{{{([^|}]*)/mis', $templateText, $matches ) ) {
				foreach ( $matches[1] as $i => $fieldName ) {
					$fieldName = trim( $fieldName );
					if ( !empty( $fieldName ) && ( ! in_array( $fieldName, $fieldNamesArray ) ) ) {
						$cur_pos = stripos( $templateText, $fieldName );
						$templateFields[$cur_pos] = SFTemplateField::create( $fieldName, $wgContLang->ucfirst( $fieldName ) );
						$fieldNamesArray[] = $fieldName;
					}
				}
			}
		}
		ksort( $templateFields );
		return $templateFields;
	}

	static function create( $name, $label, $allow_multiple, $max_allowed = null ) {
		$tif = new SFTemplateInForm();
		$tif->template_name = str_replace( '_', ' ', $name );
		$tif->fields = array();
		$fields = $tif->getAllFields();
		$field_num = 0;
		foreach ( $fields as $field ) {
			$tif->fields[] = SFFormField::create( $field_num++, $field );
		}
		$tif->label = $label;
		$tif->allow_multiple = $allow_multiple;
		$tif->max_allowed = $max_allowed;
		return $tif;
	}

	function creationHTML( $template_num ) {
		$checked_str = ( $this->allow_multiple ) ? "checked" : "";
		$template_str = wfMsg( 'sf_createform_template' );
		$template_label_input = wfMsg( 'sf_createform_templatelabelinput' );
		$allow_multiple_text = wfMsg( 'sf_createform_allowmultiple' );
		$text = <<<END
	<input type="hidden" name="template_$template_num" value="$this->template_name">
	<div class="templateForm">
	<h2>$template_str '$this->template_name'</h2>
	<p>$template_label_input <input size=25 name="label_$template_num" value="$this->label"></p>
	<p><input type="checkbox" name="allow_multiple_$template_num" $checked_str> $allow_multiple_text</p>
	<hr>

END;
		foreach ( $this->fields as $field ) {
			$text .= $field->creationHTML( $template_num );
		}
		$text .= '	<p><input type="submit" name="del_' . $template_num .
		  '" value="' . wfMsg( 'sf_createform_removetemplate' ) . '"></p>' . "\n";
		$text .= "	</div>\n";
		return $text;
	}

	function createMarkup() {
		$text = "";
		$text .= "{{{for template|" . $this->template_name;
		if ( $this->allow_multiple )
			$text .= "|multiple";
		if ( $this->label != '' )
			$text .= "|label=" . $this->label;
		$text .= "}}}\n";
		// for now, HTML for templates differs for multiple-instance templates;
		// this may change if handling of form definitions gets more sophisticated
		if ( ! $this->allow_multiple ) { $text .= "{| class=\"formtable\"\n"; }
		foreach ( $this->fields as $i => $field ) {
			$is_last_field = ( $i == count( $this->fields ) - 1 );
			$text .= $field->createMarkup( $this->allow_multiple, $is_last_field );
		}
		if ( ! $this->allow_multiple ) { $text .= "|}\n"; }
		$text .= "{{{end template}}}\n";
		return $text;
	}
}
