<?php
/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:Uniwiki_Generic_Edit_Page
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'name'           => 'GenericEditPage',
	'author'         => 'Merrick Schaefer, Mark Johnston, Evan Wheeler and Adam Mckaig (at UNICEF)',
	'description'    => 'Supplements the edit page with something more usable',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Uniwiki_Generic_Edit_Page',
	'svn-date'       => '$LastChangedDate: 2009-03-06 22:14:41 +0100 (ptk, 06 mar 2009) $',
	'svn-revision'   => '$LastChangedRevision: 48098 $',
	'descriptionmsg' => 'gep-desc',
);

$wgExtensionMessagesFiles['GenericEditPage'] = dirname( __FILE__ ) . '/GenericEditPage.i18n.php';

/* ---- CONFIGURABLE OPTIONS ---- */

$wgSectionBox               = true;
$wgCategoryBox              = true;
$wgAddSection               = true;
$wgAddCategory              = true;
$wgSuggestCategory          = false;
$wgSuggestCategoryRecipient = $wgEmergencyContact;
$wgUseCategoryPage          = false;
$wgRequireCategory          = false;
$wgGenericEditPageWhiteList = array( NS_MAIN );
$wgAllowSimilarTitles		= true;

/* not configurable. in fact,
 * it's a big ugly hack */
$wgSwitchMode = false;

/* ---- HOOKS ---- */
$wgHooks['BeforePageDisplay'][] = "UW_GenericEditPage_addJS";
$wgHooks['EditPage::showEditForm:fields'][]  = 'UW_GenericEditPage_displayEditPage';
$wgHooks['EditPage::attemptSave'][]          = 'UW_GenericEditPage_combineBeforeSave';
$wgHooks['EditPage::showEditForm:initial'][] = 'UW_GenericEditPage_combineBeforeSave';

$wgAjaxExportList[] = "UW_GenericEditPage_emailSuggestion";

function UW_GenericEditPage_addJS( $out ) {
	global $wgScriptPath;
	$src = "$wgScriptPath/extensions/uniwiki/GenericEditPage/GenericEditPage.js";
	$out->addScript ( "<script type='text/javascript' src='$src'></script>" );
	$href = "$wgScriptPath/extensions/uniwiki/GenericEditPage/global.css";
	$out->addScript ( "<link rel='stylesheet' href='$href' />" );
	return true;
}

function UW_GenericEditPage_emailSuggestion ( $category ) {
	global $wgSuggestCategoryRecipient, $wgEmergencyContact, $wgSitename, $wgUser;
	require_once ( "UserMailer.php" );

	wfLoadExtensionMessages( 'GenericEditPage' );

	$from = new MailAddress ( $wgEmergencyContact );
	$to   = new MailAddress ( $wgSuggestCategoryRecipient );
	$subj = wfMsg ( "gep-emailsubject", $wgSitename, $category );
	$body = wfMsg ( "gep-emailbody", $wgUser->getName(), $category, $wgSitename );

	// attempt to send the notification
	$result = userMailer ( $to, $from, $subj, $body, null, 'GenericEditPage' );

	/* send a message back to the client, to let them
	 * know if the suggestion was successfully sent (or not) */
	return WikiError::isError ( $result )
	     ? wfMsg ( 'gep-emailfailure' )
	     : wfMsg ( 'gep-emailsuccess', $category );
}

function UW_GenericEditPage_extractLayout ( &$text ) {
	/* match all layout tags (in case, some how, multiple
	 * tags have ended up in the wiki markup). only the
	 * first tag will be used, but all will be removed */
	$re = "/\n*<layout\s+name=\"(.+)\"\s+\/>/";
	preg_match_all ( $re, $text, $matches );
	$text = preg_replace ( $re, "", $text );

	/* if no layout tag was found, this
	 * function does nothing useful */
	if ( !isset( $matches[1][0] ) ) {
		return array();
	}

	/* get the wiki markup (containing the
	 * directives) from this page's layout */
	$layout      	= array();
	$layout_title 	= Title::newFromDBkey ( "Layout:" . $matches[1][0] );
	$layout_article = new Article ( $layout_title );
	$layout_text 	= $layout_article->getContent();

	// add the first element as page meta-data
	// and the second for the untitled first section
	$layout[] = array ( "name" => $matches[1][0] );
	$layout[] = array();

	// ignore (delete) the categories on the layout
	$layout_text = preg_replace ( "/\[\[category:(.+?)\]\]/i", "", $layout_text );

	// break it up into sections (same regex as in displayEditPage)
	$nodes = preg_split ( '/^(==?[^=].*)$/mi', $layout_text, -1, PREG_SPLIT_DELIM_CAPTURE );

	// build an array with the layout section attributes
	for ( $i = 0; $i < count ( $nodes ); $i++ ) {
		$value = trim ( $nodes[$i] );

		/* is this block of text a header?
		 * update the 'current section' flag ($title), so
		 * all following directives are dropped in to it */
		if ( preg_match ( '/^(==?)\s*(.+?)\s*\\1$/i', $value, $matches ) ) {
			$layout[] = array(
				"title" => htmlspecialchars( $matches[2] ),
				"level" => strlen( $matches[1] )
			);

		// not header -> plain text
		} else {
			/* find and iterate all directives in this section,
			 * and add them to the last-seen title array */
			$re = "/^@(.+)$/m";
			$section_num = count ( $layout ) - 1;
			preg_match_all ( $re, $value, $matches );
			foreach ( $matches[1] as $attribute )
				$layout[$section_num][$attribute] = true;

			// add the remaining stuff as text
			$value = preg_replace ( $re, "", $value );
			$layout[$section_num]['text'] = trim( $value );
		}
	}

	return $layout;
}

function UW_GenericEditPage_extractCategoriesIntoBox( &$text ) {
	global $wgDBprefix, $wgAddCategory, $wgSuggestCategory, $wgRequest,
		$wgEmergencyContact, $wgUseCategoryPage;
	$out = "";

	wfLoadExtensionMessages( 'GenericEditPage' );

	/* build an array of the categories, either from a page
	 * or from all available categories in the wiki */
	$categories = array();
	if ( $wgUseCategoryPage ) {

		// from the specified page
		$revision = Revision::newFromTitle ( Title::newFromDBKey ( wfMsgForContent( 'gep-categorypage' ) ) );
		$results = $revision ? split ( "\n", $revision->getText() ) : array();
		foreach ( $results as $result ) {
			if ( trim( $result ) != '' )
				$categories[] = Title::newFromText ( trim ( $result ) )->getDBkey();
		}
	} else {

		// all the categories
		$db = wfGetDB ( DB_MASTER );
		$results = $db->resultObject ( $db->query(
			"select distinct cl_to from {$wgDBprefix}categorylinks order by cl_to" ) );

		while ( $result = $results->next() )
			$categories[] = $result->cl_to;
	}

	// extract the categories on this page
	$regex = "/\[\[category:(.+?)(?:\|.*)?\]\]/i";
	preg_match_all ( $regex, strtolower( $text ), $matches );
	$text = preg_replace ( $regex, "", $text );

	// an array of the categories on the page (in db form)
	$on_page = array();
	foreach ( $matches[1] as $cat )
		$on_page[] = strtolower ( Title::newFromText ( $cat )->getDBkey() );

	/* add any categories that may have been passed with the
	 * GET request as if they started out on the page */
	$data = $wgRequest->data;
	foreach ( $data as $key => $value ) {
		if ( $key == 'category' ) {
			$category = substr ( $value, 9 ); // value = category-categoryname
			$on_page[] = strtolower ( $category );
			if ( !in_array ( $category, $categories ) )
				$categories[] = $category;
		}
	}

	/* add checkboxes for the categories,
	 * with ones from the page already checked */
	$out .= "<div id='category-box'><h3>" . wfMsg ( 'gep-categories' ) . "</h3>";
	foreach ( $categories as $category ) {
		$fm_id = "category-$category";
		$caption = Title::newFromDBkey ( $category )->getText();
		$checked = in_array ( strtolower ( $category ), $on_page )
			? "checked='checked'" : '';

		$out .= "
			<div>
				<input type='checkbox' name='$fm_id' id='$fm_id' $checked/>
				<label for='$fm_id'>$caption</label>
			</div>
		";
	}

	// add a text field to add new categories
	if ( $wgAddCategory ) {
		$out .= "
			<div class='add'>
				<label for='fm-add-cat'>" . wfMsg ( 'gep-addcategory' ) . "</label>
				<input type='text' id='fm-add-cat' autocomplete='off' />
				<input type='button' value='" . wfMsg ( 'gep-addcategorybutton' ) . "' id='fm-add-cat-button' />
			</div>
			<script type='text/javascript'>
				// hook up the 'add category' box events
				Uniwiki.GenericEditPage.Events.add_category();
			</script>
		";
	}

	/* add a text field to suggest a category
	 * as email to $wgEmergencyContact */
	if ( $wgSuggestCategory ) {
		$out .= "
			<div class='suggest'>
				<label for='fm-suggest-cat'>" . wfMsg ( 'gep-suggestcategory' ) . "</label>
				<input type='text' id='fm-suggest-cat' autocomplete='off' />
				<input type='button' value='" . wfMsg ( 'gep-suggestcategorybutton' ) . "' id='fm-suggest-cat-button' />
			</div>
			<script type='text/javascript'>
				$('fm-suggest-cat-button').addEvent ('click', function() {
					var field = this.getPrevious();
					var that = this;

					// only if a category name was entered...
					var cat_name = field.value.trim();
					if (cat_name != '') {
						sajax_do_call ('UW_GenericEditPage_emailSuggestion', [cat_name], function (msg) {

							/* got response from the server, append it after the
							 * suggest form (so subsequent suggestions are injected
							 * ABOVE existing suggetions before they're removed) */
							var n = new Element ('div')
								.injectAfter ('fm-suggest-cat-button', 'after')
								.appendText (msg.responseText)
								.highlight();

							/* fade out and destroy the notification within
							 * a timely manner, to keep the DOM tidy */
							(function() {  n.fade()     }).delay(6000);
							(function() {  n.destroy()  }).delay(8000);
						});

						// clear the suggestion
						field.value = '';
					}
				});

				// catch the ENTER key in the suggestion box,
				// to prevent the entire edit form from submitting
				$('fm-suggest-cat').addEvent ('keypress', function (e) {
					if (e.key == 'enter') {
						this.getNext().fireEvent ('click');
						e.stop();
					}
				});
			</script>
		";
	}

	// end of category box
	$out .= "</div>";
	return $out;
}

function UW_GenericEditPage_renderSectionBox ( $sections ) {
	global $wgAddSection;

	wfLoadExtensionMessages( 'GenericEditPage' );

	$out = "
		<div id='section-box'>
			<h3>" . wfMsg ( 'gep-sections' ) . "</h3>
			<div class='sortables'>
	";

	for ( $i = 1; $i < count ( $sections ); $i++ ) {
		if ( !empty($sections[$i]['required']) ) {

			/* required sections are checked and disabled, but...
			 * this doesn't pass a value back to the server! so
			 * we must include a hidden field to fill in */
			$out .= "
				<div id='sect-$i' class='section-box disabled'>
					<input type='hidden' name='enable-$i' value='on' />
					<input type='checkbox' checked='checked' disabled='disabled' />
					<label title='" . wfMsg ( 'gep-sectionnotdisabled' ) . "'>{$sections[$i]['title']}</label>
				</div>
			";
		} else {
			// sections that are currently in us are pre-checked
			$checked = $sections[$i]['in-use'] ? " checked='checked'" : "";
			$out .= "
				<div id='sect-$i' class='section-box'>
					<input type='checkbox' name='enable-$i' $checked />
					<label>{$sections[$i]['title']}</label>
				</div>
			";
		}
	}

	$out .= "
			</div>
	";

	if ( $wgAddSection ) {
		$out .= "
			<div class='add'>
				<label for='fm-add-sect'>" . wfMsg ( 'gep-addsection' ) . "</label>
				<input type='text' id='fm-add-sect' autocomplete='off' />
				<input type='button' value='" . wfMsg ( 'gep-addsectionbutton' ) . "' id='fm-add-sect-button' />
			</div>
			<script type='text/javascript'>
				// hook up the 'add section' box events
				Uniwiki.GenericEditPage.Events.add_section();
			</script>
		";
	}

	$out .= "
		</div>
		<script type='text/javascript'>
			Uniwiki.GenericEditPage.Events.toggle_sections();
			Uniwiki.GenericEditPage.Events.reorder_sections();
		</script>
	";

	return $out;
}

function UW_GenericEditPage_displayEditPage ( $editor, $out ) {
	global $wgHooks, $wgParser, $wgTitle, $wgRequest, $wgUser, $wgCategoryBox, $wgSectionBox, $wgRequireCategory;
	global $wgGenericEditPageClass, $wgSwitchMode, $wgGenericEditPageWhiteList, $wgAllowSimilarTitles;

	// disable this whole thing on conflict and comment pages
	if ( $editor->section == "new" || $editor->isConflict )
		return true;

	// get the article text (as wiki markup)
	$text = trim ( $editor->safeUnicodeOutput ( $editor->textbox1 ) );

	// see if we have a link to a layout
	$layout = UW_GenericEditPage_extractLayout ( $text );

	/* remove the categories, to be added as
	 * checkboxes later (after the edit form) */
	if ( $wgCategoryBox ) {
		$catbox = UW_GenericEditPage_extractCategoriesIntoBox ( $text );
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'UW_GenericEditPage_addCssHookSidebar';
	}

	/* break the page up into sections by splitting
	 * at header level =one= or ==two== */
	$nodes = preg_split( '/^(==?[^=].*)$/mi', $text, -1, PREG_SPLIT_DELIM_CAPTURE );

	// add css hooks only to the edit page
	$wgHooks['SkinTemplateSetupPageCss'][] = 'UW_GenericEditPage_editPageCss';
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'UW_GenericEditPage_addCssHookGenEd';


	/* the current contents of the page we are
	 * editing will be broken up into $page(and
	 * combined with $layout, later on) */
	$page = array();
	$title = "";

	/* always create a space for the first un-named
	 * section, even if it is not used */
	$page[] = array();

	for ( $i = 0; $i < count ( $nodes ); $i++ ) {
		$value = trim ( $nodes[$i] );
		$this_section = count ( $page ) - 1;

		// is this block of text a header?
		$node_is_title = preg_match ( '/^(==?)\s*(.+?)\s*\\1$/i', $value, $matches );

		/* for titles, create a new element in the
		 * page array, to store the title and text */
		if ( $node_is_title ) {

			// extract header level and title
			$level = strlen ( $matches[1] );
			$title = htmlspecialchars ( $matches[2] );

			// add this section and mark it as in use
			$page[] = array(
				'title'  => $title,
				'level'  => $level,
				'in-use' => true
			);

		/* not header -> plain text (store in
		/ * the previous section, with title) */
		} else {
			$page[$this_section]['text'] = $value;
		}

		/* fetch the meta-data for new sections, or
		 * the un-named first section. this is done
		 * here (not when merging) because meta-data
		 * can ONLY come from the layout (not the page) */
		if ( $node_is_title or $i == 0 ) {

			/* now check if any meta-data exists for this
			 * section in the layout for this page
			 * (ignore the first two sections)
			 * j = 0:  page meta-data
			 * j = 1:  special first section */
			for ( $j = 1; $j < count ( $layout ); $j++ ) {
				if ( $layout[$j]['title'] == $title ) {
					// we found a corresponding section in the layout
					// so we copy all the associated meta-data
					foreach ( $layout[$j] as $k => $v ) {

						// don't overwrite the page text!
						if ( $k != "text" ) $page[count ( $page ) - 1][$k] = $v;
					}
				}
			}
		}
	}

	/* the results of the
	 * layout + page merge */
	$result = array();

	/* special case: if the first (un-named) section has text in the layout,
	 * but not in the page, copy it. otherwise, use the page text (even if empty) */
	$result[] = ( !empty($layout[0]) && $layout[0]['text'] && !$page[0]['text'] ) ? $layout[0] : $page[0];

	/* only show the un-named section if it is being used. as
	 * default, do not encourage people to use it by showing it */
	$result[0]['in-use'] = ( $result[0]['text'] != "" );

	// get sections that are in the layout
	for ( $i = 2; $i < count ( $layout ); $i++ ) {
		$found_at = null;
		for ( $j = 0; $j < count ( $page ); $j++ ) {
			if ( $layout[$i]['title'] == $page[$j]['title'] ) {
				$found_at = $j;
				break;
			}
		}
		if ( !$found_at ) { // take the section from the layout
			$result[] = $layout[$i];
		} else {
			$result[] = $page[$found_at];
		}
	}

	// now put in the stuff that is not in the layout, but IS in the page
	for ( $i = 1; $i < count ( $page ); $i++ ) {

		// if this section is already in the result,
		// then skip to the next page section
		if(!$wgAllowSimilarTitles){
			for ( $j = 0; $j < count ( $result ); $j++ ) {
				if (!empty($result[$j]['title']) && $page[$i]['title'] == $result[$j]['title'] )
					continue 2;
			}
		}

		/* this page section has not been added yet!
		 * re-iterate the results, to find the index
		 * of the section BEFORE this section, which
		 * we will insert after */
		$insert_at = null;

		for ( $j = 0; $j < count ( $result ); $j++ ) {
			if (!empty($result[$j]['title']) && $result[$j]['title'] == $page[$i - 1]['title'] ) {
				$insert_at = $j + 1;
				break;
			}
		}

		if ( $insert_at === null )
			$result[] = $page[$i];
		else
			array_splice ( $result, $insert_at, 0, array( $page[$i] ) );
	}

	/* check to see if there were any sections in use
	 * if there are not, we will display instructions */
	$any_in_use = false;
	for ( $i = 0; $i < count( $result ); $i++ ) {
		if ( $result[$i]['in-use'] ) {
			$any_in_use = true;
			break;
		}
	}

	// use the default (untitled) section if there is nothing else
	if ( !$any_in_use ) {
		$result[0]['in-use'] = true;
		$any_in_use = true;
	}

	// this line is sort of outdated... may want to remove?
	$gen_editor_class = $any_in_use ? "" : " show-instructions";

	wfLoadExtensionMessages( 'GenericEditPage' );

	/* add the buttons to switch between editing modes
	 * (only one is visible at a time, via css/js) and
	 * start the generic editor div */
	$out->addHTML( "
		<script type='text/javascript' language='javascript'>
			$(window).addEvent ('domready', function() {
				/* add CLASSIC button
				 * (visibility via css) */
				new Element ('input', {
					type: 'button',
					'class': 'switch sw-classic',
					events: { click: Uniwiki.GenericEditPage.toggle_mode },
					value: '" . wfMsg ( 'gep-classicmode' ) . "'
				}).inject ($('content'));

				/* add GENERIC button
				 * (visibility via css) */
				new Element ('input', {
					type: 'button',
					'class': 'switch sw-generic',
					events: { click: Uniwiki.GenericEditPage.toggle_mode },
					value: '" . wfMsg ( 'gep-genericmode' ) . "'
				}).inject($('content'));
	" );

	/* only enforce the categorization of pages in the
	 * main namespace, using the generic edit page */
	if ( $wgRequireCategory && ( $wgTitle->getNamespace() == NS_MAIN ) ) {
		$out->addHTML( "
				/* when the form is submitted, check that one or
				 * more categories were selected, or alert */
				$('editform').addEvent ('submit', function (e) {

					// only enforce when in generic mode
					if (!document.body.hasClass ('edit-generic'))
						return true;

					/* iterate the category checkboxes, and count
					 * how many of them are 'ticked' */
					var checked = 0;
					$$('#category-box input[type=checkbox]').each (function (el) {
						if (el.checked) checked++;
					});

					if (checked==0) {
						alert('" . wfMsg ( 'gep-nocategories' ) . "');
						e.stop();
					}
				});
		" );
	}

	$out->addHTML( "
				/* if the sidebar is taller than the editor,
				 * make the editor the same height */
				var sbs = $('sidebar').getSize();
				var eds = Uniwiki.GenericEditPage.editor().getSize();
				if (sbs.y > eds.y) Uniwiki.GenericEditPage.editor().setStyle
					((Browser.Engine.trident ? 'height' : 'min-height'), sbs.y+'px');
			});
		</script>
		<!-- will be assigned the name of 'wpPreview' when the
		     switch-mode button is pressed, because mediawiki
		     only checks for its presence, not value (?!) -->
		<input type='hidden' id='wpFakePreview' name='' value='' />
		<input type='hidden' id='switch-mode' name='switch-mode' value='' />
		<div class='generic-editor $gen_editor_class'>
			<div class='instructions'>" . wfMsg ( 'gep-nosectioninstructions' ) . "</div>
	" );

	// now build the results into a real HTML page
	for ( $i = 0; $i < count ( $result ); $i++ ) {
		$in_use = $result[$i]['in-use'] ? "in-use" : "not-in-use";
		$out->addHTML( "<div id='section-$i' class='section sect-" . ( $i + 1 ) . " $in_use'>" );


		// if this section has a title, show it
		if ( !empty($result[$i]['title']) ) {
			$title = $result[$i]['title'];
			if (!empty($result[$i]['lock-header']) &&  $result[$i]['lock-header'] ) {
				$out->addHTML ( "<h2>$title</h2>" );
				$out->addHTML ( "<input type='hidden' name='title-$i' value='$title' />" );
			} else {
				// wrap the editable section header in a div, for css hackery
				$out->addHTML ( "<div class='sect-title'><input type='text' name='title-$i' class='section-title' value='$title' /></div>" );
			}

			// always include the level of titles
			$out->addHTML ( "<input type='hidden' name='level-$i' value='{$result[$i]['level']}' />" );
		}

		/* always add a textarea, whether or
		 * not it is currently in use. titles
		 * without text are kind of useless */
		if ( !empty($result[$i]['lock-text']) ) {

			/* render the wiki markup into HTML, the old-school
			 * way which actually works, unlike recursiveTagParse() */
			$text = $wgParser->parse ( $result[$i]['text'], $wgTitle, new ParserOptions )->getText();
			$out->addHTML ( "<input type='hidden' name='section-$i' value='" . htmlspecialchars ( $result[$i]['text'], ENT_QUOTES ) . "' />" );
			$out->addHTML ( "<div class='locked-text' id='locked-text-$i'>" . $text . "</div>" );
		} else {
			// add the editable text for this section
			$text = (empty($result[$i]['text'])) ? "" : $result[$i]['text'];
			$text = htmlspecialchars ($text , ENT_QUOTES );
			$out->addHTML ( "<textarea name='section-$i' class='editor'>$text</textarea>" );
		}

		$out->addHTML( "</div>" );
	}


	/* end of .generic-editor
	 * (and some javascript!) */
	$out->addHTML( "
		</div>
		<script type='text/javascript'>
			/* when any section title is changed (in the generic
			 * editor), update the sections on the right, too */
			window.addEvent ('domready', function() {
				Uniwiki.GenericEditPage.Events.section_title_change()
			});
		</script>
	" );


	/* if the article we're editing is in the whitelist, then
	 * default to the generic editor; otherwise, default to
	 * classic mode (but allow switching) */
	$default = in_array ( $wgTitle->getNamespace(), $wgGenericEditPageWhiteList )
	         ? "generic" : "classic";

	/* use the mode from the last request; default to generic (the first time)
	 * if we are switching modes, then use the OPPOSITE mode */
	$klass = $wgRequest->getVal ( "edit-mode", $default );
	if ( $wgSwitchMode ) $klass = ( $klass == "classic" ) ? "generic" : "classic";
	$out->addHTML ( "<input type='hidden' name='edit-mode' id='edit-mode' value='$klass' />" );
	$wgGenericEditPageClass = $klass;


	// pass the layout name back, to be re-appended
	if(!empty($layout))
		$out->addHTML ( "<input type='hidden' name='layout-name' value='{$layout[0]['name']}' />" );


	// build the sidebar (cats, sections) in its entirety
	if ( $wgCategoryBox || $wgSectionBox ) {
		$out->addHTML ( "<div id='sidebar'>" );
		if ( $wgSectionBox )  $out->addHTML ( UW_GenericEditPage_renderSectionBox( $result ) );
		if ( $wgCategoryBox ) $out->addHTML ( $catbox );
		$out->addHTML ( "</div>" );
	}

	return true;
}

/* OH, HOW I WISH FOR CLOSURES IN PHP, SO
 * THESE DIDN'T HAVE TO BE GLOBAL FUNCTIONS */

/* when this hook is called (only on the generic edit page), add a
 * special class to the <body> tag, to make targetting our css easier
 * (also add a hook if we just switched modes, to hide the preview) */
function UW_GenericEditPage_addCssHookGenEd ( &$sktemplate, &$tpl ) {
	global $wgGenericEditPageClass, $wgSwitchMode;
	$tpl->data['pageclass'] .= " edit-$wgGenericEditPageClass";
	if ( $wgSwitchMode ) $tpl->data['pageclass'] .= " switching-mode";
	return true;
}
function UW_GenericEditPage_addCssHookSidebar ( &$sktemplate, &$tpl ) {
	global $wgGenericEditPageClass;
	$tpl->data['pageclass'] .= " with-sidebar";
	return true;
}


// also attach our generic editor stylesheet
function UW_GenericEditPage_editPageCss ( &$out ) {
	global $wgScriptPath;
	$out .= "@import '$wgScriptPath/extensions/uniwiki/GenericEditPage/style.css';\n";
	return true;
}

function UW_GenericEditPage_combineBeforeSave ( &$editpage_Obj ) {
	global $wgRequest, $wgSwitchMode;
	$data = $wgRequest->data;

	/* if this request was triggered by the user
	 * pressing the "switch mode" button, then
	 * set a global to do some jiggery-pokery
	 * in the displayEditPage function, later */
	if ( isset( $data['switch-mode'] ) and strlen( $data['switch-mode']) > 0)
		$wgSwitchMode = true;

	/* if we are editing in classic mode,
	 * then this function does nothing! */
	if ( ( isset( $data['edit-mode'] ) && $data['edit-mode'] != "generic" ) || !isset( $data['edit-mode'] ) )
		return true;

	/* otherwise, clear the textbox and rebuild it
	 * from the generic input POST data */
	$editpage_Obj->textbox1 = '';
	$nodes = array();
	$categories = array();
	$directives = array();
	foreach ( $data as $key => $value ) {
		if ( trim ( $value ) != '' ) {

			if ( substr( $key, 0, 6 ) == 'title-' ) {
				$index = intval ( substr( $key, 6 ) );

				/* only add this section if it is enabled,
				 * by checking the associated checkbox */
				if ( isset ( $data["enable-$index"] ) ) {

					/* got a title -> add it back as a header,
					 * by fetching the level from field "level-N" */
					$level = isset ( $data["level-$index"] ) ? $data["level-$index"] : 2;
					$delim = str_repeat ( "=", $level );
					$nodes[$index]['title'] = "$delim " . trim ( $value ) . " $delim\n";
				}

			/* got a section -> check that associated checkbox is
			 * ticked (or this is the first magic section, which
			 * does not have a checkbox), and add it into the output */
			} else if ( substr ( $key, 0, 8 ) == 'section-' ) {
				$index = intval ( substr( $key, 8 ) );
				if ( isset ( $data["enable-$index"] ) || ( $index == 0 ) ) {
					$nodes[$index]['text'] = trim( $value ) . "\n\n";
				}

			/* got a category -> add it to the list of categories and put
			 * it into the page as human-friendly text (i.e. not a DB key) */
			} else if ( substr ( $key, 0, 9 ) == 'category-' ) {
				$categories[] = Title::newFromDBkey ( substr ( $key, 9 ) )->getText();
			}
		}
	}

	/* put the section titles and text
	 * back into the default textbox */
	foreach ( array_keys ( $nodes ) as $k ) {
		if ( !empty($nodes[$k]['title']) ) $editpage_Obj->textbox1 .= $nodes[$k]['title'];
		if ( !empty($nodes[$k]['text']) )  $editpage_Obj->textbox1 .= $nodes[$k]['text'];
	}

	// then add back the categories
	if ( count ( $categories ) != 0 ) {
		sort ( $categories );
		foreach ( $categories as $category ) {
			$editpage_Obj->textbox1 .= "[[Category:" . $category . "]]\n";
		}
	}

	// finally, re-add the layout name
	if ( isset( $data['layout-name'] ) ) {
		$editpage_Obj->textbox1 .= "<layout name=\"{$data['layout-name']}\" />";
	}

	return true;
}
