<?php
/**
 * Unfortunately, we have to override entire methods of EditPage
 * Search for "MeanEditor" to find our patches
 *
 * The situation has improved a lot since Mediawiki 1.16, thanks guys!
 *
 */

class MeanEditorEditPage extends EditPage {
	# MeanEditor: set when we decide to revert to traditional editing
	var $noVisualEditor = false;
	# MeanEditor: respect user preference
	var $userWantsTraditionalEditor = false;

	/**
	 * Replace entire edit method, need to convert HTML -> wikitext before saving
	 *
	 * Perhaps one of the new hooks could do we need? But what about the interaction
	 * with other extensions?
	 */
	 function edit() {
		global $wgOut, $wgRequest, $wgUser;

		# MeanEditor: enabling this hook without also disabling visual editing
		#             would probably create a mess
		#// Allow extensions to modify/prevent this form or submission
		#if ( !wfRunHooks( 'AlternateEdit', array( $this ) ) ) {
		#	return;
		#}

		wfProfileIn( __METHOD__ );
		wfDebug( __METHOD__.": enter\n" );

		// This is not an article
		$wgOut->setArticleFlag( false );

		$this->importFormData( $wgRequest );
		$this->firsttime = false;

		if ( $this->live ) {
			$this->livePreview();
			wfProfileOut( __METHOD__ );
			return;
		}

		if ( wfReadOnly() && $this->save ) {
			// Force preview
			$this->save = false;
			$this->preview = true;
		}

		$wgOut->addScriptFile( 'edit.js' );

		if ( $wgUser->getOption( 'uselivepreview', false ) ) {
			$wgOut->includeJQuery();
			$wgOut->addScriptFile( 'preview.js' );
		}
		// Bug #19334: textarea jumps when editing articles in IE8
		$wgOut->addStyle( 'common/IE80Fixes.css', 'screen', 'IE 8' );

		$permErrors = $this->getEditPermissionErrors();
		if ( $permErrors ) {
			wfDebug( __METHOD__ . ": User can't edit\n" );
			$this->readOnlyPage( $this->getContent( false ), true, $permErrors, 'edit' );
			wfProfileOut( __METHOD__ );
			return;
		} else {
			if ( $this->save ) {
				$this->formtype = 'save';
			} elseif ( $this->preview ) {
				$this->formtype = 'preview';
			} elseif ( $this->diff ) {
				$this->formtype = 'diff';
			} else { # First time through
				$this->firsttime = true;
				if ( $this->previewOnOpen() ) {
					$this->formtype = 'preview';
				} else {
					$this->formtype = 'initial';
				}
			}
		}

		// If they used redlink=1 and the page exists, redirect to the main article
		if ( $wgRequest->getBool( 'redlink' ) && $this->mTitle->exists() ) {
			$wgOut->redirect( $this->mTitle->getFullURL() );
		}

		wfProfileIn( __METHOD__."-business-end" );

		$this->isConflict = false;
		// css / js subpages of user pages get a special treatment
		$this->isCssJsSubpage      = $this->mTitle->isCssJsSubpage();
		$this->isCssSubpage        = $this->mTitle->isCssSubpage();
		$this->isJsSubpage         = $this->mTitle->isJsSubpage();
		$this->isWrongCaseCssJsPage = $this->isWrongCaseCssJsPage(); // copied from EditPage.php (BugId:31008)

		# Show applicable editing introductions
		if ( $this->formtype == 'initial' || $this->firsttime )
			$this->showIntro();

		if ( $this->mTitle->isTalkPage() ) {
			$wgOut->addWikiMsg( 'talkpagetext' );
		}

		# Optional notices on a per-namespace and per-page basis
		$editnotice_ns   = 'editnotice-'.$this->mTitle->getNamespace();
		if ( !wfEmptyMsg( $editnotice_ns, wfMsgForContent( $editnotice_ns ) ) ) {
			$wgOut->addWikiText( wfMsgForContent( $editnotice_ns )  );
		}
		if ( MWNamespace::hasSubpages( $this->mTitle->getNamespace() ) ) {
			$parts = explode( '/', $this->mTitle->getDBkey() );
			$editnotice_base = $editnotice_ns;
			while ( count( $parts ) > 0 ) {
				$editnotice_base .= '-'.array_shift( $parts );
				if ( !wfEmptyMsg( $editnotice_base, wfMsgForContent( $editnotice_base ) ) ) {
					$wgOut->addWikiText( wfMsgForContent( $editnotice_base )  );
				}
			}
		}


		# MeanEditor: always use traditional editing for these strange things
		if ($this->mTitle->getNamespace() != NS_MAIN || $this->isCssJsSubpage)
			$this->noVisualEditor = true;

		# MeanEditor: convert HTML to wikitext
		#             The hidden box should tell us if the editor was in use (we got HTML in the POST)
		if ( !$this->firsttime && !($this->formtype == 'initial') && !$this->noVisualEditor ) {
			self::html2wiki( $this->mArticle, $wgUser, &$this, &$this->textbox1 );
		}

		# MeanEditor: we could leave MeanEditor enabled, but I think it would be confusing
		if ($this->diff || ($this->formtype == 'diff'))
			$this->noVisualEditor = true;




		# Attempt submission here.  This will check for edit conflicts,
		# and redundantly check for locked database, blocked IPs, etc.
		# that edit() already checked just in case someone tries to sneak
		# in the back door with a hand-edited submission URL.

		if ( 'save' == $this->formtype ) {
			if ( !$this->attemptSave() ) {
				wfProfileOut( __METHOD__."-business-end" );
				wfProfileOut( __METHOD__ );
				return;
			}
		}

		# First time through: get contents, set time for conflict
		# checking, etc.
		if ( 'initial' == $this->formtype || $this->firsttime ) {
			if ( $this->initialiseForm() === false ) {
				$this->noSuchSectionPage();
				wfProfileOut( __METHOD__."-business-end" );
				wfProfileOut( __METHOD__ );
				return;
			}
			if ( !$this->mTitle->getArticleId() )
				wfRunHooks( 'EditFormPreloadText', array( &$this->textbox1, &$this->mTitle ) );
			else
				wfRunHooks( 'EditFormInitialText', array( $this ) );
		}

		$this->showEditForm();
		wfProfileOut( __METHOD__."-business-end" );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * We need to read the checkbox and the hidden value to know if the
	 * visual editor was used or not
	 */
	function importFormData( &$request ) {
		global $wgUser;

		if ( $request->wasPosted() ) {
			# Reuse values from the previous submission
			$this->noVisualEditor = $request->getVal( 'wpNoVisualEditor' );
			$this->userWantsTraditionalEditor = $request->getCheck( 'wpWantTraditionalEditor' );
		} else {
			# Default values
			$this->noVisualEditor = false;
			$this->userWantsTraditionalEditor = $wgUser->getOption('prefer_traditional_editor');
		}

		return parent::importFormData($request);
	}

	# Mediawiki 1.16 implements almost exactly the hook we need here.
	# They even automatically disable the visual editor on conflicts. Thanks guys!
	function showContentForm() {
		global $wgOut;

		# Should be redundant, but check just in case
		if ( $this->diff || wfReadOnly() ) {
			$this->noVisualEditor = true;
		}

		# Also apply htmlspecialchars? See $encodedtext
		$html_text = $this->safeUnicodeOutput( $this->textbox1 );
		if (!($this->noVisualEditor || $this->userWantsTraditionalEditor)) {
			$this->noVisualEditor = self::wiki2html( $this->mArticle, $wgUser, &$this, &$html_text );
		}
		if (!$this->noVisualEditor && !$this->userWantsTraditionalEditor) {
			# TODO: Now that MediaWiki has showContentForm, there is no need for a separate hook
			$this->noVisualEditor = self::showBox( &$this, $html_text, $rows, $cols, $ew );
		}
		if (!$this->noVisualEditor && !$this->userWantsTraditionalEditor) {
			$wgOut->addHTML("<input type='hidden' value=\"0\" name=\"wpNoVisualEditor\" />\n");
		} else {
			$wgOut->addHTML("<input type='hidden' value=\"1\" name=\"wpNoVisualEditor\" />\n");
			parent::showContentForm();
	        }
	}

	# We need to set the correct value for our checkbox
	function showStandardInputs( &$tabindex = 2 ) {
		global $wgOut, $wgUser;
		$wgOut->addHTML( "<div class='editOptions'>\n" );

		if ( $this->section != 'new' ) {
			$this->showSummaryInput( false, $this->summary );
			$wgOut->addHTML( $this->getSummaryPreview( false, $this->summary ) );
		}

		# MeanEditor: also set the value of our checkbox
		$checkboxes = $this->getCheckboxes( $tabindex, //$wgUser->getSkin(),
			array( 'minor' => $this->minoredit, 'watch' => $this->watchthis,
			 'want_traditional_editor' => $this->userWantsTraditionalEditor) );

		$wgOut->addHTML( "<div class='editCheckboxes'>" . implode( $checkboxes, "\n" ) . "</div>\n" );
		$wgOut->addHTML( "<div class='editButtons'>\n" );
		$wgOut->addHTML( implode( $this->getEditButtons( $tabindex ), "\n" ) . "\n" );

		$cancel = $this->getCancelLink();
		$separator = wfMsgExt( 'pipe-separator' , 'escapenoentities' );
		$edithelpurl = Skin::makeInternalOrExternalUrl( wfMsgForContent( 'edithelppage' ) );
		$edithelp = '<a target="helpwindow" href="'.$edithelpurl.'">'.
			htmlspecialchars( wfMsg( 'edithelp' ) ).'</a> '.
			htmlspecialchars( wfMsg( 'newwindow' ) );
		$wgOut->addHTML( "	<span class='editHelp'>{$cancel}{$separator}{$edithelp}</span>\n" );
		$wgOut->addHTML( "</div><!-- editButtons -->\n</div><!-- editOptions -->\n" );
	}

	# We need to add the class 'wymupdate' to all buttons
	public function getEditButtons(&$tabindex) {
		$buttons = array();

		$temp = array(
			'id'        => 'wpSave',
			'name'      => 'wpSave',
			'type'      => 'submit',
			'class'     => 'wymupdate', #MeanEditor
			'tabindex'  => ++$tabindex,
			'value'     => wfMsg( 'savearticle' ),
			'accesskey' => wfMsg( 'accesskey-save' ),
			'title'     => wfMsg( 'tooltip-save' ).' ['.wfMsg( 'accesskey-save' ).']',
		);
		$buttons['save'] = Xml::element('input', $temp, '');

		++$tabindex; // use the same for preview and live preview
		$temp = array(
			'id'        => 'wpPreview',
			'name'      => 'wpPreview',
			'type'      => 'submit',
			'class'     => 'wymupdate', #MeanEditor
			'tabindex'  => $tabindex,
			'value'     => wfMsg( 'showpreview' ),
			'accesskey' => wfMsg( 'accesskey-preview' ),
			'title'     => wfMsg( 'tooltip-preview' ) . ' [' . wfMsg( 'accesskey-preview' ) . ']',
		);
		$buttons['preview'] = Xml::element( 'input', $temp, '' );
		$buttons['live'] = '';

		$temp = array(
			'id'        => 'wpDiff',
			'name'      => 'wpDiff',
			'type'      => 'submit',
			'class'     => 'wymupdate', #MeanEditor
			'tabindex'  => ++$tabindex,
			'value'     => wfMsg( 'showdiff' ),
			'accesskey' => wfMsg( 'accesskey-diff' ),
			'title'     => wfMsg( 'tooltip-diff' ) . ' [' . wfMsg( 'accesskey-diff' ) . ']',
		);
		$buttons['diff'] = Xml::element( 'input', $temp, '' );

		wfRunHooks( 'EditPageBeforeEditButtons', array( &$this, &$buttons, &$tabindex ) );
		return $buttons;
	}

	static function substitute_hashed_img_urls($text) {
		while (preg_match('/\[\[Image:(.*?)\]\]/', $text, $matches)) {
			$img = $matches[1];
			$hash = md5($img);
			$folder = substr($hash, 0, 1) .
				'/' . substr($hash, 0, 2);
			$tag = '<img alt="' . $img . '" src="' . $wgUploadPath .
				'/' . $folder . '/' . $img . '" />';
			$text = str_replace($matches[0], $tag, $text);
		}
		return $text;
	}

	static function deny_visual_because_of($reason, &$edit_context) {
		global $wgOut;
		$wgOut->addHTML('<p class="visual_editing_denied errorbox">' . wfMsg('no_visual') . '<em class="visual_editing_denied_reason">'.$reason.'</em></p>');
		# FIXME: Doesn't work. Why?
		#$edit_context->editFormTextBeforeContent .= '<p class="visual_editing_denied errorbox">The visual editor can\'t be used for this page. Most likely, it contains advanced or unsopported features. If you can, try editing smaller paragraphs.<br /><br />Reason: <em class="visual_editing_denied_reason">'.$reason.'</em></p>';
		# Maybe add a page to gather feedback
		return true;  # Show the standard textbox interface
	}

	# Return true to force traditional editing
	static function wiki2html($article, $user, &$edit_context, &$wiki_text) {
		global $wgUploadPath, $wgArticlePath;
		$meaneditor_page_src = str_replace('$1', '', $wgArticlePath);

		# Detect code sections (lines beginning with whitespace)
		if (preg_match('/^[ \t]/m',$wiki_text))
			return self::deny_visual_because_of(wfMsg('reason_whitespace'), $edit_context);

		# Detect custom tags: only <br />, super/sub-scripts and references are supported at the moment
		# TODO: expand the safe list
		# Especially problematic tags (do not even think about supporting them):
		#      <p>  (would require special handling to disable normal paragraphing, confusing)
		#      <h*> (for headings not in TOC, strange closing tag)
		#      <b>,<i> (not to be confused with ''emphasis'' as <em>)
		#      <pre>, <nowiki> (if something gets implemented, better be the common leading spaces)
		$wiki_text=str_replace('<br />','__TEMP__TEMP__br',$wiki_text);
		$wiki_text=str_replace('<br>','__TEMP__TEMP__br',$wiki_text);
		$wiki_text=str_replace('<references />','__TEMP__TEMP__allreferences',$wiki_text);
		$wiki_text=str_replace('<ref>','__TEMP__TEMP__ref',$wiki_text);
		$wiki_text=str_replace('</ref>','__TEMP__TEMP__cref',$wiki_text);
		$wiki_text=str_replace('<sup>','__TEMP__TEMP__sup',$wiki_text);
		$wiki_text=str_replace('</sup>','__TEMP__TEMP__csup',$wiki_text);
		$wiki_text=str_replace('<sub>','__TEMP__TEMP__sub',$wiki_text);
		$wiki_text=str_replace('</sub>','__TEMP__TEMP__csub',$wiki_text);
		if (!((strpos($wiki_text, '<')===FALSE) && (strpos($wiki_text, '>')===FALSE)))
			return self::deny_visual_because_of(wfMsg('reason_tag'), $edit_context);
		$wiki_text=str_replace('__TEMP__TEMP__br','<br />', $wiki_text);
		$wiki_text=str_replace('__TEMP__TEMP__allreferences','references_here',$wiki_text);
		$wiki_text=str_replace('__TEMP__TEMP__sup','<sup>',$wiki_text);
		$wiki_text=str_replace('__TEMP__TEMP__csup','</sup>',$wiki_text);
		$wiki_text=str_replace('__TEMP__TEMP__sub','<sub>',$wiki_text);
		$wiki_text=str_replace('__TEMP__TEMP__csub','</sub>',$wiki_text);
		$wiki_text=str_replace('__TEMP__TEMP__ref','<ref>',$wiki_text);
		$wiki_text=str_replace('__TEMP__TEMP__cref','</ref>',$wiki_text);

		# This characters are problematic only at line beginning
		$unwanted_chars_at_beginning = array(':', ';');
		foreach ($unwanted_chars_at_beginning as $uc)
			if (preg_match('/^'.$uc.'/m',$wiki_text))
				return self::deny_visual_because_of(wfMsg('reason_indent', $uc), $edit_context);

		# <hr>, from Parser.php... TODO: other regexps can be directly stolen from there
		$wiki_text=preg_replace('/(^|\n)-----*/', '\\1<hr />', $wiki_text);

		#Collapse multiple newlines
		# TODO: Compare Wikipedia:Don't_use_line_breaks
		$wiki_text=preg_replace("/\n\n+/","\n\n",$wiki_text);

		$wiki_text=preg_replace('/^(.+?)$/m','<p>$1</p>',$wiki_text);

		#$wiki_text=preg_replace('/\'\'\'(.*?)\'\'\'/','<strong>$1</strong>',$wiki_text);
		#$wiki_text=preg_replace('/\'\'(.*?)\'\'/','<em>$1</em>',$wiki_text);
		$obp = new Parser;
		$obp->setTitle('');
		$obp->mOptions = new ParserOptions;
		$obp->clearState();
		$wiki_text = $obp->doAllQuotes($wiki_text);

		#Substitute ===
		$wiki_text=preg_replace('/(?:<p>|)\s*===(.*?)===\s*(?:<\/p>|)/','<h3>\1</h3>',$wiki_text);

		#Substitute ==
		$wiki_text=preg_replace('/(?:<p>|)\s*==(.*?)==\s*(?:<\/p>|)/','<h2>\1</h2>',$wiki_text);

		#Substitute [[Image:a]]
		if (!$wgHashedUploadDirectory) {
			$wiki_text=preg_replace('/\[\[Image:(.*?)\]\]/','<img alt="\1" src="' . $wgUploadPath . '/\1" />',$wiki_text);
		} else {
			$wiki_text = self::substitute_hashed_img_urls($wiki_text);
		}

		$wiki_text=preg_replace('/\[\[Image:(.*?)\]\]/','<img alt="\1" src="' . $wgUploadPath . '/\1" />',$wiki_text);

		#Create [[a|b]] syntax for every link
		#TODO: What to do for the [[word (detailed disambiguation)|]] 'pipe trick'?
		$wiki_text=preg_replace('/\[\[([^|]*?)\]\]/','[[\1|\1]]',$wiki_text);

		#Substitute [[ syntax (internal links)
		if (preg_match('/\[\[([^|\]]*?):(.*?)\|(.*?)\]\]/',$wiki_text,$unwanted_matches))
			return self::deny_visual_because_of(wfMsg('reason_special_link', $unwanted_matches[0]), $edit_context);
		#Preserve #section links from the draconic feature detection
		$wiki_text=preg_replace_callback('/\[\[(.*?)\|(.*?)\]\]/',
			create_function('$matches', 'return "[[".str_replace("#","__TEMP_MEAN_hash",$matches[1])."|".str_replace("#","__TEMP_MEAN_hash",$matches[2])."]]";'),
			$wiki_text);
		$wiki_text=preg_replace_callback('/<a href="(.*?)">/',
				create_function('$matches', 'return "<a href=\"".str_replace("#","__TEMP_MEAN_hash",$matches[1])."\">";'),
				$wiki_text);
		$wiki_text=preg_replace('/\[\[(.*?)\|(.*?)\]\]/','<a href="' . $meaneditor_page_src . '\1">\2</a>',$wiki_text);

		#Create [a b] syntax for every link
		#(must be here, so that internal links have already been replaced)
		$wiki_text=preg_replace('/\[([^| ]*?)\]/','[\1 _autonumber_]',$wiki_text);

		#Substitute [ syntax (external links)
		$wiki_text=preg_replace('/\[(.*?) (.*?)\]/','<a href="\1">\2</a>',$wiki_text);

		#Lists support
		$wiki_text=preg_replace("/<p># (.*?)<\/p>/",'<ol><li>\1</li></ol>',$wiki_text);
		$wiki_text=preg_replace("/<p>\* (.*?)<\/p>/",'<ul><li>\1</li></ul>',$wiki_text);
		$wiki_text=preg_replace("/<\/ol>\n<ol>/","\n",$wiki_text);
		$wiki_text=preg_replace("/<\/ul>\n<ul>/","\n",$wiki_text);

		# Crude but safe detection of unsupported features
		# In the future, this could be loosened a lot, should also detect harmless uses
		# TODO: Compare with MediaWiki security policy, ensure no mediawiki code can create unsafe HTML in the editor

		# Allow numbered entities, these occur far too often and should be innocous
		$wiki_text=str_replace('&#','__TEMP__MEAN__nument',$wiki_text);

		$unwanted_chars = array('[', ']', '|', '{', '}', '#', '*');
		foreach ($unwanted_chars as $uc)
			if (!($unwanted_match = strpos($wiki_text, $uc) === FALSE))
				return self::deny_visual_because_of(wfMsg('reason_forbidden_char', $uc), $edit_context);

		# Restore numbered entities
		$wiki_text=str_replace('__TEMP__MEAN__nument','&#',$wiki_text);

		#<ref> support
		global $refs_div;
		global $refs_num;
		$refs_div='';
		$refs_num=0;
		$wiki_text=preg_replace_callback('/<ref>(.*?)<\/ref>/',
			create_function('$matches', 'global $refs_div,$refs_num; $refs_num++; $refs_div=$refs_div."<p id=ref".$refs_num." class=\"ref\"> [".$refs_num."] ".
				$matches[1]."</p>"; return "<a href=\"#ref".$refs_num."\"> [".$refs_num."] </a>";'),
			$wiki_text);
		$refs_div='<div class="ref">'.$refs_div."</div>";


		# We saved #section links from the sacred detection fury, now restore them
		$wiki_text=str_replace("__TEMP_MEAN_hash","#",$wiki_text);

		$wiki_text=$wiki_text.$refs_div;

		return false;
	}

	static function html2wiki($article, $user, &$edit_context, &$html_text) {
		global $wgArticlePath;
		$meaneditor_page_src = str_replace('$1', '', $wgArticlePath);
		$meaneditor_page_src_escaped = addcslashes($meaneditor_page_src, '/.');

		$html_text=preg_replace('/(^|\n)<hr \/>*/', '\\1-----',$html_text);
		$html_text=preg_replace('/<strong>(.*?)<\/strong>/','\'\'\'\1\'\'\'',$html_text);
		$html_text=preg_replace('/<em>(.*?)<\/em>/','\'\'\1\'\'',$html_text);
		$html_text=preg_replace('/<h2>(.*?)<\/h2>/',"==\\1==\n",$html_text);
		$html_text=preg_replace('/<h3>(.*?)<\/h3>/',"===\\1===\n",$html_text);

		$html_text=preg_replace_callback('/<a href="'.$meaneditor_page_src_escaped.'(.*?)">/',
			create_function('$matches', 'return "<a href=\"'.$meaneditor_page_src.'" . rawurldecode($matches[1]). "\">";'), $html_text);
		$html_text=preg_replace('/<a href="'.$meaneditor_page_src_escaped.'(.*?)">(.*?)<\/a>/','[[\1|\2]]',$html_text);

		$html_text=preg_replace('/references_here/','<references />',$html_text);

		#<ref> support:
		# 1) Extract references block
		global $html_refs;
		$html_text=preg_replace_callback('/<div class="ref">(.*?)<\/div>/',
			create_function('$matches', 'global $html_refs; $html_refs=$matches[1];
				return "";'),
			$html_text);
		# 2) Put each reference in place
		$html_text=preg_replace_callback('/<a href="#(.*?)">.*?<\/a>/',
			create_function('$matches', 'global $html_refs; preg_match("/<p id=.".$matches[1].".*?> \[.*?\] (.*?)<\/p>/",$html_refs,$b);return "<ref>".$b[1]."</ref>";'),$html_text);

		$html_text=preg_replace('/<p>/','',$html_text);
		$html_text=preg_replace('/<\/p>/',"\n\n",$html_text);

		$html_text=preg_replace('/<a href="(.*?)">(.*?)<\/a>/','[\1 \2]',$html_text);

		$html_text=preg_replace_callback('/<img alt="(.*?)" src="(.*?)" \/>/',create_function('$matches',
			'return "[[Image:".$matches[1]."]]";'
		),$html_text);
		$html_text=preg_replace_callback('/<img src="(.*?)" alt="(.*?)" \/>/',create_function('$matches',
			'return "[[Image:".$matches[2]."]]";'
		),$html_text);

		# TODO: integrate lists with the previous paragraph? Check XHTML requirements
		$html_text=preg_replace_callback('/<ol>(.*?)<\/ol>/',create_function('$matches',
			'$matches[1]=str_replace("<li>","# ",$matches[1]);
			return str_replace("</li>","\n",$matches[1])."\n";'),$html_text);
		$html_text=preg_replace_callback('/<ul>(.*?)<\/ul>/',create_function('$matches',
			'$matches[1]=str_replace("<li>","* ",$matches[1]);
			return str_replace("</li>","\n",$matches[1])."\n";'),$html_text);

		# Let's simplify [page] links which don't need [page|text] syntax
		$html_text=preg_replace('/\[\[(.*?)\|\1\]\]/','[[\1]]',$html_text);
		# The same for autonumbered external links
		$html_text=preg_replace('/\[(.*?) _autonumber_\]/','[\1]',$html_text);

		# Safe-guard against unwanted whitespace at the beginning of a line
		# TODO: code sections
		$html_text=preg_replace('/^[ \t]+/',"",$html_text);
		$html_text=preg_replace('/\n[ \t]+/',"\n",$html_text);

		# When editing sections, Wymeditor has the bad habit of adding two newlines
		# TODO: Why? Anyway, redundant whitespace handling is already authoritarian
		$html_text=preg_replace('/\n\n$/', '', $html_text);

		return false;
	}

	static function showBox(&$edit_context, $html_text, $rows, $cols, $ew) {
		global $wgOut, $wgArticlePath, $wgStylePath, $wgUploadPath, $wgLang;
		$wiki_path = str_replace('$1', '', $wgArticlePath);
		$wgOut->addScriptFile('../../extensions/MeanEditor/wymeditor/jquery/jquery.js');
		$wgOut->addScriptFile('../../extensions/MeanEditor/wymeditor/wymeditor/jquery.wymeditor.pack.js');
		$wgOut->addScriptFile('../../extensions/MeanEditor/wymeditor/wymeditor/plugins/resizable/jquery.wymeditor.resizable.js');
		$wgOut->addExtensionStyle('../extensions/MeanEditor/fix_meaneditor.css');

		# For now, it looks better in IE8 standards mode, even though IE support is very messy
		#$wgOut->addMeta('X-UA-Compatible', 'IE=7');

		$wgOut->addInlineScript('
			Array.prototype.wym_remove = function(from, to) {
				// From a suggestion at forum.wymeditor.org
				this.splice(from, !to || 1 + to - from + (!(to < 0 ^ from >= 0) && (to < 0 || -1) * this.length));
				    return this.length;
			};
	                jQuery(function() {
	                    jQuery(\'.wymeditor\').wymeditor({
					html: "'.addcslashes($html_text,"\"\n").'",
					lang: "'.$wgLang->getCode().'",
					iframeBasePath: "extensions/MeanEditor/iframe/",
					dialogLinkHtml: "<body class=\'wym_dialog wym_dialog_link\'"
						+ " onload=\'WYMeditor.INIT_DIALOG(" + WYMeditor.INDEX + ")\'"
						+ ">"
						+ "<form>"
						+ "<fieldset>"
						+ "<input type=\'hidden\' class=\'wym_dialog_type\' value=\'"
						+ WYMeditor.DIALOG_LINK
						+ "\' />"
						+ "<legend>{Link}</legend>"
						+ "<div class=\'row\'>"
						+ "<label>{URL}</label>"
						+ "<input type=\'text\' class=\'wym_href\' value=\'\' size=\'40\' />"
						+ "</div>"
						+ "<div class=\'row row-indent\'>"
						+ "<input class=\'wym_submit\' type=\'button\'"
						+ " value=\'{Submit}\' />"
						+ "<input class=\'wym_cancel\' type=\'button\'"
						+ "value=\'{Cancel}\' />"
						+ "</div>"
						+ "</fieldset>"
						+ "</form>"
						+ "</body>",
					dialogImageHtml:  "<body class=\'wym_dialog wym_dialog_image\'"
						+ " onload=\'WYMeditor.INIT_DIALOG(" + WYMeditor.INDEX + ")\'"
						+ ">"
						+ "<script type=\'text/javascript\' src=\''.$wgStylePath.'/common/ajax.js\'></scr"+"ipt>"
						+ "<script type=\'text/javascript\'>function meaneditor_responder(e) {"
						+ "	divwait=document.getElementById(\'meaneditor_ajax_wait\');"
						+ "	if (divwait)"
						+ "		divwait.style.display = \'none\';"
						+ "	div=document.getElementById(\'meaneditor_ajax_table\');"
						+ "	div.innerHTML=e.responseText;"
						+ "}</scr"+"ipt>"
						+ "<form>"
						+ "<fieldset>"
						+ "<input type=\'hidden\' class=\'wym_dialog_type\' value=\'"
						+ WYMeditor.DIALOG_IMAGE
						+ "\' />"
						+ "<legend>{Image}</legend>"
						+ "<div class=\'row\'>"
						+ "<label>{Title}</label>"
						+ "<input id=\'image_name\' type=\'text\' class=\'wym_src\' value=\'\' size=\'40\' />"
						+ "</div>"
						+ "<div class=\'row\'>"
						+ "<script>sajax_do_call(\'recent_images\',[0],meaneditor_responder,0);</scr"+"ipt>"
						+ "<p>' . wfMsg('recent_images_text',str_replace('$1','Special:Upload',$wgArticlePath)) . '</p>"
						+ "<div id=\'meaneditor_ajax_wait\' style=\'color: #999; margin-bottom: 1em;\'>' . wfMsg('livepreview-loading') . '</div>"
						+ "<div style=\'max-height: 115px; overflow: auto\'><table id=\'meaneditor_ajax_table\'></table></div>"
						+ "</div>"
						+ "<div class=\'row row-indent\'>"
						+ "<input class=\'wym_submit_meaneditor_image\' type=\'button\'"
						+ " value=\'{Submit}\' />"
						+ "<input class=\'wym_cancel\' type=\'button\'"
						+ "value=\'{Cancel}\' />"
						+ "</div>"
						+ "</fieldset>"
						+ "</form>"
						+ "</body>",

					preInit: function(wym) {
						// Remove unwanted buttons, code from a suggestion at forum.wymeditor.org
						wym._options.toolsItems.wym_remove(6);
						wym._options.toolsItems.wym_remove(6);
						wym._options.toolsItems.wym_remove(11);
						wym._options.toolsItems.wym_remove(12);
						wym._options.toolsItems.wym_remove(12);
					},
					postInit: function(wym) {
						var wikilink_button_html = "<li class=\'wym_tools_wikilink\'>"
							+ "<a name=\'Wikilink\' href=\'#\' "
							+ "style=\'background-image: url(extensions/MeanEditor/wikilink-icon.png)\'>"
							+ "Create Wikilink</a></li>";
						var wikilink_dialog_html = "<body class=\'wym_dialog wym_dialog_wikilink\'"
							+ " onload=\'WYMeditor.INIT_DIALOG(" + WYMeditor.INDEX + ")\'"
							+ ">"
							+ "<form>"
							+ "<fieldset>"
							+ "<input type=\'hidden\' class=\'wym_dialog_type\' value=\'"
							+ "MeanEditor_dialog_wikilink"
							+ "\' />"
							+ "<legend>Wikilink</legend>"
							+ "<div class=\'row\'>"
							+ "<label>Page</label>"
							+ "<input type=\'text\' class=\'wym_wikititle\' value=\'\' size=\'40\' />"
							+ "</div>"
							+ "<div class=\'row row-indent\'>"
							+ "Tip: to link \"dog\" from \"dogs\", just select the first letters."
							+ "</div>"
							+ "<div class=\'row row-indent\'>"
							+ "<input class=\'wym_submit wym_submit_wikilink\' type=\'button\'"
							+ " value=\'{Submit}\' />"
							+ "<input class=\'wym_cancel\' type=\'button\'"
							+ "value=\'{Cancel}\' />"
							+ "</div></fieldset></form></body>";

						jQuery(wym._box).find(wym._options.toolsSelector + wym._options.toolsListSelector)
							.append(wikilink_button_html);
						jQuery(wym._box).find(\'li.wym_tools_wikilink a\').click(function() {
							wym.dialog(\'Wikilink\', wikilink_dialog_html);
							return (false);
						});

						wym.resizable();
					},
					preInitDialog: function(wym, wdm) {
						if (wdm.jQuery(wym._options.dialogTypeSelector).val() != \'MeanEditor_dialog_wikilink\')
							return;

						var selected = wym.selected();

						// Copied from Link dialog handling
						if(selected && selected.tagName && selected.tagName.toLowerCase != WYMeditor.A)
							selected = jQuery(selected).parentsOrSelf(WYMeditor.A);
						if(!selected && wym._selected_image)
							selected = jQuery(wym._selected_image).parentsOrSelf(WYMeditor.A);

						var wikipage;
						wikipage = jQuery(selected).attr(WYMeditor.HREF);
						if (wikipage) {
							if (wikipage.indexOf(\'' . $wiki_path . '\') == -1) {
								alert(\'This is an external link. If you want to convert it to a wikilink, remove the existing link first.\');
								wikipage = \'[External link, do not edit here]\';
								wdm.close();
							}
							else wikipage = wikipage.slice(' . strlen($wiki_path) . ');
						} elseif (wym._iframe.contentWindow.getSelection) {
							wikipage = wym._iframe.contentWindow.getSelection().toString();
						} elseif (wym._iframe.contentWindow.document.selection && wym._iframe.contentWindow.document.selection.createRange) {
							var range = wym._iframe.contentWindow.document.selection.createRange();
							wikipage = range.text;
						}
						wdm.jQuery(\'.wym_wikititle\').val(wikipage);
					},
					postInitDialog: function(wym, wdw) {
						var dbody = wdw.document.body;
						wdw.jQuery(dbody).find(\'input.wym_submit_wikilink\').click(function() {
							var wikipage = jQuery(dbody).find(\'.wym_wikititle\').val();
							var sUrl = \'' . $wiki_path . '\' + wikipage;

							// Copied from Link dialog handling
							var sStamp = wym.uniqueStamp();
							if(sUrl.length > 0) {
								wym._exec(WYMeditor.CREATE_LINK, sStamp);
								jQuery("a[@href=" + sStamp + "]", wym._doc.body)
									.attr(WYMeditor.HREF, sUrl);
							}
							wdw.close();
						});
						wdw.jQuery(dbody).find(\'input.wym_submit_meaneditor_image\').click(function() {
							var image_name = jQuery(dbody).find(wym._options.srcSelector).val();
							var sUrl = \'' . $wgUploadPath . '/' . '\' + image_name;

							// Copied from original dialog handling
							var sStamp = wym.uniqueStamp();
							if(sUrl.length > 0) {
								wym._exec(WYMeditor.INSERT_IMAGE, sStamp);
								jQuery("img[@src=" + sStamp + "]", wym._doc.body)
									.attr(WYMeditor.SRC, sUrl)
									.attr(WYMeditor.ALT, image_name);
							}
							wdw.close();
						});
					}

	                    });
	                });
');
		$wgOut->addHTML( <<<END
<textarea tabindex='1' accesskey="," name="wpTextbox1" id="wpTextbox1" class="wymeditor" rows='{$rows}'
cols='{$cols}'{$ew}></textarea>
END
		);
		return false;
	}

}
