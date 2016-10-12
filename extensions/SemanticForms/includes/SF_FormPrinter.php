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
		// Only add these if the Semantic Maps extension is not
		// included.
		if ( !defined( 'SM_VERSION' ) ) {
			$this->registerInputType( 'SFGoogleMapsInput' );
			$this->registerInputType( 'SFOpenLayersInput' );
		}

		// All-purpose setup hook.
		wfRunHooks( 'sfFormPrinterSetup', array( $this ) );
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

	static function makePlaceholderInWikiText( $str ) {
		return '@replace_' . $str . '@';
	}

	static function makePlaceholderInFormHTML( $str ) {
		return '@insertHTML_' . $str . '@';
	}

	/**
	 * Creates the HTML for the inner table for every instance of a
	 * multiple-instance template in the form.
	 */
	function multipleTemplateInstanceTableHTML( $form_is_disabled, $mainText ) {
		global $sfgScriptPath;

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
	 * Creates the HTML for a single instance of a multiple-instance template;
	 * plus the end tags for the full multiple-instance HTML.
	 */
	function multipleTemplateInstanceHTML( $form_is_disabled, $all_instances_printed, &$section, $instance_num, $add_button_text ) {
		global $sfgTabIndex;

		if ( ! $all_instances_printed ) {
			// Add the character "a" onto the instance number of this input
			// in the form, to differentiate the inputs the form starts out
			// with from any inputs added by the Javascript.
			$section = str_replace( '[num]', "[{$instance_num}a]", $section );
			// @TODO - this replacement should be
			// case- and spacing-insensitive.
			// Also, keeping the "id=" attribute should not be
			// necessary; but currently it is, for "show on select".
			$section = preg_replace( '/ id="(.*)" /', ' id="$1" data-origID="$1" ', $section );

			$text = "\t\t" . Html::rawElement( 'div',
				array(
					// The "multipleTemplate" class is there for
					// backwards-compatibility with any custom CSS on people's
					// wikis before SF 2.0.9.
					'class' => "multipleTemplateInstance multipleTemplate"
				),
				$this->multipleTemplateInstanceTableHTML( $form_is_disabled, $section )
			) . "\n";

		} else { // if ( $all_instances_printed ) {
			// This is the last instance of this
			// template - print all the sections
			// necessary for adding additional
			// instances.
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
			if ( $form_is_disabled ) $attributes['disabled'] = true;
			$button = Html::input( null, Sanitizer::decodeCharReferences( $add_button_text ), 'button', $attributes );
			$text .= <<<END
	</div><!-- multipleTemplateList -->
		<p>$button</p>
		<div class="sfErrorMessages"></div>
	</div><!-- multipleTemplateWrapper -->
END;
		}
		return $text;
	}

	/**
	 * If the value passed in for a certain field, when a form is
	 * submitted, is an array, then it might be from a checkbox
	 * or date input - in that case, convert it into a string.
	 */
	function getStringFromPassedInArray( $value, $delimiter ) {
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
					if ( $wgAmericanDates == true ) {
						return "$month $year";
					} else {
						return "$year/$month";
					}
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

		// initialize some variables
		$sfgTabIndex = 1;
		$sfgFieldNum = 1;
		$source_page_matches_this_form = false;
		$form_page_title = null;
		$generated_page_name = $page_name_formula;
		// $form_is_partial is true if:
		// (a) 'partial' == 1 in the arguments
		// (b) 'partial form' is found in the form definition
		// in the latter case, it may remain false until close to the end of
		// the parsing, so we have to assume that it will become a possibility
		$form_is_partial = false;
		$new_text = "";
		// flag for placing "<onlyinclude>" tags in form output
		$onlyinclude_free_text = false;

		// If we have existing content and we're not in an active replacement
		// situation, preserve the original content. We do this because we want
		// to pass the original content on IF this is a partial form.
		// TODO: A better approach here would be to pass the revision ID of the
		// existing page content through the replace value, which would
		// minimize the html traffic and would allow us to do a concurrent
		// update check. For now, we pass it through a hidden text field.

		if ( ! $wgRequest->getCheck( 'partial' ) ) {
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
			$this->mPageTitle = Title::newFromText( 'RunQuery dummy title' );
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
			wfRunHooks( 'sfUserCanEditPage', array( $this->mPageTitle, &$userCanEditPage ) );
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
		$free_text_preload_page = null;
		$free_text_components = array();
		$all_values_for_template = array();
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
		$all_fields = array();
		$data_text = "";
		$template_name = "";
		$allow_multiple = false;
		$instance_num = 0;
		$all_instances_printed = false;
		$strict_parsing = false;

		// Placeholder name in the form
		$curPlaceholder = null;
		// Used to store the HTML code of the multiple template, to reinsert it into the right spot
		// This array will keep track of all the replaced @<name>@ strings
		$placeholderFields = array();

		for ( $section_num = 0; $section_num < count( $form_def_sections ); $section_num++ ) {
			$start_position = 0;
			$template_text = "";
			// the append is there to ensure that the original
			// array doesn't get modified; is it necessary?
			$section = " " . $form_def_sections[$section_num];


			$multipleTemplateString = "";

			while ( $brackets_loc = strpos( $section, '{{{', $start_position ) ) {
				$brackets_end_loc = strpos( $section, "}}}", $brackets_loc );
				$bracketed_string = substr( $section, $brackets_loc + 3, $brackets_end_loc - ( $brackets_loc + 3 ) );
				$tag_components = SFUtils::getFormTagComponents( $bracketed_string );
				$tag_title = trim( $tag_components[0] );
				// =====================================================
				// for template processing
				// =====================================================
				if ( $tag_title == 'for template' ) {
					$old_template_name = $template_name;
					$template_name = trim( $tag_components[1] );
					$tif = SFTemplateInForm::create( $template_name );
					$query_template_name = str_replace( ' ', '_', $template_name );
					$add_button_text = wfMessage( 'sf_formedit_addanother' )->text();
					$minimumInstances = null;
					$maximumInstances = null;
					// Also replace periods with underlines, since that's what
					// POST does to strings anyway.
					$query_template_name = str_replace( '.', '_', $query_template_name );
					// ...and escape apostrophes.
					// (Or don't.)
					//$query_template_name = str_replace( "'", "\'", $query_template_name );
					// Cycle through the other components.
					for ( $i = 2; $i < count( $tag_components ); $i++ ) {
						$component = $tag_components[$i];
						if ( $component == 'multiple' ) $allow_multiple = true;
						if ( $component == 'strict' ) $strict_parsing = true;
						$sub_components = array_map( 'trim', explode( '=', $component, 2 ) );
						if ( count( $sub_components ) == 2 ) {
							if ( $sub_components[0] == 'label' ) {
								$template_label = $sub_components[1];
							} elseif ( $sub_components[0] == 'minimum instances' ) {
								$minimumInstances = $sub_components[1];
							} elseif ( $sub_components[0] == 'maximum instances' ) {
								$maximumInstances = $sub_components[1];
							} elseif ( $sub_components[0] == 'add button text' ) {
								$add_button_text = $wgParser->recursiveTagParse( $sub_components[1] );
							} elseif ( $sub_components[0] == 'embed in field' ) {
								// Placeholder on form template level. Assume that the template form def
								// will have a multiple+placeholder parameters, and get the placeholder value.
								// We expect something like TemplateName[fieldName], and convert it to the
								// TemplateName___fieldName form used internally.
								preg_match( '/\s*(.*)\[(.*)\]\s*/', $sub_components[1], $matches );
								$curPlaceholder = ( count( $matches ) > 2 ) ? self::placeholderFormat( $matches[1], $matches[2] ) : null;
								unset( $matches );
							}
						}
					}
					// If this is the first instance, add
					// the label into the form, if there is
					// one, and add the appropriate wrapper
					// div, if this is a multiple-instance
					// template.
					if ( $old_template_name != $template_name ) {
						if ( isset( $template_label ) ) {
							$multipleTemplateString .= "<fieldset>\n";
							$multipleTemplateString .= Html::element( 'legend', null, $template_label ) . "\n";
						}
						// If $curPlaceholder is set, it means we want to insert a
						// multiple template form's HTML into the main form's HTML.
						// So, the HTML will be stored in $multipleTemplateString.
						if ( $allow_multiple ) {
							$multipleTemplateString .= "\t" . '<div class="multipleTemplateWrapper">' . "\n";
							$multipleTemplateString .= "\t" . '<div class="multipleTemplateList"';
							if ( !is_null( $minimumInstances ) ) {
								$multipleTemplateString .= " minimumInstances=\"$minimumInstances\"";
							}
							if ( !is_null( $maximumInstances ) ) {
								$multipleTemplateString .= " maximumInstances=\"$maximumInstances\"";
							}
							$multipleTemplateString .= ">\n";
						}
					}
					if ( $curPlaceholder == null ) {
						$form_text .= $multipleTemplateString;
					}
					$template_text .= "{{" . $template_name;
					$all_fields = $tif->getAllFields();
					// remove template tag
					$section = substr_replace( $section, '', $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
					$template_instance_query_values = $wgRequest->getArray( $query_template_name );
					// If we are editing a page, and this
					// template can be found more than
					// once in that page, and multiple
					// values are allowed, repeat this
					// section.
					$existing_template_text = null;
					if ( $source_is_page || $form_is_partial ) {
						// Replace underlines with spaces in template name, to allow for
						// searching on either.
						$search_template_str = str_replace( '_', ' ', $template_name );
						$preg_match_template_str = str_replace(
							array( '/', '(', ')', '^' ),
							array( '\/', '\(', '\)', '\^' ),
							$search_template_str );
						$found_instance = preg_match( '/{{' . $preg_match_template_str . '\s*[\|}]/i', str_replace( '_', ' ', $existing_page_content ) );
						if ( $allow_multiple ) {
							// Find instances of this template in the page -
							// if there's at least one, re-parse this section of the
							// definition form for the subsequent template instances in
							// this page; if there's none, don't include fields at all.
							// There has to be a more efficient way to handle multiple
							// instances of templates, one that doesn't involve re-parsing
							// the same tags, but I don't know what it is.
							// (Also add additional, blank instances if there's a minimum
							// number required in this form, and we haven't reached it yet.)
							if ( $found_instance || $instance_num < $minimumInstances ) {
								// Print another instance until we reach the minimum
								// instances, which is also the starting number.
							} else {
								$all_instances_printed = true;
							}
						}
						// get the first instance of this template on the page being edited,
						// even if there are more
						if ( $found_instance ) {
							$matches = array();
							$search_pattern = '/{{' . $preg_match_template_str . '\s*[\|}]/i';
							$content_str = str_replace( '_', ' ', $existing_page_content );
							preg_match( $search_pattern, $content_str, $matches, PREG_OFFSET_CAPTURE );
							// is this check necessary?
							if ( array_key_exists( 0, $matches ) && array_key_exists( 1, $matches[0] ) ) {
								$start_char = $matches[0][1];
								$fields_start_char = $start_char + 2 + strlen( $search_template_str );
								// Skip ahead to the first real character.
								while ( in_array( $existing_page_content[$fields_start_char], array( ' ', '\n' ) ) ) {
									$fields_start_char++;
								}
								// If the next character is a pipe, skip that too.
								if ( $existing_page_content[$fields_start_char] == '|' ) {
									$fields_start_char++;
								}
								$template_contents = array( '0' => '' );
								// Cycle through template call, splitting it up by pipes ('|'),
								// except when that pipe is part of a piped link.
								$field = "";
								$uncompleted_square_brackets = 0;
								$uncompleted_curly_brackets = 2;
								$template_ended = false;
								for ( $i = $fields_start_char; ! $template_ended && ( $i < strlen( $existing_page_content ) ); $i++ ) {
									$c = $existing_page_content[$i];
									if ( $c == '[' ) {
										$uncompleted_square_brackets++;
									} elseif ( $c == ']' && $uncompleted_square_brackets > 0 ) {
										$uncompleted_square_brackets--;
									} elseif ( $c == '{' ) {
										$uncompleted_curly_brackets++;
									} elseif ( $c == '}' && $uncompleted_curly_brackets > 0 ) {
										$uncompleted_curly_brackets--;
									}
									// handle an end to a field and/or template declaration
									$template_ended = ( $uncompleted_curly_brackets == 0 && $uncompleted_square_brackets == 0 );
									$field_ended = ( $c == '|' && $uncompleted_square_brackets == 0 && $uncompleted_curly_brackets <= 2 );
									if ( $template_ended || $field_ended ) {
										// if this was the last character in the template, remove
										// the closing curly brackets
										if ( $template_ended ) {
											$field = substr( $field, 0, - 1 );
										}
										// either there's an equals sign near the beginning or not -
										// handling is similar in either way; if there's no equals
										// sign, the index of this field becomes the key
										$sub_fields = explode( '=', $field, 2 );
										if ( count( $sub_fields ) > 1 ) {
											$template_contents[trim( $sub_fields[0] )] = trim( $sub_fields[1] );
										} else {
											$template_contents[] = trim( $sub_fields[0] );
										}
										$field = '';
									} else {
										$field .= $c;
									}
								}
								// If there are uncompleted opening brackets, the whole form will get messed up -
								// display a warning.
								// (If there are too many *closing* brackets, some template stuff will end up in
								// the "free text" field - which is bad, but it's harder for the code to detect
								// the problem - though hopefully, easier for users.)
								if ( $uncompleted_curly_brackets > 0 || $uncompleted_square_brackets > 0 ) {
									$form_text .= "\t" . '<div class="warningbox">' .
										wfMessage(
											'sf_formedit_mismatchedbrackets',
											$this->mPageTitle->getFullURL(
												array( 'action' => 'edit' )
											)
										)->text() .
										"</div>\n<br clear=\"both\" />\n";
								}
								$existing_template_text = substr( $existing_page_content, $start_char, $i - $start_char );
								// now remove this template from the text being edited
								// if this is a partial form, establish a new insertion point
								if ( $existing_page_content && $form_is_partial && $wgRequest->getCheck( 'partial' ) ) {
									// if something already exists, set the new insertion point
									// to its position; otherwise just let it lie
									if ( strpos( $existing_page_content, $existing_template_text ) !== false ) {
										$existing_page_content = str_replace( '{{{insertionpoint}}}', '', $existing_page_content );
										$existing_page_content = str_replace( $existing_template_text, '{{{insertionpoint}}}', $existing_page_content );
									}
								} else {
									$existing_page_content = $this->strReplaceFirst( $existing_template_text, '', $existing_page_content );
								}
								// If this is not a multiple-instance template, and we've found
								// a match in the source page, there's a good chance that this
								// page was created with this form - note that, so we don't
								// send the user a warning
								// (multiple-instance templates have a greater chance of
								// getting repeated from one form to the next)
								// - on second thought, allow even the presence of multiple-
								// instance templates to validate that this is the correct
								// form: the problem is that some forms contain *only* mutliple-
								// instance templates.
								// if (! $allow_multiple) {
								$source_page_matches_this_form = true;
								// }
							}
						}
					}
					// If the input is from the form (meaning the user has hit one
					// of the bottom row of buttons), and we're dealing with a
					// multiple template, get the values for this instance of this
					// template, then delete them from the array, so we can get the
					// next group next time - the next() command for arrays doesn't
					// seem to work here.
					// @TODO - This is currently called regardless of whether the
					// input is from the form; the $wgRequest check doesn't do
					// anything. Is that a problem?
					if ( ( ! $source_is_page ) && $allow_multiple && $wgRequest ) {
						if ( $instance_num < $minimumInstances ) {
							// Print another instance until we reach the minimum
							// instances, which is also the starting number.
						} else {
							$all_instances_printed = true;
						}
						if ( $old_template_name != $template_name ) {
							$all_values_for_template = $wgRequest->getArray( $query_template_name );
						}
						if ( $all_values_for_template ) {
							$cur_key = key( $all_values_for_template );
							// skip the input coming in from the "starter" div
							// TODO: this code is probably no longer necessary
							if ( $cur_key == 'num' ) {
								unset( $all_values_for_template[$cur_key] );
								$cur_key = key( $all_values_for_template );
							}
							if ( $template_instance_query_values = current( $all_values_for_template ) ) {
								$all_instances_printed = false;
								unset( $all_values_for_template[$cur_key] );
							}
						}
					}
				// =====================================================
				// end template processing
				// =====================================================
				} elseif ( $tag_title == 'end template' ) {
					if ( $source_is_page ) {
						// Add any unhandled template fields in the page as hidden variables.
						if ( isset( $template_contents ) ) {
							$form_text .= SFFormUtils::unhandledFieldsHTML( $template_name, $template_contents );
							$template_contents = null;
						}
					}
					// Remove this tag, reset some variables, and close off form HTML tag.
					$section = substr_replace( $section, '', $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
					$template_name = null;
					if ( isset( $template_label ) && $curPlaceholder == null ) {
						$form_text .= "</fieldset>\n";
						unset ( $template_label );
					}
					$allow_multiple = false;
					$all_instances_printed = false;
					$instance_num = 0;
				// =====================================================
				// field processing
				// =====================================================
				} elseif ( $tag_title == 'field' ) {
					$field_name = trim( $tag_components[1] );
					$fullFieldName = $template_name . '[' . $field_name . ']';
					// cycle through the other components
					$is_mandatory = false;
					$is_hidden = false;
					$is_restricted = false;
					$is_uploadable = false;
					$is_list = false;
					$delimiter = null;
					$input_type = null;
					$field_args = array();
					$show_on_select = array();
					$default_value = null;
					$values = null;
					$possible_values = null;
					$semantic_property = null;
					$cargo_table = null;
					$cargo_field = null;
					$fullCargoField = null;
					$preload_page = null;
					$holds_template = false;

					for ( $i = 2; $i < count( $tag_components ); $i++ ) {

						$component = trim( $tag_components[$i] );

						if ( $component == 'mandatory' ) {
							$is_mandatory = true;
						} elseif ( $component == 'hidden' ) {
							$is_hidden = true;
						} elseif ( $component == 'restricted' ) {
							$is_restricted = ( ! $wgUser || ! $wgUser->isAllowed( 'editrestrictedfields' ) );
						} elseif ( $component == 'list' ) {
							$is_list = true;
						} elseif ( $component == 'unique' ) {
							$field_args['unique'] = true;
						} elseif ( $component == 'edittools' ) { // free text only
							$free_text_components[] = 'edittools';
						}

						$sub_components = array_map( 'trim', explode( '=', $component, 2 ) );

						if ( count( $sub_components ) == 1 ) {
							// add handling for single-value params, for custom input types
							$field_args[$sub_components[0]] = true;

							if ( $component == 'holds template' ) {
								$is_hidden = true;
								$holds_template = true;
								$placeholderFields[] = self::placeholderFormat( $template_name, $field_name );
							}
						} elseif ( count( $sub_components ) == 2 ) {
							// First, set each value as its own entry in $field_args.
							$field_args[$sub_components[0]] = $sub_components[1];

							// Then, do all special handling.
							if ( $sub_components[0] == 'input type' ) {
								$input_type = $sub_components[1];
							} elseif ( $sub_components[0] == 'default' ) {
								$default_value = $wgParser->recursiveTagParse( $sub_components[1] );
							} elseif ( $sub_components[0] == 'preload' ) {
								// free text field has special handling
								if ( $field_name == 'free text' || $field_name == '<freetext>' ) {
									$free_text_preload_page = $sub_components[1];
								} else {
									$preload_page = $sub_components[1];
								}
							} elseif ( $sub_components[0] == 'show on select' ) {
								// html_entity_decode() is needed to turn '&gt;' to '>'
								$vals = explode( ';', html_entity_decode( $sub_components[1] ) );
								foreach ( $vals as $val ) {
									$val = trim( $val );
									if ( empty( $val ) )
										continue;
									$option_div_pair = explode( '=>', $val, 2 );
									if ( count( $option_div_pair ) > 1 ) {
										$option = $option_div_pair[0];
										$div_id = $option_div_pair[1];
										if ( array_key_exists( $div_id, $show_on_select ) )
											$show_on_select[$div_id][] = $option;
										else
											$show_on_select[$div_id] = array( $option );
									} else {
										$show_on_select[$val] = array();
									}
								}
							} elseif ( $sub_components[0] == 'autocomplete on property' ) {
								$field_args['autocomplete field type'] = 'property';
								$field_args['autocompletion source'] = $sub_components[1];
							} elseif ( $sub_components[0] == 'autocomplete on category' ) {
								$field_args['autocomplete field type'] = 'category';
								$field_args['autocompletion source'] = $sub_components[1];
							} elseif ( $sub_components[0] == 'autocomplete on concept' ) {
								$field_args['autocomplete field type'] = 'concept';
								$field_args['autocompletion source'] = $sub_components[1];
							} elseif ( $sub_components[0] == 'autocomplete on namespace' ) {
								$field_args['autocomplete field type'] = 'namespace';
								$autocompletion_source = $sub_components[1];
								// special handling for "main" (blank) namespace
								if ( $autocompletion_source == "" )
									$autocompletion_source = "main";
								$field_args['autocompletion source'] = $autocompletion_source;
							} elseif ( $sub_components[0] == 'autocomplete from url' ) {
								$field_args['autocomplete field type'] = 'external_url';
								$field_args['autocompletion source'] = $sub_components[1];
								// 'external' autocompletion is always done remotely, i.e. via API
								$field_args['remote autocompletion'] = true;
							} elseif ( $sub_components[0] == 'values' ) {
								// Handle this one only after 'delimiter' has
								// also been set.
								$values = $wgParser->recursiveTagParse( $sub_components[1] );
							} elseif ( $sub_components[0] == 'values from property' ) {
								$propertyName = $sub_components[1];
								$possible_values = SFUtils::getAllValuesForProperty( $propertyName );
							} elseif ( $sub_components[0] == 'values from query' ) {
								$pages = SFUtils::getAllPagesForQuery( $sub_components[1] );
								foreach ( $pages as $page ) {
									$page_name_for_values = $page->getDbKey();
									$possible_values[] = $page_name_for_values;
								}
							} elseif ( $sub_components[0] == 'values from category' ) {
								$category_name = ucfirst( $sub_components[1] );
								$possible_values = SFUtils::getAllPagesForCategory( $category_name, 10 );
							} elseif ( $sub_components[0] == 'values from concept' ) {
								$possible_values = SFUtils::getAllPagesForConcept( $sub_components[1] );
							} elseif ( $sub_components[0] == 'values from namespace' ) {
								$possible_values = SFUtils::getAllPagesForNamespace( $sub_components[1] );
							} elseif ( $sub_components[0] == 'values dependent on' ) {
								global $sfgDependentFields;
								$sfgDependentFields[] = array( $sub_components[1], $fullFieldName );
							} elseif ( $sub_components[0] == 'unique for category' ) {
								$field_args['unique'] = true;
								$field_args['unique_for_category'] = $sub_components[1];
							} elseif ( $sub_components[0] == 'unique for namespace' ) {
								$field_args['unique'] = true;
								$field_args['unique_for_namespace'] = $sub_components[1];
							} elseif ( $sub_components[0] == 'unique for concept' ) {
								$field_args['unique'] = true;
								$field_args['unique_for_concept'] = $sub_components[1];
							} elseif ( $sub_components[0] == 'property' ) {
								$semantic_property = $sub_components[1];
							} elseif ( $sub_components[0] == 'cargo table' ) {
								$cargo_table = $sub_components[1];
							} elseif ( $sub_components[0] == 'cargo field' ) {
								$cargo_field = $sub_components[1];
							} elseif ( $sub_components[0] == 'default filename' ) {
								$default_filename = str_replace( '&lt;page name&gt;', $page_name, $sub_components[1] );
								// Parse value, so default filename can include parser functions.
								$default_filename = $wgParser->recursiveTagParse( $default_filename );
								$field_args['default filename'] = $default_filename;
							} elseif ( $sub_components[0] == 'restricted' ) {
								$is_restricted = !array_intersect(
									$wgUser->getEffectiveGroups(), array_map( 'trim', explode( ',', $sub_components[1] ) )
								);
							}
						}
					} // end for

					// If we're using Cargo, there's no
					// equivalent for "values from property"
					// - instead, we just always get the
					// values if a field and table have
					// been specified.
					if ( is_null( $possible_values ) && defined( 'CARGO_VERSION' ) && $cargo_table != null && $cargo_field != null ) {
						$possible_values = SFUtils::getAllValuesForCargoField( $cargo_table, $cargo_field );
					}

					if ( !is_null( $possible_values ) && array_key_exists( 'mapping template', $field_args ) ) {
						$possible_values = SFUtils::getLabels( $possible_values, $field_args['mapping template'] );
					}
					// Backwards compatibility
					if ( $input_type == 'datetime with timezone' ) {
						$input_type = 'datetime';
						$field_args['include timezone'] = true;
					} elseif ( $input_type == 'text' || $input_type == 'textarea' ) {
						// Also for backwards compatibility,
						// in that once b/c goes away,
						// this will no longer be
						// necessary.
						$field_args['no autocomplete'] = true;
					}
					if ( $allow_multiple ) {
						$field_args['part_of_multiple'] = $allow_multiple;
					}
					if ( count( $show_on_select ) > 0 ) {
						$field_args['show on select'] = $show_on_select;
					}
					if ( array_key_exists( 'delimiter', $field_args ) ) {
						$delimiter = $field_args['delimiter'];
					} else {
						$delimiter = ",";
					}

					// Get the value from the request, if
					// it's there, and if it's not an array.
					$cur_value = null;
					$escaped_field_name = str_replace( "'", "\'", $field_name );
					if ( isset( $template_instance_query_values ) &&
						$template_instance_query_values != null &&
						is_array( $template_instance_query_values ) ) {
						// If the field name contains an
						// apostrophe, the array sometimes
						// has the apostrophe escaped, and
						// sometimes not. For now, just check
						// for both versions.
						// @TODO - figure this out.
						$field_query_val = null;
						if ( array_key_exists( $escaped_field_name, $template_instance_query_values ) ) {
							$field_query_val = $template_instance_query_values[$escaped_field_name];
						} elseif ( array_key_exists( $field_name, $template_instance_query_values ) ) {
							$field_query_val = $template_instance_query_values[$field_name];
						}
						if ( $form_submitted && $field_query_val != '' ) {
							$mapping_template = null;
							if ( array_key_exists( 'mapping_template', $template_instance_query_values ) &&
								array_key_exists( $field_name, $template_instance_query_values['mapping_template'] ) ) {
								$mapping_template = $template_instance_query_values['mapping_template'][$field_name];
							}
							if ( is_array( $field_query_val ) ) {
								$cur_values = array();
								if ( !is_null( $mapping_template ) && !is_null( $possible_values ) ) {
									$cur_values = array();
									foreach ( $field_query_val as $key => $val ) {
										$val = trim( $val );
										if ( $key === 'is_list' ) {
											$cur_values[$key] = $val;
										} else {
											$cur_values[] = SFUtils::labelToValue( $val, $possible_values, $mapping_template );
										}
									}
								} else {
									foreach ( $field_query_val as $key => $val ) {
										$cur_values[$key] = $val;
									}
								}
								$cur_value = $this->getStringFromPassedInArray( $cur_values, $delimiter );
							} else {
								$field_query_val = trim( $field_query_val );
								if ( !is_null( $mapping_template ) && !is_null( $possible_values ) ) {
									// this should be replaced with an input type neutral way of
									// figuring out if this scalar input type is a list
									if ( $input_type == "tokens" ) {
										$is_list = true;
									}
									if ( $is_list ) {
										$cur_values = array_map( 'trim', explode( $delimiter, $field_query_val ) );
										foreach ( $cur_values as $key => $value ) {
											$cur_values[$key] = SFUtils::labelToValue( $value, $possible_values, $mapping_template );
										}
										$cur_value = implode( $delimiter, $cur_values );
									} else {
										$cur_value = SFUtils::labelToValue( $field_query_val, $possible_values, $mapping_template );
									}
								} else {
									$cur_value = $field_query_val;
								}
							}
						}
						if ( !$form_submitted && $field_query_val != '' ) {
							if ( is_array( $field_query_val ) ) {
								$cur_value = $this->getStringFromPassedInArray( $field_query_val, $delimiter );
							} else {
								$cur_value = $field_query_val;
							}
						}
					}

					if ( empty( $cur_value ) && !$form_submitted ) {
						if ( !is_null( $default_value ) ) {
							// Set to the default value specified in the form, if it's there.
							$cur_value = $default_value;
						} elseif ( $preload_page ) {
							$cur_value = SFFormUtils::getPreloadedText( $preload_page );
						}
					}

					// If the user is editing a page, and that page contains a call to
					// the template being processed, get the current field's value
					// from the template call
					if ( $source_is_page && ( ! empty( $existing_template_text ) ) ) {
						if ( isset( $template_contents[$field_name] ) ) {
							$cur_value = $template_contents[$field_name];

							// If the field is a placeholder, the contents of this template
							// parameter should be treated as elements parsed by an another
							// multiple template form.
							// By putting that at the very end of the parsed string, we'll
							// have it processed as a regular multiple template form.
							if ( $holds_template ) {
								$existing_page_content = $existing_page_content . $cur_value;
							}

							// Now remove this value
							// from $template_contents,
							// so that at the end we
							// can have a list of all
							// the fields that weren't
							// handled by the form.
							unset( $template_contents[$field_name] );
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
						if ( $is_hidden ) {
							$new_text = Html::hidden( 'sf_free_text', '!free_text!' );
						} else {
							$sfgTabIndex++;
							$sfgFieldNum++;
							if ( $cur_value === '' || is_null( $cur_value ) ) {
								$default_value = '!free_text!';
							} else {
								$default_value = $cur_value;
							}
							$new_text = SFTextAreaInput::getHTML( $default_value, 'sf_free_text', false, ( $form_is_disabled || $is_restricted ), $field_args );
							if ( in_array( 'edittools', $free_text_components ) ) {
								// borrowed from EditPage::showEditTools()
								$options[] = 'parse';
								$edittools_text = $wgParser->recursiveTagParse( wfMessage( 'edittools', array( 'content' ) )->text() );

								$new_text .= <<<END
		<div class="mw-editTools">
		$edittools_text
		</div>

END;
							}
						}
						$free_text_was_included = true;
						// add a similar placeholder to the data text
						$data_text .= "!free_text!\n";
					}

					if ( $template_name === '' || $field_name == '<freetext>' ) {
						$section = substr_replace( $section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
					} else {
						if ( is_array( $cur_value ) ) {
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
								$cur_value_in_template = $this->getStringFromPassedInArray( $cur_value, $delimiter );
							}
						} else { // value is not an array
							$cur_value_in_template = $cur_value;
						}
						if ( $template_name == null || $template_name === '' ) {
							$input_name = $field_name;
						} elseif ( $allow_multiple ) {
							// 'num' will get replaced by an actual index, either in PHP
							// or in Javascript, later on
							$input_name = $template_name . '[num][' . $field_name . ']';
							$field_args['origName'] = $template_name . '[' . $field_name . ']';
						} else {
							$input_name = $template_name . '[' . $field_name . ']';
						}


						// If the 'values' parameter was set, separate it based on the
						// 'delimiter' parameter, if any.
						if ( ! empty( $values ) ) {
							// Remove whitespaces, and un-escape characters
							$possible_values = array_map( 'trim', explode( $delimiter, $values ) );
							$possible_values = array_map( 'htmlspecialchars_decode', $possible_values );
						}

						// if we're creating the page name from a formula based on
						// form values, see if the current input is part of that formula,
						// and if so, substitute in the actual value
						if ( $form_submitted && $generated_page_name !== '' ) {
							// this line appears to be unnecessary
							// $generated_page_name = str_replace('.', '_', $generated_page_name);
							$generated_page_name = str_replace( ' ', '_', $generated_page_name );
							$escaped_input_name = str_replace( ' ', '_', $input_name );
							$generated_page_name = str_ireplace( "<$escaped_input_name>", $cur_value_in_template, $generated_page_name );
							// once the substitution is done, replace underlines back
							// with spaces
							$generated_page_name = str_replace( '_', ' ', $generated_page_name );
						}
						// disable this field if either the whole form is disabled, or
						// it's a restricted field and user doesn't have sysop privileges
						$is_disabled = ( $form_is_disabled || $is_restricted );
						// Create an SFFormField instance based on all the parameters
						// in the form definition, and any information from the template
						// definition (contained in the $all_fields parameter).
						$form_field = SFFormField::createFromDefinition( $field_name,
							$input_name, $is_mandatory, $is_hidden, $is_uploadable,
							$possible_values, $is_disabled, $is_list, $input_type,
							$field_args, $all_fields, $strict_parsing );

						// Do some data storage specific to the Semantic MediaWiki and
						// Cargo extensions.
						if ( defined( 'SMW_VERSION' ) ) {
							// If a property was set in the form definition, overwrite whatever
							// is set in the template field - this is somewhat of a hack, since
							// parameters set in the form definition are meant to go into the
							// SFFormField object, not the SFTemplateField object it contains;
							// it seemed like too much work, though, to create an
							// SFFormField::setSemanticProperty() function just for this call.
							if ( $semantic_property != null ) {
								$form_field->template_field->setSemanticProperty( $semantic_property );
							}
							$semantic_property = $form_field->template_field->getSemanticProperty();
							if ( !is_null( $semantic_property ) ) {
								global $sfgFieldProperties;
								$sfgFieldProperties[$fullFieldName] = $semantic_property;
							}
						}
						if ( defined( 'CARGO_VERSION' ) ) {
							if ( $cargo_table != null && $cargo_field != null ) {
								$form_field->template_field->setCargoFieldData( $cargo_table, $cargo_field );
							}
							$fullCargoField = $form_field->template_field->getFullCargoField();
							if ( !is_null( $fullCargoField ) ) {
								global $sfgCargoFields;
								$sfgCargoFields[$fullFieldName] = $fullCargoField;
							}
						}

						// call hooks - unfortunately this has to be split into two
						// separate calls, because of the different variable names in
						// each case
						if ( $form_submitted ) {
							wfRunHooks( 'sfCreateFormField', array( &$form_field, &$cur_value_in_template, true ) );
						} else {
							if ( !empty( $cur_value ) && array_key_exists( 'mapping template', $field_args ) ) {
								$cur_value = SFUtils::valuesToLabels( $cur_value, $field_args['mapping template'], $delimiter, $possible_values );
							}
							wfRunHooks( 'sfCreateFormField', array( &$form_field, &$cur_value, false ) );
						}
						// if this is not part of a 'multiple' template, increment the
						// global tab index (used for correct tabbing)
						if ( ! array_key_exists( 'part_of_multiple', $field_args ) ) {
							$sfgTabIndex++;
						}
						// increment the global field number regardless
						$sfgFieldNum++;
						// If the field is a date field, and its default value was set
						// to 'now', and it has no current value, set $cur_value to be
						// the current date.
						if ( $default_value == 'now' &&
								// if the date is hidden, cur_value will already be set
								// to the default value
								( $cur_value == '' || $cur_value == 'now' ) ) {
							if ( $input_type == 'date' || $input_type == 'datetime' ||
									$input_type == 'year' ||
									( $input_type == '' && $form_field->getTemplateField()->getPropertyType() == '_dat' ) ) {
								// Get current time, for the time zone specified in the wiki.
								global $wgLocaltimezone;
								if ( isset( $wgLocaltimezone ) ) {
									$serverTimezone = date_default_timezone_get();
									date_default_timezone_set( $wgLocaltimezone );
								}
								$cur_time = time();
								$year = date( "Y", $cur_time );
								$month = date( "n", $cur_time );
								$day = date( "j", $cur_time );
								global $wgAmericanDates, $sfg24HourTime;
								if ( $wgAmericanDates == true ) {
									$month_names = SFFormUtils::getMonthNames();
									$month_name = $month_names[$month - 1];
									$cur_value_in_template = "$month_name $day, $year";
								} else {
									$cur_value_in_template = "$year/$month/$day";
								}
								if ( isset( $wgLocaltimezone ) ) {
									date_default_timezone_set( $serverTimezone );
								}
								if ( $input_type ==	'datetime' ) {
									if ( $sfg24HourTime ) {
										$hour = str_pad( intval( substr( date( "G", $cur_time ), 0, 2 ) ), 2, '0', STR_PAD_LEFT );
									} else {
										$hour = str_pad( intval( substr( date( "g", $cur_time ), 0, 2 ) ), 2, '0', STR_PAD_LEFT );
									}
									$minute = str_pad( intval( substr( date( "i", $cur_time ), 0, 2 ) ), 2, '0', STR_PAD_LEFT );
									$second = str_pad( intval( substr( date( "s", $cur_time ), 0, 2 ) ), 2, '0', STR_PAD_LEFT );
									if ( $sfg24HourTime ) {
										$cur_value_in_template .= " $hour:$minute:$second";
									} else {
										$ampm = date( "A", $cur_time );
										$cur_value_in_template .= " $hour:$minute:$second $ampm";
									}
								}
								if ( array_key_exists( 'include timezone', $field_args ) ) {
									$timezone = date( "T", $cur_time );
									$cur_value_in_template .= " $timezone";
								}
							}
						}
						// If the field is a text field, and its default value was set
						// to 'current user', and it has no current value, set $cur_value
						// to be the current user.
						if ( $default_value == 'current user' &&
							// if the date is hidden, cur_value will already be set
							// to the default value
							( $cur_value === '' || $cur_value == 'current user' ) ) {

							$cur_value_in_template = $wgUser->getName();
							$cur_value = $cur_value_in_template;
						}

						// Generate a hidden field with a placeholder value that will be replaced
						// by the multiple-instances template output at form submission.
						//// <input type="hidden" value="@replace_Town___mayors@" name="Town[town_mayors]" />
						if ( $holds_template ) {
							$cur_value = self::makePlaceholderInWikiText( self::placeholderFormat( $template_name, $field_name ) );
						}

						$new_text = $this->formFieldHTML( $form_field, $cur_value );

						// Add a field just after the hidden field, within the HTML, to locate
						// where the multiple-templates HTML, stored in $multipleTemplateString,
						// should be inserted.
						if ( $holds_template ) {
							$new_text .= self::makePlaceholderInFormHTML( self::placeholderFormat( $template_name, $field_name ) );
						}

						// If this field is disabled, add a hidden field holding
						// the value of this field, because disabled inputs for some
						// reason don't submit their value.
						if ( $form_field->isDisabled() ) {
							if ( $field_name == 'free text' || $field_name == '<freetext>' ) {
								$new_text .= Html::hidden( 'sf_free_text', '!free_text!' );
							} else {
								if ( is_array( $cur_value ) ) {
									$new_text .= Html::hidden( $input_name, implode( $delimiter, $cur_value ) );
								} else {
									$new_text .= Html::hidden( $input_name, $cur_value );
								}
							}
						}

						if ( array_key_exists( 'mapping template', $field_args ) ) {
							if ( $allow_multiple ) {
								$new_text .= Html::hidden( $template_name . '[num][mapping_template][' . $field_name . ']', $field_args['mapping template'] );
							} else {
								$new_text .= Html::hidden( $template_name . '[mapping_template][' . $field_name . ']', $field_args['mapping template'] );
							}
						}

						if ( array_key_exists( 'unique', $field_args ) ) {
							if ( $semantic_property != null ) {
								$new_text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_property', $semantic_property );
							}
							if ( $fullCargoField != null ) {
								// It's inefficient to get these values via
								// text parsing, but oh well.
								list( $cargo_table, $cargo_field ) = explode( '|', $fullCargoField, 2 );
								$new_text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_cargo_table', $cargo_table );
								$new_text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_cargo_field', $cargo_field );
							}
							if ( array_key_exists( 'unique_for_category', $field_args ) ) {
								$new_text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_for_category', $field_args['unique_for_category'] );
							}
							if ( array_key_exists( 'unique_for_namespace', $field_args ) ) {
								$new_text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_for_namespace', $field_args['unique_for_namespace'] );
							}
							if ( array_key_exists( 'unique_for_concept', $field_args ) ) {
								$new_text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_for_concept', $field_args['unique_for_concept'] );
							}
						}

						if ( $new_text ) {
							// Include the field name only for non-numeric field names.
							if ( is_numeric( $field_name ) ) {
								$template_text .= "|$cur_value_in_template";
							} else {
								// If the value is null, don't include it at all.
								if ( $cur_value_in_template != '' ) {
									$template_text .= "\n|$field_name=$cur_value_in_template";
								}
							}
							$section = substr_replace( $section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
						} else {
							$start_position = $brackets_end_loc;
						}
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
							if ( $sub_components[0] == 'edittools' ) {
								$free_text_components[] = 'edittools';
							} elseif ( $sub_components[0] == 'checked' ) {
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
							// free text input needs more handling than the rest
							if ( $input_name == 'free text' || $input_name == '<freetext>' ) {
								if ( $sub_components[0] == 'preload' ) {
									$free_text_preload_page = $sub_components[1];
								}
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
					$section_name = trim( $tag_components[1] );
					$is_mandatory = false;
					$is_hidden = false;
					$is_restricted = false;
					$header_level = 2;
					$other_args = array();

					// cycle through the other components
					for ( $i = 2; $i < count( $tag_components ); $i++ ) {

						$component = trim( $tag_components[$i] );

						if ( $component === 'mandatory' ) {
							$is_mandatory = true;
						} elseif ( $component === 'hidden' ) {
							$is_hidden = true;
						} elseif ( $component === 'restricted' ) {
							$is_restricted = !( $wgUser && $wgUser->isAllowed( 'editrestrictedfields' ) );
						} elseif ( $component === 'autogrow' ) {
							$other_args['autogrow'] = true;
						}

						$sub_components = array_map( 'trim', explode( '=', $component, 2 ) );

						if ( count( $sub_components ) === 2 ) {
							switch ( $sub_components[0] ) {
							case 'level':
								$header_level = $sub_components[1];
								break;
							case 'rows':
							case 'cols':
							case 'class':
							case 'editor':
								$other_args[$sub_components[0]] = $sub_components[1];
								break;
							default:
								// Ignore unknown
							}
						}
					}

					// Generate the wikitext for the section header
					$header_string = str_repeat( "=", $header_level );
					$header_text = $header_string . $section_name . $header_string . "\n";
					$data_text .= $header_text;

					// split the existing page contents into the textareas in the form
					$default_value = "";
					$section_start_loc = 0;
					if ( $source_is_page && $existing_page_content !== null ) {

						$section_start_loc = strpos( $existing_page_content, $header_text );
						$existing_page_content = str_replace( $header_text, '', $existing_page_content );
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
								if ( preg_match( '/(^={1,6}' . $tag_components_next_section[1] . '?={1,6}\s*?$)/m', $existing_page_content, $matches, PREG_OFFSET_CAPTURE ) ) {
									$section_end_loc = $matches[0][1];
								}
							}
						}

						if ( $section_end_loc === -1 ) {
							$default_value = $existing_page_content;
							$existing_page_content = '';
						} else {
							$default_value = substr( $existing_page_content, $section_start_loc, $section_end_loc - $section_start_loc );
							$existing_page_content = substr( $existing_page_content, $section_end_loc );
						}
					}

					//if input is from the form
					$section_text = "";
					if ( ( ! $source_is_page ) && $wgRequest ) {
						$section_text = $wgRequest->getArray( '_section' );
						$default_value = $section_text[trim( $section_name )];

						if ( $default_value == "" || $default_value == null ) {
							$data_text .= $default_value . "\n\n";
						} else {
							$data_text .= rtrim( $default_value ) . "\n\n";
						}
					}

					//set input name for query string
					$input_name = '_section' . '[' . trim( $section_name ) . ']';
					if ( $is_mandatory ) {
						$other_args['mandatory'] = true;
					}

					if ( $is_hidden ) {
						$form_section_text = Html::hidden( $input_name, $default_value );
					} else {
						$form_section_text = SFTextAreaInput::getHTML( $default_value, $input_name, false, ( $form_is_disabled || $is_restricted ), $other_args );
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
							$onlyinclude_free_text = true;
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

			if ( ! $all_instances_printed ) {
				if ( $template_text !== '' ) {
					// For mostly aesthetic purposes, if the template call ends with
					// a bunch of pipes (i.e., it's an indexed template with unused
					// parameters at the end), remove the pipes.
					$template_text = preg_replace( '/\|*$/', '', $template_text );
					// add another newline before the final bracket, if this template
					// call is already more than one line
					if ( strpos( $template_text, "\n" ) ) {
						$template_text .= "\n";
					}
					// If we're editing an existing page, and there were fields in
					// the template call not handled by this form, preserve those.
					if ( !$allow_multiple ) {
						$template_text .= SFFormUtils::addUnhandledFields( $template_name );
					}
					$template_text .= "}}";

					// The base $template_text will contain strings like "@replace_xxx@"
					// in the hidden fields when the form is submitted.
					// On the following loops, the text for the multiple-instance templates
					// is progressively reinserted in the main data, always keeping a
					// trailing @replace_xxx@ for a given field
					// The trailing @replace_xxx@ is then deleted at the end.
					// Note: this cleanup step could also be done with a regexp, instead of
					// keeping a track array (e.g., /@replace_(.*)@/)
					$reptmp = self::makePlaceholderInWikiText( $curPlaceholder );
					if ( $curPlaceholder != null && $data_text && strpos( $data_text, $reptmp, 0 ) !== false ) {
						// Escape $template_text, because values like $1 cause problems
						// for preg_replace().
						$escaped_template_text = str_replace( '$', '\$', $template_text );
						$data_text = preg_replace( '/' . $reptmp . '/', $escaped_template_text . $reptmp, $data_text );
					} else {
						$data_text .= $template_text . "\n";
					}

					// If there is a placeholder in the
					// text, we know that we are
					// doing a replace.
					if ( $existing_page_content && strpos( $existing_page_content, '{{{insertionpoint}}}', 0 ) !== false ) {
						$existing_page_content = preg_replace( '/\{\{\{insertionpoint\}\}\}(\r?\n?)/',
							preg_replace( '/\}\}/m', '}�',
								preg_replace( '/\{\{/m', '�{', $template_text ) ) .
							"\n{{{insertionpoint}}}",
							$existing_page_content );
					// otherwise, if it's a partial form, we have to add the new
					// text somewhere
					} elseif ( $form_is_partial && $wgRequest->getCheck( 'partial' ) ) {
						$existing_page_content = preg_replace( '/\}\}/m', '}�',
							preg_replace( '/\{\{/m', '�{', $template_text ) ) .
								"\n{{{insertionpoint}}}\n" . $existing_page_content;
					}
				}
			}

			if ( $allow_multiple ) {
				if ( $curPlaceholder == null ) {
					// The normal process.
					$form_text .= $this->multipleTemplateInstanceHTML( $form_is_disabled, $all_instances_printed, $section, $instance_num, $add_button_text );
				} else { // if ( $curPlaceholder != null ){
					// The template text won't be appended at the end of the template like for usual multiple template forms.
					// The HTML text will then be stored in the $multipleTemplateString variable,
					// and then added in the right @insertHTML_".$placeHolderField."@"; position
					// Optimization: actually, instead of separating the processes, the usual multiple
					// template forms could also be handled this way if a fitting placeholder tag was added.
					$multipleTemplateString .= $this->multipleTemplateInstanceHTML( $form_is_disabled, $all_instances_printed, $section, $instance_num, $add_button_text );
					// We replace the $multipleTemplateString HTML into the
					// current placeholder tag, but also add another
					// placeholder tag, to keep track of it.
					$multipleTemplateString .= self::makePlaceholderInFormHTML( $curPlaceholder );
					if ( isset( $template_label ) ) {
						$multipleTemplateString .= "</fieldset>\n";
						unset ( $template_label );
					}
					$escapedMultipleTemplateString = str_replace( '$', '\$', $multipleTemplateString );
					$form_text = preg_replace( '/' . self::makePlaceholderInFormHTML( $curPlaceholder ) . '/',
						$escapedMultipleTemplateString, $form_text );
				}
				if ( ! $all_instances_printed ) {
					// This will cause the section to be
					// re-parsed on the next go.
					$section_num--;
					$instance_num++;
				}
			} else {
				$form_text .= $section;
			}
			$curPlaceholder = null;
		} // end for

		// Cleanup - everything has been browsed.
		// Remove all the remaining placeholder
		// tags in the HTML and wiki-text.

		foreach ( $placeholderFields as $stringToReplace ) {
			// remove the @<replacename>@ tags from the data that is submitted
			$data_text = preg_replace( '/' . self::makePlaceholderInWikiText( $stringToReplace ) . '/', '', $data_text );

			// remove the @<insertHTML>@ tags from the generated HTML form
			$form_text = preg_replace( '/' . self::makePlaceholderInFormHTML( $stringToReplace ) . '/', '', $form_text );
		}

		// if it wasn't included in the form definition, add the
		// 'free text' input as a hidden field at the bottom
		if ( ! $free_text_was_included ) {
			$form_text .= Html::hidden( 'sf_free_text', '!free_text!' );
		}
		// Get free text, and add to page data, as well as retroactively
		// inserting it into the form.

		// If $form_is_partial is true then either:
		// (a) we're processing a replacement (param 'partial' == 1)
		// (b) we're sending out something to be replaced (param 'partial' is missing)
		if ( $form_is_partial ) {
			if ( !$wgRequest->getCheck( 'partial' ) ) {
				$free_text = $original_page_content;
			} else {
				$free_text = null;
				$existing_page_content = preg_replace( array( '/�\{/m', '/\}�/m' ),
					array( '{{', '}}' ),
					$existing_page_content );
				$existing_page_content = preg_replace( '/\{\{\{insertionpoint\}\}\}/', '', $existing_page_content );
			}
			$form_text .= Html::hidden( 'partial', 1 );
		} elseif ( $source_is_page ) {
			// if the page is the source, free_text will just be whatever in the
			// page hasn't already been inserted into the form
			$free_text = trim( $existing_page_content );
		// or get it from a form submission
		} elseif ( $wgRequest->getCheck( 'sf_free_text' ) ) {
			$free_text = $wgRequest->getVal( 'sf_free_text' );
			if ( ! $free_text_was_included ) {
				$data_text .= "!free_text!";
			}
		// or get it from the form definition
		} elseif ( $free_text_preload_page != null ) {
			$free_text = SFFormUtils::getPreloadedText( $free_text_preload_page );
		} else {
			$free_text = null;
		}
		if ( $onlyinclude_free_text ) {
			// modify free text and data text to insert <onlyinclude> tags
			$free_text = str_replace( "<onlyinclude>", '', $free_text );
			$free_text = str_replace( "</onlyinclude>", '', $free_text );
			$free_text = trim( $free_text );
			$data_text = str_replace( '!free_text!', '<onlyinclude>!free_text!</onlyinclude>', $data_text );
		}

		// The first hook here is deprecated. Use the second.
		// Note: wfRunHooks can take a third argument which indicates a deprecated hook, but it
		// expects a MediaWiki version, not an extension version.
		wfRunHooks( 'sfModifyFreeTextField', array( &$free_text, $existing_page_content ) );
		wfRunHooks( 'sfBeforeFreeTextSubstitution',
			array( &$free_text, $existing_page_content, &$data_text ) );

		// now that we have it, substitute free text into the form and page
		$escaped_free_text = Sanitizer::safeEncodeAttribute( $free_text );
		$form_text = str_replace( '!free_text!', $escaped_free_text, $form_text );
		$data_text = str_replace( '!free_text!', $free_text, $data_text );

		// Add a warning in, if we're editing an existing page and that
		// page appears to not have been created with this form.
		if ( !$is_query && is_null( $page_name_formula ) &&
			$this->mPageTitle->exists() && $existing_page_content !== ''
			&& !$source_page_matches_this_form ) {
			$form_text = "\t" . '<div class="warningbox">' .
				wfMessage( 'sf_formedit_formwarning', $this->mPageTitle->getFullURL() )->text() .
				"</div>\n<br clear=\"both\" />\n" . $form_text;
		}

		// add form bottom, if no custom "standard inputs" have been defined
		if ( !$this->standardInputsIncluded ) {
			if ( $is_query )
				$form_text .= SFFormUtils::queryFormBottom( $form_is_disabled );
			else
				$form_text .= SFFormUtils::formBottom( $form_submitted, $form_is_disabled );
		}


		if ( !$is_query ) {
			$form_text .= Html::hidden( 'wpStarttime', wfTimestampNow() );
			$article = new Article( $this->mPageTitle, 0 );
			$form_text .= Html::hidden( 'wpEdittime', $article->getTimestamp() );

			$form_text .= Html::hidden( 'wpEditToken', $wgUser->getEditToken() );
		}

		$form_text .= "\t</form>\n";
		$wgParser->replaceLinkHolders( $form_text );
		wfRunHooks( 'sfRenderingEnd', array( &$form_text ) );

		// Add general Javascript code.
		$javascript_text = "";
		wfRunHooks( 'sfAddJavascriptToForm', array( &$javascript_text ) );

		// Send the autocomplete values to the browser, along with the
		// mappings of which values should apply to which fields.
		// If doing a replace, the data text is actually the modified
		// original page.
		if ( $wgRequest->getCheck( 'partial' ) ) {
			$data_text = $existing_page_content;
		}

		if ( !$is_embedded ) {
			$form_page_title = $wgParser->recursiveTagParse( str_replace( "{{!}}", "|", $form_page_title ) );
		} else {
			$form_page_title = null;
		}

		// If the form has already been submitted, i.e. this is just
		// the redirect page, get rid of all the Javascript, to avoid
		// JS errors.
		if ( $form_submitted ) {
			$javascript_text = '';
		}

//		$wgParser = $oldParser;

		return array( $form_text, $javascript_text, $data_text, $form_page_title, $generated_page_name );
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
			// last argument to function should be a hash, merging the default
			// values for this input type with all other properties set in
			// the form definition, plus some semantic-related arguments
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
			} else { // anything else
				$other_args = $form_field->getArgumentsForInputCall();
				// special call to ensure that a list input is the right default size
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
