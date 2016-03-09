<?php
/**
 * Defines a class, SFTemplate, that represents a MediaWiki "infobox"
 * template that holds structured data, which may or may not include
 * SMW properties.
 *
 * For now, this class is used only to generate the text of a template,
 * by various helper pages.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

class SFTemplate {
	private $mTemplateName;
	private $mTemplateFields;
	private $mConnectingProperty;
	private $mCategoryName;
	public $mCargoTable;
	private $mAggregatingProperty;
	private $mAggregationLabel;
	private $mTemplateFormat;
	private $mFieldStart;
	private $mFieldEnd;
	private $mTemplateStart;
	private $mTemplateEnd;

	public function __construct( $templateName, $templateFields ) {
		$this->mTemplateName = $templateName;
		$this->mTemplateFields = $templateFields;
	}

	public function setConnectingProperty( $connectingProperty ) {
		$this->mConnectingProperty = $connectingProperty;
	}

	public function setCategoryName( $categoryName ) {
		$this->mCategoryName = $categoryName;
	}

	public function setAggregatingInfo( $aggregatingProperty, $aggregationLabel ) {
		$this->mAggregatingProperty = $aggregatingProperty;
		$this->mAggregationLabel = $aggregationLabel;
	}

	// Currently unused method.
	public function setFieldStartAndEnd( $fieldStart, $fieldEnd ) {
		$this->mFieldStart = $fieldStart;
		$this->mFieldEnd = $fieldEnd;
	}

	// Currently unused method.
	public function setTemplateStartAndEnd( $templateStart, $templateEnd ) {
		$this->mTemplateStart = $templateStart;
		$this->mTemplateEnd = $templateEnd;
	}

	public function setFormat( $templateFormat ) {
		$this->mTemplateFormat = $templateFormat;
	}

	public function createCargoDeclareCall() {
		$text = '{{#cargo_declare:';
		$text .= '_table=' . $this->mCargoTable;
		foreach ( $this->mTemplateFields as $i => $field ) {
			if ( $field->mCargoFieldType == '' ) {
				continue;
			}

			$text .= '|';
			$text .= str_replace( ' ', '_', $field->getFieldName() ) . '=';
			if ( $field->isList() ) {
				$delimiter = $field->getDelimiter();
				if ( $delimiter == '' ) {
					$delimiter = ',';
				}
				$text .= "List ($delimiter) of ";
			}
			$text .= $field->mCargoFieldType;
			if ( count( $field->getPossibleValues() ) > 0 ) {
				$allowedValuesString = implode( ',', $field->getPossibleValues() );
				$text .= " (allowed values=$allowedValuesString)";
			}
		}
		$text .= '}}';
		return $text;
	}

	public function createCargoStoreCall() {
		$text = '{{#cargo_store:';
		$text .= '_table=' . $this->mCargoTable;
		foreach ( $this->mTemplateFields as $i => $field ) {
			$text .= '|' .
				str_replace( ' ', '_', $field->getFieldName() ) .
				'={{{' . $field->getFieldName() . '|}}}';
		}
		$text .= ' }}';
		return $text;
	}

	/**
	 * Creates the text of a template, when called from
	 * Special:CreateTemplate, Special:CreateClass or the Page Schemas
	 * extension.
	 */
	public function createText() {
		wfRunHooks( 'SFCreateTemplateText', array( &$this ) );
		$templateHeader = wfMessage( 'sf_template_docu', $this->mTemplateName )->inContentLanguage()->text();
		$text = <<<END
<noinclude>
$templateHeader
<pre>

END;
		$text .= '{{' . $this->mTemplateName;
		if ( count( $this->mTemplateFields ) > 0 ) { $text .= "\n"; }
		foreach ( $this->mTemplateFields as $field ) {
			if ( $field->getFieldName() == '' ) continue;
			$text .= "|" . $field->getFieldName() . "=\n";
		}
		if ( defined( 'CARGO_VERSION' ) && !defined( 'SMW_VERSION' ) && $this->mCargoTable != '' ) {
			$cargoInUse = true;
			$cargoDeclareCall = $this->createCargoDeclareCall() . "\n";
			$cargoStoreCall = $this->createCargoStoreCall();
		} else {
			$cargoInUse = false;
			$cargoDeclareCall = '';
			$cargoStoreCall = '';
		}

		$templateFooter = wfMessage( 'sf_template_docufooter' )->inContentLanguage()->text();
		$text .= <<<END
}}
</pre>
$templateFooter
$cargoDeclareCall</noinclude><includeonly>$cargoStoreCall
END;

		// Before text
		$text .= $this->mTemplateStart;

		// $internalObjText can be either a call to #set_internal
		// or to #subobject (or null); which one we go with
		// depends on whether Semantic Internal Objects is installed,
		// and on the SMW version.
		// Thankfully, the syntaxes of #set_internal and #subobject
		// are quite similar, so we don't need too much extra logic.
		$internalObjText = null;
		if ( $this->mConnectingProperty ) {
			global $smwgDefaultStore;
			if ( defined( 'SIO_VERSION' ) ) {
				$useSubobject = false;
				$internalObjText = '{{#set_internal:' . $this->mConnectingProperty;
			} elseif ( $smwgDefaultStore == "SMWSQLStore3" ) {
				$useSubobject = true;
				$internalObjText = '{{#subobject:-|' . $this->mConnectingProperty . '={{PAGENAME}}';
			}
		}
		$setText = '';

		// Topmost part of table depends on format.
		if ( !$this->mTemplateFormat ) $this->mTemplateFormat = 'standard';
		if ( $this->mTemplateFormat == 'standard' ) {
			$tableText = '{| class="wikitable"' . "\n";
		} elseif ( $this->mTemplateFormat == 'infobox' ) {
			// A CSS style can't be used, unfortunately, since most
			// MediaWiki setups don't have an 'infobox' or
			// comparable CSS class.
			$tableText = <<<END
{| style="width: 30em; font-size: 90%; border: 1px solid #aaaaaa; background-color: #f9f9f9; color: black; margin-bottom: 0.5em; margin-left: 1em; padding: 0.2em; float: right; clear: right; text-align:left;"
! style="text-align: center; background-color:#ccccff;" colspan="2" |<big>{{PAGENAME}}</big>
|-

END;
		} else {
			$tableText = '';
		}

		foreach ( $this->mTemplateFields as $i => $field ) {
			if ( $field->getFieldName() == '' ) continue;

			$fieldString = '{{{' . $field->getFieldName() . '|}}}';
			if ( !is_null( $field->getNamespace() ) ) {
				$fieldString = $field->getNamespace() . ':' . $fieldString;
			}
			$separator = '';

			$fieldStart = $this->mFieldStart;
			wfRunHooks('SFTemplateFieldStart', array( $field, &$fieldStart ) );
			$fieldEnd = $this->mFieldEnd;
			wfRunHooks('SFTemplateFieldEnd', array( $field, &$fieldEnd ) );

			$fieldLabel = $field->getLabel();
			if ( $fieldLabel == '' ) {
				$fieldLabel = $field->getFieldName();
			}
			$fieldDisplay = $field->getDisplay();
			$fieldProperty = $field->getSemanticProperty();
			$fieldIsList = $field->isList();

			// Header/field label column
			if ( is_null( $fieldDisplay ) ) {
				if ( $this->mTemplateFormat == 'standard' || $this->mTemplateFormat == 'infobox' ) {
					if ( $i > 0 ) {
						$tableText .= "|-\n";
					}
					$tableText .= '! ' . $fieldLabel . "\n";
				} elseif ( $this->mTemplateFormat == 'plain' ) {
					$tableText .= "\n'''" . $fieldLabel . ":''' ";
				} elseif ( $this->mTemplateFormat == 'sections' ) {
					$tableText .= "\n==" . $fieldLabel . "==\n";
				}
			} elseif ( $fieldDisplay == 'nonempty' ) {
				if ( $this->mTemplateFormat == 'plain' || $this->mTemplateFormat == 'sections' ) {
					$tableText .= "\n";
				}
				$tableText .= '{{#if:' . $fieldString . '|';
				if ( $this->mTemplateFormat == 'standard' || $this->mTemplateFormat == 'infobox' ) {
					if ( $i > 0 ) {
						$tableText .= "\n{{!}}-\n";
					}
					$tableText .= '! ' . $fieldLabel . "\n";
					$separator = '{{!}}';
				} elseif ( $this->mTemplateFormat == 'plain' ) {
					$tableText .= "'''" . $fieldLabel . ":''' ";
					$separator = '';
				} elseif ( $this->mTemplateFormat == 'sections' ) {
					$tableText .= '==' . $fieldLabel . "==\n";
					$separator = '';
				}
			} // If it's 'hidden', do nothing
			// Value column
			if ( $this->mTemplateFormat == 'standard' || $this->mTemplateFormat == 'infobox' ) {
				if ( $fieldDisplay == 'hidden' ) {
				} elseif ( $fieldDisplay == 'nonempty' ) {
					//$tableText .= "{{!}} ";
				} else {
					$tableText .= "| ";
				}
			}

			// If we're using Cargo, fields can simply be displayed
			// normally - no need for any special tags - *unless*
			// the field holds a list of Page value, in which case
			// we need to apply #arraymap.
			$isCargoListOfPages = $cargoInUse && $field->isList() && $field->getFieldType() == 'Page';
			if ( !$fieldProperty && !$isCargoListOfPages ) {
				if ( $separator != '' ) {
					$tableText .= "$separator ";
				}
				if ( $fieldStart != '' ) {
					$tableText .= "$fieldStart ";
				}
				if ( $cargoInUse && ( $field->getFieldType() == 'Page' || $field->getFieldType() == 'File' ) ) {
					$tableText .= "[[$fieldString]]";
				} else {
					$tableText .= $fieldString;
				}
				if ( $fieldEnd != '' ) {
					$tableText .= " $fieldEnd";
				}
				$tableText .= "\n";
				if ( $fieldDisplay == 'nonempty' ) {
					$tableText .= " }}";
				}
			} elseif ( !is_null( $internalObjText ) ) {
				if ( $separator != '' ) {
					$tableText .= "$separator ";
				}
				if ( $fieldStart != '' ) {
					$tableText .= "$fieldStart ";
				}
				$tableText .= "$fieldString $fieldEnd";
				if ( $fieldDisplay == 'nonempty' ) {
					$tableText .= " }}";
				}
				$tableText .= "\n";
				if ( $field->isList() ) {
					if ( $useSubobject ) {
						$internalObjText .= '|' . $fieldProperty . '=' . $fieldString . '|+sep=,';
					} else {
						$internalObjText .= '|' . $fieldProperty . '#list=' . $fieldString;
					}
				} else {
					$internalObjText .= '|' . $fieldProperty . '=' . $fieldString;
				}
			} elseif ( $fieldDisplay == 'hidden' ) {
				if ( $fieldIsList ) {
					$setText .= $fieldProperty . '#list=' . $fieldString . '|';
				} else {
					$setText .= $fieldProperty . '=' . $fieldString . '|';
				}
			} elseif ( $fieldDisplay == 'nonempty' ) {
				if ( $this->mTemplateFormat == 'standard' || $this->mTemplateFormat == 'infobox' ) {
					$tableText .= '{{!}} ';
				}
				if ( $fieldStart != '' ) {
					$tableText .= $fieldStart . ' ';
				}
				if ( !is_null( $field->getNamespace() ) ) {
					// Special handling is needed, for at
					// least the File and Category namespaces.
					$tableText .= "[[$fieldString]] {{#set:$fieldProperty=$fieldString}}";
				} else {
					$tableText .= "[[$fieldProperty::$fieldString]]";
				}
				$tableText .= "}} $fieldEnd\n";
			} elseif ( $fieldIsList ) {
				// If this field is meant to contain a list,
				// add on an 'arraymap' function, that will
				// call this semantic markup tag on every
				// element in the list.
				// Find a string that's not in the semantic
				// field call, to be used as the variable.
				$var = "x"; // default - use this if all the attempts fail
				if ( strstr( $fieldProperty, $var ) ) {
					$var_options = array( 'y', 'z', 'xx', 'yy', 'zz', 'aa', 'bb', 'cc' );
					foreach ( $var_options as $option ) {
						if ( ! strstr( $fieldProperty, $option ) ) {
							$var = $option;
							break;
						}
					}
				}
				$tableText .= "{{#arraymap:{{{" . $field->getFieldName() . '|}}}|' . $field->getDelimiter() . "|$var|[[";
				if ( $cargoInUse ) {
					$tableText .= "$var]]";
				} elseif ( is_null( $field->getNamespace() ) ) {
					$tableText .= "$fieldProperty::$var]]";
				} else {
					$tableText .= $field->getNamespace() . ":$var]] {{#set:" . $fieldProperty . "=$var}} ";
				}
				$tableText .= "}}\n";
			} else {
				if ( $fieldStart != '' ) {
					$tableText .= $fieldStart . ' ';
				}
				if ( !is_null( $field->getNamespace() ) ) {
					// Special handling is needed, for at
					// least the File and Category namespaces.
					$tableText .= "[[$fieldString]] {{#set:$fieldProperty=$fieldString}}";
				} else {
					$tableText .= "[[$fieldProperty::$fieldString]]";
				}
				$tableText .= " $fieldEnd\n";
			}
		}

		// Add an inline query to the output text, for
		// aggregation, if a property was specified.
		if ( !is_null( $this->mAggregatingProperty ) && $this->mAggregatingProperty !== '' ) {
			if ( $this->mTemplateFormat == 'standard' || $this->mTemplateFormat == 'infobox' ) {
				if ( count( $this->mTemplateFields ) > 0 ) {
					$tableText .= "|-\n";
				}
				$tableText .= <<<END
! $this->mAggregatingLabel
| 
END;
			} elseif ( $this->mTemplateFormat == 'plain' ) {
				$tableText .= "\n'''" . $this->mAggregatingLabel . ":''' ";
			} elseif ( $this->mTemplateFormat == 'sections' ) {
				$tableText .= "\n==" . $this->mAggregatingLabel . "==\n";
			}
			$tableText .= "{{#ask:[[" . $this->mAggregatingProperty . "::{{SUBJECTPAGENAME}}]]|format=list}}\n";
		}
		if ( $this->mTemplateFormat == 'standard' || $this->mTemplateFormat == 'infobox' ) {
			$tableText .= "|}";
		}
		// Leave out newlines if there's an internal property
		// set here (which would mean that there are meant to be
		// multiple instances of this template.)
		if ( is_null( $internalObjText ) ) {
			if ( $this->mTemplateFormat == 'standard' || $this->mTemplateFormat == 'infobox' ) {
				$tableText .= "\n";
			}
		} else {
			$internalObjText .= "}}";
			$text .= $internalObjText;
		}

		// Add a call to #set, if necessary
		if ( $setText !== '' ) {
			$setText = '{{#set:' . $setText . "}}\n";
			$text .= $setText;
		}

		$text .= $tableText;
		if ( ( $this->mCategoryName !== '' ) && ( $this->mCategoryName !== null ) ) {
			global $wgContLang;
			$namespaceLabels = $wgContLang->getNamespaces();
			$categoryNamespace = $namespaceLabels[NS_CATEGORY];
			$text .= "\n[[$categoryNamespace:" . $this->mCategoryName . "]]\n";
		}

		// After text
		$text .= $this->mTemplateEnd;

		$text .= "</includeonly>\n";

		return $text;
	}
}
