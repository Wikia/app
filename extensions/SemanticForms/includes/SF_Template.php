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
	private $mTemplateText;
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

	public static function newFromName( $templateName ) {
		$template = new SFTemplate( $templateName, array() );
		$template->loadTemplateFields();
		return $template;
	}

	/**
	 * @TODO - fix so that this function only gets called once per
	 * template; right now it seems to get called once per field. (!)
	 */
	function loadTemplateFields() {
		$templateTitle = Title::makeTitleSafe( NS_TEMPLATE, $this->mTemplateName );
		if ( !isset( $templateTitle ) ) {
			return;
		}

		$templateText = SFUtils::getPageText( $templateTitle );
		// Ignore 'noinclude' sections and 'includeonly' tags.
		$templateText = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $templateText );
		$this->mTemplateText = strtr( $templateText, array( '<includeonly>' => '', '</includeonly>' => '' ) );

		// The Cargo-based function is more specific; it only gets
		// data structure information from the template schema. If
		// there's no Cargo schema for this template, we call
		// loadTemplateFieldsSMWAndOther(), which doesn't require the
		// presence of SMW and can get non-SMW information as well.
		if ( defined( 'CARGO_VERSION' ) ) {
			$this->loadTemplateFieldsCargo( $templateTitle );
			if ( count( $this->mTemplateFields ) > 0 ) {
				return;
			}
		}
		return $this->loadTemplateFieldsSMWAndOther();
	}

	/**
	 * Get the fields of the template, along with the semantic property
	 * attached to each one (if any), by parsing the text of the template.
	 */
	function loadTemplateFieldsSMWAndOther() {
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

		// First, look for "arraymap" parser function calls
		// that map a property onto a list.
		if ( $ret = preg_match_all( '/{{#arraymap:{{{([^|}]*:?[^|}]*)[^\[]*\[\[([^:]*:?[^:]*)::/mis', $this->mTemplateText, $matches ) ) {
			foreach ( $matches[1] as $i => $field_name ) {
				if ( ! in_array( $field_name, $fieldNamesArray ) ) {
					$propertyName = $matches[2][$i];
					$this->loadPropertySettingInTemplate( $field_name, $propertyName, true );
					$fieldNamesArray[] = $field_name;
				}
			}
		} elseif ( $ret === false ) {
			// There was an error in the preg_match_all()
			// call - let the user know about it.
			if ( preg_last_error() == PREG_BACKTRACK_LIMIT_ERROR ) {
				print 'Semantic Forms error: backtrace limit exceeded during parsing! Please increase the value of <a href="http://www.php.net/manual/en/pcre.configuration.php#ini.pcre.backtrack-limit">pcre.backtrack_limit</a> in php.ini or LocalSettings.php.';
			}
		}

		// Second, look for normal property calls.
		if ( preg_match_all( '/\[\[([^:|\[\]]*:*?[^:|\[\]]*)::{{{([^\]\|}]*).*?\]\]/mis', $this->mTemplateText, $matches ) ) {
			foreach ( $matches[1] as $i => $propertyName ) {
				$field_name = trim( $matches[2][$i] );
				if ( ! in_array( $field_name, $fieldNamesArray ) ) {
					$propertyName = trim( $propertyName );
					$this->loadPropertySettingInTemplate( $field_name, $propertyName, false );
					$fieldNamesArray[] = $field_name;
				}
			}
		}

		// Then, get calls to #set, #set_internal and #subobject.
		// (Thankfully, they all have similar syntax).
		if ( preg_match_all( '/#(set|set_internal|subobject):(.*?}}})\s*}}/mis', $this->mTemplateText, $matches ) ) {
			foreach ( $matches[2] as $match ) {
				if ( preg_match_all( '/([^|{]*?)=\s*{{{([^|}]*)/mis', $match, $matches2 ) ) {
					foreach ( $matches2[1] as $i => $propertyName ) {
						$fieldName = trim( $matches2[2][$i] );
						if ( ! in_array( $fieldName, $fieldNamesArray ) ) {
							$propertyName = trim( $propertyName );
							$this->loadPropertySettingInTemplate( $fieldName, $propertyName, false );
							$fieldNamesArray[] = $fieldName;
						}
					}
				}
			}
		}

		// Then, get calls to #declare. (This is really rather
		// optional, since no one seems to use #declare.)
		if ( preg_match_all( '/#declare:(.*?)}}/mis', $this->mTemplateText, $matches ) ) {
			foreach ( $matches[1] as $match ) {
				$setValues = explode( '|', $match );
				foreach ( $setValues as $valuePair ) {
					$keyAndVal = explode( '=', $valuePair );
					if ( count( $keyAndVal ) == 2 ) {
						$propertyName = trim( $keyAndVal[0] );
						$fieldName = trim( $keyAndVal[1] );
						if ( ! in_array( $fieldName, $fieldNamesArray ) ) {
							$this->loadPropertySettingInTemplate( $fieldName, $propertyName, false );
							$fieldNamesArray[] = $fieldName;
						}
					}
				}
			}
		}

		// Finally, get any non-semantic fields defined.
		if ( preg_match_all( '/{{{([^|}]*)/mis', $this->mTemplateText, $matches ) ) {
			foreach ( $matches[1] as $fieldName ) {
				$fieldName = trim( $fieldName );
				if ( !empty( $fieldName ) && ( ! in_array( $fieldName, $fieldNamesArray ) ) ) {
					$cur_pos = stripos( $this->mTemplateText, $fieldName );
					$this->mTemplateFields[$cur_pos] = SFTemplateField::create( $fieldName, $wgContLang->ucfirst( $fieldName ) );
					$fieldNamesArray[] = $fieldName;
				}
			}
		}
		ksort( $this->mTemplateFields );
	}

	/**
	 * For a field name and its attached property name located in the
	 * template text, create an SFTemplateField object out of it, and
	 * add it to $this->mTemplateFields.
	 */
	function loadPropertySettingInTemplate( $fieldName, $propertyName, $isList ) {
		global $wgContLang;
		$templateField = SFTemplateField::create( $fieldName, $wgContLang->ucfirst( $fieldName ), $propertyName, $isList );
		$cur_pos = stripos( $this->mTemplateText, $fieldName . '|' );
		$this->mTemplateFields[$cur_pos] = $templateField;
	}

	function loadTemplateFieldsCargo( $templateTitle ) {
		$cargoFieldsOfTemplateParams = array();

		// First, get the table name, and fields, declared for this
		// template.
		$templatePageID = $templateTitle->getArticleID();
		$tableSchemaString = CargoUtils::getPageProp( $templatePageID, 'CargoFields' );
		// See if there even is DB storage for this template - if not,
		// exit.
		if ( is_null( $tableSchemaString ) ) {
			return null;
		}
		$tableSchema = CargoTableSchema::newFromDBString( $tableSchemaString );
		$tableName = CargoUtils::getPageProp( $templatePageID, 'CargoTableName' );

		// Then, match template params to Cargo table fields, by
		// parsing call(s) to #cargo_store.
		// Let's find every #cargo_store tag.
		// Unfortunately, it doesn't seem possible to use a regexp
		// search for this, because it's hard to know which set of
		// double brackets represents the end of such a call. Instead,
		// we'll do some manual parsing.
		$cargoStoreLocations = array();
		$curPos = 0;
		while ( true ) {
			$newPos = strpos( $this->mTemplateText, "#cargo_store:", $curPos );
			if ( $newPos === false ) {
				break;
			}
			$curPos = $newPos + 13;
			$cargoStoreLocations[] = $curPos;
		}

		$cargoStoreCalls = array();
		foreach ( $cargoStoreLocations as $locNum => $startPos ) {
			$numUnclosedBrackets = 2;
			if ( $locNum < count( $cargoStoreLocations ) - 1 ) {
				$lastPos = $cargoStoreLocations[$locNum + 1];
			} else {
				$lastPos = strlen( $this->mTemplateText ) - 1;
			}
			$curCargoStoreCall = '';
			$curPos = $startPos;
			while ( $curPos <= $lastPos ) {
				$curChar = $this->mTemplateText[$curPos];
				$curCargoStoreCall .= $curChar;
				if ( $curChar == '}' ) {
					$numUnclosedBrackets--;
				} elseif ( $curChar == '{' ) {
					$numUnclosedBrackets++;
				}
				if ( $numUnclosedBrackets == 0 ) {
					break;
				}
				$curPos++;
			}
			$cargoStoreCalls[] = $curCargoStoreCall;
		}

		foreach ( $cargoStoreCalls as $cargoStoreCall ) {
			if ( preg_match_all( '/([^|{]*?)=\s*{{{([^|}]*)/mis', $cargoStoreCall, $matches ) ) {
				foreach ( $matches[1] as $i => $cargoFieldName ) {
					$templateParameter = trim( $matches[2][$i] );
					$cargoFieldsOfTemplateParams[$templateParameter] = $cargoFieldName;
				}
			}
		}

		// Now, combine the two sets of information into an array of
		// SFTemplateFields objects.
		$fieldDescriptions = $tableSchema->mFieldDescriptions;
		foreach ( $cargoFieldsOfTemplateParams as $templateParameter => $cargoField ) {
			$templateField = SFTemplateField::create( $templateParameter, $templateParameter );
			if ( array_key_exists( $cargoField, $fieldDescriptions ) ) {
				$fieldDescription = $fieldDescriptions[$cargoField];
				$templateField->setCargoFieldData( $tableName, $cargoField, $fieldDescription );
			}
			$this->mTemplateFields[] = $templateField;
		}
	}

	public function getTemplateFields() {
		return $this->mTemplateFields;
	}

	public function getFieldNamed( $fieldName ) {
		foreach ( $this->mTemplateFields as $curField ) {
			if ( $curField->getFieldName() == $fieldName ) {
				return $curField;
			}
		}
		return null;
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
			if ( $field->getFieldType() == '' ) {
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
			$text .= $field->getFieldType();
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
		Hooks::run( 'SFCreateTemplateText', array( &$this ) );
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
! style="text-align: center; background-color:#ccccff;" colspan="2" |<span style="font-size: larger;">{{PAGENAME}}</span>
|-

END;
		} else {
			$tableText = '';
		}

		foreach ( $this->mTemplateFields as $i => $field ) {
			if ( $field->getFieldName() == '' ) continue;

			$fieldParam = '{{{' . $field->getFieldName() . '|}}}';
			if ( is_null( $field->getNamespace() ) ) {
				$fieldString = $fieldParam;
			} else {
				$fieldString = $field->getNamespace() . ':' . $fieldParam;
			}
			$separator = '';

			$fieldStart = $this->mFieldStart;
			Hooks::run('SFTemplateFieldStart', array( $field, &$fieldStart ) );
			$fieldEnd = $this->mFieldEnd;
			Hooks::run('SFTemplateFieldEnd', array( $field, &$fieldEnd ) );

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
				$tableText .= '{{#if:' . $fieldParam . '|';
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
! $this->mAggregationLabel
| 
END;
			} elseif ( $this->mTemplateFormat == 'plain' ) {
				$tableText .= "\n'''" . $this->mAggregationLabel . ":''' ";
			} elseif ( $this->mTemplateFormat == 'sections' ) {
				$tableText .= "\n==" . $this->mAggregationLabel . "==\n";
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
