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
 * @file
 * @ingroup SF
 */

class SFFormPrinter {

	public $mSemanticTypeHooks;
	public $mInputTypeHooks;
	public $standardInputsIncluded;
	public $mPageTitle;

	public function __construct() {
		// Initialize variables.
		$this->mSemanticTypeHooks = array();
		$this->mInputTypeHooks = array();
		$this->mInputTypeClasses = array();
		$this->mDefaultInputForPropType = array();
		$this->mDefaultInputForPropTypeList = array();
		$this->mPossibleInputsForPropType = array();
		$this->mPossibleInputsForPropTypeList = array();

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
		$this->registerInputType( 'SFCategoryInput' );
		$this->registerInputType( 'SFCategoriesInput' );
	}

	public function setSemanticTypeHook( $type, $is_list, $function_name, $default_args ) {
		$this->mSemanticTypeHooks[$type][$is_list] = array( $function_name, $default_args );
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

	public function getDefaultInputType( $isList, $propertyType ) {
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

	public function getPossibleInputTypes( $isList, $propertyType ) {
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

	public function getAllInputTypes() {
		return array_keys( $this->mInputTypeClasses );
	}

	/**
	 * Show the set of previous deletions for the page being added.
	 * This function is copied almost exactly from
	 * EditPage::showDeletionLog() - unfortunately, neither that function
	 * nor Article::showDeletionLog() can be called from here, since
	 * they're both protected.
	 */
	function showDeletionLog( $out ) {
		// if MW doesn't have LogEventsList defined, exit immediately
		if ( ! class_exists( 'LogEventsList' ) )
			return false;

		global $wgUser;
		$loglist = new LogEventsList( $wgUser->getSkin(), $out );
		$pager = new LogPager( $loglist, 'delete', false, $this->mPageTitle->getPrefixedText() );
		$count = $pager->getNumRows();
		if ( $count > 0 ) {
			$pager->mLimit = 10;
			$out->addHTML( '<div class="mw-warning-with-logexcerpt">' );
			// the message name changed in MW 1.16
			if ( ! wfEmptyMsg( 'moveddeleted-notice', wfMsg( 'moveddeleted-notice' ) ) )
				$out->addWikiMsg( 'moveddeleted-notice' );
			else
				$out->addWikiMsg( 'recreate-deleted-warn' );
			$out->addHTML(
				$loglist->beginLogEventsList() .
				$pager->getBody() .
				$loglist->endLogEventsList()
			);
			if ( $count > 10 ) {
				$out->addHTML( $wgUser->getSkin()->link(
					SpecialPage::getTitleFor( 'Log' ),
					wfMsgHtml( 'deletelog-fulllog' ),
					array(),
					array(
						'type' => 'delete',
						'page' => $this->mPageTitle->getPrefixedText() ) ) );
			}
			$out->addHTML( '</div>' );
			return true;
		}

		return false;
	}

	/**
	 * Like PHP's str_replace(), but only replaces the first found
	 * instance - unfortunately, str_replace() doesn't allow for that.
	 * This code is basically copied directly from
	 * http://www.php.net/manual/en/function.str-replace.php#86177
	 * - this might make sense in the SFUtils class, if it's useful in
	 * other places.
	 */
	function strReplaceFirst( $search, $replace, $subject) {
		$firstChar = strpos( $subject, $search );
		if ( $firstChar !== false ) {
			$beforeStr = substr( $subject, 0, $firstChar );
			$afterStr = substr( $subject, $firstChar + strlen( $search ) );
			return $beforeStr . $replace . $afterStr;
		} else {
			return $subject;
		}
	}

	/**
	 * Creates the HTML for the inner table for every instance of a
	 * multiple-instance template in the form.
	 */
	function multipleTemplateInstanceTableHTML( $mainText ) {
		global $sfgTabIndex, $sfgScriptPath;

		$remove_text = wfMsg( 'sf_formedit_remove' );
		$text =<<<END

			<table>
			<tr>
			<td>
			$mainText
			</td>
			<td class="removeButton">
			<input type="button" value="$remove_text" tabindex="$sfgTabIndex" class="remover" />
			</td>
			<td class="instanceRearranger">
			<img src="$sfgScriptPath/skins/rearranger.png" class="rearrangerImage" />
			</td>
			</tr>
			</table>

END;

		return $text;
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
	function formHTML( $form_def, $form_submitted, $source_is_page, $form_id = null, $existing_page_content = null, $page_name = null, $page_name_formula = null, $is_query = false, $embedded = false ) {
		global $wgRequest, $wgUser, $wgOut, $wgParser;
		global $sfgTabIndex; // used to represent the current tab index in the form
		global $sfgFieldNum; // used for setting various HTML IDs

		wfProfileIn( __METHOD__ );

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
			 if ( $wgRequest->getCheck( 'free_text' ) ) {
					$existing_page_content = $wgRequest->getVal( 'free_text' );
					$form_is_partial = true;
			 }
		}

		// Disable all form elements if user doesn't have edit
		// permission - two different checks are needed, because
		// editing permissions can be set in different ways.
		// HACK - sometimes we don't know the page name in advance, but
		// we still need to set a title here for testing permissions.
		if ( $embedded ) {
			// If this is an embedded form (probably a 'RunQuery'),
			// just use the name of the actual page we're on.
			global $wgTitle;
			$this->mPageTitle = $wgTitle;
		} elseif ( $page_name == '' ) {
			$this->mPageTitle = Title::newFromText(
				$wgRequest->getVal( 'namespace' ) . ":Semantic Forms permissions test" );
		} else {
			$this->mPageTitle = Title::newFromText( $page_name );
		}

		global $wgOut;
		// show previous set of deletions for this page, if it's been deleted before
		if ( ! $form_submitted && ! $this->mPageTitle->exists() ) {
			$this->showDeletionLog( $wgOut );
		}
		// Unfortunately, we can't just call userCan() here because, as of MW 1.16,
		// it has a bug in which it ignores a setting of
		// "$wgEmailConfirmToEdit = true;". Instead, we'll just get the
		// permission errors from the start, and use those to determine whether
		// the page is editable.
		//$userCanEditPage = ( $wgUser->isAllowed( 'edit' ) && $this->mPageTitle->userCan( 'edit' ) );
		$permissionErrors = $this->mPageTitle->getUserPermissionsErrors( 'edit', $wgUser );
		$userCanEditPage = count( $permissionErrors ) == 0;
		wfRunHooks( 'sfUserCanEditPage', array( $this->mPageTitle, &$userCanEditPage ) );
		$form_text = "";
		if ( $userCanEditPage || $is_query ) {
			$form_is_disabled = false;
			// Show "Your IP address will be recorded" warning if
			// user is anonymous, and it's not a query -
			// wiki-text for bolding has to be replaced with HTML.
			if ( $wgUser->isAnon() && ! $is_query ) {
				$anon_edit_warning = preg_replace( "/'''(.*)'''/", "<strong>$1</strong>", wfMsg( 'anoneditwarning' ) );
				$form_text .= "<p>$anon_edit_warning</p>\n";
			}
		} else {
			$form_is_disabled = true;
			$wgOut->readOnlyPage( null, false, $permissionErrors, 'edit' );
			$wgOut->addHTML( "\n<hr />\n" );
		}

		// Remove <noinclude> sections and <includeonly> tags from form definition.
		$form_def = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $form_def );
		$form_def = strtr( $form_def, array( '<includeonly>' => '', '</includeonly>' => '' ) );

		// Parse wiki-text.
		// Add '<nowiki>' tags around every triple-bracketed form definition
		// element, so that the wiki parser won't touch it - the parser will
		// remove the '<nowiki>' tags, leaving us with what we need.
		$form_def = "__NOEDITSECTION__" . strtr( $form_def, array( '{{{' => '<nowiki>{{{', '}}}' => '}}}</nowiki>' ) );

		$oldParser = $wgParser;

		$wgParser = unserialize( serialize( $oldParser ) ); // deep clone of parser
		
		// Get the form definition from the cache, if we're using caching and it's
		// there.
//		$got_form_def_from_cache = false;
//		global $sfgCacheFormDefinitions;
//		if ( $sfgCacheFormDefinitions && ! is_null( $form_id ) ) {
//			$db = wfGetDB( DB_MASTER );
//			$res = $db->select( 'page_props', 'pp_value', "pp_propname = 'formdefinition' AND pp_page = '$form_id'" );
//			if ( $res->numRows() >	0 ) {
//				$form_def = $res->fetchObject()->pp_value;
//				$got_form_def_from_cache = true;
//			}
//		}
		// Otherwise, parse it.
//		if ( ! $got_form_def_from_cache ) {
		$form_def = $wgParser->parse($form_def, $this->mPageTitle, ParserOptions::newFromUser($wgUser))->getText();
//		}

		// Turn form definition file into an array of sections, one for each
		// template definition (plus the first section)
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
		// And another hack - replace the 'free text' standard input with
		// a field declaration to get it to be handled as a field.
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
		for ( $section_num = 0; $section_num < count( $form_def_sections ); $section_num++ ) {
			$start_position = 0;
			$template_text = "";
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
					$old_template_name = $template_name;
					$template_name = trim( $tag_components[1] );
					$tif = SFTemplateInForm::create( $template_name );
					$query_template_name = str_replace( ' ', '_', $template_name );
					$add_button_text = wfMsg( 'sf_formedit_addanother' );
					// Also replace periods with underlines, since that's what
					// POST does to strings anyway.
					$query_template_name = str_replace( '.', '_', $query_template_name );
					// Cycle through the other components.
					for ( $i = 2; $i < count( $tag_components ); $i++ ) {
						$component = $tag_components[$i];
						if ( $component == 'multiple' ) $allow_multiple = true;
						if ( $component == 'strict' ) $strict_parsing = true;
						$sub_components = array_map( 'trim', explode( '=', $component, 2 ) );
						if ( count( $sub_components ) == 2 ) {
							if ( $sub_components[0] == 'label' ) {
								$template_label = $sub_components[1];
							} elseif ( $sub_components[0] == 'add button text' ) {
								$add_button_text = $sub_components[1];
							}
						}
					}
					// If this is the first instance, add the label into the form, if
					// there is one, and add the appropriate wrapper div, if this is
					// a multiple-instance template.
					if ( $old_template_name != $template_name ) {
						if ( isset( $template_label ) ) {
							$form_text .= "<fieldset>\n";
							$form_text .= "<legend>$template_label</legend>\n";
						}
						if ($allow_multiple) {
							$form_text .= "\t" . '<div class="multipleTemplateWrapper">' . "\n";
							$form_text .= "\t" . '<div class="multipleTemplateList">' . "\n";
						}
					}
					$template_text .= "{{" . $template_name;
					$all_fields = $tif->getAllFields();
					// remove template tag
					$section = substr_replace( $section, '', $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
					$template_instance_query_values = $wgRequest->getArray( $query_template_name );
					// If we are editing a page, and this template can be found more than
					// once in that page, and multiple values are allowed, repeat this
					// section.
					$existing_template_text = null;
					if ( $source_is_page || $form_is_partial ) {
						// Replace underlines with spaces in template name, to allow for
						// searching on either.
						$search_template_str = str_replace( '_', ' ', $template_name );
						$preg_match_template_str = str_replace(
							array( '/', '(', ')' ),
							array( '\/', '\(', '\)' ),
							$search_template_str );
						$found_instance = preg_match( '/{{' . $preg_match_template_str . '\s*[\|}]/i', str_replace( '_', ' ', $existing_page_content ) );
						if ( $allow_multiple ) {
							// find instances of this template in the page -
							// if there's at least one, re-parse this section of the
							// definition form for the subsequent template instances in
							// this page; if there's none, don't include fields at all.
							// there has to be a more efficient way to handle multiple
							// instances of templates, one that doesn't involve re-parsing
							// the same tags, but I don't know what it is.
							if ( $found_instance ) {
								$instance_num++;
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
							preg_match($search_pattern, $content_str, $matches, PREG_OFFSET_CAPTURE);
							// is this check necessary?
							if ( array_key_exists( 0, $matches ) && array_key_exists( 1, $matches[0] ) ) {
								$start_char = $matches[0][1];
								$fields_start_char = $start_char + 2 + strlen( $search_template_str );
								// Skip ahead to the first real character.
								while ( in_array( $existing_page_content[$fields_start_char], array( ' ', '\n' ) ) ) {
									$fields_start_char++;
								}
								// If the next character is a pipe, skip that too.
								if( $existing_page_content[$fields_start_char] == '|' ) {
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
					if ( ( ! $source_is_page ) && $allow_multiple && $wgRequest ) {
						$all_instances_printed = true;
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
					if ( isset( $template_label ) ) {
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
					// cycle through the other components
					$is_mandatory = false;
					$is_hidden = false;
					$is_restricted = false;
					$is_uploadable = false;
					$is_list = false;
					$input_type = null;
					$field_args = array();
					$show_on_select = array();
					$default_value = null;
					$values = null;
					$possible_values = null;
					$semantic_property = null;
					$preload_page = null;
					for ( $i = 2; $i < count( $tag_components ); $i++ ) {
						$component = trim( $tag_components[$i] );
						if ( $component == 'mandatory' ) {
							$is_mandatory = true;
						} elseif ( $component == 'hidden' ) {
							$is_hidden = true;
						} elseif ( $component == 'restricted' ) {
							$is_restricted = ( ! $wgUser || ! $wgUser->isAllowed( 'editrestrictedfields' ) );
						} elseif ( $component == 'uploadable' ) {
							$field_args['is_uploadable'] = true;
						} elseif ( $component == 'list' ) {
							$is_list = true;
						} elseif ( $component == 'autocomplete' ) {
							$field_args['autocomplete'] = true;
						} elseif ( $component == 'no autocomplete' ) {
							$field_args['no autocomplete'] = true;
						} elseif ( $component == 'remote autocompletion' ) {
							$field_args['remote autocompletion'] = true;
						} elseif ( $component == 'edittools' ) { // free text only
							$free_text_components[] = 'edittools';
						} else {
							$sub_components = array_map( 'trim', explode( '=', $component, 2 ) );
							if ( count( $sub_components ) == 1 ) {
								// add handling for single-value params, for custom input types
								$field_args[$sub_components[0]] = null;
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
										if ( empty( $val ) ) continue;
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
									$property_name = $sub_components[1];
									$propValue = SMWPropertyValue::makeUserProperty( $property_name );
									if ( $propValue->getPropertyTypeID() == '_wpg' ) {
										$field_args['autocomplete field type'] = 'relation';
									} else {
										$field_args['autocomplete field type'] = 'attribute';
									}
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
									$values = $sub_components[1];
								} elseif ( $sub_components[0] == 'values from property' ) {
									$propertyName = $sub_components[1];
									$propValue = SMWPropertyValue::makeUserProperty( $propertyName );
									$isRelation = $propValue->getPropertyTypeID() == '_wpg';
									$possible_values = SFAutocompleteAPI::getAllValuesForProperty( $isRelation, $propertyName );
								} elseif ( $sub_components[0] == 'values from category' ) {
									$category_name = ucfirst( $sub_components[1] );
									$possible_values = SFUtils::getAllPagesForCategory( $category_name, 10 );
								} elseif ( $sub_components[0] == 'values from concept' ) {
									$possible_values = SFUtils::getAllPagesForConcept( $sub_components[1] );
								} elseif ( $sub_components[0] == 'values from namespace' ) {
									$possible_values = SFUtils::getAllPagesForNamespace( $sub_components[1] );
								} elseif ( $sub_components[0] == 'property' ) {
									$semantic_property = $sub_components[1];
								} elseif ( $sub_components[0] == 'default filename' ) {
									$default_filename = str_replace( '&lt;page name&gt;', $page_name, $sub_components[1] );
									// Parse value, so default filename can include parser functions.
									$default_filename = $wgParser->recursiveTagParse( $default_filename );
									$field_args['default filename'] = $default_filename;
								} elseif ( $sub_components[0] == 'restricted' ) {
									$is_restricted = !array_intersect(
											$wgUser->getEffectiveGroups(),
											array_map( 'trim', explode( ',', $sub_components[1] ) )
									);
								}
							}
						}
					} // end for
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
						if ( $form_submitted || ( ! empty( $field_query_val ) && ! is_array( $field_query_val ) ) ) {
							$cur_value = $field_query_val;
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

					// if the user is editing a page, and that page contains a call to
					// the template being processed, get the current field's value
					// from the template call
					if ( $source_is_page && ( ! empty( $existing_template_text ) ) ) {
						if ( isset( $template_contents[$field_name] ) ) {
							$cur_value = $template_contents[$field_name];
							// now remove this value from $template_contents, so that
							// at the end we can have a list of all the fields that
							// weren't handled by the form
							unset( $template_contents[$field_name] );
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
							$new_text = SFFormUtils::hiddenFieldHTML( 'free_text', '!free_text!' );
						} else {
							$sfgTabIndex++;
							$sfgFieldNum++;
							if ( $cur_value == '' ) {
								$default_value = '!free_text!';
							} else {
								$default_value = $cur_value;
								// If the FCKeditor extension is installed and
								// active, the default value needs to be parsed
								// for use in the editor.
								global $wgFCKEditorDir;
								if ( $wgFCKEditorDir && strpos( $existing_page_content, '__NORICHEDITOR__' ) === false ) {
									$showFCKEditor = SFFormUtils::getShowFCKEditor();
									if ( !$form_submitted && ( $showFCKEditor & RTE_VISIBLE ) ) {
										$default_value = SFFormUtils::prepareTextForFCK( $cur_value );
									}
								}
							}
							$new_text = SFTextAreaInput::getHTML( $default_value, 'free_text', false, ( $form_is_disabled || $is_restricted ), $field_args );
							if ( in_array( 'edittools', $free_text_components ) ) {
								// borrowed from EditPage::showEditTools()
								$options[] = 'parse';
								$edittools_text = wfMsgExt( 'edittools', array( 'parse' ), array( 'content' ) );

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

					if ( $template_name == '' || $field_name == '<freetext>' ) {
						$section = substr_replace( $section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc );
					} else {
						if ( is_array( $cur_value ) ) {
							// first, check if it's a list
							if ( array_key_exists( 'is_list', $cur_value ) &&
									$cur_value['is_list'] == true ) {
								$cur_value_in_template = "";
								if ( array_key_exists( 'delimiter', $field_args ) ) {
									$delimiter = $field_args['delimiter'];
								} else {
									$delimiter = ",";
								}
								foreach ( $cur_value as $key => $val ) {
									if ( $key !== "is_list" ) {
										if ( $cur_value_in_template != "" ) {
											$cur_value_in_template .= $delimiter . " ";
										}
										$cur_value_in_template .= $val;
									}
								}
							} else {
								// otherwise:
								// if it has 1 or 2 elements, assume it's a checkbox; if it has
								// 3 elements, assume it's a date
								// - this handling will have to get more complex if other
								// possibilities get added
								if ( count( $cur_value ) == 1 ) {
									$cur_value_in_template = SFUtils::getWordForYesOrNo( false );
								} elseif ( count( $cur_value ) == 2 ) {
									$cur_value_in_template = SFUtils::getWordForYesOrNo( true );
								// if it's 3 or greater, assume it's a date or datetime
								} elseif ( count( $cur_value ) >= 3 ) {
									$month = $cur_value['month'];
									$day = $cur_value['day'];
									if ( $day != '' ) {
										global $wgAmericanDates;
										if ( $wgAmericanDates == false ) {
											// pad out day to always be two digits
											$day = str_pad( $day, 2, "0", STR_PAD_LEFT );
										}
									}
									$year = $cur_value['year'];
									$hour = $minute = $second = $ampm24h = $timezone = null;
									if ( isset( $cur_value['hour'] ) ) $hour = $cur_value['hour'];
									if ( isset( $cur_value['minute'] ) ) $minute = $cur_value['minute'];
									if ( isset( $cur_value['second'] ) ) $second = $cur_value['second'];
									if ( isset( $cur_value['ampm24h'] ) ) $ampm24h = $cur_value['ampm24h'];
									if ( isset( $cur_value['timezone'] ) ) $timezone = $cur_value['timezone'];
									if ( $month != '' && $day != '' && $year != '' ) {
										// special handling for American dates - otherwise, just
										// the standard year/month/day (where month is a number)
										global $wgAmericanDates;
										if ( $wgAmericanDates == true ) {
											$cur_value_in_template = "$month $day, $year";
										} else {
											$cur_value_in_template = "$year/$month/$day";
										}
										// include whatever time information we have
										if ( ! is_null( $hour ) )
											$cur_value_in_template .= " " . str_pad( intval( substr( $hour, 0, 2 ) ), 2, '0', STR_PAD_LEFT ) . ":" . str_pad( intval( substr( $minute, 0, 2 ) ), 2, '0', STR_PAD_LEFT );
										if ( ! is_null( $second ) )
											$cur_value_in_template .= ":" . str_pad( intval( substr( $second, 0, 2 ) ), 2, '0', STR_PAD_LEFT );
										if ( ! is_null( $ampm24h ) )
											$cur_value_in_template .= " $ampm24h";
										if ( ! is_null( $timezone ) )
											$cur_value_in_template .= " $timezone";
									} else {
										$cur_value_in_template = "";
									}
								}
							}
						} else { // value is not an array
							$cur_value_in_template = $cur_value;
						}
						if ( $template_name == null || $template_name == '' ) {
							$input_name = $field_name;
						} elseif ( $allow_multiple ) {
							// 'num' will get replaced by an actual index, either in PHP
							// or in Javascript, later on
							$input_name = $template_name . '[num][' . $field_name . ']';
						} else {
							$input_name = $template_name . '[' . $field_name . ']';
						}


						// If the 'values' parameter was set, separate it based on the
						// 'delimiter' parameter, if any.
						if ( ! empty( $values ) ) {
							if ( array_key_exists( 'delimiter', $field_args ) ) {
								$delimiter = $field_args['delimiter'];
							} else {
								$delimiter = ",";
							}
							// Remove whitespaces, and un-escape characters
							$possible_values = array_map( 'trim', explode( $delimiter, $values ) );
							$possible_values = array_map( 'htmlspecialchars_decode', $possible_values );
						}

						// if we're creating the page name from a formula based on
						// form values, see if the current input is part of that formula,
						// and if so, substitute in the actual value
						if ( $form_submitted && $generated_page_name != '' ) {
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
						// If a property was set in the form definition, overwrite whatever
						// is set in the template field - this is somewhat of a hack, since
						// parameters set in the form definition are meant to go into the
						// SFFormField object, not the SFTemplateField object it contains;
						// it seemed like too much work, though, to create an
						// SFFormField::setSemanticProperty() function just for this call
						if ( $semantic_property != null ) {
							$form_field->template_field->setSemanticProperty( $semantic_property );
						}

						// call hooks - unfortunately this has to be split into two
						// separate calls, because of the different variable names in
						// each case
						if ( $form_submitted ) {
							wfRunHooks( 'sfCreateFormField', array( &$form_field, &$cur_value_in_template, true ) );
						} else {
							wfRunHooks( 'sfCreateFormField', array( &$form_field, &$cur_value, false ) );
						}
						// if this is not part of a 'multiple' template, increment the
						// global tab index (used for correct tabbing)
						if ( ! array_key_exists( 'part_of_multiple', $field_args ) ) {
							$sfgTabIndex++;
						}
						// increment the global field number regardless
						$sfgFieldNum++;
						// if the field is a date field, and its default value was set
						// to 'now', and it has no current value, set $cur_value to be
						// the current date
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
						// if the field is a text field, and its default value was set
						// to 'current user', and it has no current value, set $cur_value
						// to be the current user
						if ( $default_value == 'current user' &&
								// if the date is hidden, cur_value will already be set
								// to the default value
								( $cur_value == '' || $cur_value == 'current user' ) ) {
							if ( $input_type == 'text' || $input_type == '' ) {
								$cur_value_in_template = $wgUser->getName();
								$cur_value = $cur_value_in_template;
							}
						}
						$new_text = $this->formFieldHTML( $form_field, $cur_value );

						// if this field is disabled, add a hidden field holding
						// the value of this field, because disabled inputs for some
						// reason don't submit their value
						if ( $form_field->isDisabled() ) {
							if ( $field_name == 'free text' || $field_name == '<freetext>' ) {
								$new_text .= SFFormUtils::hiddenFieldHTML( 'free_text', '!free_text!' );
							} else {
								$new_text .= SFFormUtils::hiddenFieldHTML( $input_name, $cur_value );
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
					for ( $i = 2; $i < count( $tag_components ); $i++ ) {
						$component = $tag_components[$i];
						$sub_components = array_map( 'trim', explode( '=', $component ) );
						if ( count( $sub_components ) == 1 ) {
							if ( $sub_components[0] == 'edittools' ) {
								$free_text_components[] = 'edittools';
							}
						} elseif ( count( $sub_components ) == 2 ) {
							switch( $sub_components[0] ) {
							case 'label':
								$input_label = $sub_components[1];
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
						$new_text = SFFormUtils::summaryInputHTML( $form_is_disabled, $input_label, $attr );
					} elseif ( $input_name == 'minor edit' ) {
						$new_text = SFFormUtils::minorEditInputHTML( $form_is_disabled, $input_label, $attr );
					} elseif ( $input_name == 'watch' ) {
						$new_text = SFFormUtils::watchInputHTML( $form_is_disabled, $input_label, $attr );
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
				// page info processing
				// =====================================================
				} elseif ( $tag_title == 'info' ) {
					// TODO: Generate an error message if this is included more than once
					foreach ( array_slice( $tag_components, 1 ) as $component ) {
						$sub_components = array_map( 'trim', explode( '=', $component, 2 ) );
						$tag = $sub_components[0];
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
				if ( $template_text != '' ) {
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
					$data_text .= $template_text . "\n";
					// If there is a placeholder in the text, we know that we are
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
				if ( ! $all_instances_printed ) {
					// Add the character "a" onto the instance number of this input
					// in the form, to differentiate the inputs the form starts out
					// with from any inputs added by the Javascript.
					$section = str_replace( '[num]', "[{$instance_num}a]", $section );
					// @TODO - this replacement should be
					// case- and spacing-insensitive
					$section = str_replace( ' id=', ' origID=', $section );
					$form_text .= "\t\t" . Xml::tags( 'div',
						array(
							// The "multipleTemplate" class is there for
							// backwards-compatibility with any custom CSS on people's
							// wikis before SF 2.0.9.
							'class' => "multipleTemplateInstance multipleTemplate"
						),
						$this->multipleTemplateInstanceTableHTML( $section )
					) . "\n";

					// This will cause the section to be
					// re-parsed on the next go.
					$section_num--;
				} else {
					// This is the last instance of this
					// template - print all the sections
					// necessary for adding additional
					// instances.
					$form_text .= "\t\t" . Xml::tags( 'div',
						array(
							'class' => "multipleTemplateStarter",
							'style' => "display: none",
						),
						$this->multipleTemplateInstanceTableHTML( $section )
					) . "\n";
					$form_text .= <<<END
	</div><!-- multipleTemplateList -->
		<p style="margin-left:10px;" />
		<p><input type="button" value="$add_button_text" tabindex="$sfgTabIndex" class="multipleTemplateAdder" /></p>
	</div><!-- multipleTemplateWrapper -->

END;
				}
			} else {
				$form_text .= $section;
			}

		} // end for

		// if it wasn't included in the form definition, add the
		// 'free text' input as a hidden field at the bottom
		if ( ! $free_text_was_included ) {
			$form_text .= SFFormUtils::hiddenFieldHTML( 'free_text', '!free_text!' );
		}
		// Get free text, and add to page data, as well as retroactively
		// inserting it into the form.

		// If $form_is_partial is true then either:
		// (a) we're processing a replacement (param 'partial' == 1)
		// (b) we're sending out something to be replaced (param 'partial' is missing)
		if ( $form_is_partial ) {
			 if ( !$wgRequest->getCheck( 'partial' ) ) {
				 $free_text = $original_page_content;
				 $form_text .= SFFormUtils::hiddenFieldHTML( 'partial', 1 );
			 } else {
				 $free_text = null;
				 $existing_page_content = preg_replace( array( '/�\{/m','/\}�/m' ),
					 array( '{{','}}' ),
					 $existing_page_content );
				 $existing_page_content = preg_replace( '/\{\{\{insertionpoint\}\}\}/', '', $existing_page_content );
			 }
		} elseif ( $source_is_page ) {
			// if the page is the source, free_text will just be whatever in the
			// page hasn't already been inserted into the form
			$free_text = trim( $existing_page_content );
		// or get it from a form submission
		} elseif ( $wgRequest->getCheck( 'free_text' ) ) {
			$free_text = $wgRequest->getVal( 'free_text' );
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

		wfRunHooks( 'sfModifyFreeTextField', array( &$free_text, $existing_page_content ) );
		// if the FCKeditor extension is installed, use that for the free text input
		global $wgFCKEditorDir;
		if ( $wgFCKEditorDir && strpos( $existing_page_content, '__NORICHEDITOR__' ) === false ) {
			$showFCKEditor = SFFormUtils::getShowFCKEditor();
			if ( !$form_submitted && ( $showFCKEditor & RTE_VISIBLE ) ) {
				$free_text = SFFormUtils::prepareTextForFCK( $free_text );
			}
		} else {
			$showFCKEditor = 0;
		}
		// now that we have it, substitute free text into the form and page
		$escaped_free_text = Sanitizer::safeEncodeAttribute( $free_text );
		$form_text = str_replace( '!free_text!', $escaped_free_text, $form_text );
		$data_text = str_replace( '!free_text!', $free_text, $data_text );

		// Add a warning in, if we're editing an existing page and that
		// page appears to not have been created with this form.
		if ( $this->mPageTitle->exists() && ( $existing_page_content != '' ) && ! $source_page_matches_this_form ) {
			$form_text = "\t" . '<div class="warningMessage">' . wfMsg( 'sf_formedit_formwarning', $this->mPageTitle->getFullURL() ) . "</div>\n" . $form_text;
		}

		// add form bottom, if no custom "standard inputs" have been defined
		if ( !$this->standardInputsIncluded ) {
			if ( $is_query )
				$form_text .= SFFormUtils::queryFormBottom( $form_is_disabled );
			else
				$form_text .= SFFormUtils::formBottom( $form_is_disabled );
		}
		$starttime = wfTimestampNow();
		$page_article = new Article( $this->mPageTitle );
		$edittime = $page_article->getTimestamp();
		if ( !$is_query ) {
			$form_text .= SFFormUtils::hiddenFieldHTML( 'wpStarttime', wfTimestampNow() );
			$form_text .= SFFormUtils::hiddenFieldHTML( 'wpEdittime', $page_article->getTimestamp() );
		}
		$form_text .= "\t</form>\n";

		// Add general Javascript code.
		wfRunHooks( 'sfAddJavascriptToForm', array( &$javascript_text ) );

		// @TODO The FCKeditor Javascript should be handled within
		// the FCKeditor extension itself, using the hook.
		$javascript_text = "";
		if ( $free_text_was_included && $showFCKEditor > 0 ) {
			$javascript_text .= SFFormUtils::mainFCKJavascript( $showFCKEditor, $field_args );
			if ( $showFCKEditor & ( RTE_TOGGLE_LINK | RTE_POPUP ) ) {
				$javascript_text .= SFFormUTils::FCKToggleJavascript();
			}
			if ( $showFCKEditor & RTE_POPUP ) {
				$javascript_text .= SFFormUTils::FCKPopupJavascript();
			}
		}

		// Send the autocomplete values to the browser, along with the
		// mappings of which values should apply to which fields.
		// If doing a replace, the data text is actually the modified original page
		if ( $wgRequest->getCheck( 'partial' ) )
			$data_text = $existing_page_content;

		if ( !$embedded ) {
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

		$parserOutput = $wgParser->getOutput();
		$wgOut->addParserOutputNoText( $parserOutput );

		$wgParser = $oldParser;

		wfProfileOut( __METHOD__ );

		return array( $form_text, $javascript_text, $data_text, $form_page_title, $generated_page_name );
	}

	/**
	 * Create the HTML and Javascript to display this field within a form
	 */
	function formFieldHTML( $form_field, $cur_value ) {
		// Also get the actual field, with all the semantic information
		// (type is SFTemplateField, instead of SFFormField)
		$template_field = $form_field->getTemplateField();

		if ( $form_field->isHidden() ) {
			$text = SFFormUtils::hiddenFieldHTML( $form_field->getInputName(), $cur_value );
		} elseif ( $form_field->getInputType() != '' &&
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
			$property_type = $template_field->getPropertyType();
			$is_list = ( $form_field->isList() || $template_field->isList() );
			if ( $property_type != '' &&
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
