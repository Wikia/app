<?php
/**
 * Handles the creation and running of a user-created form.
 *
 * @author Yaron Koren
 * @author Nils Oppermann
 * @author Jeffrey Stuckman
 * @author Harold Solbrig
 */

class SFFormPrinter {

  var $mSemanticTypeHooks;
  var $mInputTypeHooks;
  var $standardInputsIncluded;
  var $mPageTitle;

  function SFFormPrinter() {
    global $smwgContLang;

    // initialize the set of hooks for the entry-field functions to call for
    // fields of both a specific semantic "type" and a defined "input type"
    // in the form definition
    $this->mSemanticTypeHooks = array();
    if ($smwgContLang != null) {
      $datatypeLabels =  $smwgContLang->getDatatypeLabels();
      $string_type = $datatypeLabels['_str'];
      $text_type = $datatypeLabels['_txt'];
      // type introduced in SMW 1.2
      if (array_key_exists('_cod', $datatypeLabels))
        $code_type = $datatypeLabels['_cod'];
      else
        $code_type = 'code';
      $url_type = $datatypeLabels['_uri'];
      $email_type = $datatypeLabels['_ema'];
      $float_type = $datatypeLabels['_num'];
      $bool_type = $datatypeLabels['_boo'];
      $date_type = $datatypeLabels['_dat'];
      $enum_type = 'enumeration'; // not a real type
      $page_type = $datatypeLabels['_wpg'];
      $this->setSemanticTypeHook($string_type, false, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'string'));
      $this->setSemanticTypeHook($string_type, true, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'string', 'is_list' => 'true'));
      $this->setSemanticTypeHook($text_type, false, array('SFFormInputs', 'textAreaHTML'), array());
      $this->setSemanticTypeHook($code_type, false, array('SFFormInputs', 'textAreaHTML'), array());
      $this->setSemanticTypeHook($url_type, false, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'URL'));
      $this->setSemanticTypeHook($email_type, false, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'email'));
      $this->setSemanticTypeHook($float_type, false, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'float'));
      $this->setSemanticTypeHook($bool_type, false, array('SFFormInputs', 'checkboxHTML'), array());
      $this->setSemanticTypeHook($date_type, false, array('SFFormInputs', 'dateEntryHTML'), array());
      $this->setSemanticTypeHook($enum_type, false, array('SFFormInputs', 'dropdownHTML'), array());
      $this->setSemanticTypeHook($enum_type, true, array('SFFormInputs', 'checkboxesHTML'), array());
      $this->setSemanticTypeHook($page_type, false, array('SFFormInputs', 'textInputWithAutocompleteHTML'), array('field_type' => 'page'));
      $this->setSemanticTypeHook($page_type, true, array('SFFormInputs', 'textInputWithAutocompleteHTML'), array('field_type' => 'page', 'size' => '100', 'is_list' => 'true'));
    }
    $this->mInputTypeHooks = array();
    $this->setInputTypeHook('text', array('SFFormInputs', 'textEntryHTML'), array());
    $this->setInputTypeHook('textarea', array('SFFormInputs', 'textAreaHTML'), array());
    $this->setInputTypeHook('date', array('SFFormInputs', 'dateEntryHTML'), array());
    $this->setInputTypeHook('datetime', array('SFFormInputs', 'dateTimeEntryHTML'), array('include_timezone' => false));
    $this->setInputTypeHook('datetime with timezone', array('SFFormInputs', 'dateTimeEntryHTML'), array('include_timezone' => true));
    $this->setInputTypeHook('checkbox', array('SFFormInputs', 'checkboxHTML'), array());
    $this->setInputTypeHook('radiobutton', array('SFFormInputs', 'radioButtonHTML'), array());
    $this->setInputTypeHook('checkboxes', array('SFFormInputs', 'checkboxesHTML'), array());
    $this->setInputTypeHook('listbox', array('SFFormInputs', 'listboxHTML'), array());

    // initialize other variables
    $this->standardInputsIncluded = false;
  }

  function setSemanticTypeHook($type, $is_list, $function_name, $default_args) {
    $this->mSemanticTypeHooks[$type][$is_list] = array($function_name, $default_args);
  }

  function setInputTypeHook($input_type, $function_name, $default_args) {
    $this->mInputTypeHooks[$input_type] = array($function_name, $default_args);
  }

  function formHTML($form_def, $form_submitted, $source_is_page, $existing_page_content = null, $page_title = null, $page_name_formula = null) {
    global $wgRequest, $wgUser, $wgParser, $wgScriptPath;
    global $sfgTabIndex; // used to represent the current tab index in the form
    global $sfgFieldNum; // used for setting various HTML IDs
    global $sfgJSValidationCalls; // array of Javascript calls to determine if page can be saved

    // initialize some variables
    $sfgTabIndex = 1;
    $sfgFieldNum = 1;
    $source_page_matches_this_form = false;
    $form_page_title = NULL;
    $generated_page_name = $page_name_formula;
    // $form_is_partial is true if:
    // (a) 'partial' == 1 in the arguments
    // (b) 'partial form' is found in the form definition
    // in the latter case, it may remain false until close to the end of
    // the parsing, so we have to assume that it will become a possibility
    $form_is_partial = false;
    $new_text = "";
    
    // if we have existing content and we're not in an active replacement
    // situation, preserve the original content. We do this because we want
    // to pass the original content on IF this is a partial form
    // TODO: A better approach here would be to pass the revision id of the
    // existing page content through the replace value, which would
    // minimize the html traffic and would allow us to do a concurrent
    // update check.  For now, we pass it through the hidden text field...

    if (! $wgRequest->getCheck('partial')) {
      $original_page_content = $existing_page_content;
    } else {
      $original_page_content = null;
       if($wgRequest->getCheck('free_text')) {
          $existing_page_content= $wgRequest->getVal('free_text');
          $form_is_partial = true;
       }
    }

    // disable all form elements if user doesn't have edit permission -
    // two different checks are needed, because editing permissions can be
    // set in different ways
    // HACK - sometimes we don't know the page name in advance, but we still
    // need to set a title here for testing permissions
    if ($page_title == '')
      $this->mPageTitle = Title::newFromText("Semantic Forms permissions test");
    else
      $this->mPageTitle = Title::newFromText($page_title);
    if ($wgUser->isAllowed('edit') && $this->mPageTitle->userCanEdit()) {
      $form_is_disabled = false;
      $form_text = "";
      // show "Your IP address will be recorded" warning if user is
      // anonymous - wikitext for bolding has to be replaced with HTML
      if ($wgUser->isAnon()) {
        $anon_edit_warning = preg_replace("/'''(.*)'''/", "<strong>$1</strong>", wfMsg('anoneditwarning'));
        $form_text .= "<p>$anon_edit_warning</p>\n";
      }
    } else {
      $form_is_disabled = true;
      // display a message to the user explaining why they can't edit the
      // page - borrowed heavily from EditPage.php
      if ( $wgUser->isAnon() ) {
        $skin = $wgUser->getSkin();
        $loginTitle = SpecialPage::getTitleFor( 'Userlogin' );
        $loginLink = $skin->makeKnownLinkObj( $loginTitle, wfMsgHtml( 'loginreqlink' ) );
        $form_text = wfMsgWikiHtml( 'whitelistedittext', $loginLink );
      } else {
        $form_text = wfMsg( 'protectedpagetext' );
      }
    }
    $javascript_text = "";
    $sfgJSValidationCalls = array();
    $fields_javascript_text = "";

    // Remove <noinclude> sections and <includeonly> tags from form definition
    $form_def = StringUtils::delimiterReplace('<noinclude>', '</noinclude>', '', $form_def);
    $form_def = strtr($form_def, array('<includeonly>' => '', '</includeonly>' => ''));

    // parse wiki-text
    // add '<nowiki>' tags around every triple-bracketed form definition
    // element, so that the wiki parser won't touch it - the parser will
    // remove the '<nowiki>' tags, leaving us with what we need
    global $sfgDisableWikiTextParsing;
    if (! $sfgDisableWikiTextParsing) {
      $form_def = strtr($form_def, array('{{{' => '<nowiki>{{{', '}}}' => '}}}</nowiki>'));
      $wgParser->mOptions = new ParserOptions();
      $wgParser->mOptions->initialiseFromUser($wgUser);
      $form_def = $wgParser->parse($form_def, $this->mPageTitle, $wgParser->mOptions)->getText();
    }

    // turn form definition file into an array of sections, one for each
    // template definition (plus the first section)
    $form_def_sections = array();
    $start_position = 0;
    $section_start = 0;
    $free_text_was_included = false;
    $all_values_for_template = array();
    while ($brackets_loc = strpos($form_def, "{{{", $start_position)) {
      $brackets_end_loc = strpos($form_def, "}}}", $brackets_loc);
      $bracketed_string = substr($form_def, $brackets_loc + 3, $brackets_end_loc - ($brackets_loc + 3));
      $tag_components = explode('|', $bracketed_string);
      $tag_title = trim($tag_components[0]);
      if ($tag_title == 'for template' || $tag_title == 'end template') {
        // create a section for everything up to here
        $section = substr($form_def, $section_start, $brackets_loc - $section_start);
        $form_def_sections[] = $section;
        $section_start = $brackets_loc;
      }
      $start_position = $brackets_loc + 1;
    } // end while
    $form_def_sections[] = trim(substr($form_def, $section_start));

    // cycle through form definition file (and possibly an existing article
    // as well), finding template and field declarations and replacing them
    // with form elements, either blank or pre-populated, as appropriate
    $all_fields = array();
    $data_text = "";
    $template_name = "";
    $allow_multiple = false;
    $instance_num = 0;
    $all_instances_printed = false;
    $strict_parsing = false;
    // initialize list of choosers (dropdowns with available templates)
    $choosers = array();
    for ($section_num = 0; $section_num < count($form_def_sections); $section_num++) {
      $tif = new SFTemplateInForm();
      $start_position = 0;
      $template_text = "";
      // the append is there to ensure that the original array doesn't get
      // modified; is it necessary?
      $section = " " . $form_def_sections[$section_num];

      while ($brackets_loc = strpos($section, '{{{', $start_position)) {
        $brackets_end_loc = strpos($section, "}}}", $brackets_loc);
        $bracketed_string = substr($section, $brackets_loc + 3, $brackets_end_loc - ($brackets_loc + 3));
        $tag_components = explode('|', $bracketed_string);
        $tag_title = trim($tag_components[0]);
        // =====================================================
        // for template processing
        // =====================================================
        if ($tag_title == 'for template') {
          $old_template_name = $template_name;
          $template_name = trim($tag_components[1]);
          $tif->template_name = $template_name;
          $query_template_name = str_replace(' ', '_', $template_name);
          // also replace periods with underlines, since that's what
          // POST does to strings anyway
          $query_template_name = str_replace('.', '_', $query_template_name);
          $chooser_name = false;
          $chooser_caption = false;
	  // cycle through the other components
          for ($i = 2; $i < count($tag_components); $i++) {
            $component = $tag_components[$i];
            if ($component == 'multiple') $allow_multiple = true;
            if ($component == 'strict') $strict_parsing = true;
            $sub_components = explode('=', $component);
            if (count($sub_components) == 2) {
              if ($sub_components[0] == 'label') {
                $template_label = $sub_components[1];
              }
              if ($sub_components[0] == 'chooser') {
                $allow_multiple = true;
                $chooser_name = $sub_components[1];
              }
              if ($sub_components[0] == 'chooser caption') {
                $chooser_caption = $sub_components[1];
              }
            }
          }
          // if this is the first instance, add the label in the form
          if (($old_template_name != $template_name) && isset($template_label)) {
            // add a placeholder to the form text so the fieldset can be
            // hidden if chooser support demands it
            if ($chooser_name !== false)
              $form_text .= "<fieldset [[placeholder]] haschooser=true>\n";
            else
               $form_text .= "<fieldset>\n";
            $form_text .= "<legend>$template_label</legend>\n";
          }
          $template_text .= "{{" . $tif->template_name;
          $all_fields = $tif->getAllFields();
          // remove template tag
          $section = substr_replace($section, '', $brackets_loc, $brackets_end_loc + 3 - $brackets_loc);
          $template_instance_query_values = $wgRequest->getArray($query_template_name);
          // if we are editing a page, and this template can be found more than
          // once in that page, and multiple values are allowed, repeat this
          // section
          $existing_template_text = null;
          // special template string for preg_match calls - includes a
          // regular expression, to allow matching of either spaces or
          // underlines in name
          $search_template_str = str_replace('/', '\/', $tif->template_name);
          $search_template_str = preg_replace('/[_| ]/', '[_| ]', $search_template_str);
          if ($source_is_page || $form_is_partial) {
            $matches = array();
            if ($allow_multiple) {
              // find the number of instances of this template in the page -
              // if it's more than one, re-parse this section of the
              // definition form for the subsequent template instances in
              // this page; if there's none, don't include fields at all.
              // there has to be a more efficient way to handle multiple
              // instances of templates, one that doesn't involve re-parsing
              // the same tags, but I don't know what it is.
              if (preg_match_all('/\{\{' . $search_template_str . '\s*(?:(?:([\||:].*?)\}\})|()\}\})/mis', $existing_page_content, $matches)) {
                $instance_num++;
              } else {
                $all_instances_printed = true;
              }
            }
            // get the first instance of this template on the page being edited,
            // even if there are more
            if (preg_match('/\{\{' . $search_template_str . '\s*(?:(?:([\||:].*?)\}\})|()\}\})/mis', $existing_page_content, $matches)) {
              $existing_template_text = $matches[1];
              // create array of contents of this template
              // somewhat of a hack - this array starts out with one element,
              // so that adding fields with no corresponding key will give them
              // an index starting with 1, not 0, to match MediaWiki's counting
              // system
              $template_contents = array(null);
              // cycle through template call, splitting it up by pipes ('|'),
              // except when that pipe is part of a piped link
              $field = "";
              $uncompleted_square_brackets = 0;
              for ($i = 0; $i < strlen($existing_template_text); $i++) {
                $c = $existing_template_text[$i];
                if (($i == strlen($existing_template_text) - 1) ||
                    ($c == '|' && $uncompleted_square_brackets == 0)) {
                  if ($field != null) {
                    // if this was the last character in the template, append
                    // this character
                    if ($i == strlen($existing_template_text) - 1) {
                      $field .= $c;
                    }
                    // either there's an equals sign near the beginning or not -
                    // handling is similar in either way; if there's no equals
                    // sign, the index of this field becomes the key
                    $sub_fields = explode('=', $field, 2);
                    if (count($sub_fields) > 1) {
                      $template_contents[trim($sub_fields[0])] = trim($sub_fields[1]);
                    } else {
                      $template_contents[] = trim($sub_fields[0]);
                    }
                    $field = '';
                  }
                } else {
                  $field .= $c;
                  if ($c == '[') {
                    $uncompleted_square_brackets++;
                  } elseif ($c == ']' && $uncompleted_square_brackets > 0) {
                    $uncompleted_square_brackets--;
                  }
                }
              }
              // now remove this template from the text being edited
              // if this is a partial form, establish a new insertion point
              if ($existing_page_content && $form_is_partial && $wgRequest->getCheck('partial')) {
              	// if something already exists, set the new insertion point
                // to its position; otherwise just let it lie
                if (strpos($existing_page_content, $matches[0]) !== false) {
                  $existing_page_content = str_replace('{{{insertionpoint}}}', '', $existing_page_content);
                  $existing_page_content = str_replace($matches[0], '{{{insertionpoint}}}', $existing_page_content);
                }
              } else {
                $existing_page_content = str_replace($matches[0], '', $existing_page_content);
              }
              // if this is not a multiple-instance template, and we've found
              // a match in the source page, there's a good chance that this
              // page was created with this form - note that, so we don't
              // send the user a warning
              // (multiple-instance templates have a greater chance of
              // getting repeated from one form to the next)
              if (! $allow_multiple) {
                $source_page_matches_this_form = true;
              }
            }
          }
          // if the input is from the form (meaning the user has hit one
          // of the bottom row of buttons), and we're dealing with a
          // multiple template, get the values for this instance of this
          // template, then delete them from the array, so we can get the
          // next group next time - the next() command for arrays doesn't
          // seem to work here
         if ((! $source_is_page) && $allow_multiple && $wgRequest) {
            $all_instances_printed = true;
            if ($old_template_name != $template_name) {
              $all_values_for_template = $wgRequest->getArray($query_template_name);
            }
            if ($all_values_for_template) {
              $cur_key = key($all_values_for_template);
              // skip the input coming in from the "starter" div
              if ($cur_key == 'num') {
                unset($all_values_for_template[$cur_key]);
                $cur_key = key($all_values_for_template);
              }
              if ($template_instance_query_values = current($all_values_for_template)) {
                $all_instances_printed = false;
                unset($all_values_for_template[$cur_key]);
              }
            }
          }
        // =====================================================
        // end template processing
        // =====================================================
        } elseif ($tag_title == 'end template') {
          // remove this tag, reset some variables, and close off form HTML tag
          $section = substr_replace($section, '', $brackets_loc, $brackets_end_loc + 3 - $brackets_loc);
          $template_name = null;
          if (isset($template_label)) {
            $form_text .= "</fieldset>\n";
            unset ($template_label);
          }
          $allow_multiple = false;
          $all_instances_printed = false;
          $instance_num = 0;
          // if the hiding placeholder is still around, this fieldset should
          // be hidden because it is empty and choosers are being used. So,
          // hide it.
          $form_text = str_replace("[[placeholder]]", "style='display:none'", $form_text);
        // =====================================================
        // field processing
        // =====================================================  
        } elseif ($tag_title == 'field') {
          $field_name = trim($tag_components[1]);
          // cycle through the other components
          $is_mandatory = false;
          $is_hidden = false;
          $is_restricted = false;
          $is_uploadable = false;
          $is_list = false;
          $input_type = null;
          $field_args = array();
          $default_value = "";
          $possible_values = null;
          $preload_page = null;
          for ($i = 2; $i < count($tag_components); $i++) {
            $component = trim($tag_components[$i]);
            if ($component == 'mandatory') {
              $is_mandatory = true;
            } elseif ($component == 'hidden') {
              $is_hidden = true;
            } elseif ($component == 'restricted') {
              $is_restricted = true;
            } elseif ($component == 'uploadable') {
              $field_args['is_uploadable'] = true;
            } elseif ($component == 'list') {
              $is_list = true;
            } elseif ($component == 'autocomplete') {
              $field_args['autocomplete'] = true;
            } elseif ($component == 'no autocomplete') {
              $field_args['no autocomplete'] = true;
            } elseif ($component == 'remote autocompletion') {
              $field_args['remote_autocompletion'] = true;
            } else {
              $sub_components = explode('=', $component);
              if (count($sub_components) == 2) {
                if ($sub_components[0] == 'input type') {
                  $input_type = $sub_components[1];
                } elseif ($sub_components[0] == 'default') {
                  $default_value = $sub_components[1];
                } elseif ($sub_components[0] == 'preload') {
                  $preload_page = $sub_components[1];
                } elseif ($sub_components[0] == 'values') {
                  $possible_values = explode(',', $sub_components[1]);
                } else {
                  $field_args[$sub_components[0]] = $sub_components[1];
                }
                // for backwards compatibility
                if ($sub_components[0] == 'autocomplete on' && $sub_components[1] == null) {
                    $field_args['no autocomplete'] = true;
                  }
              }
            }
          }
          $field_args['part_of_multiple'] = $allow_multiple;
          // get the value from the request, if it's there, and if it's not
          // an array
          if (isset($template_instance_query_values) &&
              $template_instance_query_values != null &&
              array_key_exists($field_name, $template_instance_query_values)) {
            $field_query_val = $template_instance_query_values[$field_name];
            if ($form_submitted || ($field_query_val && ! is_array($field_query_val))) {
              $cur_value = $field_query_val;
            }
          } else
            $cur_value = '';
          if ($cur_value && ! is_array($cur_value)) {
            $cur_value = Sanitizer::safeEncodeAttribute($cur_value);
            // ampersands don't need to be escaped - undo their encoding
            $cur_value = str_replace('&amp;', '&', $cur_value);
          }

          if ($cur_value == null) {
            // set to default value specified in the form, if it's there
            $cur_value = $default_value;
          }

          // if the user is starting to edit a page, and that page contains
          // the current template being processed, get the current template
          // field's value in the existing page
          if ($source_is_page && (! empty($existing_template_text))) {
            if (isset($template_contents[$field_name]))
              $cur_value = $template_contents[$field_name];
            else
              $cur_value = '';
            if ($cur_value) {
              $cur_value = Sanitizer::safeEncodeAttribute($cur_value);
              // ampersands don't need to be escaped - undo their encoding
              $cur_value = str_replace('&amp;', '&', $cur_value);
            }
          }

          // handle non-template fields - 'page title' and 'free text'
          if ($template_name == '') {
            if ($field_name == 'page title') {
              // the actual value should be non-null - stick it in
              $new_text = $page_title;
            } elseif ($field_name == 'free text') {
              // add placeholders for the free text in both the form and
              // the page, using <free_text> tags - once all the free text
              // is known (at the end), it will get substituted in
              if ($is_hidden) {
                $new_text = $this->hiddenFieldHTML('free_text', '<free_text>');
              } else {
                if (! array_key_exists('rows', $field_args))
                  $field_args['rows'] = 5;
                if (! array_key_exists('cols', $field_args))
                  $field_args['cols'] = 80;
                $sfgTabIndex++;
                $sfgFieldNum++;
                list($new_text, $new_javascript_text) = SFFormInputs::textAreaHTML('<free_text>', 'free_text', false, $form_is_disabled, $field_args);
              }
              $free_text_was_included = true;
              // add a similar placeholder to the data text
              $data_text .= "<free_text>\n";
            }
            $section = substr_replace($section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc);
          } else { // this field is part of a template
            if (is_array($cur_value)) {
              // first, check if it's a list
              if (array_key_exists('is_list', $cur_value) &&
                  $cur_value['is_list'] == true) {
                $cur_value_in_template = "";
                if (array_key_exists('delimiter', $field_args)) {
                  $delimiter = $field_args['delimiter'];
                } else {
                  $delimiter = ",";
                }
                foreach ($cur_value as $key => $val) {
                  if ($key !== "is_list") {
		    if ($cur_value_in_template != "") {
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
                if (count($cur_value) == 1) {
                  $words_for_false = explode(',', wfMsgForContent('smw_false_words'));
                  // for each language, there's a series of words that are
                  // equal to false - get the word in the series that matches
                  // "no"; generally, that's the third word
                  $index_of_no = 2;
                  if (count($words_for_false) > $index_of_no) {
                    $no = ucwords($words_for_false[$index_of_no]);
                  } elseif (count($words_for_false) == 0) {
                    $no = "0"; // some safe value if no words are found
                  } else {
                    $no = ucwords($words_for_false[0]);
                  }
                  $cur_value_in_template = $no;
                } elseif (count($cur_value) == 2) {
                  $words_for_true = explode(',', wfMsgForContent('smw_true_words'));
                  // get the value in the 'true' series that tends to be "yes",
                  // and go with that one - generally, that's the third word
                  $index_of_yes = 2;
                  if (count($words_for_true) > $index_of_yes) {
                    $yes = ucwords($words_for_true[$index_of_yes]);
                  } elseif (count($words_for_true) == 0) {
                    $yes = "1"; // some safe value if no words are found
                  } else {
                    $yes = ucwords($words_for_true[0]);
                  }
                  $cur_value_in_template = $yes;
                // if it's 3 or greater, assume it's a date or datetime
                } elseif (count($cur_value) >= 3) {
                  $month = $cur_value['month'];
                  $day = $cur_value['day'];
                  if ($day != '') {
                    global $wgAmericanDates;
                    if ($wgAmericanDates == false) {
                      // pad out day to always be two digits
                      $day = str_pad($day, 2, "0", STR_PAD_LEFT);
                    }
                  }
                  $year = $cur_value['year'];
                  if (isset($cur_value['hour'])) $hour = $cur_value['hour'];
                  if (isset($cur_value['minute'])) $minute = $cur_value['minute'];
                  if (isset($cur_value['second'])) $second = $cur_value['second'];
                  if (isset($cur_value['ampm24h'])) $ampm24h = $cur_value['ampm24h'];
                  if (isset($cur_value['timezone'])) $timezone = $cur_value['timezone'];
                  if ($month != '' && $day != '' && $year != '') {
                    // special handling for American dates - otherwise, just
                    // the standard year/month/day (where month is a number)
                    global $wgAmericanDates;
                    if ($wgAmericanDates == true) {
                      $cur_value_in_template = "$month $day, $year";
                    } else {
                      $cur_value_in_template = "$year/$month/$day";
                    }
                    // include whatever time information we have
                    if(isset($hour)) $cur_value_in_template .= " " . str_pad(intval(substr($hour,0,2)),2,'0',STR_PAD_LEFT) . ":" . str_pad(intval(substr($minute,0,2)),2,'0',STR_PAD_LEFT);
                    if(isset($second)) $cur_value_in_template .= ":" . str_pad(intval(substr($second,0,2)),2,'0',STR_PAD_LEFT);
                    if(isset($ampm24h)) $cur_value_in_template .= " $ampm24h";
                    if(isset($timezone)) $cur_value_in_template .= " $timezone";
                  } else {
                    $cur_value_in_template = "";
                  }
                }
              }
            } else { // value is not an array
              $cur_value_in_template = $cur_value;
            }
            if ($query_template_name == null || $query_template_name == '')
              $input_name = $field_name;
            elseif ($allow_multiple)
              // 'num' will get replaced by an actual index, either in PHP
              // or in Javascript, later on
              $input_name = $query_template_name . '[num][' . $field_name . ']';
            else
              $input_name = $query_template_name . '[' . $field_name . ']';

            // if we're creating the page name from a formula based on
            // form values, see if the current input is part of that formula,
            // and if so, substitute in the actual value
            if ($form_submitted && $generated_page_name != '') {
              $true_input_name = str_replace('_', ' ', $input_name);
              $generated_page_name = str_ireplace("<$true_input_name>", $cur_value_in_template, $generated_page_name);
            }
            // disable this field if either the whole form is disabled, or
            // it's a restricted field and user doesn't have sysop privileges
            $is_disabled = ($form_is_disabled ||
              ($is_restricted && (! $wgUser || ! $wgUser->isAllowed('delete'))));
            // create an SFFormTemplateField instance based on all the
            // parameters in the form definition, and any information from
            // the template definition (contained in the $all_fields parameter)
            $form_field = SFFormTemplateField::createFromDefinition($field_name, $input_name,
              $is_mandatory, $is_hidden, $is_uploadable, $possible_values, $is_disabled,
              $is_list, $input_type, $field_args, $all_fields, $strict_parsing);
            // if this is not part of a 'multiple' template, incrememt the
            // global tab index (used for correct tabbing)
            if (! $field_args['part_of_multiple'])
              $sfgTabIndex++;
            // increment the global field number regardless
            $sfgFieldNum++;
            // if the field is a date field, and its default value was set
            // to 'now', and it has no current value, set $cur_value to be
            // the current date
            if ($default_value == 'now' &&
                // if the date is hidden, cur_value will already be set
                // to the default value
                ($cur_value == '' || $cur_value == 'now')) {
              if ($input_type == 'date' || $input_type == 'datetime' ||
                  $input_type == 'datetime with timezone' ||
                  ($input_type == '' && $form_field->template_field->field_type == 'Date')) {
                $cur_time = time();
                $year = date("Y", $cur_time);
                $month = date("n", $cur_time);
                $day = date("j", $cur_time);
                global $wgAmericanDates;
                if ($wgAmericanDates == true) {
                  $month_names = sffGetMonthNames();
                  $month_name = $month_names[$month - 1];
                  $cur_value_in_template = "$month_name $day, $year";
                } else {
                  $cur_value_in_template = "$year/$month/$day";
                }
                if ($input_type ==  'datetime' || $input_type == 'datetime with timezone') {
                  $hour = str_pad(intval(substr(date("g", $cur_time),0,2)),2,'0',STR_PAD_LEFT);
                  $minute = str_pad(intval(substr(date("i", $cur_time),0,2)),2,'0',STR_PAD_LEFT);
                  $second = str_pad(intval(substr(date("s", $cur_time),0,2)),2,'0',STR_PAD_LEFT);
                  $ampm = date("A", $cur_time);
                  $cur_value_in_template .= " $hour:$minute:$second $ampm";
                }
                if ($input_type == 'datetime with timezone') {
                  $timezone = date("T", $cur_time);
                  $cur_value_in_template .= " $timezone";
                }
              }
            }
            list($new_text, $new_javascript_text) = $this->formFieldHTML($form_field, $cur_value);

            $fields_javascript_text .= $new_javascript_text;

            // if this was field was disabled due to being 'restricted',
            // add a hidden field holding the value of this field, because
            // disabled inputs for some reason don't submit their value
            if ($is_restricted && ! $wgUser->isAllowed('delete')) {
              if ($field_name == 'free text') {
                $new_text .= $this->hiddenFieldHTML('free_text', '<free_text>');
              } else {
                $new_text .= $this->hiddenFieldHTML($input_name, $cur_value);
              }
            }

            if ($new_text) {
              if (is_numeric($field_name)) {
                // if the value is null, don't include it at all -
                // TODO: this isn't quite right
                if ($cur_value_in_template != '')
                  $template_text .= "|$cur_value_in_template";
              } else {
                // if the value is null, don't include it at all
                if ($cur_value_in_template != '')
                  $template_text .= "\n|$field_name=$cur_value_in_template";
              }
              $section = substr_replace($section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc);
              // also add to Javascript validation code
              $input_id = "input_" . $sfgFieldNum;
              $info_id = "info_" . $sfgFieldNum;
              if ($is_mandatory) {
                if ($input_type == 'date' || $input_type == 'datetime' || $input_type == 'datetime with timezone') {
                  $sfgJSValidationCalls[] = "validate_mandatory_field ('$input_id" . "_month', '$info_id')";
                  $sfgJSValidationCalls[] = "validate_mandatory_field ('$input_id" . "_day', '$info_id')";
                  $sfgJSValidationCalls[] = "validate_mandatory_field ('$input_id" . "_year', '$info_id')";
                  if ($input_type == 'datetime' || $input_type == 'datetime with timezone') {
                    // TODO - validate the time fields
                    if ($input_type == 'datetime with timezone') {
                       // TODO - validate the timezone
                    }
                  }
                } else {
                  if ($allow_multiple) {
                    $sfgJSValidationCalls[] = "validate_multiple_mandatory_fields($sfgFieldNum)";
                  } else {
                    $sfgJSValidationCalls[] = "validate_mandatory_field('$input_id', '$info_id')";
                  }
                }
              }
            } else {
              $start_position = $brackets_end_loc;
            }
          }
        // =====================================================
        // standard input processing
        // =====================================================
        } elseif ($tag_title == 'standard input') {
          // set a flag so that the standard 'form bottom' won't get displayed
          $this->standardInputsIncluded = true;
          // handle all the possible values
          $input_name = $tag_components[1];
          $input_label = null;
          // cycle through the other components
          for ($i = 2; $i < count($tag_components); $i++) {
            $component = $tag_components[$i];
            $sub_components = explode('=', $component);
            if (count($sub_components) == 2) {
              if ($sub_components[0] == 'label') {
                $input_label = $sub_components[1];
              }
            }
          }
          if ($input_name == 'summary') {
            $new_text = $this->summaryInputHTML($form_is_disabled, $input_label);
          } elseif ($input_name == 'minor edit') {
            $new_text = $this->minorEditInputHTML($form_is_disabled, $input_label);
          } elseif ($input_name == 'watch') {
            $new_text = $this->watchInputHTML($form_is_disabled, $input_label);
          } elseif ($input_name == 'save') {
            $new_text = $this->saveButtonHTML($form_is_disabled, $input_label);
          } elseif ($input_name == 'preview') {
            $new_text = $this->showPreviewButtonHTML($form_is_disabled, $input_label);
          } elseif ($input_name == 'changes') {
            $new_text = $this->showChangesButtonHTML($form_is_disabled, $input_label);
          } elseif ($input_name == 'cancel') {
            $new_text = $this->cancelLinkHTML($form_is_disabled, $input_label);
          }
          $section = substr_replace($section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc);
        // =====================================================
        // page info processing
        // =====================================================
        } elseif ($tag_title == 'info') {
          // TODO: Generate an error message if this is included more than once
          foreach(array_slice($tag_components, 1) as $component) {
            $sub_components = explode('=', $component, 2);
            $tag = $sub_components[0];
            if ($tag == 'add title') {
              // handle this only if we're adding a page
              if (! $this->mPageTitle->exists()) {
                $val = $sub_components[1];
                $form_page_title = $val;
              }
            }
            elseif($tag == 'edit title') {
              // handle this only if we're editing a page
              if ($this->mPageTitle->exists()) {
                $val = $sub_components[1];
                $form_page_title = $val;
              }
            }
            elseif($tag == 'partial form') {           		
              $form_is_partial = true;
              // replacement pages may have minimal matches...
              $source_page_matches_this_form = true;
              }
            }
          $section = substr_replace($section, '', $brackets_loc, $brackets_end_loc + 3 - $brackets_loc);
        // =====================================================
        // default outer level processing
        // =====================================================
        } else { // tag is not one of the three allowed values
          // ignore tag
          $start_position = $brackets_end_loc;
        } // end if
      } // end while

      if (! $all_instances_printed ) {
        if ( $template_text != '' ) {
          // add another newline before the final bracket, if this template
          // call is already more than one line
          if (strpos($template_text, "\n"))
            $template_text .= "\n";
            $template_text .= "}}";
            $data_text .= $template_text . "\n";
            // if there is a placeholder in the text, we know that we are
            // doing a replace
            if ($existing_page_content && strpos($existing_page_content, '{{{insertionpoint}}}', 0) !== false) {
              $existing_page_content = preg_replace('/\{\{\{insertionpoint\}\}\}(\r?\n?)/', 
                preg_replace('/\}\}/m', '}²',
                  preg_replace('/\{\{/m', '²{', $template_text)) .
                "\n{{{insertionpoint}}}",
                $existing_page_content);
          // otherwise, if it's a partial form, we have to add the new
          // text somewhere
          } elseif ($form_is_partial && $wgRequest->getCheck('partial') ) {
            $existing_page_content = preg_replace('/\}\}/m', '}²',
              preg_replace('/\{\{/m', '²{', $template_text)) .
                "\n{{{insertionpoint}}}\n" . $existing_page_content;
          }
        }
      }

      if ($allow_multiple) {
        if (! $all_instances_printed) {
          // add the character "a' onto the instance number of this input
          // in the form, to differentiate the inputs the form starts out
          // with from any inputs added by the Javascript
          $section = str_replace('[num]', "[{$instance_num}a]", $section);
          $remove_text = wfMsg('sf_editdata_remove');
          $form_text .=<<<END
	<div id="wrapper_$sfgFieldNum" class="multipleTemplate">
        $section
        <input type="button" onclick="removeInstance('wrapper_$sfgFieldNum');" value="$remove_text" tabindex="$sfgTabIndex" class="remove" />
        </div>

END;
          // this will cause the section to be re-parsed on the next go
          $section_num--;
          // because there is an instance, the fieldset will never be hidden,
          // even if choosers are being used. So, do not hide the fieldset.
          $form_text = str_replace("[[placeholder]]", "", $form_text);
        } else {
          // this is the last instance of this template - stick an 'add'
          // button in the form
        $form_text .=<<<END
	<div id="starter_$query_template_name" class="multipleTemplate" style="display: none;">
        $section
        </div>
         <div id="main_$query_template_name"></div>

END;
          $add_another = wfMsg('sf_editdata_addanother');
          $form_text .=<<<END
	<p style="margin-left:10px;">
	<p><input type="button" onclick="addInstance('starter_$query_template_name', 'main_$query_template_name', '$sfgFieldNum');" value="$add_another" tabindex="$sfgTabIndex" class="addAnother" /></p>

END;
           // if a chooser is being used for this template, add the template
           // to the chooser data array
          if ($chooser_name !== false)
            $choosers[$chooser_name][]= array($query_template_name, $sfgFieldNum, $chooser_caption);
        }
      } else {
        $form_text .= $section;
      }

    } // end for

    // if it wasn't included in the form definition, add the
    // 'free text' input as a hidden field at the bottom
    if (! $free_text_was_included) {
      $form_text .= $this->hiddenFieldHTML('free_text', '<free_text>');
    }
    // get free text, and add to page data, as well as retroactively
    // inserting it into the form

    // If $form_is_partial is true then either:
    // (a) we're processing a replacement (param 'partial' == 1)
    // (b) we're sending out something to be replaced (param 'partial' is missing)
    if ($form_is_partial) {
       if(!$wgRequest->getCheck('partial')) {
         $free_text = $original_page_content;
         $form_text .= $this->hiddenFieldHTML('partial', 1);
       } else {
         $free_text = null;
         $existing_page_content = preg_replace('/²\{(.*?)\}²/s', '{{\1}}', $existing_page_content);
         $existing_page_content = preg_replace('/\{\{\{insertionpoint\}\}\}/', '', $existing_page_content);
         $existing_page_content = Sanitizer::safeEncodeAttribute($existing_page_content);
       }
    } elseif ($source_is_page) {
      // if the page is the source, free_text will just be whatever in the
      // page hasn't already been inserted into the form
      $free_text = trim($existing_page_content);
    // or get it from a form submission
    } elseif ($wgRequest->getCheck('free_text')) {
      $free_text = $wgRequest->getVal('free_text');
      if (! $free_text_was_included) {
        $data_text .= "<free_text>";
      }
    // or get it from the form definition
    } elseif ($preload_page != null) {
      $free_text = $this->getPreloadedText($preload_page);
    } else {
      $free_text = null;
    }
    $free_text = Sanitizer::safeEncodeAttribute($free_text);
    // now that we have it, substitute free text into the form and page
    $form_text = str_replace('<free_text>', $free_text, $form_text);
    $data_text = str_replace('<free_text>', $free_text, $data_text);

    // add a warning in, if we're editing an existing page and that page
    // appears to not have been created with this form
    if ($this->mPageTitle->exists() && ($existing_page_content != '') && ! $source_page_matches_this_form) {
      $form_text = '	<div class="warningMessage">' . wfMsg('sf_editdata_formwarning', $this->mPageTitle->getFullURL()) . "</div>\n" . $form_text;
    }

    //Substitute the choosers in here too.
    $chooser_count = 0;
    $chooser_text = "";
    $using_choosers = "false";
    foreach ($choosers as $choosername => $chooser) {
      if (count($chooser)!=0) {
        $chooser_count++;
        if ($chooser_count==1) {
          // emit the initial javascript code
          $using_choosers = "true";
          $chooser_text .= <<<END
<script type="text/javascript">/* <![CDATA[ */

function updatechooserbutton(f,n)
{
	document.getElementById(n).disabled = (f.options[f.selectedIndex].value=="invalid");
}

function addInstanceFromChooser(chooserid)
{
	var chooser = document.getElementById(chooserid);
	var optionstring = chooser.options[chooser.selectedIndex].value;
	var pos = optionstring.indexOf(",");
	var tabindex = optionstring.substr(0,pos);
	var chooservalue = optionstring.substr(pos+1);
	addInstance('starter_' + chooservalue, 'main_' + chooservalue, parseInt(tabindex));
}

//The fieldset containing the given element was just updated. If the fieldset is associated with a chooser,
//ensure that the fieldset is hidden if and only if there are no template instances inside.
function hideOrShowFieldset(element)
{
	//Find fieldset
	while (element.tagName.toLowerCase() != "fieldset")
		element = element.parentNode;
	//Bail out if fieldset is not part of chooser
	if (!element.getAttribute("haschooser"))
		return;
	//Now look for "input" or "select" tags that don't look like they're part of the starter template
	var inputs = element.getElementsByTagName("input");
	var x;
	var show = false;
	for (x=0;x<inputs.length;x++)
	{
		if (inputs[x].type=="text" && inputs[x].name.indexOf("[num]") == -1)
			show = true;
	}
	var selects = element.getElementsByTagName("select");
	for (x=0;x<selects.length;x++)
	{
		if (selects[x].name.indexOf("[num]") == -1)
			show = true;
	}
	//Now show or hide fieldset
	element.style.display = (show?"block":"none");
}
/* ]]> */ </script>

END;
        }

        $chooser_text .= "<p>$choosername:<select id='chooserselect$chooser_count' size='1' onchange='updatechooserbutton(this,\"chooserbutton$chooser_count\")'>\n";
        $chooser_text .= "<option value='invalid'>" . wfMsg('sf_createform_choosefield') . "</option>\n";
        foreach ($chooser as $chooser_item) {
          $chooser_value = str_replace('"','\\"',$chooser_item[0]);
          $tabindex = $chooser_item[1];
          $chooser_caption = $chooser_item[2];
          if ($chooser_caption === false)
            $chooser_caption = str_replace('_', ' ', $chooser_value);
          $chooser_text .= "<option value=\"$tabindex ,$chooser_value\">$chooser_caption</option>\n";
        }
        $chooser_text .= "</select>\n";
      }
      $chooser_text .= "<input type='button' onclick=\"addInstanceFromChooser('chooserselect$chooser_count');\" value='" . wfMsg('sf_editdata_addanother') . "' disabled='true' id='chooserbutton$chooser_count'></p>";
    }
	
    $form_text = str_replace('{{{choosers}}}', $chooser_text, $form_text);

    // add form bottom, if no custom "standard inputs" have been defined
    if (! $this->standardInputsIncluded)
      $form_text .= $this->formBottom($form_is_disabled);
    $starttime = wfTimestampNow();
    $page_article = new Article($this->mPageTitle);
    $edittime = $page_article->getTimestamp();
    $form_text .=<<<END

	<input type="hidden" value="$starttime" name="wpStarttime" />
	<input type="hidden" value="$edittime" name="wpEdittime" />
	</form>

END;

    // add general Javascript code
    $form_errors_header = wfMsg('sf_formerrors_header');
    $blank_error_str = wfMsg('sf_blank_error');
    $bad_url_error_str = wfMsg('sf_bad_url_error');
    $bad_email_error_str = wfMsg('sf_bad_email_error');
    $bad_number_error_str = wfMsg('sf_bad_number_error');
    $bad_integer_error_str = wfMsg('sf_bad_integer_error');
    $bad_date_error_str = wfMsg('sf_bad_date_error');
    $javascript_text .=<<<END

function validate_mandatory_field(field_id, info_id) {
	field = document.getElementById(field_id);
	if (field.value.replace(/\s+/, '') == '') {
		infobox = document.getElementById(info_id);
		infobox.innerHTML = "$blank_error_str";
		return false;
	} else {
		return true;
	}
}

// validate a mandatory field that exists across multiple instances of
// a template - we have to find each one, matching on the pattern of its
// ID, and validate it
function validate_multiple_mandatory_fields(field_num) {
	var num_errors = 0;
	elems = document.getElementsByTagName("*");
	var field_pattern = new RegExp('input_(.*)_' + field_num);
	for (var i = 0; i < elems.length; i++) {
		id = elems[i].id;
		if (matches = field_pattern.exec(id)) {
			instance_num = matches[1];
			var input_name = "input_" + instance_num + "_" + field_num;
			var info_name = "info_" + instance_num + "_" + field_num;
			if (! validate_mandatory_field(input_name, info_name)) {
				num_errors += 1;
			}
		}
	}
	return (num_errors == 0);
}

function validate_field_type(field_id, type, info_id) {
	field = document.getElementById(field_id);
	if (type != 'date' && field.value == '') {
		return true;
	} else {
		if (type == 'URL') {
			// code borrowed from http://snippets.dzone.com/posts/show/452
			var url_regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			if (url_regexp.test(field.value)) {
				return true;
			} else {
				infobox = document.getElementById(info_id);
				infobox.innerHTML = "$bad_url_error_str";
				return false;
			}
		} else if (type == 'email') {
			// code borrowed from http://javascript.internet.com/forms/email-validation---basic.html
			var email_regexp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if (email_regexp.test(field.value)) {
				return true;
			} else {
				infobox = document.getElementById(info_id);
				infobox.innerHTML = "$bad_email_error_str";
				return false;
			}
		} else if (type == 'float') {
			if (field.value.match(/^[\d\.,]+$/)) {
				return true;
			} else {
				infobox = document.getElementById(info_id);
				infobox.innerHTML = "$bad_number_error_str";
				return false;
			}
		} else if (type == 'integer') {
			var num_regexp = /[0-9,]*/;
			if (field.value.match(/^[\d,]+$/)) {
				return true;
			} else {
				infobox = document.getElementById(info_id);
				infobox.innerHTML = "$bad_integer_error_str";
				return false;
			}
		} else if (type == 'date') {
			// validate only if day and year fields are both filled in
			day_field = document.getElementById(field_id + "_day");
			year_field = document.getElementById(field_id + "_year");
			if (day_field.value == '' || year_field.value == '') {
				return true;
			} else if (day_field.value.match(/^\d+$/) &&
				   day_field.value <= 31 &&
				   year_field.value.match(/^\d+$/)) {
				return true;
			} else {
				infobox = document.getElementById(info_id);
				infobox.innerHTML = "$bad_date_error_str";
				return false;
			}
		} else {
			return true;
		}
	}
}

// same as validate_multiple_mandatory_fields(), but for type validation
function validate_type_of_multiple_fields(field_num, type) {
	var num_errors = 0;
	elems = document.getElementsByTagName("*");
	var field_pattern = new RegExp('input_(.*)_' + field_num);
	for (var i = 0; i < elems.length; i++) {
		id = elems[i].id;
		if (matches = field_pattern.exec(id)) {
			instance_num = matches[1];
			var input_name = "input_" + instance_num + "_" + field_num;
			var info_name = "info_" + instance_num + "_" + field_num;
			if (! validate_field_type(input_name, type, info_name)) {
				num_errors += 1;
			}
		}
	}
	return (num_errors == 0);
}


function validate_all() {
	var num_errors = 0;

END;
    foreach ($sfgJSValidationCalls as $function_call) {
      $javascript_text .= "	if (! $function_call) num_errors += 1;\n";
    }
    $remove_text = wfMsg('sf_editdata_remove');
    $delimiter = '","';
    $javascript_text .=<<<END
	if (num_errors > 0) {
		// add error header, if it's not there already
		if (! document.getElementById("form_error_header")) {
			var errorMsg = document.createElement('div');
			errorMsg.innerHTML = "<div id=\"form_error_header\" class=\"warningMessage\" style=\"font-size: medium\">$form_errors_header</div>";
			document.getElementById("contentSub").appendChild(errorMsg);
		}
		scroll(0, 0);
	}
	return (num_errors == 0);
}

var num_elements = 0;

function addInstance(starter_div_id, main_div_id, tab_index)
{
	var starter_div = document.getElementById(starter_div_id);
	var main_div = document.getElementById(main_div_id);
	num_elements++;
	
	//Create the new instance
	var new_div = starter_div.cloneNode(true);
	var div_id = 'div_gen_' + num_elements;
	new_div.className = 'multipleTemplate';
	new_div.id = div_id;
	new_div.style.display = 'block';
	
	// make internal ID unique for the relevant divs and spans, and replace
	// the [num] index in the element names with an actual unique index
	var children = new_div.getElementsByTagName('*');
	var x;
	for (x = 0; x < children.length; x++)
	{
		if (children[x].name)
			children[x].name = children[x].name.replace(/\[num\]/g, '[' + num_elements + ']');
		if (children[x].id)
			children[x].id = children[x].id
				.replace(/input_/g, 'input_' + num_elements + '_')
				.replace(/info_/g, 'info_' + num_elements + '_')
				.replace(/div_/g, 'div_' + num_elements + '_');
	}

	//Create remove button
	var remove_button = document.createElement('input');
	remove_button.type = 'button';
	remove_button.value = "$remove_text";
	remove_button.tabIndex = tab_index;
	remove_button.onclick = removeInstanceEventHandler(div_id);
	new_div.appendChild(remove_button);
	
	//Add the new instance
	main_div.appendChild(new_div);
	attachAutocompleteToAllFields(new_div);
	
	if ($using_choosers) {
		hideOrShowFieldset(new_div);
	}
}

function removeInstanceEventHandler(this_div_id)
{
	return function() {
		removeInstance(this_div_id);
	};
}

function removeInstance(div_id) {
	var olddiv = document.getElementById(div_id);
	var parent = olddiv.parentNode;
	parent.removeChild(olddiv);
	if ($using_choosers)
		hideOrShowFieldset(parent);
}

var autocompletemappings = new Array();
var autocompletestrings = new Array();
var autocompletedatatypes = new Array();

//Activate autocomplete functionality for every field on the document
function attachAutocompleteToAllDocumentFields()
{
	var forms = document.getElementsByTagName("form");
	var x;
	for (x = 0; x < forms.length; x++) {
		if (forms[x].name == "createbox") {
			attachAutocompleteToAllFields(forms[x]);
		}	
	}
}

//Activate autocomplete functionality for every field under the specified element
function attachAutocompleteToAllFields(base)
{
	var inputs = base.getElementsByTagName("input");
	var y;
	for (y = 0; y < inputs.length; y++) {
		attachAutocompleteToField(inputs[y].id);
	}
	// don't forget the textareas
	inputs = base.getElementsByTagName("textarea");
	for (y = 0; y < inputs.length; y++) {
		attachAutocompleteToField(inputs[y].id);
	}
}

//Activate autocomplete functionality for the specified field
function attachAutocompleteToField(input_id)
{
	//Check input id for the proper format, to ensure this is for SF
	if (input_id.substr(0,6) == 'input_')
	{
		//Extract the field ID number from the input field
		var field_num = parseInt(input_id.substring(input_id.lastIndexOf('_') + 1, input_id.length),10);
		//Add the autocomplete string, if a mapping exists.
		var field_string = autocompletemappings[field_num];
		if (field_string) {
			var div_id = input_id.replace(/input_/g, 'div_');
			var field_values = new Array();
			field_values = field_string.split(',');
			var delimiter = null;
			var data_source = field_values[0];
			if (field_values[1] == 'list') {
				delimiter = ",";
				if (field_values[2] != null) {
					delimiter = field_values[2];
				}
			}
			if (autocompletestrings[field_string] != null) {
				sf_autocomplete(input_id, div_id, autocompletestrings[field_string], null, null, delimiter, data_source);
			} else {
				sf_autocomplete(input_id, div_id, null, "{$wgScriptPath}/api.php", autocompletedatatypes[field_string], delimiter, data_source);
			}
		}
	}
}

YAHOO.util.Event.addListener(window, 'load', attachAutocompleteToAllDocumentFields);

END;

    // send the autocomplete values to the browser, along with the mappings
    // of which values should apply to which fields
    // if doing a replace, the data text is actually the modified original page
    if($wgRequest->getCheck('partial'))
      $data_text = $existing_page_content;
    $javascript_text .= $fields_javascript_text;
    return array($form_text, "/*<![CDATA[*/ $javascript_text /*]]>*/",
      $data_text, $form_page_title, $generated_page_name);
  }

  function formFieldHTML($form_field, $cur_value) {
    global $smwgContLang;

    // also get the actual field, with all the semantic information (type is
    // SFTemplateField, instead of SFFormTemplateField)
    $template_field = $form_field->template_field;

    if ($form_field->is_hidden) {
      $text = $this->hiddenFieldHTML($form_field->input_name, $cur_value);
      $javascript_text = "";
    } elseif ($form_field->input_type != '' &&
              array_key_exists($form_field->input_type, $this->mInputTypeHooks) &&
              $this->mInputTypeHooks[$form_field->input_type] != null) {
      $funcArgs = array();
      $funcArgs[] = $cur_value;
      $funcArgs[] = $form_field->input_name;
      $funcArgs[] = $form_field->is_mandatory;
      $funcArgs[] = $form_field->is_disabled;
      // last argument to function should be a hash, merging the default
      // values for this input type with all other properties set in
      // the form definition, plus some semantic-related arguments
      $hook_values = $this->mInputTypeHooks[$form_field->input_type];
      $default_args = $hook_values[1];
      $other_args = $form_field->field_args;
      // if the set of possible values were set in the form definition,
      // go with that
      if ($form_field->possible_values != null)
        $other_args['possible_values'] = $form_field->possible_values;
      else
        $other_args['possible_values'] = $template_field->possible_values;
      // the fact that this is a list can be specified in either the
      // template or the form
      $other_args['is_list'] = ($template_field->is_list || $form_field->is_list);
      if ($template_field->is_relation)
        $other_args['is_relation'] = true;
      if ($template_field->semantic_field != '')
        $other_args['semantic_field_name'] = $template_field->semantic_field;
      // merge default values and values from form - put the default values
      // first, so that if there's a conflict they'll be overridden
      $funcArgs[] = array_merge($default_args, $other_args);
      list($text, $javascript_text) = call_user_func_array($hook_values[0], $funcArgs);
    // escape out here if user doesn't have SMW installed
    } elseif ($smwgContLang == null) {
      $size = $template_field->field_args['size'];
      if ($size == null) $size = 35;
      $field_args = array('size' => $size);
      list($text, $javascript_text) = SFFormInputs::textEntryHTML($cur_value, $form_field->input_name, $form_field->is_mandatory, $form_field->is_disabled, $field_args);
    } else { // input type not defined in form
      $field_type = $template_field->field_type;
      $is_list = ($form_field->is_list || $template_field->is_list);
      if ($field_type != '' &&
          array_key_exists($field_type, $this->mSemanticTypeHooks) &&
          isset($this->mSemanticTypeHooks[$field_type][$is_list])) {
        $hook_values = $this->mSemanticTypeHooks[$field_type][$is_list];
        $funcArgs = array();
        $funcArgs[] = $cur_value;
        $funcArgs[] = $form_field->input_name;
        $funcArgs[] = $form_field->is_mandatory;
        $funcArgs[] = $form_field->is_disabled;
        // merge default values and values from form - put the default values
        // first, so that if there's a conflict they'll be overridden
        $other_args = array_merge($hook_values[1], $form_field->field_args);
        if ($form_field->possible_values != null)
          $other_args['possible_values'] = $form_field->possible_values;
        else
          $other_args['possible_values'] = $template_field->possible_values;
        if ($template_field->is_relation)
          $other_args['is_relation'] = true;
        if ($template_field->semantic_field != '')
          $other_args['semantic_field_name'] = $template_field->semantic_field;
        $funcArgs[] = $other_args;
        list($text, $javascript_text) = call_user_func_array($hook_values[0], $funcArgs);
      } else { // anything else
        $other_args = $form_field->field_args;
        // set field to be a list if that was specified in the form definition
        if ($form_field->is_list) {
          $other_args['is_list'] = true;
          $other_args['size'] = 100;
        }
        if ($form_field->possible_values != null)
          $other_args['possible_values'] = $form_field->possible_values;
        list($text, $javascript_text) = SFFormInputs::textEntryHTML($cur_value, $form_field->input_name, $form_field->is_mandatory, $form_field->is_disabled, $other_args);
      }
    }
    return array($text, $javascript_text);
  }

  function hiddenFieldHTML($input_name, $cur_value) {
    $text =<<<END
	<input type="hidden" name="$input_name" value="$cur_value" />

END;
    return $text;
  }

  function summaryInputHTML($is_disabled, $label = null) {
    global $sfgTabIndex;

    $sfgTabIndex++;
    if ($label == null)
      $label = wfMsg('summary');
    $disabled_text = ($is_disabled) ? "disabled" : "";
    $text =<<<END
	<span id='wpSummaryLabel'><label for='wpSummary'>$label:</label></span>
	<input tabindex="$sfgTabIndex" type='text' value="" name='wpSummary' id='wpSummary' maxlength='200' size='60' $disabled_text/>

END;
    return $text;
  }

  function minorEditInputHTML($is_disabled, $label = null) {
    global $sfgTabIndex;

    $sfgTabIndex++;
    $disabled_text = ($is_disabled) ? "disabled" : "";
    if ($label == null)
      $label = wfMsgExt('minoredit', array('parseinline'));
    $accesskey = wfMsg('accesskey-minoredit');
    $tooltip = wfMsg('tooltip-minoredit');
    $text =<<<END
	<input tabindex="$sfgTabIndex" type="checkbox" value="1" name="wpMinoredit" accesskey="$accesskey" id="wpMinoredit" $disabled_text/>
	<label for="wpMinoredit" title="$tooltip">$label</label>

END;
    return $text;
  }

  function watchInputHTML($is_disabled, $label = null) {
    global $sfgTabIndex, $wgUser;

    $sfgTabIndex++;
    $checked_text = "";
    $disabled_text = ($is_disabled) ? "disabled" : "";
    // figure out if the checkbox should be checked - 
    // this code borrowed from /includes/EditPage.php
    if ($wgUser->getOption('watchdefault')) {
      # Watch all edits
      $checked_text = "checked";
    } elseif ($wgUser->getOption('watchcreations') && !$this->mPageTitle->exists() ) {
      # Watch creations
      $checked_text = "checked";
    } elseif ($this->mPageTitle->userIsWatching()) {
      # Already watched
      $checked_text = "checked";
    }
    if ($label == null)
      $label = wfMsgExt('watchthis', array('parseinline'));
    $accesskey = htmlspecialchars(wfMsg('accesskey-watch'));
    $tooltip = htmlspecialchars(wfMsg('tooltip-watch'));
    $text =<<<END
	<input tabindex="$sfgTabIndex" type="checkbox" name="wpWatchthis" accesskey="$accesskey" id='wpWatchthis' $checked_text $disabled_text/>
        <label for="wpWatchthis" title="$tooltip">$label</label>

END;
    return $text;
  }

  function saveButtonHTML($is_disabled, $label = null) {
    global $sfgTabIndex;

    $sfgTabIndex++;
    $disabled_text = ($is_disabled) ? "disabled" : "";
    if ($label == null)
      $label = wfMsg('savearticle');
    $temp = array(
      'id'        => 'wpSave',
      'name'      => 'wpSave',
      'type'      => 'submit',
      'tabindex'  => $sfgTabIndex,
      'value'     => $label,
      'accesskey' => wfMsg('accesskey-save'),
      'title'     => wfMsg('tooltip-save'),
      $disabled_text => '',
    );
    $text = "		" . wfElement('input', $temp, '') . "\n";
    return $text;
  }

  function showPreviewButtonHTML($is_disabled, $label = null) {
    global $sfgTabIndex;

    $sfgTabIndex++;
    $disabled_text = ($is_disabled) ? "disabled" : "";
    if ($label == null)
      $label = wfMsg('showpreview');
    $temp = array(
      'id'        => 'wpPreview',
      'name'      => 'wpPreview',
      'type'      => 'submit',
      'tabindex'  => $sfgTabIndex,
      'value'     => $label,
      'accesskey' => wfMsg('accesskey-preview'),
      'title'     => wfMsg('tooltip-preview'),
      $disabled_text => '',
    );
    $text = "		" . wfElement('input', $temp, '') . "\n";
    return $text;
  }

  function showChangesButtonHTML($is_disabled, $label = null) {
    global $sfgTabIndex;

    $sfgTabIndex++;
    $disabled_text = ($is_disabled) ? "disabled" : "";
    if ($label == null)
      $label = wfMsg('showdiff');
    $temp = array(
      'id'        => 'wpDiff',
      'name'      => 'wpDiff',
      'type'      => 'submit',
      'tabindex'  => $sfgTabIndex,
      'value'     => $label,
      'accesskey' => wfMsg('accesskey-diff'),
      'title'     => wfMsg('tooltip-diff'),
      $disabled_text => '',
    );
    $text = "		" . wfElement('input', $temp, '') . "\n";
    return $text;
  }

  function cancelLinkHTML($is_disabled, $label = null) {
    global $wgUser;

    $sk = $wgUser->getSkin();
    if ($label == null)
      $label = wfMsgExt('cancel', array('parseinline'));
    if ($this->mPageTitle == null)
      $cancel = '';
    else
      $cancel = $sk->makeKnownLink( $this->mPageTitle->getPrefixedText(), $label);
    $text = "		<span class='editHelp'>$cancel</span>\n";
    return $text;
  }

  // Much of this function is based on MediaWiki's EditPage::showEditForm()
  function formBottom($is_disabled) {
    global $wgUser;
    
    $summary_text = $this->summaryInputHTML($is_disabled);
    $text =<<<END
	<br /><br />
	<div class='editOptions'>
$summary_text	<br />

END;
    if ( $wgUser->isAllowed('minoredit') ) {
      $text .= $this->minorEditInputHTML($is_disabled);
    }

    if ( $wgUser->isLoggedIn() ) {
      $text .= $this->watchInputHTML($is_disabled);
    }

    $text .=<<<END
	<br />
	<div class='editButtons'>

END;
    $text .= $this->saveButtonHTML($is_disabled);
    $text .= $this->showPreviewButtonHTML($is_disabled);
    $text .= $this->showChangesButtonHTML($is_disabled);
    $text .= $this->cancelLinkHTML($is_disabled);
    $text .=<<<END
	</div><!-- editButtons -->
	</div><!-- editOptions -->

END;
    return $text;
  }

  // based on MediaWiki's EditPage::getPreloadedText()
  function getPreloadedText($preload) {
    if ( $preload === '' ) {
      return '';
    } else {
      $preloadTitle = Title::newFromText( $preload );
      if ( isset( $preloadTitle ) && $preloadTitle->userCanRead() ) {
        $rev = Revision::newFromTitle($preloadTitle);
        if ( is_object( $rev ) ) {
          $text = $rev->getText();
          // Remove <noinclude> sections and <includeonly> tags from text
          $text = StringUtils::delimiterReplace('<noinclude>', '</noinclude>', '', $text);
          $text = strtr($text, array('<includeonly>' => '', '</includeonly>' => ''));
          return $text;
        }
      }
      return '';
    }
  } 

}

?>
