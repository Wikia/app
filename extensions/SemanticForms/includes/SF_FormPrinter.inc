<?php
/**
 * Handles the creation and running of a user-created form.
 *
 * @author Yaron Koren
 * @author Nils Oppermann
 * @author Jeffrey Stuckman
 * @author Harold Solbrig
 * @author Daniel Hansch
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
      $number_type = $datatypeLabels['_num'];
      $bool_type = $datatypeLabels['_boo'];
      $date_type = $datatypeLabels['_dat'];
      $enum_type = 'enumeration'; // not a real type
      $page_type = $datatypeLabels['_wpg'];
      $this->setSemanticTypeHook($string_type, false, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'string'));
      $this->setSemanticTypeHook($string_type, true, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'string', 'is_list' => 'true', 'size' => '100'));
      $this->setSemanticTypeHook($text_type, false, array('SFFormInputs', 'textAreaHTML'), array());
      $this->setSemanticTypeHook($code_type, false, array('SFFormInputs', 'textAreaHTML'), array());
      $this->setSemanticTypeHook($url_type, false, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'URL'));
      $this->setSemanticTypeHook($email_type, false, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'email'));
      $this->setSemanticTypeHook($number_type, false, array('SFFormInputs', 'textEntryHTML'), array('field_type' => 'number'));
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
    $this->setInputTypeHook('year', array('SFFormInputs', 'textEntryHTML'), array('size' => 4));
    $this->setInputTypeHook('checkbox', array('SFFormInputs', 'checkboxHTML'), array());
    $this->setInputTypeHook('radiobutton', array('SFFormInputs', 'radioButtonHTML'), array());
    $this->setInputTypeHook('checkboxes', array('SFFormInputs', 'checkboxesHTML'), array());
    $this->setInputTypeHook('listbox', array('SFFormInputs', 'listboxHTML'), array());
    $this->setInputTypeHook('category', array('SFFormInputs', 'categoryHTML'), array());
    $this->setInputTypeHook('categories', array('SFFormInputs', 'categoriesHTML'), array());

    // initialize other variables
    $this->standardInputsIncluded = false;
  }

  function setSemanticTypeHook($type, $is_list, $function_name, $default_args) {
    $this->mSemanticTypeHooks[$type][$is_list] = array($function_name, $default_args);
  }

  function setInputTypeHook($input_type, $function_name, $default_args) {
    $this->mInputTypeHooks[$input_type] = array($function_name, $default_args);
  }


  /**
   * Show the set of previous deletions for the page being added.
   * This function is copied almost exactly from EditPage::showDeletionLog() -
   * unfortunately, neither that function nor Article::showDeletionLog() can
   * be called from here, since they're both protected
   */
  function showDeletionLog( $out ) {
    // if MW doesn't have LogEventsList defined, exit immediately
    if (! class_exists('LogEventsList'))
      return false;

    global $wgUser;
    $loglist = new LogEventsList( $wgUser->getSkin(), $out );
    $pager = new LogPager( $loglist, 'delete', false, $this->mPageTitle->getPrefixedText() );
    $count = $pager->getNumRows();
    if ( $count > 0 ) {
      $pager->mLimit = 10;
      $out->addHTML( '<div class="mw-warning-with-logexcerpt">' );
      // the message name changed in MW 1.16
      if (! wfEmptyMsg( 'moveddeleted-notice', wfMsg('moveddeleted-notice') ))
        $out->addWikiMsg( 'moveddeleted-notice' );
      else
        $out->addWikiMsg( 'recreate-deleted-warn' );
      $out->addHTML(
        $loglist->beginLogEventsList() .
        $pager->getBody() .
        $loglist->endLogEventsList()
      );
      if($count > 10){
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

  function formHTML($form_def, $form_submitted, $source_is_page, $form_id = null, $existing_page_content = null, $page_name = null, $page_name_formula = null, $is_query = false, $embedded = false) {
    global $wgRequest, $wgUser, $wgParser;
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
    // flag for placing "<onlyinclude>" tags in form output
    $onlyinclude_free_text = false;
    
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
    if ($page_name == '')
      $this->mPageTitle = Title::newFromText(
        $wgRequest->getVal('namespace') . ":Semantic Forms permissions test");
    else
      $this->mPageTitle = Title::newFromText($page_name);
    global $wgOut;
    // show previous set of deletions for this page, if it's been deleted before
    if (! $form_submitted && ! $this->mPageTitle->exists())
      $this->showDeletionLog($wgOut);
    if (($wgUser->isAllowed('edit') && $this->mPageTitle->userCan('edit')) || $is_query) {
      $form_is_disabled = false;
      $form_text = "";
      // show "Your IP address will be recorded" warning if user is
      // anonymous, and it's not a query -
      // wikitext for bolding has to be replaced with HTML
      if ($wgUser->isAnon() && ! $is_query) {
        #wikia change: we wiki text this message, core does not, so need to proper parse
        $anon_edit_warning = wfMsgExt('anoneditwarning', array('parse'));
        $form_text .= $anon_edit_warning . "\n";
        #end wikia change
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
    $form_def = "__NOEDITSECTION__" . strtr($form_def, array('{{{' => '<nowiki>{{{', '}}}' => '}}}</nowiki>'));
    $old_strip_state = $wgParser->mStripState;
    $wgParser->mStripState = new StripState();
    $wgParser->mOptions = new ParserOptions();
    $wgParser->mOptions->initialiseFromUser($wgUser);

    // get the form definition from the cache, if we're using caching and it's
    // there
    $got_form_def_from_cache = false;
    global $sfgCacheFormDefinitions;
    if ($sfgCacheFormDefinitions && ! is_null($form_id)) {
      $db = wfGetDB( DB_MASTER );
      $res = $db->select('page_props', 'pp_value', "pp_propname = 'formdefinition' AND pp_page = '$form_id'");
      if ($res->numRows() >  0) {
        $form_def = $res->fetchObject()->pp_value;
        $got_form_def_from_cache = true;
      }
    }
    // otherwise, parse it
    if (! $got_form_def_from_cache)
      $form_def = $wgParser->parse($form_def, $this->mPageTitle, $wgParser->mOptions)->getText();
    $wgParser->mStripState = $old_strip_state;
    
    // turn form definition file into an array of sections, one for each
    // template definition (plus the first section)
    $form_def_sections = array();
    $start_position = 0;
    $section_start = 0;
    $free_text_was_included = false;
    $free_text_preload_page = null;
    $free_text_components = array();
    $all_values_for_template = array();
    // unencode and HTML-encoded representations of curly brackets and
    // pipes - this is a hack to allow for forms to include templates
    // that themselves contain form elements - the escaping is needed
    // to make sure that those elements don't get parsed too early
    $form_def = str_replace(array('&#123;', '&#124;', '&#125;'), array('{', '|', '}'), $form_def);
    // and another hack - replace the 'free text' standard input with
    // a field declaration to get it to be handled as a field
    $form_def = str_replace('standard input|free text', 'field|<freetext>', $form_def);
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
            $sub_components = explode('=', $component, 2);
            if (count($sub_components) == 2) {
              if ($sub_components[0] == 'label') {
                $template_label = $sub_components[1];
              } elseif ($sub_components[0] == 'chooser') {
                $allow_multiple = true;
                $chooser_name = $sub_components[1];
              } elseif ($sub_components[0] == 'chooser caption') {
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
          if ($source_is_page || $form_is_partial) {
            // replace underlines with spaces in template name, to allow for
            // searching on either
            $search_template_str = str_replace('_', ' ', $tif->template_name);
            $preg_match_template_str = str_replace(
              array('/', '(', ')'),
              array('\/', '\(', '\)'),
              $search_template_str);
            $found_instance = preg_match('/{{' . $preg_match_template_str . '\s*[\|}]/i', str_replace('_', ' ', $existing_page_content));
            if ($allow_multiple) {
              // find instances of this template in the page -
              // if there's at least one, re-parse this section of the
              // definition form for the subsequent template instances in
              // this page; if there's none, don't include fields at all.
              // there has to be a more efficient way to handle multiple
              // instances of templates, one that doesn't involve re-parsing
              // the same tags, but I don't know what it is.
              if ($found_instance) {
                $instance_num++;
              } else {
                $all_instances_printed = true;
              }
            }
            // get the first instance of this template on the page being edited,
            // even if there are more
            if ($found_instance && ($start_char = stripos(str_replace('_', ' ', $existing_page_content), '{{' . $search_template_str)) !== false) {
              $fields_start_char = $start_char + 2 + strlen($search_template_str);
              // skip ahead to the first real character
              while (in_array($existing_page_content[$fields_start_char], array(' ', '\n', '|'))) {
                $fields_start_char++;
              }
              $template_contents = array('0' => '');
              // cycle through template call, splitting it up by pipes ('|'),
              // except when that pipe is part of a piped link
              $field = "";
              $uncompleted_square_brackets = 0;
              $uncompleted_curly_brackets = 2;
              $template_ended = false;
              for ($i = $fields_start_char; ! $template_ended && ($i < strlen($existing_page_content)); $i++) {
                $c = $existing_page_content[$i];
                if ($c == '[') {
                  $uncompleted_square_brackets++;
                } elseif ($c == ']' && $uncompleted_square_brackets > 0) {
                  $uncompleted_square_brackets--;
                } elseif ($c == '{') {
                  $uncompleted_curly_brackets++;
                } elseif ($c == '}' && $uncompleted_curly_brackets > 0) {
                  $uncompleted_curly_brackets--;
                }
                // handle an end to a field and/or template declaration
                $template_ended = ($uncompleted_curly_brackets == 0 && $uncompleted_square_brackets == 0);
                $field_ended = ($c == '|' && $uncompleted_square_brackets == 0 && $uncompleted_curly_brackets <= 2);
                if ($template_ended || $field_ended) {
                  // if this was the last character in the template, remove
                  // the closing curly brackets
                  if ($template_ended) {
                    $field = substr($field, 0, -1);
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
                } else {
                  $field .= $c;
                }
              }
              $existing_template_text = substr($existing_page_content, $start_char, $i - $start_char);
              // now remove this template from the text being edited
              // if this is a partial form, establish a new insertion point
              if ($existing_page_content && $form_is_partial && $wgRequest->getCheck('partial')) {
              	// if something already exists, set the new insertion point
                // to its position; otherwise just let it lie
                if (strpos($existing_page_content, $existing_template_text) !== false) {
                  $existing_page_content = str_replace('{{{insertionpoint}}}', '', $existing_page_content);
                  $existing_page_content = str_replace($existing_template_text, '{{{insertionpoint}}}', $existing_page_content);
                }
              } else {
                $existing_page_content = str_replace($existing_template_text, '', $existing_page_content);
              }
              // if this is not a multiple-instance template, and we've found
              // a match in the source page, there's a good chance that this
              // page was created with this form - note that, so we don't
              // send the user a warning
              // (multiple-instance templates have a greater chance of
              // getting repeated from one form to the next)
              // - on second thought, allow even the presence of multiple-
              // instance templates to validate that this is the correct
              // form: the problem is that some forms contain *only* mutliple-
              // instance templates
              //if (! $allow_multiple) {
              $source_page_matches_this_form = true;
              //}
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
          if ($source_is_page) {
            // add any unhandled template fields in the page as hidden variables
            if (isset($template_contents))
              $form_text .= SFFormUtils::unhandledFieldsHTML($template_contents);
          }
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
          $show_on_select = array();
          $default_value = "";
          $possible_values = null;
          $semantic_property = null;
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
              $field_args['remote autocompletion'] = true;
            } elseif ($component == 'edittools') { // free text only
              $free_text_components[] = 'edittools';
            } else {
              $sub_components = explode('=', $component, 2);
              if (count($sub_components) == 1) {
                // add handling for single-value params, for custom input types
                $field_args[$sub_components[0]] = null;
              } elseif (count($sub_components) == 2) {
                if ($sub_components[0] == 'input type') {
                  $input_type = $sub_components[1];
                } elseif ($sub_components[0] == 'default') {
                  $default_value = $sub_components[1];
                } elseif ($sub_components[0] == 'preload') {
                  // free text field has special handling
                  if ($field_name == 'free text' || $field_name = '<freetext>') {
                    $free_text_preload_page = $sub_components[1];
                  } else {
                    // this variable is not used
                    $preload_page = $sub_components[1];
                  }
                } elseif ($sub_components[0] == 'show on select') {
                  // html_entity_decode() is needed to turn '&gt;' to '>'
                  $vals = explode(';', html_entity_decode($sub_components[1]));
                  foreach ($vals as $val) {
                    $option_div_pair = explode('=>', $val, 2);
                    if (count($option_div_pair) > 1) {
                      $option = $option_div_pair[0];
                      $div_id = $option_div_pair[1];
                      if (array_key_exists($div_id, $show_on_select))
                        $show_on_select[$div_id][] = $option;
                      else
                        $show_on_select[$div_id] = array($option);
                    } else {
                      $show_on_select[$val] = array();
                    }
                  }
                } elseif ($sub_components[0] == 'autocomplete on property') {
                  // HACK - we need to figure out if this property is a
                  // relation or attribute, i.e. whether it points to wiki
                  // pages or not; so construct an SFTemplateField object
                  // with this property, and determine it that way
                  $property_name = $sub_components[1];
                  $dummy_field = new SFTemplateField();
                  $dummy_field->setSemanticProperty($property_name);
                  if ($dummy_field->propertyIsOfType('_wpg'))
                    $field_args['autocomplete field type'] = 'relation';
                  else
                    $field_args['autocomplete field type'] = 'attribute';
                  $field_args['autocompletion source'] = $sub_components[1];
                } elseif ($sub_components[0] == 'autocomplete on') { // for backwards-compatibility
                  $field_args['autocomplete field type'] = 'category';
                  $field_args['autocompletion source'] = $sub_components[1];
                } elseif ($sub_components[0] == 'autocomplete on category') {
                  $field_args['autocomplete field type'] = 'category';
                  $field_args['autocompletion source'] = $sub_components[1];
                } elseif ($sub_components[0] == 'autocomplete on concept') {
                  $field_args['autocomplete field type'] = 'concept';
                  $field_args['autocompletion source'] = $sub_components[1];
                } elseif ($sub_components[0] == 'autocomplete on namespace') {
                  $field_args['autocomplete field type'] = 'namespace';
                  $autocompletion_source = $sub_components[1];
                  // special handling for "main" (blank) namespace
                  if ($autocompletion_source == "")
                    $autocompletion_source = "main";
                  $field_args['autocompletion source'] = $autocompletion_source;
                } elseif ($sub_components[0] == 'autocomplete from url') {
                  $field_args['autocomplete field type'] = 'external_url';
                  $field_args['autocompletion source'] = $sub_components[1];
                  // 'external' autocompletion is always done remotely, i.e. via API
                  $field_args['remote autocompletion'] = true;
                } elseif ($sub_components[0] == 'values') {
                  // remove whitespaces, and un-escape characters
                  $possible_values = array_map('trim', explode(',', $sub_components[1]));
                  $possible_values = array_map('htmlspecialchars_decode', $possible_values);
                } elseif ($sub_components[0] == 'values from category') {
                  $category_name = ucfirst($sub_components[1]);
                  $possible_values = SFUtils::getAllPagesForCategory($category_name, 10);
                } elseif ($sub_components[0] == 'values from concept') {
                  $possible_values = SFUtils::getAllPagesForConcept($sub_components[1]);
                } elseif ($sub_components[0] == 'property') {
                  $semantic_property = $sub_components[1];
                } elseif ($sub_components[0] == 'default filename') {
                  $default_filename = str_replace('&lt;page name&gt;', $page_name, $sub_components[1]);
                  $field_args['default filename'] = $default_filename;
                } else {
                  $field_args[$sub_components[0]] = $sub_components[1];
                }
                // for backwards compatibility
                if ($sub_components[0] == 'autocomplete on' && $sub_components[1] == null) {
                    $field_args['no autocomplete'] = true;
                }
              }
            }
          } // end for
          if ($allow_multiple)
            $field_args['part_of_multiple'] = $allow_multiple;
          if (count($show_on_select) > 0)
            $field_args['show on select'] = $show_on_select;
          // get the value from the request, if it's there, and if it's not
          // an array
          $escaped_field_name = str_replace("'", "\'", $field_name);
          if (isset($template_instance_query_values) &&
              $template_instance_query_values != null &&
              is_array($template_instance_query_values) &&
              array_key_exists($escaped_field_name, $template_instance_query_values)) {
            $field_query_val = $template_instance_query_values[$escaped_field_name];
            if ($form_submitted || ($field_query_val && ! is_array($field_query_val))) {
              $cur_value = $field_query_val;
            }
          } else
            $cur_value = '';
          //if ($cur_value && ! is_array($cur_value)) {
            //$cur_value = htmlspecialchars($cur_value);
          //}

          if ($cur_value == null) {
            // set to default value specified in the form, if it's there
            $cur_value = $default_value;
          }

          // if the user is editing a page, and that page contains a call to
          // the template being processed, get the current field's value
          // from the template call
          if ($source_is_page && (! empty($existing_template_text))) {
            if (isset($template_contents[$field_name])) {
              $cur_value = $template_contents[$field_name];
              // now remove this value from $template_contents, so that
              // at the end we can have a list of all the fields that
              // weren't handled by the form
              unset($template_contents[$field_name]);
            } else {
              $cur_value = '';
            }
          }

          // handle the free text field - if it was declared as
          // "field|free text" (a deprecated usage), it has to be outside
          // of a template
          if (($template_name == '' && $field_name == 'free text') ||
              $field_name == '<freetext>') {
            // add placeholders for the free text in both the form and
            // the page, using <free_text> tags - once all the free text
            // is known (at the end), it will get substituted in
            if ($is_hidden) {
              $new_text = SFFormUtils::hiddenFieldHTML('free_text', '!free_text!');
            } else {
              if (! array_key_exists('rows', $field_args))
                $field_args['rows'] = 5;
              if (! array_key_exists('cols', $field_args))
                $field_args['cols'] = 80;
              $sfgTabIndex++;
              $sfgFieldNum++;
              list($new_text, $new_javascript_text) = SFFormInputs::textAreaHTML('!free_text!', 'free_text', false, ($form_is_disabled || $is_restricted), $field_args);
              if (in_array('edittools', $free_text_components)) {
                // borrowed from EditPage::showEditTools()
                $options[] = 'parse';
                $edittools_text = wfMsgExt( 'edittools', array( 'parse' ), array( 'content' ) );

                $new_text .=<<<END
		<div class="mw-editTools">
		$edittools_text
		</div>

END;
              }
              $fields_javascript_text .= $new_javascript_text;
            }
            $free_text_was_included = true;
            // add a similar placeholder to the data text
            $data_text .= "!free_text!\n";
          }

          if ($template_name == '' || $field_name == '<freetext>') {
            $section = substr_replace($section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc);
          } else {
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
                  // manually load SMW's message values here, in case they
                  // didn't get loaded before
                  wfLoadExtensionMessages('SemanticMediaWiki');
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
                  wfLoadExtensionMessages('SemanticMediaWiki');
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
                  $hour = $minute = $second = $ampm24h = $timezone = null;
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
                    if (! is_null($hour))
                      $cur_value_in_template .= " " . str_pad(intval(substr($hour,0,2)),2,'0',STR_PAD_LEFT) . ":" . str_pad(intval(substr($minute,0,2)),2,'0',STR_PAD_LEFT);
                    if (! is_null($second))
                      $cur_value_in_template .= ":" . str_pad(intval(substr($second,0,2)),2,'0',STR_PAD_LEFT);
                    if (! is_null($ampm24h))
                      $cur_value_in_template .= " $ampm24h";
                    if (! is_null($timezone))
                      $cur_value_in_template .= " $timezone";
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
              // this line appears unnecessary
              //$generated_page_name = str_replace('.', '_', $generated_page_name);
              $generated_page_name = str_replace(' ', '_', $generated_page_name);
              $escaped_input_name = str_replace(' ', '_', $input_name);
              $generated_page_name = str_ireplace("<$escaped_input_name>", $cur_value_in_template, $generated_page_name);
              // once the substitution is done, replace underlines back
              // with spaces
              $generated_page_name = str_replace('_', ' ', $generated_page_name);
            }
            // disable this field if either the whole form is disabled, or
            // it's a restricted field and user doesn't have sysop privileges
            $is_disabled = ($form_is_disabled ||
              ($is_restricted && (! $wgUser || ! $wgUser->isAllowed('editrestrictedfields'))));
            // create an SFFormField instance based on all the
            // parameters in the form definition, and any information from
            // the template definition (contained in the $all_fields parameter)
            $form_field = SFFormField::createFromDefinition($field_name, $input_name,
              $is_mandatory, $is_hidden, $is_uploadable, $possible_values, $is_disabled,
              $is_list, $input_type, $field_args, $all_fields, $strict_parsing);
            // if a property was set in the form definition, overwrite whatever
            // is set in the template field - this is somewhat of a hack, since
            // parameters set in the form definition are meant to go into the
            // SFFormField object, not the SFTemplateField object it contains;
            // it seemed like too much work, though, to create an
            // SFFormField::setSemanticProperty() function just for this call
            if ($semantic_property != null)
               $form_field->template_field->setSemanticProperty($semantic_property);

            // call hooks - unfortunately this has to be split into two
            // separate calls, because of the different variable names in
            // each case
            if ($form_submitted)
              wfRunHooks('sfCreateFormField', array(&$form_field, &$cur_value_in_template, true));
            else
              wfRunHooks('sfCreateFormField', array(&$form_field, &$cur_value, false));
            // if this is not part of a 'multiple' template, increment the
            // global tab index (used for correct tabbing)
            if (! array_key_exists('part_of_multiple', $field_args))
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
                  $input_type == 'datetime with timezone' || $input_type == 'year' ||
                  ($input_type == '' && $form_field->template_field->propertyIsOfType('_dat'))) {
                // get current time, for the time zone specified in the wiki
                global $wgLocaltimezone;
                putenv('TZ=' . $wgLocaltimezone);
                $cur_time = time();
                $year = date("Y", $cur_time);
                $month = date("n", $cur_time);
                $day = date("j", $cur_time);
                global $wgAmericanDates, $sfg24HourTime;
                if ($wgAmericanDates == true) {
                  $month_names = SFFormUtils::getMonthNames();
                  $month_name = $month_names[$month - 1];
                  $cur_value_in_template = "$month_name $day, $year";
                } else {
                  $cur_value_in_template = "$year/$month/$day";
                }
                if ($input_type ==  'datetime' || $input_type == 'datetime with timezone') {
                  if ($sfg24HourTime) {
                    $hour = str_pad(intval(substr(date("G", $cur_time),0,2)),2,'0',STR_PAD_LEFT);
                  } else {
                    $hour = str_pad(intval(substr(date("g", $cur_time),0,2)),2,'0',STR_PAD_LEFT);
                  }
                  $minute = str_pad(intval(substr(date("i", $cur_time),0,2)),2,'0',STR_PAD_LEFT);
                  $second = str_pad(intval(substr(date("s", $cur_time),0,2)),2,'0',STR_PAD_LEFT);
                  if ($sfg24HourTime) {
                    $cur_value_in_template .= " $hour:$minute:$second";
                  } else {
                    $ampm = date("A", $cur_time);
                    $cur_value_in_template .= " $hour:$minute:$second $ampm";
                  }
                }
                if ($input_type == 'datetime with timezone') {
                  $timezone = date("T", $cur_time);
                  $cur_value_in_template .= " $timezone";
                }
              }
            }
            // if the field is a text field, and its default value was set
            // to 'current user', and it has no current value, set $cur_value
            // to be the current user
            if ($default_value == 'current user' &&
                // if the date is hidden, cur_value will already be set
                // to the default value
                ($cur_value == '' || $cur_value == 'current user')) {
              if ($input_type == 'text' || $input_type == '') {
                $cur_value_in_template = $wgUser->getName();
                $cur_value = $cur_value_in_template;
              }
            }
            list($new_text, $new_javascript_text) = $this->formFieldHTML($form_field, $cur_value);

            $fields_javascript_text .= $new_javascript_text;

            // if this field is disabled, add a hidden field holding
            // the value of this field, because disabled inputs for some
            // reason don't submit their value
            if ($form_field->is_disabled) {
              if ($field_name == 'free text' || $field_name == '<freetext>') {
                $new_text .= SFFormUtils::hiddenFieldHTML('free_text', '!free_text!');
              } else {
                $new_text .= SFFormUtils::hiddenFieldHTML($input_name, $cur_value);
              }
            }

            if ($new_text) {
              // include the field name only for non-numeric field names
              if (is_numeric($field_name)) {
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
                if ($input_type == 'date' || $input_type == 'datetime' || $input_type == 'datetime with timezone' ||
                    ($input_type == '' && $form_field->template_field->propertyIsOfType('_dat'))) {
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
                    if ($all_instances_printed) {
                      $sfgJSValidationCalls[] = "validate_multiple_mandatory_fields($sfgFieldNum)";
                    } else {
                      $sfgJSValidationCalls[] = "validate_mandatory_field(\"input_$sfgFieldNum\", \"info_$sfgFieldNum\")";
                    }
                  } elseif ($input_type == 'radiobutton' || $input_type == 'category') {
                    // only add this if there's a "None" option
                    if (empty($default_value)) {
                      $sfgJSValidationCalls[] = "validate_mandatory_radiobutton('$input_id', '$info_id')";
                    }
                  } elseif (($form_field->template_field->is_list && $form_field->template_field->field_type == 'enumeration' && $input_type != 'listbox') || ($input_type == 'checkboxes')) {
                    $sfgJSValidationCalls[] = "validate_mandatory_checkboxes('$input_id', '$info_id')";
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
          // handle all the possible values
          $input_name = $tag_components[1];
          $input_label = null;
          $attr = array();
          
          // if it's a query, ignore all standard inputs except run query
          if (($is_query && $input_name != 'run query') || (!$is_query && $input_name == 'run query')) {
            $new_text = "";
            $section = substr_replace($section, $new_text, $brackets_loc, $brackets_end_loc + 3 - $brackets_loc);
            continue;
          }
          // set a flag so that the standard 'form bottom' won't get displayed
          $this->standardInputsIncluded = true;
          // cycle through the other components
          for ($i = 2; $i < count($tag_components); $i++) {
            $component = $tag_components[$i];
            $sub_components = explode('=', $component);
            if (count($sub_components) == 1) {
              if ($sub_components[0] == 'edittools') {
                $free_text_components[] = 'edittools';
              }
            } elseif (count($sub_components) == 2) {
              switch($sub_components[0]) {
              case 'label':
                $input_label = $sub_components[1];
                break;
              case 'class':
              case 'style':
                $attr[$sub_components[0]] = $sub_components[1];
                break;
              }
              // free text input needs more handling than the rest
              if ($input_name == 'free text' || $input_name == '<freetext>') {
                if ($sub_components[0] == 'preload') {
                  $free_text_preload_page = $sub_components[1];
                }
              }
            }
          }
          if ($input_name == 'summary') {
            $new_text = SFFormUtils::summaryInputHTML($form_is_disabled, $input_label, $attr);
          } elseif ($input_name == 'minor edit') {
            $new_text = SFFormUtils::minorEditInputHTML($form_is_disabled, $input_label, $attr);
          } elseif ($input_name == 'watch') {
            $new_text = SFFormUtils::watchInputHTML($form_is_disabled, $input_label, $attr);
          } elseif ($input_name == 'save') {
            $new_text = SFFormUtils::saveButtonHTML($form_is_disabled, $input_label, $attr);
          } elseif ($input_name == 'preview') {
            $new_text = SFFormUtils::showPreviewButtonHTML($form_is_disabled, $input_label, $attr);
          } elseif ($input_name == 'changes') {
            $new_text = SFFormUtils::showChangesButtonHTML($form_is_disabled, $input_label, $attr);
          } elseif ($input_name == 'cancel') {
            $new_text = SFFormUtils::cancelLinkHTML($form_is_disabled, $input_label, $attr);
          } elseif ($input_name == 'run query') {
            $new_text = SFFormUtils::runQueryButtonHTML($form_is_disabled, $input_label, $attr);
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
            if ($tag == 'create title' || $tag == 'add title') {
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
            elseif($tag == 'includeonly free text' || $tag == 'onlyinclude free text') {           		
              $onlyinclude_free_text = true;
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
        if ($template_text != '') {
          // for mostly aesthetic purposes, if the template call ends with
          // a bunch of pipes (i.e., it's an indexed template with unused
          // parameters at the end), remove the pipes
          $template_text = preg_replace('/\|*$/', '', $template_text);
          // add another newline before the final bracket, if this template
          // call is already more than one line
          if (strpos($template_text, "\n"))
            $template_text .= "\n";
          // if we're editing an existing page, and there were fields in
          // the template call not handled by this form, preserve those
          $template_text .= SFFormUtils::addUnhandledFields();
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
          // add the character "a" onto the instance number of this input
          // in the form, to differentiate the inputs the form starts out
          // with from any inputs added by the Javascript
          $section = str_replace('[num]', "[{$instance_num}a]", $section);
          $remove_text = wfMsg('sf_formedit_remove');
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
          $add_another = wfMsg('sf_formedit_addanother');
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
      $form_text .= SFFormUtils::hiddenFieldHTML('free_text', '!free_text!');
    }
    // get free text, and add to page data, as well as retroactively
    // inserting it into the form

    // If $form_is_partial is true then either:
    // (a) we're processing a replacement (param 'partial' == 1)
    // (b) we're sending out something to be replaced (param 'partial' is missing)
    if ($form_is_partial) {
       if(!$wgRequest->getCheck('partial')) {
         $free_text = $original_page_content;
         $form_text .= SFFormUtils::hiddenFieldHTML('partial', 1);
       } else {
         $free_text = null;
         $existing_page_content = preg_replace('/²\{(.*?)\}²/s', '{{\1}}', $existing_page_content);
         $existing_page_content = preg_replace('/\{\{\{insertionpoint\}\}\}/', '', $existing_page_content);
       }
    } elseif ($source_is_page) {
      // if the page is the source, free_text will just be whatever in the
      // page hasn't already been inserted into the form
      $free_text = trim($existing_page_content);
    // or get it from a form submission
    } elseif ($wgRequest->getCheck('free_text')) {
      $free_text = $wgRequest->getVal('free_text');
      if (! $free_text_was_included) {
        $data_text .= "!free_text!";
      }
    // or get it from the form definition
    } elseif ($free_text_preload_page != null) {
      $free_text = SFFormUtils::getPreloadedText($free_text_preload_page);
    } else {
      $free_text = null;
    }
    if ($onlyinclude_free_text) {
      // modify free text and data text to insert <onlyinclude> tags
      $free_text = str_replace("<onlyinclude>",'', $free_text);
      $free_text = str_replace("</onlyinclude>",'', $free_text);
      $free_text = trim($free_text);
      $data_text = str_replace('!free_text!','<onlyinclude>!free_text!</onlyinclude>', $data_text);
    }
    // if the FCKeditor extension is installed, use that for the free text input
    global $wgFCKEditorDir;
    if ($wgFCKEditorDir) {
      $showFCKEditor = SFFormUtils::getShowFCKEditor();
      $free_text = str_replace( '"', '&quot;', $free_text );
      if(!$form_submitted && ($showFCKEditor & RTE_VISIBLE)) {
        $free_text = SFFormUtils::prepareTextForFCK($free_text);
      }
    } else {
      $showFCKEditor = 0;
    }
    // now that we have it, substitute free text into the form and page
    $escaped_free_text = Sanitizer::safeEncodeAttribute( $free_text );
    $form_text = str_replace('!free_text!', $escaped_free_text, $form_text);
    $data_text = str_replace('!free_text!', $free_text, $data_text);

    // add a warning in, if we're editing an existing page and that page
    // appears to not have been created with this form
    if ($this->mPageTitle->exists() && ($existing_page_content != '') && ! $source_page_matches_this_form) {
      $form_text = '	<div class="warningMessage">' . wfMsg('sf_formedit_formwarning', $this->mPageTitle->getFullURL()) . "</div>\n" . $form_text;
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
      $chooser_text .= "<input type='button' onclick=\"addInstanceFromChooser('chooserselect$chooser_count');\" value='" . wfMsg('sf_formedit_addanother') . "' disabled='true' id='chooserbutton$chooser_count'></p>";
    }
	
    $form_text = str_replace('{{{choosers}}}', $chooser_text, $form_text);

    // add form bottom, if no custom "standard inputs" have been defined
    if ( !$this->standardInputsIncluded ) {
      if ($is_query)
        $form_text .= SFFormUtils::queryFormBottom($form_is_disabled);
      else
        $form_text .= SFFormUtils::formBottom($form_is_disabled);
    }
    $starttime = wfTimestampNow();
    $page_article = new Article($this->mPageTitle);
    $edittime = $page_article->getTimestamp();
    if (!$is_query)
    	$form_text .=<<<END

	<input type="hidden" value="$starttime" name="wpStarttime" />
	<input type="hidden" value="$edittime" name="wpEdittime" />
END;
    $form_text .=<<<END
	</form>

END;

    // add Javascript code for form-wide use
    $javascript_text .= SFFormUtils::validationJavascript();
    $javascript_text .= SFFormUtils::instancesJavascript($using_choosers);
    $javascript_text .= SFFormUtils::autocompletionJavascript();
    if ($free_text_was_included && $showFCKEditor > 0) {
      $javascript_text .= SFFormUtils::mainFCKJavascript($showFCKEditor);
      if ($showFCKEditor & (RTE_TOGGLE_LINK | RTE_POPUP)) {
        $javascript_text .= SFFormUTils::FCKToggleJavascript();
      }
      if ($showFCKEditor & RTE_POPUP) {
        $javascript_text .= SFFormUTils::FCKPopupJavascript();
      }
    }

    // send the autocomplete values to the browser, along with the mappings
    // of which values should apply to which fields
    // if doing a replace, the data text is actually the modified original page
    if($wgRequest->getCheck('partial'))
      $data_text = $existing_page_content;
    $javascript_text .= $fields_javascript_text;
    global $wgParser;
    $new_text = "";
    if ( !$embedded )
      $new_text = $wgParser->preprocess(str_replace( "{{!}}", "|", $form_page_title ), $this->mPageTitle, new ParserOptions()); 
    
    return array($form_text, "/*<![CDATA[*/ $javascript_text /*]]>*/",
      $data_text, $new_text, $generated_page_name);
  }

  /**
   * Create the HTML and Javascript to display this field within a form
   */
  function formFieldHTML($form_field, $cur_value) {
    global $smwgContLang;

    // also get the actual field, with all the semantic information (type is
    // SFTemplateField, instead of SFFormField)
    $template_field = $form_field->template_field;

    if ($form_field->is_hidden) {
      $text = SFFormUtils::hiddenFieldHTML($form_field->input_name, $cur_value);
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
      $other_args = $form_field->getArgumentsForInputCall($hook_values[1]);
      $funcArgs[] = $other_args;
      list($text, $javascript_text) = call_user_func_array($hook_values[0], $funcArgs);
    } else { // input type not defined in form
      $field_type = $template_field->field_type;
      $is_list = ($form_field->is_list || $template_field->is_list);
      if ($field_type != '' &&
          array_key_exists($field_type, $this->mSemanticTypeHooks) &&
          isset($this->mSemanticTypeHooks[$field_type][$is_list])) {
        $funcArgs = array();
        $funcArgs[] = $cur_value;
        $funcArgs[] = $form_field->input_name;
        $funcArgs[] = $form_field->is_mandatory;
        $funcArgs[] = $form_field->is_disabled;
        $hook_values = $this->mSemanticTypeHooks[$field_type][$is_list];
        $other_args = $form_field->getArgumentsForInputCall($hook_values[1]);
        $funcArgs[] = $other_args;
        list($text, $javascript_text) = call_user_func_array($hook_values[0], $funcArgs);
      } else { // anything else
        $other_args = $form_field->getArgumentsForInputCall();
        // special call to ensure that a list input is the right default size
        if ($form_field->is_list) {
          if (! array_key_exists('size', $other_args))
            $other_args['size'] = 100;
        }
        list($text, $javascript_text) = SFFormInputs::textEntryHTML($cur_value, $form_field->input_name, $form_field->is_mandatory, $form_field->is_disabled, $other_args);
      }
    }
    return array($text, $javascript_text);
  }

}
