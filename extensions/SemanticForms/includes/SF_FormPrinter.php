<?php
/**
 * Handles the creation and running of a user-created form.
 *
 * @author Yaron Koren
 * @author Nils Oppermann
 * @author Jeffrey Stuckman
 * @author Harold Solbrig
 * @author Daniel Hansch
 * @author Stephan Gambke
 * @author LY Meng
 * @file
 * @ingroup SF
 */

class SFFormPrinter {

	public $mSemanticTypeHooks;
	public $mCargoTypeHooks;
	public $mInputTypeHooks;
	public $standardInputsIncluded;
	public $mPageTitle;

	public function __construct() {
		// Initialize variables.
		$this->mSemanticTypeHooks = array();
		$this->mCargoTypeHooks = array();
		$this->mInputTypeHooks = array();
		$this->mInputTypeClasses = array();
		$this->mDefaultInputForPropType = array();
		$this->mDefaultInputForPropTypeList = array();
		$this->mPossibleInputsForPropType = array();
		$this->mPossibleInputsForPropTypeList = array();
		$this->mDefaultInputForCargoType = array();
		$this->mDefaultInputForCargoTypeList = array();
		$this->mPossibleInputsForCargoType = array();
		$this->mPossibleInputsForCargoTypeList = array();

		$this->standardInputsIncluded = false;

		$this->registerInputType( 'SFTextInput' );
		$this->registerInputType( 'SFTextWithAutocompleteInput' );
		$this->registerInputType( 'SFTextAreaInput' );
		$this->registerInputType( 'SFTextAreaWithAutocompleteInput' );
		$this->registerInputType( 'SFDateInput' );
		$this->registerInputType( 'SFDatePickerInput' );
		$this->registerInputType( 'SFDateTimeInput' );
		$this->registerInputType( 'SFYearInput' );
		$this->registerInputType( 'SFCheckboxInput' );
		$this->registerInputType( 'SFDropdownInput' );
		$this->registerInputType( 'SFRadioButtonInput' );
		$this->registerInputType( 'SFCheckboxesInput' );
		$this->registerInputType( 'SFListBoxInput' );
		$this->registerInputType( 'SFComboBoxInput' );
		$this->registerInputType( 'SFTreeInput' );
		$this->registerInputType( 'SFCategoryInput' );
		$this->registerInputType( 'SFCategoriesInput' );
		$this->registerInputType( 'SFTokensInput' );
		$this->registerInputType( 'SFRegExpInput' );
		// Only add these if the Semantic Maps extension is not
		// included.
		if ( !defined( 'SM_VERSION' ) ) {
			$this->registerInputType( 'SFGoogleMapsInput' );
			$this->registerInputType( 'SFOpenLayersInput' );
		}

		// All-purpose setup hook.
		Hooks::run( 'sfFormPrinterSetup', array( $this ) );
	}

	public function setSemanticTypeHook( $type, $is_list, $function_name, $default_args ) {
		$this->mSemanticTypeHooks[$type][$is_list] = array( $function_name, $default_args );
	}

	public function setCargoTypeHook( $type, $is_list, $function_name, $default_args ) {
		$this->mCargoTypeHooks[$type][$is_list] = array( $function_name, $default_args );
	}

	public function setInputTypeHook( $input_type, $function_name, $default_args ) {
		$this->mInputTypeHooks[$input_type] = array( $function_name, $default_args );
	}

	/**
	 * Register all information about the passed-in form input class.
	 *
	 * @param Class $inputTypeClass The class representing the new input.
	 * Must be derived from SFFormInput.
	 */
	public function registerInputType( $inputTypeClass ) {
		$inputTypeName = call_user_func( array( $inputTypeClass, 'getName' ) );
		$this->mInputTypeClasses[$inputTypeName] = $inputTypeClass;
		$this->setInputTypeHook( $inputTypeName, array( $inputTypeClass, 'getHTML' ), array() );

		$defaultProperties = call_user_func( array( $inputTypeClass, 'getDefaultPropTypes' ) );
		foreach ( $defaultProperties as $propertyType => $additionalValues ) {
			$this->setSemanticTypeHook( $propertyType, false, array( $inputTypeClass, 'getHTML' ), $additionalValues );
			$this->mDefaultInputForPropType[$propertyType] = $inputTypeName;
		}
		$defaultPropertyLists = call_user_func( array( $inputTypeClass, 'getDefaultPropTypeLists' ) );
		foreach ( $defaultPropertyLists as $propertyType => $additionalValues ) {
			$this->setSemanticTypeHook( $propertyType, true, array( $inputTypeClass, 'getHTML' ), $additionalValues );
			$this->mDefaultInputForPropTypeList[$propertyType] = $inputTypeName;
		}

		$defaultCargoTypes = call_user_func( array( $inputTypeClass, 'getDefaultCargoTypes' ) );
		foreach ( $defaultCargoTypes as $fieldType => $additionalValues ) {
			$this->setCargoTypeHook( $fieldType, false, array( $inputTypeClass, 'getHTML' ), $additionalValues );
			$this->mDefaultInputForCargoType[$fieldType] = $inputTypeName;
		}
		$defaultCargoTypeLists = call_user_func( array( $inputTypeClass, 'getDefaultCargoTypeLists' ) );
		foreach ( $defaultCargoTypeLists as $fieldType => $additionalValues ) {
			$this->setCargoTypeHook( $fieldType, true, array( $inputTypeClass, 'getHTML' ), $additionalValues );
			$this->mDefaultInputForCargoTypeList[$fieldType] = $inputTypeName;
		}

		$otherProperties = call_user_func( array( $inputTypeClass, 'getOtherPropTypesHandled' ) );
		foreach ( $otherProperties as $propertyTypeID ) {
			if ( array_key_exists( $propertyTypeID, $this->mPossibleInputsForPropType ) ) {
				$this->mPossibleInputsForPropType[$propertyTypeID][] = $inputTypeName;
			} else {
				$this->mPossibleInputsForPropType[$propertyTypeID] = array( $inputTypeName );
			}
		}
		$otherPropertyLists = call_user_func( array( $inputTypeClass, 'getOtherPropTypeListsHandled' ) );
		foreach ( $otherPropertyLists as $propertyTypeID ) {
			if ( array_key_exists( $propertyTypeID, $this->mPossibleInputsForPropTypeList ) ) {
				$this->mPossibleInputsForPropTypeList[$propertyTypeID][] = $inputTypeName;
			} else {
				$this->mPossibleInputsForPropTypeList[$propertyTypeID] = array( $inputTypeName );
			}
		}

		$otherCargoTypes = call_user_func( array( $inputTypeClass, 'getOtherCargoTypesHandled' ) );
		foreach ( $otherCargoTypes as $cargoType ) {
			if ( array_key_exists( $cargoType, $this->mPossibleInputsForCargoType ) ) {
				$this->mPossibleInputsForCargoType[$cargoType][] = $inputTypeName;
			} else {
				$this->mPossibleInputsForCargoType[$cargoType] = array( $inputTypeName );
			}
		}
		$otherCargoTypeLists = call_user_func( array( $inputTypeClass, 'getOtherCargoTypeListsHandled' ) );
		foreach ( $otherCargoTypeLists as $cargoType ) {
			if ( array_key_exists( $cargoType, $this->mPossibleInputsForCargoTypeList ) ) {
				$this->mPossibleInputsForCargoTypeList[$cargoType][] = $inputTypeName;
			} else {
				$this->mPossibleInputsForCargoTypeList[$cargoType] = array( $inputTypeName );
			}
		}

		// FIXME: No need to register these functions explicitly. Instead
		// formFieldHTML should call $someInput -> getJsInitFunctionData() and
		// store its return value. formHTML should at some (late) point use the
		// stored data.
//		$initJSFunction = call_user_func( array( $inputTypeClass, 'getJsInitFunctionData' ) );
//		if ( !is_null( $initJSFunction ) ) {
//			$sfgInitJSFunctions[] = $initJSFunction;
//		}
//
//		$validationJSFunctions = call_user_func( array( $inputTypeClass, 'getJsValidationFunctionData' ) );
//		if ( count( $validationJSFunctions ) > 0 ) {
//			$sfgValidationJSFunctions = array_merge( $sfgValidationJSFunctions, $initJSFunction );
//		}
	}

	public function getInputType( $inputTypeName ) {
		if ( array_key_exists( $inputTypeName, $this->mInputTypeClasses ) ) {
			return $this->mInputTypeClasses[$inputTypeName];
		} else {
			return null;
		}
	}

	public function getDefaultInputTypeSMW( $isList, $propertyType ) {
		if ( $isList ) {
			if ( array_key_exists( $propertyType, $this->mDefaultInputForPropTypeList ) ) {
				return $this->mDefaultInputForPropTypeList[$propertyType];
			} else {
				return null;
			}
		} else {
			if ( array_key_exists( $propertyType, $this->mDefaultInputForPropType ) ) {
				return $this->mDefaultInputForPropType[$propertyType];
			} else {
				return null;
			}
		}
	}

	public function getDefaultInputTypeCargo( $isList, $fieldType ) {
		if ( $isList ) {
			if ( array_key_exists( $fieldType, $this->mDefaultInputForCargoTypeList ) ) {
				return $this->mDefaultInputForCargoTypeList[$fieldType];
			} else {
				return null;
			}
		} else {
			if ( array_key_exists( $fieldType, $this->mDefaultInputForCargoType ) ) {
				return $this->mDefaultInputForCargoType[$fieldType];
			} else {
				return null;
			}
		}
	}

	public function getPossibleInputTypesSMW( $isList, $propertyType ) {
		if ( $isList ) {
			if ( array_key_exists( $propertyType, $this->mPossibleInputsForPropTypeList ) ) {
				return $this->mPossibleInputsForPropTypeList[$propertyType];
			} else {
				return array();
			}
		} else {
			if ( array_key_exists( $propertyType, $this->mPossibleInputsForPropType ) ) {
				return $this->mPossibleInputsForPropType[$propertyType];
			} else {
				return array();
			}
		}
	}

	public function getPossibleInputTypesCargo( $isList, $fieldType ) {
		if ( $isList ) {
			if ( array_key_exists( $fieldType, $this->mPossibleInputsForCargoTypeList ) ) {
				return $this->mPossibleInputsForCargoTypeList[$fieldType];
			} else {
				return array();
			}
		} else {
			if ( array_key_exists( $fieldType, $this->mPossibleInputsForCargoType ) ) {
				return $this->mPossibleInputsForCargoType[$fieldType];
			} else {
				return array();
			}
		}
	}

	public function getAllInputTypes() {
		return array_keys( $this->mInputTypeClasses );
	}

	/**
	 * Show the set of previous deletions for the page being edited.
	 */
	function showDeletionLog( $out ) {
		LogEventsList::showLogExtract( $out, 'delete', $this->mPageTitle->getPrefixedText(),
			'', array( 'lim' => 10,
				'conds' => array( "log_action != 'revision'" ),
				'showIfEmpty' => false,
				'msgKey' => array( 'moveddeleted-notice' ) )
		);
		return true;
	}

	/**
	 * Like PHP's str_replace(), but only replaces the first found
	 * instance - unfortunately, str_replace() doesn't allow for that.
	 * This code is basically copied directly from
	 * http://www.php.net/manual/en/function.str-replace.php#86177
	 * - this might make sense in the SFUtils class, if it's useful in
	 * other places.
	 */
	function strReplaceFirst( $search, $replace, $subject ) {
		$firstChar = strpos( $subject, $search );
		if ( $firstChar !== false ) {
			$beforeStr = substr( $subject, 0, $firstChar );
			$afterStr = substr( $subject, $firstChar + strlen( $search ) );
			return $beforeStr . $replace . $afterStr;
		} else {
			return $subject;
		}
	}

	static function placeholderFormat( $templateName, $fieldName ) {
		return $templateName . '___' . $fieldName;
	}

	static function makePlaceholderInFormHTML( $str ) {
		return '@insertHTML_' . $str . '@';
	}

	function multipleTemplateStartHTML( $tif ) {
		$text = '';
		// If placeholder is set, it means we want to insert a
		// multiple template form's HTML into the main form's HTML.
		// So, the HTML will be stored in $text.
		$text .= "\t" . '<div class="multipleTemplateWrapper">' . "\n";
		$text .= "\t" . '<div class="multipleTemplateList"';
		if ( !is_null( $tif->getMinInstancesAllowed() ) ) {
			$text .= " minimumInstances=\"{$tif->getMinInstancesAllowed()}\"";
		}
		if ( !is_null( $tif->getMaxInstancesAllowed() ) ) {
			$text .= " maximumInstances=\"{$tif->getMaxInstancesAllowed()}\"";
		}
		$text .= ">\n";
		return $text;
	}

	/**
	 * Creates the HTML for the inner table for every instance of a
	 * multiple-instance template in the form.
	 */
	function multipleTemplateInstanceTableHTML( $form_is_disabled, $mainText ) {
		if ( $form_is_disabled ) {
			$addAboveButton = $removeButton = '';
		} else {
			$addAboveButton = Html::element( 'a', array( 'class' => "addAboveButton", 'title' => wfMessage( 'sf_formedit_addanotherabove' )->text() ) );
			$removeButton = Html::element( 'a', array( 'class' => "removeButton", 'title' => wfMessage( 'sf_formedit_remove' )->text() ) );
		}

		$text = <<<END
			<table>
			<tr>
			<td class="instanceRearranger"></td>
			<td class="instanceMain">$mainText</td>
			<td class="instanceAddAbove">$addAboveButton</td>
			<td class="instanceRemove">$removeButton</td>
			</tr>
			</table>
END;

		return $text;
	}

	/**
	 * Creates the HTML for a single instance of a multiple-instance
	 * template.
	 */
	function multipleTemplateInstanceHTML( $template_in_form, $form_is_disabled, &$section ) {
		// Add the character "a" onto the instance number of this input
		// in the form, to differentiate the inputs the form starts out
		// with from any inputs added by the Javascript.
		$section = str_replace( '[num]', "[{$template_in_form->getInstanceNum()}a]", $section );
		// @TODO - this replacement should be
		// case- and spacing-insensitive.
		// Also, keeping the "id=" attribute should not be
		// necessary; but currently it is, for "show on select".
		$section = preg_replace( '/ id="(.*?)"/', ' id="$1" data-origID="$1" ', $section );

		$text = "\t\t" . Html::rawElement( 'div',
				array(
				// The "multipleTemplate" class is there for
				// backwards-compatibility with any custom CSS on people's
				// wikis before SF 2.0.9.
				'class' => "multipleTemplateInstance multipleTemplate"
			),
			$this->multipleTemplateInstanceTableHTML( $form_is_disabled, $section )
		) . "\n";

		return $text;
	}

	/**
	 * Creates the end of the HTML for a multiple-instance template -
	 * including the sections necessary for adding additional instances.
	 */
	function multipleTemplateEndHTML( $template_in_form, $form_is_disabled, $section ) {
		global $sfgTabIndex;

		$text = "\t\t" . Html::rawElement( 'div',
			array(
				'class' => "multipleTemplateStarter",
				'style' => "display: none",
			),
			$this->multipleTemplateInstanceTableHTML( $form_is_disabled, $section )
		) . "\n";

		$attributes = array(
			'tabindex' => $sfgTabIndex,
			'class' => 'multipleTemplateAdder',
		);
		if ( $form_is_disabled ) {
			$attributes['disabled'] = true;
		}
		$button = Html::input( null, Sanitizer::decodeCharReferences( $template_in_form->getAddButtonText() ), 'button', $attributes );
		$text .= <<<END
	</div><!-- multipleTemplateList -->
		<p>$button</p>
		<div class="sfErrorMessages"></div>
	</div><!-- multipleTemplateWrapper -->
</fieldset>
END;
		return $text;
	}

	function tableHTML( $tif, $instanceNum ) {
		global $sfgFieldNum;

		$allGridValues = $tif->getGridValues();
		if ( array_key_exists( $instanceNum, $allGridValues ) ) {
			$gridValues = $allGridValues[$instanceNum];
		} else {
			$gridValues = null;
		}

		$html = '';
		foreach ( $tif->getFields() as $formField ) {
			$fieldName = $formField->template_field->getFieldName();
			if ( $gridValues == null ) {
				$curValue = null;
			} else {
				$curValue = $gridValues[$fieldName];
			}

			$sfgFieldNum++;
			$label = Html::element( 'label',
				array( 'for' => "input_$sfgFieldNum" ),
				$formField->getLabel() );
			$labelCell = Html::rawElement( 'th', null, $label );
			$inputCell = Html::rawElement( 'td', null, $this->formFieldHTML( $formField, $curValue ) );
			$html .= Html::rawElement( 'tr', null, $labelCell . $inputCell ) . "\n";
		}

		$html = Html::rawElement( 'table', array( 'class' => 'formtable' ), $html );

		return $html;
	}

	function spreadsheetHTML( $tif ) {
		global $wgOut, $sfgGridValues, $sfgGridParams;
		global $sfgScriptPath;

		$wgOut->addModules( 'ext.semanticforms.jsgrid' );

		$gridParams = array();
		foreach ( $tif->getFields() as $formField ) {
			$templateField = $formField->template_field;

			$inputType = $formField->getInputType();
			$gridParamValues = array( 'name' => $templateField->getFieldName() );
			if ( $formField->getLabel() !== null ) {
				$gridParamValues['title'] = $formField->getLabel();
			}
			if ( $inputType == 'textarea' ) {
				$gridParamValues['type'] = 'textarea';
			} elseif ( $inputType == 'checkbox' ) {
				$gridParamValues['type'] = 'checkbox';
			} elseif ( ( $possibleValues = $formField->getPossibleValues() ) != null ) {
				array_unshift( $possibleValues, '' );
				$completePossibleValues = array();
				foreach ( $possibleValues as $value ) {
					$completePossibleValues[] = array( 'Name' => $value, 'Id' => $value );
				}
				$gridParamValues['type'] = 'select';
				$gridParamValues['items'] = $completePossibleValues;
				$gridParamValues['valueField'] = 'Id';
				$gridParamValues['textField'] = 'Name';
			} else {
				$gridParamValues['type'] = 'text';
			}
			$gridParams[] = $gridParamValues;
		}

		$templateName = $tif->getTemplateName();
		$templateDivID = str_replace( ' ', '', $templateName ) . "Grid";
		$templateDivAttrs = array(
			'class' => 'sfJSGrid',
			'id' => $templateDivID,
			'data-template-name' => $templateName
		);
		if ( $tif->getHeight() != null ) {
			$templateDivAttrs['height'] = $tif->getHeight();
		}

		$loadingImage = Html::element( 'img', array( 'src' => "$sfgScriptPath/skins/loading.gif" ) );
		$text = Html::rawElement( 'div', $templateDivAttrs, $loadingImage );

		$sfgGridParams[$templateName] = $gridParams;
		$sfgGridValues[$templateName] = $tif->getGridValues();

		return $text;
	}

	/**
	 * Get a string representing the current time, for the time zone
	 * specified in the wiki.
	 */
	function getStringForCurrentTime( $includeTime, $includeTimezone ) {
		global $wgLocaltimezone, $wgAmericanDates, $sfg24HourTime;

		if ( isset( $wgLocaltimezone ) ) {
			$serverTimezone = date_default_timezone_get();
			date_default_timezone_set( $wgLocaltimezone );
		}
		$cur_time = time();
		$year = date( "Y", $cur_time );
		$month = date( "n", $cur_time );
		$day = date( "j", $cur_time );
		if ( $wgAmericanDates == true ) {
			$month_names = SFFormUtils::getMonthNames();
			$month_name = $month_names[$month - 1];
			$curTimeString = "$month_name $day, $year";
		} else {
			$curTimeString = "$year/$month/$day";
		}
		if ( isset( $wgLocaltimezone ) ) {
			date_default_timezone_set( $serverTimezone );
		}
		if ( !$includeTime ) {
			return $curTimeString;
		}

		if ( $sfg24HourTime ) {
			$hour = str_pad( intval( substr( date( "G", $cur_time ), 0, 2 ) ), 2, '0', STR_PAD_LEFT );
		} else {
			$hour = str_pad( intval( substr( date( "g", $cur_time ), 0, 2 ) ), 2, '0', STR_PAD_LEFT );
		}
		$minute = str_pad( intval( substr( date( "i", $cur_time ), 0, 2 ) ), 2, '0', STR_PAD_LEFT );
		$second = str_pad( intval( substr( date( "s", $cur_time ), 0, 2 ) ), 2, '0', STR_PAD_LEFT );
		if ( $sfg24HourTime ) {
			$curTimeString .= " $hour:$minute:$second";
		} else {
			$ampm = date( "A", $cur_time );
			$curTimeString .= " $hour:$minute:$second $ampm";
		}

		if ( $includeTimezone ) {
			$timezone = date( "T", $cur_time );
			$curTimeString .= " $timezone";
		}

		return $curTimeString;
	}

	/**
	 * If the value passed in for a certain field, when a form is
	 * submitted, is an array, then it might be from a checkbox
	 * or date input - in that case, convert it into a string.
	 */
	static function getStringFromPassedInArray( $value, $delimiter ) {
		// If it's just a regular list, concatenate it.
		// This is needed due to some strange behavior
		// in SF, where, if a preload page is passed in
		// in the query string, the form ends up being
		// parsed twice.
		if ( array_key_exists( 'is_list', $value ) ) {
			unset( $value['is_list'] );
			return implode( "$delimiter ", $value );
		}

		// if it has 1 or 2 elements, assume it's a checkbox; if it has
		// 3 elements, assume it's a date
		// - this handling will have to get more complex if other
		// possibilities get added
		if ( count( $value ) == 1 ) {
			return SFUtils::getWordForYesOrNo( false );
		} elseif ( count( $value ) == 2 ) {
			return SFUtils::getWordForYesOrNo( true );
		// if it's 3 or greater, assume it's a date or datetime
		} elseif ( count( $value ) >= 3 ) {
			$month = $value['month'];
			$day = $value['day'];
			if ( $day !== '' ) {
				global $wgAmericanDates;
				if ( $wgAmericanDates == false ) {
					// pad out day to always be two digits
					$day = str_pad( $day, 2, "0", STR_PAD_LEFT );
				}
			}
			$year = $value['year'];
			$hour = $minute = $second = $ampm24h = $timezone = null;
			if ( isset( $value['hour'] ) ) $hour = $value['hour'];
			if ( isset( $value['minute'] ) ) $minute = $value['minute'];
			if ( isset( $value['second'] ) ) $second = $value['second'];
			if ( isset( $value['ampm24h'] ) ) $ampm24h = $value['ampm24h'];
			if ( isset( $value['timezone'] ) ) $timezone = $value['timezone'];
			//if ( $month !== '' && $day !== '' && $year !== '' ) {
			// We can accept either year, or year + month, or year + month + day.
			//if ( $month !== '' && $day !== '' && $year !== '' ) {
			if ( $year !== '' ) {
				// special handling for American dates - otherwise, just
				// the standard year/month/day (where month is a number)
				global $wgAmericanDates;

				if ( $month == '' ) {
					return $year;
				} elseif ( $day == '' ) {
					if ( ! $wgAmericanDates ) {
						// The month is a number - we
						// need it to be a string, so
						// that the date will be parsed
						// correctly if strtotime() is
						// used.
						$monthNames = SFFormUtils::getMonthNames();
						$month = $monthNames[$month - 1];
					}
					return "$month $year";
				} else {
					if ( $wgAmericanDates == true ) {
						$new_value = "$month $day, $year";
					} else {
						$new_value = "$year/$month/$day";
					}
					// If there's a day, include whatever
					// time information we have.
					if ( ! is_null( $hour ) ) {
						$new_value .= " " . str_pad( intval( substr( $hour, 0, 2 ) ), 2, '0', STR_PAD_LEFT ) . ":" . str_pad( intval( substr( $minute, 0, 2 ) ), 2, '0', STR_PAD_LEFT );
					}
					if ( ! is_null( $second ) ) {
						$new_value .= ":" . str_pad( intval( substr( $second, 0, 2 ) ), 2, '0', STR_PAD_LEFT );
					}
					if ( ! is_null( $ampm24h ) ) {
						$new_value .= " $ampm24h";
					}
					if ( ! is_null( $timezone ) ) {
						$new_value .= " $timezone";
					}
					return $new_value;
				}
			}
		}
		return '';
	}

	/**
	 * This function is the real heart of the entire Semantic Forms
	 * extension. It handles two main actions: (1) displaying a form on the
	 * screen, given a form definition and possibly page contents (if an
	 * existing page is being edited); and (2) creating actual page
	 * contents, if the form was already submitted by the user.
	 *
	 * It also does some related tasks, like figuring out the page name (if
	 * only a page formula exists).
	 */
	function formHTML( $form_def, $form_submitted, $source_is_page, $form_id = null, $existing_page_content = null, $page_name = null, $page_name_formula = null, $is_query = false, $is_embedded = false ) {
		global $wgRequest, $wgUser, $wgParser;
		global $sfgTabIndex; // used to represent the current tab index in the form
		global $sfgFieldNum; // used for setting various HTML IDs

		// Initialize some variables.
		$wiki_page = new SFWikiPage();
		$sfgTabIndex = 0;
		$sfgFieldNum = 0;
		$source_page_matches_this_form = false;
		$form_page_title = null;
		$generated_page_name = $page_name_formula;
		// $form_is_partial is true if:
		// (a) 'partial' == 1 in the arguments
		// (b) 'partial form' is found in the form definition
		// in the latter case, it may remain false until close to the end of
		// the parsing, so we have to assume that it will become a possibility
		$form_is_partial = false;
		$partial_form_submitted = $wgRequest->getCheck( 'partial' );
		$new_text = "";

		// If we have existing content and we're not in an active replacement
		// situation, preserve the original content. We do this because we want
		// to pass the original content on IF this is a partial form.
		// TODO: A better approach here would be to pass the revision ID of the
		// existing page content through the replace value, which would
		// minimize the html traffic and would allow us to do a concurrent
		// update check. For now, we pass it through a hidden text field.

		if ( ! $partial_form_submitted ) {
			$original_page_content = $existing_page_content;
		} else {
			$original_page_content = null;
			if ( $wgRequest->getCheck( 'sf_free_text' ) ) {
				if ( !isset( $existing_page_content ) || $existing_page_content == '' ) {
					$existing_page_content = $wgRequest->getVal( 'sf_free_text' );
				}
				$form_is_partial = true;
			}
		}

		// Disable all form elements if user doesn't have edit
		// permission - two different checks are needed, because
		// editing permissions can be set in different ways.
		// HACK - sometimes we don't know the page name in advance, but
		// we still need to set a title here for testing permissions.
		if ( $is_embedded ) {
			// If this is an embedded form (probably a 'RunQuery'),
			// just use the name of the actual page we're on.
			global $wgTitle;
			$this->mPageTitle = $wgTitle;
		} elseif ( $is_query ) {
			// We're in Special:RunQuery - just use that as the
			// title.
			global $wgTitle;
			$this->mPageTitle = $wgTitle;
		} elseif ( $page_name === '' || $page_name === null ) {
			$this->mPageTitle = Title::newFromText(
				$wgRequest->getVal( 'namespace' ) . ":Semantic Forms permissions test" );
		} else {
			$this->mPageTitle = Title::newFromText( $page_name );
		}

		global $wgOut;
		// Show previous set of deletions for this page, if it's been
		// deleted before.
		if ( ! $form_submitted &&
			( $this->mPageTitle && !$this->mPageTitle->exists() &&
			is_null( $page_name_formula ) )
		) {
			$this->showDeletionLog( $wgOut );
		}
		// Unfortunately, we can't just call userCan() here because,
		// since MW 1.16, it has a bug in which it ignores a setting of
		// "$wgEmailConfirmToEdit = true;". Instead, we'll just get the
		// permission errors from the start, and use those to determine
		// whether the page is editable.
		if ( !$is_query ) {
			// $userCanEditPage = ( $wgUser->isAllowed( 'edit' ) && $this->mPageTitle->userCan( 'edit' ) );
			$permissionErrors = $this->mPageTitle->getUserPermissionsErrors( 'edit', $wgUser );
			// The handling of $wgReadOnly and $wgReadOnlyFile
			// has to be done separately.
			if ( wfReadOnly() ) {
				$permissionErrors = array( array( 'readonlytext', array ( wfReadOnlyReason() ) ) );
			}
			$userCanEditPage = count( $permissionErrors ) == 0;
			Hooks::run( 'sfUserCanEditPage', array( $this->mPageTitle, &$userCanEditPage ) );
		}
		$form_text = "";
		if ( $is_query || $userCanEditPage ) {
			$form_is_disabled = false;
			// Show "Your IP address will be recorded" warning if
			// user is anonymous, and it's not a query.
			if ( $wgUser->isAnon() && ! $is_query ) {
				// Based on code in MediaWiki's EditPage.php.
				$anonEditWarning = wfMessage( 'anoneditwarning',
					// Log-in link
					'{{fullurl:Special:UserLogin|returnto={{FULLPAGENAMEE}}}}',
					// Sign-up link
					'{{fullurl:Special:UserLogin/signup|returnto={{FULLPAGENAMEE}}}}' )->parse();
				$form_text .= Html::rawElement( 'div', array( 'id' => 'mw-anon-edit-warning', 'class' => 'warningbox' ), $anonEditWarning );
			}
		} else {
			$form_is_disabled = true;
			$wgOut->setPageTitle( wfMessage( 'badaccess' )->text() );
			$wgOut->addWikiText( $wgOut->formatPermissionsErrorMessage( $permissionErrors, 'edit' ) );
			$wgOut->addHTML( "\n<hr />\n" );
		}

//		$oldParser = $wgParser;

//		$wgParser = unserialize( serialize( $oldParser ) ); // deep clone of parser
		if ( !$wgParser->Options() ) {
			$wgParser->Options( ParserOptions::newFromUser( $wgUser ) );
		}
		$wgParser->Title( $this->mPageTitle );
		// This is needed in order to make sure $parser->mLinkHolders
		// is set.
		$wgParser->clearState();

		$form_def = SFFormUtils::getFormDefinition( $wgParser, $form_def, $form_id );

		// Turn form definition file into an array of sections, one for
		// each template definition (plus the first section).
		$form_def_sections = array();
		$start_position = 0;
		$section_start = 0;
		$free_text_was_included = false;
		// Unencode any HTML-encoded representations of curly brackets and
		// pipes - this is a hack to allow for forms to include templates
		// that themselves contain form elements - the escaping was needed
		// to make sure that those elements don't get parsed too early.
		$form_def = str_replace( array( '&#123;', '&#124;', '&#125;' ), array( '{', '|', '}' ), $form_def );
		// And another hack - replace the 'free text' standard input
		// with a field declaration to get it to be handled as a field.
		$form_def = str_replace( 'standard input|free text', 'field|<freetext>', $form_def );
		while ( $brackets_loc = strpos( $form_def, "{{{", $start_position ) ) {
			$brackets_end_loc = strpos( $form_def, "}}}", $brackets_loc );
			$bracketed_string = substr( $form_def, $brackets_loc + 3, $brackets_end_loc - ( $brackets_loc + 3 ) );
			$tag_components = SFUtils::getFormTagComponents( $bracketed_string );
			$tag_title = trim( $tag_components[0] );
			if ( $tag_title == 'for template' || $tag_title == 'end template' ) {
				// Create a section for everything up to here
				$section = substr( $form_def, $section_start, $brackets_loc - $section_start );
				$form_def_sections[] = $section;
				$section_start = $brackets_loc;
			}
			$start_position = $brackets_loc + 1;
		} // end while
		$form_def_sections[] = trim( substr( $form_def, $section_start ) );

		// Cycle through the form definition file, and possibly an
		// existing article as well, finding template and field
		// declarations and replacing them with form elements, either
		// blank or pre-populated, as appropriate.
		$template = null;
		$tif = null;
		// This array will keep track of all the replaced @<name>@ strings
		$placeholderFields = array();

		for ( $section_num = 0; $section_num < count( $form_def_sections ); $section_num++ ) {
			$start_position = 0;
			// the append is there to ensure that the original
			// array doesn't get modified; is it necessary?
			$section = " " . $form_def_sections[$section_num];

			while ( $brackets_loc = strpos( $section, '{{{', $start_position ) ) {
				$brackets_end_loc = strpos( $section, "}}}", $brackets_loc );
				$bracketed_string = substr( $section, $brackets_loc + 3, $brackets_end_loc - ( $brackets_loc + 3 ) );
				$tag_components = SFUtils::getFormTagComponents( $bracketed_string );
				$tag_title = trim( $tag_components[0] );
				// =====================================================
				// for template processing
				// =====================================================
				if ( $tag_title == 'for template' ) {
					if ( $tif ) {
						$previous_template_name = $tif->getTemplateName();
					} else {
						$previous_template_name = '';
					}
					$template_name = str_replace( '_', ' ', $tag_components[1] );
					$is_new_template = ( $template_name != $previous_template_name );
					if ( $is_new_template ) {
						$template = SFTemplate::newFromName( $template_name );
						$tif = SFTemplateInForm::newFromFormTag( $tag_components );
					}
					// Remove template tag.
					$section = substr_replace( $section, '', $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
					// If we are editing a page, and this
					// template can be found more than
					// once in that page, and multiple
					// values are allowed, repeat this
					// section.
					if ( $source_is_page || $partial_form_submitted ) {
						$tif->setPageRelatedInfo( $existing_page_content );
						// Get the first instance of
						// this template on the page
						// being edited, even if there
						// are more.
						if ( $tif->pageCallsThisTemplate() ) {
							$tif->setFieldValuesFromPage( $existing_page_content );
							$existing_template_text = $tif->getFullTextInPage();
							// Now remove this template from the text being edited.
							// If this is a partial form, establish a new insertion point.
							if ( $existing_page_content && $partial_form_submitted ) {
								// If something already exists, set the new insertion point
								// to its position; otherwise just let it lie.
								if ( strpos( $existing_page_content, $existing_template_text ) !== false ) {
									$existing_page_content = str_replace( "\n" . '{{{insertionpoint}}}', '', $existing_page_content );
									$existing_page_content = str_replace( $existing_template_text, '{{{insertionpoint}}}', $existing_page_content );
								}
							} else {
								$existing_page_content = $this->strReplaceFirst( $existing_template_text, '', $existing_page_content );
							}
							// If we've found a match in the source
							// page, there's a good chance that this
							// page was created with this form - note
							// that, so we don't send the user a warning.
							$source_page_matches_this_form = true;
						}
					}

					// We get values from the request,
					// regardless of whether the the source
					// is the page or a form submit, because
					// even if the source is a page, values
					// can still come from a query string.
					$tif->setFieldValuesFromSubmit();

					$tif->checkIfAllInstancesPrinted( $form_submitted, $source_is_page );

					if ( !$tif->allInstancesPrinted() ) {
						$wiki_page->addTemplate( $tif );
					}

				// =====================================================
				// end template processing
				// =====================================================
				} elseif ( $tag_title == 'end template' ) {
					if ( $source_is_page ) {
						// Add any unhandled template fields
						// in the page as hidden variables.
						$form_text .= SFFormUtils::unhandledFieldsHTML( $tif );
					}
					// Remove this tag from the $section variable.
					$section = substr_replace( $section, '', $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
					$template = null;
					$tif = null;
				// =====================================================
				// field processing
				// =====================================================
				} elseif ( $tag_title == 'field' ) {

					// If the template is null, that (hopefully)
					// means we're handling the free text field.
					// Make the template a dummy variable.
					if ( $tif == null ) {
						$template = new SFTemplate( null, array() );
						$tif = new SFTemplateInForm();
					}
					// We get the field name both here
					// and in the SFFormField constructor,
					// because SFFormField isn't equipped
					// to deal with the <freetext> hack,
					// among others.
					$field_name = trim( $tag_components[1] );
					$form_field = SFFormField::newFromFormFieldTag( $tag_components, $template, $tif, $form_is_disabled );
					// For special displays, add in the
					// form fields, so we know the data
					// structure.
					if ( ( $tif->getDisplay() == 'table' && ( !$tif->allowsMultiple() || $tif->getInstanceNum() == 0 ) ) ||
						( $tif->getDisplay() == 'spreadsheet' && $tif->allowsMultiple() && $tif->getInstanceNum() == 0 ) ) {
						$tif->addField( $form_field );
					}
					$cur_value = $form_field->getCurrentValue( $tif->getValuesFromSubmit(), $form_submitted, $source_is_page, $tif->allInstancesPrinted() );
					if ( $form_field->holdsTemplate() ) {
						$placeholderFields[] = self::placeholderFormat( $tif->getTemplateName(), $field_name );
					}

					// If the user is editing a page, and that page contains a call to
					// the template being processed, get the current field's value
					// from the template call
					if ( $source_is_page && ( $tif->getFullTextInPage() != '' && !$form_submitted ) ) {
						if ( $tif->hasValueFromPageForField( $field_name ) ) {
							// Get value, and remove it,
							// so that at the end we
							// can have a list of all
							// the fields that weren't
							// handled by the form.
							$cur_value = $tif->getAndRemoveValueFromPageForField( $field_name );
 
							// If the field is a placeholder, the contents of this template
							// parameter should be treated as elements parsed by an another
							// multiple template form.
							// By putting that at the very end of the parsed string, we'll
							// have it processed as a regular multiple template form.
							if ( $form_field->holdsTemplate() ) {
								$existing_page_content .= $cur_value;
							}
						} elseif ( isset( $cur_value ) && !empty( $cur_value ) ) {
							// Do nothing.
						} else {
							$cur_value = '';
						}
					}

					// Handle the free text field.
					if ( $field_name == '<freetext>' ) {
						// Add placeholders for the free text in both the form and
						// the page, using <free_text> tags - once all the free text
						// is known (at the end), it will get substituted in.
						if ( $form_field->isHidden() ) {
							$new_text = Html::hidden( 'sf_free_text', '!free_text!' );
						} else {
							$sfgTabIndex++;
							$sfgFieldNum++;
							if ( $cur_value === '' || is_null( $cur_value ) ) {
								$default_value = '!free_text!';
							} else {
								$default_value = $cur_value;
							}
							$new_text = SFTextAreaInput::getHTML( $default_value, 'sf_free_text', false, ( $form_is_disabled || $form_field->isRestricted() ), $form_field->getFieldArgs() );
							if ( $form_field->hasFieldArg( 'edittools' ) ) {
								// borrowed from EditPage::showEditTools()
								$edittools_text = $wgParser->recursiveTagParse( wfMessage( 'edittools', array( 'content' ) )->text() );

								$new_text .= <<<END
		<div class="mw-editTools">
		$edittools_text
		</div>

END;
							}
						}
						$free_text_was_included = true;
						$wiki_page->addFreeTextSection();
					}

					if ( $tif->getTemplateName() === '' || $field_name == '<freetext>' ) {
						$section = substr_replace( $section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
					} else {
						if ( is_array( $cur_value ) ) {
							// @TODO - is this code ever called?
							$delimiter = $form_field->getFieldArg( 'is_list' );
							// first, check if it's a list
							if ( array_key_exists( 'is_list', $cur_value ) &&
									$cur_value['is_list'] == true ) {
								$cur_value_in_template = "";
								foreach ( $cur_value as $key => $val ) {
									if ( $key !== "is_list" ) {
										if ( $cur_value_in_template != "" ) {
											$cur_value_in_template .= $delimiter . " ";
										}
										$cur_value_in_template .= $val;
									}
								}
							} else {
								// If it's not a list, it's probably from a checkbox or date input -
								// convert the values into a string.
								$cur_value_in_template = self::getStringFromPassedInArray( $cur_value, $delimiter );
							}
						} elseif ( $form_field->holdsTemplate() ) {
							// If this field holds an embedded template,
							// and the value is not an array, it means
							// there are no instances of the template -
							// set the value to null to avoid getting
							// whatever is currently on the page.
							$cur_value_in_template = null;
						} else { // value is not an array
							$cur_value_in_template = $cur_value;
						}

						// If we're creating the page name from a formula based on
						// form values, see if the current input is part of that formula,
						// and if so, substitute in the actual value.
						if ( $form_submitted && $generated_page_name !== '' ) {
							// This line appears to be unnecessary.
							// $generated_page_name = str_replace('.', '_', $generated_page_name);
							$generated_page_name = str_replace( ' ', '_', $generated_page_name );
							$escaped_input_name = str_replace( ' ', '_', $form_field->getInputName() );
							$generated_page_name = str_ireplace( "<$escaped_input_name>", $cur_value_in_template, $generated_page_name );
							// Once the substitution is done, replace underlines back
							// with spaces.
							$generated_page_name = str_replace( '_', ' ', $generated_page_name );
						}

						// Call hooks - unfortunately this has to be split into two
						// separate calls, because of the different variable names in
						// each case.
						if ( $form_submitted ) {
							Hooks::run( 'sfCreateFormField', array( &$form_field, &$cur_value_in_template, true ) );
						} else {
							if ( !empty( $cur_value ) &&
								( $form_field->hasFieldArg( 'mapping template' ) ||
								$form_field->hasFieldArg( 'mapping property' ) ||
								( $form_field->hasFieldArg( 'mapping cargo table' ) &&
								$form_field->hasFieldArg( 'mapping cargo field' ) ) ) ) {
								// If the input type is "tokens', the value is not
								// an array, but the delimiter still needs to be set.
								if ( !is_array( $cur_value ) ) {
									if ( $form_field->hasFieldArg( 'delimiter' ) ) {
										$delimiter = $form_field->getFieldArg( 'delimiter' );
									} else {
										$delimiter = ',';
									}
								}
								$cur_value = $form_field->valueStringToLabels( $cur_value, $delimiter );
							}
							Hooks::run( 'sfCreateFormField', array( &$form_field, &$cur_value, false ) );
						}
						// if this is not part of a 'multiple' template, increment the
						// global tab index (used for correct tabbing)
						if ( ! $form_field->hasFieldArg( 'part_of_multiple' ) ) {
							$sfgTabIndex++;
						}
						// increment the global field number regardless
						$sfgFieldNum++;
						// If the field is a date field, and its default value was set
						// to 'now', and it has no current value, set $cur_value to be
						// the current date.
						if ( $form_field->getDefaultValue() == 'now' &&
								// if the date is hidden, cur_value will already be set
								// to the default value
								( $cur_value == '' || $cur_value == 'now' ) ) {
							$input_type = $form_field->getInputType();
							if ( $input_type == 'date' || $input_type == 'datetime' ||
									$input_type == 'year' ||
									( $input_type == '' && $form_field->getTemplateField()->getPropertyType() == '_dat' ) ) {
								$cur_value_in_template = self::getStringForCurrentTime( $input_type == 'datetime', $form_field->hasFieldArg( 'include timezone' ) );
							}
						}
						// If the field is a text field, and its default value was set
						// to 'current user', and it has no current value, set $cur_value
						// to be the current user.
						if ( $form_field->getDefaultValue() == 'current user' &&
							// if the date is hidden, cur_value will already be set
							// to the default value
							( $cur_value === '' || $cur_value == 'current user' ) ) {

							$cur_value_in_template = $wgUser->getName();
							$cur_value = $cur_value_in_template;
						}

						// If all instances have been
						// printed, that means we're
						// now printing a "starter"
						// div - set the current value
						// to null, unless it's the
						// default value.
						// (Ideally it wouldn't get
						// set at all, but that seems a
						// little harder.)
						if ( $tif->allInstancesPrinted() && $form_field->getDefaultValue() == null ) {
							$cur_value = null;
						}

						$new_text = $this->formFieldHTML( $form_field, $cur_value );
						$new_text .= $form_field->additionalHTMLForInput( $cur_value, $field_name, $tif->getTemplateName() );

						if ( $new_text ) {
							$wiki_page->addTemplateParam( $template_name, $tif->getInstanceNum(), $field_name, $cur_value_in_template );
							$section = substr_replace( $section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
						} else {
							$start_position = $brackets_end_loc;
						}
					}

					if ( $tif->allowsMultiple() && !$tif->allInstancesPrinted() ) {
						$wordForYes = SFUtils::getWordForYesOrNo( true );
						if ( $form_field->getInputType() == 'checkbox' ) {
							if ( strtolower( $cur_value ) == strtolower( $wordForYes ) || strtolower( $cur_value ) == 'yes' || $cur_value == '1' ) {
								$cur_value = true;
							} else {
								$cur_value = false;
							}
						}
					}

					if ( $tif->getDisplay() != null && ( !$tif->allowsMultiple() || !$tif->allInstancesPrinted() ) ) {
						$tif->addGridValue( $field_name, $cur_value );
					}

				// =====================================================
				// standard input processing
				// =====================================================
				} elseif ( $tag_title == 'standard input' ) {
					// handle all the possible values
					$input_name = $tag_components[1];
					$input_label = null;
					$attr = array();

					// if it's a query, ignore all standard inputs except run query
					if ( ( $is_query && $input_name != 'run query' ) || ( !$is_query && $input_name == 'run query' ) ) {
						$new_text = "";
						$section = substr_replace( $section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
						continue;
					}
					// set a flag so that the standard 'form bottom' won't get displayed
					$this->standardInputsIncluded = true;
					// cycle through the other components
					$is_checked = false;
					for ( $i = 2; $i < count( $tag_components ); $i++ ) {
						$component = $tag_components[$i];
						$sub_components = array_map( 'trim', explode( '=', $component ) );
						if ( count( $sub_components ) == 1 ) {
							if ( $sub_components[0] == 'checked' ) {
								$is_checked = true;
							}
						} elseif ( count( $sub_components ) == 2 ) {
							switch( $sub_components[0] ) {
							case 'label':
								$input_label = $wgParser->recursiveTagParse( $sub_components[1] );
								break;
							case 'class':
							case 'style':
								$attr[$sub_components[0]] = $sub_components[1];
								break;
							}
						}
					}
					if ( $input_name == 'summary' ) {
						$value = $wgRequest->getVal( 'wpSummary' );
						$new_text = SFFormUtils::summaryInputHTML( $form_is_disabled, $input_label, $attr, $value );
					} elseif ( $input_name == 'minor edit' ) {
						$is_checked = $wgRequest->getCheck( 'wpMinoredit' );
						$new_text = SFFormUtils::minorEditInputHTML( $form_submitted, $form_is_disabled, $is_checked, $input_label, $attr );
					} elseif ( $input_name == 'watch' ) {
						$is_checked = $wgRequest->getCheck( 'wpWatchthis' );
						$new_text = SFFormUtils::watchInputHTML( $form_submitted, $form_is_disabled, $is_checked, $input_label, $attr );
					} elseif ( $input_name == 'save' ) {
						$new_text = SFFormUtils::saveButtonHTML( $form_is_disabled, $input_label, $attr );
					} elseif ( $input_name == 'save and continue' ) {
						$new_text = SFFormUtils::saveAndContinueButtonHTML( $form_is_disabled, $input_label, $attr );
					} elseif ( $input_name == 'preview' ) {
						$new_text = SFFormUtils::showPreviewButtonHTML( $form_is_disabled, $input_label, $attr );
					} elseif ( $input_name == 'changes' ) {
						$new_text = SFFormUtils::showChangesButtonHTML( $form_is_disabled, $input_label, $attr );
					} elseif ( $input_name == 'cancel' ) {
						$new_text = SFFormUtils::cancelLinkHTML( $form_is_disabled, $input_label, $attr );
					} elseif ( $input_name == 'run query' ) {
						$new_text = SFFormUtils::runQueryButtonHTML( $form_is_disabled, $input_label, $attr );
					}
					$section = substr_replace( $section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
				// =====================================================
				// for section processing
				// =====================================================
				} elseif ( $tag_title == 'section' ) {
					$sfgFieldNum++;
					$sfgTabIndex++;

					$section_name = trim( $tag_components[1] );
					$page_section_in_form = SFPageSection::newFromFormTag( $tag_components );
					$section_text = null;

					// Split the existing page contents into the textareas in the form.
					$default_value = "";
					$section_start_loc = 0;
					if ( $source_is_page && $existing_page_content !== null ) {
						// For the last section of the page, there is no trailing newline in
						// $existing_page_content, but the code below expects it. This code
						// ensures that there is always trailing newline. T72202
						if ( substr( $existing_page_content, -1 ) !== "\n" ) {
							$existing_page_content .= "\n";
						}

						$equalsSigns = str_pad( '', $page_section_in_form->getSectionLevel(), '=' );
						$searchStr =
							'/^' .
							preg_quote( $equalsSigns, '/' ) .
							'[ ]*?' .
							preg_quote( $section_name, '/' ) .
							'[ ]*?' .
							preg_quote( $equalsSigns, '/' ) .
							'$/m';
						if ( preg_match( $searchStr, $existing_page_content, $matches, PREG_OFFSET_CAPTURE ) ) {
							$section_start_loc = $matches[0][1];
							$header_text = $matches[0][0];
							$existing_page_content = str_replace( $header_text, '', $existing_page_content );
						} else {
							$section_start_loc = 0;
						}
						$section_end_loc = -1;

						// get the position of the next template or section defined in the form
						$next_section_start_loc = strpos( $section, '{{{', $brackets_end_loc );
						if ( $next_section_start_loc == false ) {
							$section_end_loc = strpos( $existing_page_content, '{{', $section_start_loc );
						} else {
							$next_section_end_loc = strpos( $section, '}}}', $next_section_start_loc );
							$bracketed_string_next_section = substr( $section, $next_section_start_loc + 3, $next_section_end_loc - ( $next_section_start_loc + 3 ) );
							$tag_components_next_section = SFUtils::getFormTagComponents( $bracketed_string_next_section );
							$tag_title_next_section = trim( $tag_components_next_section[0] );
							if ( $tag_title_next_section == 'section' ) {
								if ( preg_match( '/(^={1,6}[ ]*?' . $tag_components_next_section[1] . '[ ]*?={1,6}\s*?$)/m', $existing_page_content, $matches, PREG_OFFSET_CAPTURE ) ) {
									$section_end_loc = $matches[0][1];
								}
							}
						}

						if ( $section_end_loc === -1 ) {
							$section_text = $existing_page_content;
							$existing_page_content = '';
						} else {
							$section_text = substr( $existing_page_content, $section_start_loc, $section_end_loc - $section_start_loc );
							$existing_page_content = substr( $existing_page_content, $section_end_loc );
						}
					}

					// If input is from the form.
					if ( ( ! $source_is_page ) && $wgRequest ) {
						$text_per_section = $wgRequest->getArray( '_section' );
						$section_text = $text_per_section[trim( $section_name )];
						$wiki_page->addSection( $section_name, $page_section_in_form->getSectionLevel(), $section_text );
					}

					$section_text = trim( $section_text );

					// Set input name for query string.
					$input_name = '_section' . '[' . trim( $section_name ) . ']';
					$other_args = $page_section_in_form->getSectionArgs();
					$other_args['isSection'] = true;
					if ( $page_section_in_form->isMandatory() ) {
						$other_args['mandatory'] = true;
					}

					if ( $page_section_in_form->isHidden() ) {
						$form_section_text = Html::hidden( $input_name, $section_text );
					} else {
						$form_section_text = SFTextAreaInput::getHTML( $section_text, $input_name, false, ( $form_is_disabled || $page_section_in_form->isRestricted() ), $other_args );
					}

					$section = substr_replace( $section, $form_section_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
				// =====================================================
				// page info processing
				// =====================================================
				} elseif ( $tag_title == 'info' ) {
					// TODO: Generate an error message if this is included more than once
					foreach ( array_slice( $tag_components, 1 ) as $component ) {
						$sub_components = array_map( 'trim', explode( '=', $component, 2 ) );
						// Tag names are case-insensitive
						$tag = strtolower( $sub_components[0] );
						if ( $tag == 'create title' || $tag == 'add title' ) {
							// Handle this only if
							// we're adding a page.
							if ( !$is_query && !$this->mPageTitle->exists() ) {
								$form_page_title = $sub_components[1];
							}
						} elseif ( $tag == 'edit title' ) {
							// Handle this only if
							// we're editing a page.
							if ( !$is_query && $this->mPageTitle->exists() ) {
								$form_page_title = $sub_components[1];
							}
						} elseif ( $tag == 'query title' ) {
							// Handle this only if
							// we're in 'RunQuery'.
							if ( $is_query ) {
								$form_page_title = $sub_components[1];
							}
						} elseif ( $tag == 'partial form' ) {
							$form_is_partial = true;
							// replacement pages may have minimal matches...
							$source_page_matches_this_form = true;
						} elseif ( $tag == 'includeonly free text' || $tag == 'onlyinclude free text' ) {
							$wiki_page->makeFreeTextOnlyInclude();
						} elseif ( $tag == 'query form at top' ) {
							// TODO - this should be made a field of
							// some non-static class that actually
							// prints the form, instead of requiring
							// a global variable.
							global $sfgRunQueryFormAtTop;
							$sfgRunQueryFormAtTop = true;
						}
					}
					$section = substr_replace( $section, '', $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
				// =====================================================
				// default outer level processing
				// =====================================================
				} else { // Tag is not one of the three allowed values -
					// ignore the tag.
					$start_position = $brackets_end_loc;
				} // end if
			} // end while

			if ( $tif && ( !$tif->allowsMultiple() || $tif->allInstancesPrinted() ) ) {
				$template_text = $wiki_page->createTemplateCallsForTemplateName( $tif->getTemplateName() );
				// If there is a placeholder in the text, we
				// know that we are doing a replace.
				if ( $existing_page_content && strpos( $existing_page_content, '{{{insertionpoint}}}', 0 ) !== false ) {
					$existing_page_content = preg_replace( '/\{\{\{insertionpoint\}\}\}(\r?\n?)/',
						preg_replace( '/\}\}/m', '}�',
							preg_replace( '/\{\{/m', '�{', $template_text ) ) .
						"{{{insertionpoint}}}",
						$existing_page_content );
				// Otherwise, if it's a partial form, we have to add the new
				// text somewhere.
				} elseif ( $partial_form_submitted ) {
					$existing_page_content = preg_replace( '/\}\}/m', '}�',
						preg_replace( '/\{\{/m', '�{', $template_text ) ) .
							"{{{insertionpoint}}}" . $existing_page_content;
				}
			}

			$multipleTemplateHTML = '';
			if ( $tif && $tif->getLabel() != null ) {
				$fieldsetStartHTML = "<fieldset>\n" . Html::element( 'legend', null, $tif->getLabel() ) . "\n";
				if ( !$tif->allowsMultiple() ) {
					$form_text .= $fieldsetStartHTML;
				} elseif ( $tif->allowsMultiple() && $tif->getInstanceNum() == 0 ) {
					$multipleTemplateHTML .= $fieldsetStartHTML;
				}
			}
			if ( $tif && $tif->allowsMultiple() ) {
				if ( $tif->getDisplay() == 'spreadsheet' ) {
					if ( $tif->allInstancesPrinted() ) {
						$multipleTemplateHTML .= $this->spreadsheetHTML( $tif );
						// For spreadsheets, this needs
						// to be specially inserted.
						$multipleTemplateHTML .= "</fieldset>\n";
					}
				} else {
					if ( $tif->getDisplay() == 'table' ) {
						$section = $this->tableHTML( $tif, $tif->getInstanceNum() );
					}
					if ( $tif->getInstanceNum() == 0 ) {
						$multipleTemplateHTML .= $this->multipleTemplateStartHTML( $tif );
					}
					if ( ! $tif->allInstancesPrinted() ) {
						$multipleTemplateHTML .= $this->multipleTemplateInstanceHTML( $tif, $form_is_disabled, $section );
					} else {
						$multipleTemplateHTML .= $this->multipleTemplateEndHTML( $tif, $form_is_disabled, $section );
					}
				}
				$placeholder = $tif->getPlaceholder();
				if ( $placeholder == null ) {
					// The normal process.
					$form_text .= $multipleTemplateHTML;
				} else {
					// The template text won't be appended
					// at the end of the template like for
					// usual multiple template forms.
					// The HTML text will instead be stored in
					// the $multipleTemplateHTML variable,
					// and then added in the right
					// @insertHTML_".$placeHolderField."@"; position
					// Optimization: actually, instead of
					// separating the processes, the usual
					// multiple template forms could also be
					// handled this way if a fitting
					// placeholder tag was added.
					// We replace the HTML into the current
					// placeholder tag, but also add another
					// placeholder tag, to keep track of it.
					$multipleTemplateHTML .= self::makePlaceholderInFormHTML( $placeholder );
					$form_text = str_replace( self::makePlaceholderInFormHTML( $placeholder ), $multipleTemplateHTML, $form_text );
				}
				if ( ! $tif->allInstancesPrinted() ) {
					// This will cause the section to be
					// re-parsed on the next go.
					$section_num--;
					$tif->incrementInstanceNum();
				}
			} elseif ( $tif && $tif->getDisplay() == 'table' ) {
				$form_text .= $this->tableHTML( $tif, 0 );
			} else {
				$form_text .= $section;
			}
		} // end for

		// Cleanup - everything has been browsed.
		// Remove all the remaining placeholder
		// tags in the HTML and wiki-text.
		foreach ( $placeholderFields as $stringToReplace ) {
			// Remove the @<insertHTML>@ tags from the generated
			// HTML form.
			$form_text = str_replace( self::makePlaceholderInFormHTML( $stringToReplace ), '', $form_text );
		}

		// If it wasn't included in the form definition, add the
		// 'free text' input as a hidden field at the bottom.
		if ( ! $free_text_was_included ) {
			$form_text .= Html::hidden( 'sf_free_text', '!free_text!' );
		}
		// Get free text, and add to page data, as well as retroactively
		// inserting it into the form.

		// If $form_is_partial is true then either:
		// (a) we're processing a replacement (param 'partial' == 1)
		// (b) we're sending out something to be replaced (param 'partial' is missing)
		if ( $form_is_partial ) {
			if ( !$partial_form_submitted ) {
				$free_text = $original_page_content;
			} else {
				$free_text = null;
				$existing_page_content = preg_replace( array( '/�\{/m', '/\}�/m' ),
					array( '{{', '}}' ),
					$existing_page_content );
				$existing_page_content = str_replace( '{{{insertionpoint}}}', '', $existing_page_content );
			}
			$form_text .= Html::hidden( 'partial', 1 );
		} elseif ( $source_is_page ) {
			// If the page is the source, free_text will just be
			// whatever in the page hasn't already been inserted
			// into the form.
			$free_text = trim( $existing_page_content );
		// or get it from a form submission
		} elseif ( $wgRequest->getCheck( 'sf_free_text' ) ) {
			$free_text = $wgRequest->getVal( 'sf_free_text' );
			if ( ! $free_text_was_included ) {
				$wiki_page->addFreeTextSection();
			}
		} else {
			$free_text = null;
		}

		if ( $wiki_page->freeTextOnlyInclude() ) {
			$free_text = str_replace( "<onlyinclude>", '', $free_text );
			$free_text = str_replace( "</onlyinclude>", '', $free_text );
			$free_text = trim( $free_text );
		}

		$page_text = '';

		// The first hook here is deprecated. Use the second.
		// Note: Hooks::run can take a third argument which indicates
		// a deprecated hook, but it expects a MediaWiki version, not
		// an extension version.
		Hooks::run( 'sfModifyFreeTextField', array( &$free_text, $existing_page_content ) );
		Hooks::run( 'sfBeforeFreeTextSubstitution',
			array( &$free_text, $existing_page_content, &$page_text ) );

		// Now that we have the free text, we can create the full page
		// text.
		// The page text needs to be created whether or not the form
		// was submitted, in case this is called from #formredlink.
		$wiki_page->setFreeText( $free_text );
		$page_text = $wiki_page->createPageText();

		// Also substitute the free text into the form.
		$escaped_free_text = Sanitizer::safeEncodeAttribute( $free_text );
		$form_text = str_replace( '!free_text!', $escaped_free_text, $form_text );

		// Add a warning in, if we're editing an existing page and that
		// page appears to not have been created with this form.
		if ( !$is_query && is_null( $page_name_formula ) &&
			$this->mPageTitle->exists() && $existing_page_content !== ''
			&& !$source_page_matches_this_form ) {
			$form_text = "\t" . '<div class="warningbox">' .
				wfMessage( 'sf_formedit_formwarning', $this->mPageTitle->getFullURL() )->text() .
				"</div>\n<br clear=\"both\" />\n" . $form_text;
		}

		// Add form bottom, if no custom "standard inputs" have been defined.
		if ( !$this->standardInputsIncluded ) {
			if ( $is_query ) {
				$form_text .= SFFormUtils::queryFormBottom( $form_is_disabled );
			} else {
				$form_text .= SFFormUtils::formBottom( $form_submitted, $form_is_disabled );
			}
		}

		if ( !$is_query ) {
			$form_text .= Html::hidden( 'wpStarttime', wfTimestampNow() );
			$article = new Article( $this->mPageTitle, 0 );
			$form_text .= Html::hidden( 'wpEdittime', $article->getTimestamp() );

			$form_text .= Html::hidden( 'wpEditToken', $wgUser->getEditToken() );
		}

		$form_text .= "\t</form>\n";
		$wgParser->replaceLinkHolders( $form_text );
		Hooks::run( 'sfRenderingEnd', array( &$form_text ) );

		// Send the autocomplete values to the browser, along with the
		// mappings of which values should apply to which fields.
		// If doing a replace, the page text is actually the modified
		// original page.
		if ( $partial_form_submitted ) {
			$page_text = $existing_page_content;
		}

		if ( !$is_embedded ) {
			$form_page_title = $wgParser->recursiveTagParse( str_replace( "{{!}}", "|", $form_page_title ) );
		} else {
			$form_page_title = null;
		}

//		$wgParser = $oldParser;

		return array( $form_text, $page_text, $form_page_title, $generated_page_name );
	}

	/**
	 * Create the HTML and Javascript to display this field within a form.
	 */
	function formFieldHTML( $form_field, $cur_value ) {
		// Also get the actual field, with all the semantic information
		// (type is SFTemplateField, instead of SFFormField)
		$template_field = $form_field->getTemplateField();

		if ( $form_field->isHidden() ) {
			$text = Html::hidden( $form_field->getInputName(), $cur_value );
		} elseif ( $form_field->getInputType() !== '' &&
				array_key_exists( $form_field->getInputType(), $this->mInputTypeHooks ) &&
				$this->mInputTypeHooks[$form_field->getInputType()] != null ) {
			$funcArgs = array();
			$funcArgs[] = $cur_value;
			$funcArgs[] = $form_field->getInputName();
			$funcArgs[] = $form_field->isMandatory();
			$funcArgs[] = $form_field->isDisabled();
			// Last argument to function should be a hash, merging
			// the default values for this input type with all
			// other properties set in the form definition, plus
			// some semantic-related arguments.
			$hook_values = $this->mInputTypeHooks[$form_field->getInputType()];
			$other_args = $form_field->getArgumentsForInputCall( $hook_values[1] );
			$funcArgs[] = $other_args;
			$text = call_user_func_array( $hook_values[0], $funcArgs );
		} else { // input type not defined in form
			$cargo_field_type = $template_field->getFieldType();
			$property_type = $template_field->getPropertyType();
			$is_list = ( $form_field->isList() || $template_field->isList() );
			if ( $cargo_field_type !== '' &&
				array_key_exists( $cargo_field_type, $this->mCargoTypeHooks ) &&
				isset( $this->mCargoTypeHooks[$cargo_field_type][$is_list] ) ) {
				$funcArgs = array();
				$funcArgs[] = $cur_value;
				$funcArgs[] = $form_field->getInputName();
				$funcArgs[] = $form_field->isMandatory();
				$funcArgs[] = $form_field->isDisabled();
				$hook_values = $this->mCargoTypeHooks[$cargo_field_type][$is_list];
				$other_args = $form_field->getArgumentsForInputCall( $hook_values[1] );
				$funcArgs[] = $other_args;
				$text = call_user_func_array( $hook_values[0], $funcArgs );
			} elseif ( $property_type !== '' &&
				array_key_exists( $property_type, $this->mSemanticTypeHooks ) &&
				isset( $this->mSemanticTypeHooks[$property_type][$is_list] ) ) {
				$funcArgs = array();
				$funcArgs[] = $cur_value;
				$funcArgs[] = $form_field->getInputName();
				$funcArgs[] = $form_field->isMandatory();
				$funcArgs[] = $form_field->isDisabled();
				$hook_values = $this->mSemanticTypeHooks[$property_type][$is_list];
				$other_args = $form_field->getArgumentsForInputCall( $hook_values[1] );
				$funcArgs[] = $other_args;
				$text = call_user_func_array( $hook_values[0], $funcArgs );
			} else { // Anything else.
				$other_args = $form_field->getArgumentsForInputCall();
				// Set default size for list inputs.
				if ( $form_field->isList() ) {
					if ( ! array_key_exists( 'size', $other_args ) ) {
						$other_args['size'] = 100;
					}
				}
				$text = SFTextInput::getHTML( $cur_value, $form_field->getInputName(), $form_field->isMandatory(), $form_field->isDisabled(), $other_args );
			}
		}
		return $text;
	}
}
