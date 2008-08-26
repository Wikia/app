<?php

include_once("includes/EditPage.php");

$wgExtensionFunctions[] = 'registerStructuredNamespaceExtension';
$wgExtensionCredits['other'][] = array(
					    'name' => 'Structured Namespace',
					    'author' => 'Jason Richey',
					    'version' => 0.1,
					    'url' => 'http://sf.net/projects/wikia/',
					    );

function registerStructuredNamespaceExtension(){
  global $wgHooks;
  global $wgEnableStructuredEdit;
  $wgEnableStructuredEdit = true;
  if(!array_key_exists('AlternateEdit', $wgHooks) ) {
      $wgHooks['AlternateEdit'] = array();
  }
  if(defined($wgHooks['AlternateEdit']) && !is_array($wgHooks['AlternateEdit'])){
    $old = $wgHooks['AlternateEdit'];
    $wgHooks['AlternateEdit'] = array($old);
  }
#  $wgHooks['AlternateEdit'][] = "structuredEdit";

  $wgHooks['EditFilter'][] = 'structuredSave'; 
}

function structuredSave($editpage,$textbox1,$section){
  global $wgStructuredParts;
  $localdata = "";

  $ns = $editpage->mArticle->mTitle->getNamespace();
  if(isset( $wgStructuredParts[$ns] )){
    foreach($wgStructuredParts[$ns] as $item){
      $localdata .= "<{$item['name']}>{$editpage->{$item['name']}}</{$item['name']}>\n";
    }
  }
  $localdata .= "<text>$textbox1</text>\n";
  $editpage->textbox1 = $localdata;
  print "attempting to save {$editpage->textbox1}\n";
  return true;
}

function structuredEdit($editpage){
  structuredEditPage::edit($editpage);
}

class StructuredEditPage extends EditPage{


	/**
	 * Send the edit form and related headers to $wgOut
	 * @param $formCallback Optional callable that takes an OutputPage
	 *                      parameter; will be called during form output
	 *                      near the top, for captchas and the like.
	 */
	function showEditForm( $formCallback=null ) {
		global $wgOut, $wgUser, $wgLang, $wgContLang, $wgMaxArticleSize;

		$fname = 'EditPage::showEditForm';
		wfProfileIn( $fname );

		$sk =& $wgUser->getSkin();

		wfRunHooks( 'EditPage::showEditForm:initial', array( &$this ) ) ;

		$wgOut->setRobotpolicy( 'noindex,nofollow' );

		# Enabled article-related sidebar, toplinks, etc.
		$wgOut->setArticleRelated( true );

		if ( $this->isConflict ) {
			$s = wfMsg( 'editconflict', $this->mTitle->getPrefixedText() );
			$wgOut->setPageTitle( "Testing something".$s );
			$wgOut->addWikiText( wfMsg( 'explainconflict' ) );

			$this->textbox2 = $this->textbox1;
			$this->textbox1 = $this->mArticle->getContent();
			$this->edittime = $this->mArticle->getTimestamp();
		} else {

			if( $this->section != '' ) {
				if( $this->section == 'new' ) {
					$s = wfMsg('editingcomment', $this->mTitle->getPrefixedText() );
				} else {
					$s = wfMsg('editingsection', $this->mTitle->getPrefixedText() );
					if( !$this->preview && !$this->diff ) {
						preg_match( "/^(=+)(.+)\\1/mi",
							$this->textbox1,
							$matches );
						if( !empty( $matches[2] ) ) {
							$this->summary = "/* ". trim($matches[2])." */ ";
						}
					}
				}
			} else {
				$s = wfMsg( 'editing', $this->mTitle->getPrefixedText() );
			}
			$wgOut->setPageTitle( "Testing something".$s );

			if ( $this->missingComment ) {
				$wgOut->addWikiText( wfMsg( 'missingcommenttext' ) );
			}
			
			if( $this->missingSummary ) {
				$wgOut->addWikiText( wfMsg( 'missingsummary' ) );
			}

			if ( !$this->checkUnicodeCompliantBrowser() ) {
				$wgOut->addWikiText( wfMsg( 'nonunicodebrowser') );
			}
			if ( isset( $this->mArticle )
			     && isset( $this->mArticle->mRevision )
			     && !$this->mArticle->mRevision->isCurrent() ) {
				$this->mArticle->setOldSubtitle( $this->mArticle->mRevision->getId() );
				$wgOut->addWikiText( wfMsg( 'editingold' ) );
			}
		}

		if( wfReadOnly() ) {
			$wgOut->addWikiText( wfMsg( 'readonlywarning' ) );
		} elseif( $wgUser->isAnon() && $this->formtype != 'preview' ) {
			$wgOut->addWikiText( wfMsg( 'anoneditwarning' ) );
		} else {
			if( $this->isCssJsSubpage && $this->formtype != 'preview' ) {
				# Check the skin exists
				if( $this->isValidCssJsSubpage ) {
					$wgOut->addWikiText( wfMsg( 'usercssjsyoucanpreview' ) );
				} else {
					$wgOut->addWikiText( wfMsg( 'userinvalidcssjstitle', $this->mTitle->getSkinFromCssJsSubpage() ) );
				}
			}
		}
			
		if( $this->mTitle->isProtected( 'edit' ) ) {
			if( $this->mTitle->isSemiProtected() ) {
				$notice = wfMsg( 'semiprotectedpagewarning' );
				if( wfEmptyMsg( 'semiprotectedpagewarning', $notice ) || $notice == '-' ) {
					$notice = '';
				}
			} else {
				$notice = wfMsg( 'protectedpagewarning' );
			}
			$wgOut->addWikiText( $notice );
		}

		if ( $this->kblength === false ) {
			$this->kblength = (int)(strlen( $this->textbox1 ) / 1024);
		}
		if ( $this->tooBig || $this->kblength > $wgMaxArticleSize ) {
			$wgOut->addWikiText( wfMsg( 'longpageerror', $wgLang->formatNum( $this->kblength ), $wgMaxArticleSize ) );
		} elseif( $this->kblength > 29 ) {
			$wgOut->addWikiText( wfMsg( 'longpagewarning', $wgLang->formatNum( $this->kblength ) ) );
		}

		$rows = $wgUser->getOption( 'rows' );
		$cols = $wgUser->getOption( 'cols' );

		$ew = $wgUser->getOption( 'editwidth' );
		if ( $ew ) $ew = " style=\"width:100%\"";
		else $ew = '';

		$q = 'action=submit';
		#if ( "no" == $redirect ) { $q .= "&redirect=no"; }
		$action = $this->mTitle->escapeLocalURL( $q );

		$summary = wfMsg('summary');
		$subject = wfMsg('subject');
		$minor   = wfMsg('minoredit');
		$watchthis = wfMsg ('watchthis');

		$cancel = $sk->makeKnownLink( $this->mTitle->getPrefixedText(),
				wfMsg('cancel') );
		$edithelpurl = $sk->makeInternalOrExternalUrl( wfMsgForContent( 'edithelppage' ));
		$edithelp = '<a target="helpwindow" href="'.$edithelpurl.'">'.
			htmlspecialchars( wfMsg( 'edithelp' ) ).'</a> '.
			htmlspecialchars( wfMsg( 'newwindow' ) );

		global $wgRightsText;
		$copywarn = "<div id=\"editpage-copywarn\">\n" .
			wfMsg( $wgRightsText ? 'copyrightwarning' : 'copyrightwarning2',
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
				$wgRightsText ) . "\n</div>";

		if( $wgUser->getOption('showtoolbar') and !$this->isCssJsSubpage ) {
			# prepare toolbar for edit buttons
			$toolbar = $this->getEditToolbar();
		} else {
			$toolbar = '';
		}

		// activate checkboxes if user wants them to be always active
		if( !$this->preview && !$this->diff ) {
			# Sort out the "watch" checkbox
			if( $wgUser->getOption( 'watchdefault' ) ) {
				# Watch all edits
				$this->watchthis = true;
			} elseif( $wgUser->getOption( 'watchcreations' ) && !$this->mTitle->exists() ) {
				# Watch creations
				$this->watchthis = true;
			} elseif( $this->mTitle->userIsWatching() ) {
				# Already watched
				$this->watchthis = true;
			}
			
			if( $wgUser->getOption( 'minordefault' ) ) $this->minoredit = true;
		}

		$minoredithtml = '';

		if ( $wgUser->isAllowed('minoredit') ) {
			$minoredithtml =
				"<input tabindex='3' type='checkbox' value='1' name='wpMinoredit'".($this->minoredit?" checked='checked'":"").
				" accesskey='".wfMsg('accesskey-minoredit')."' id='wpMinoredit' />".
				"<label for='wpMinoredit' title='".wfMsg('tooltip-minoredit')."'>{$minor}</label>";
		}

		$watchhtml = '';

		if ( $wgUser->isLoggedIn() ) {
			$watchhtml = "<input tabindex='4' type='checkbox' name='wpWatchthis'".
				($this->watchthis?" checked='checked'":"").
				" accesskey=\"".htmlspecialchars(wfMsg('accesskey-watch'))."\" id='wpWatchthis'  />".
				"<label for='wpWatchthis' title=\"" .
					htmlspecialchars(wfMsg('tooltip-watch'))."\">{$watchthis}</label>";
		}

		$checkboxhtml = $minoredithtml . $watchhtml;

		if ( $wgUser->getOption( 'previewontop' ) ) {

			if ( 'preview' == $this->formtype ) {
				$this->showPreview();
			} else {
				$wgOut->addHTML( '<div id="wikiPreview"></div>' );
			}

			if ( 'diff' == $this->formtype ) {
				$wgOut->addHTML( $this->getDiff() );
			}
		}


		# if this is a comment, show a subject line at the top, which is also the edit summary.
		# Otherwise, show a summary field at the bottom
		$summarytext = htmlspecialchars( $wgContLang->recodeForEdit( $this->summary ) ); # FIXME
		if( $this->section == 'new' ) {
			$commentsubject="<span id='wpSummaryLabel'><label for='wpSummary'>{$subject}:</label></span> <div class='editOptions'><input tabindex='1' type='text' value=\"$summarytext\" name='wpSummary' id='wpSummary' maxlength='200' size='60' /><br />";
			$editsummary = '';
		} else {
			$commentsubject = '';
			$editsummary="<span id='wpSummaryLabel'><label for='wpSummary'>{$summary}:</label></span> <div class='editOptions'><input tabindex='2' type='text' value=\"$summarytext\" name='wpSummary' id='wpSummary' maxlength='200' size='60' /><br />";
		}

		# Set focus to the edit box on load, except on preview or diff, where it would interfere with the display
		if( !$this->preview && !$this->diff ) {
			$wgOut->setOnloadHandler( 'document.editform.wpTextbox1.focus()' );
		}
		$templates = $this->formatTemplates();

		global $wgUseMetadataEdit ;
		if ( $wgUseMetadataEdit ) {
			$metadata = $this->mMetaData ;
			$metadata = htmlspecialchars( $wgContLang->recodeForEdit( $metadata ) ) ;
			$helppage = Title::newFromText( wfMsg( "metadata_page" ) ) ;
			$top = wfMsg( 'metadata', $helppage->getLocalURL() );
			$metadata = $top . "<textarea name='metadata' rows='3' cols='{$cols}'{$ew}>{$metadata}</textarea>" ;
		}
		else $metadata = "" ;

		$hidden = '';
		$recreate = '';
		if ($this->deletedSinceEdit) {
			if ( 'save' != $this->formtype ) {
				$wgOut->addWikiText( wfMsg('deletedwhileediting'));
			} else {
				// Hide the toolbar and edit area, use can click preview to get it back
				// Add an confirmation checkbox and explanation.
				$toolbar = '';
				$hidden = 'type="hidden" style="display:none;"';
				$recreate = $wgOut->parse( wfMsg( 'confirmrecreate',  $this->lastDelete->user_name , $this->lastDelete->log_comment ));
				$recreate .=
					"<br /><input tabindex='1' type='checkbox' value='1' name='wpRecreate' id='wpRecreate' />".
					"<label for='wpRecreate' title='".wfMsg('tooltip-recreate')."'>". wfMsg('recreate')."</label>";
			}
		}

		$temp = array(
			'id'        => 'wpSave',
			'name'      => 'wpSave',
			'type'      => 'submit',
			'tabindex'  => '5',
			'value'     => wfMsg('savearticle'),
			'accesskey' => wfMsg('accesskey-save'),
			'title'     => wfMsg('tooltip-save'),
		);
		$buttons['save'] = wfElement('input', $temp, '');
		$temp = array(
			'id'        => 'wpDiff',
			'name'      => 'wpDiff',
			'type'      => 'submit',
			'tabindex'  => '7',
			'value'     => wfMsg('showdiff'),
			'accesskey' => wfMsg('accesskey-diff'),
			'title'     => wfMsg('tooltip-diff'),
		);
		$buttons['diff'] = wfElement('input', $temp, '');

		global $wgLivePreview;
		if ( $wgLivePreview && $wgUser->getOption( 'uselivepreview' ) ) {
			$temp = array(
				'id'        => 'wpPreview',
				'name'      => 'wpPreview',
				'type'      => 'submit',
				'tabindex'  => '6',
				'value'     => wfMsg('showpreview'),
				'accesskey' => '',
				'title'     => wfMsg('tooltip-preview'),
				'style'     => 'display: none;',
			);
			$buttons['preview'] = wfElement('input', $temp, '');
			$temp = array(
				'id'        => 'wpLivePreview',
				'name'      => 'wpLivePreview',
				'type'      => 'submit',
				'tabindex'  => '6',
				'value'     => wfMsg('showlivepreview'),
				'accesskey' => wfMsg('accesskey-preview'),
				'title'     => '',
				'onclick'   => $this->doLivePreviewScript(),
			);
			$buttons['live'] = wfElement('input', $temp, '');
		} else {
			$temp = array(
				'id'        => 'wpPreview',
				'name'      => 'wpPreview',
				'type'      => 'submit',
				'tabindex'  => '6',
				'value'     => wfMsg('showpreview'),
				'accesskey' => wfMsg('accesskey-preview'),
				'title'     => wfMsg('tooltip-preview'),
			);
			$buttons['preview'] = wfElement('input', $temp, '');
			$buttons['live'] = '';
		}

		$safemodehtml = $this->checkUnicodeCompliantBrowser()
			? ""
			: "<input type='hidden' name=\"safemode\" value='1' />\n";

		$wgOut->addHTML( <<<END
<form id="editform" name="editform" method="post" action="$action"
enctype="multipart/form-data">
END
);

		if( is_callable( $formCallback ) ) {
			call_user_func_array( $formCallback, array( &$wgOut ) );
		}

		// Put these up at the top to ensure they aren't lost on early form submission
		$wgOut->addHTML( "
<input type='hidden' value=\"" . htmlspecialchars( $this->section ) . "\" name=\"wpSection\" />
<input type='hidden' value=\"{$this->starttime}\" name=\"wpStarttime\" />\n
<input type='hidden' value=\"{$this->edittime}\" name=\"wpEdittime\" />\n
<input type='hidden' value=\"{$this->scrolltop}\" name=\"wpScrolltop\" id=\"wpScrolltop\" />\n" );

		$this->addStructureFields();

		$wgOut->addHTML( <<<END
{$toolbar}
$recreate
{$commentsubject}
<textarea tabindex='1' accesskey="," name="wpTextbox1" id="wpTextbox1" rows='{$rows}'
cols='{$cols}'{$ew} $hidden>
END
. htmlspecialchars( $this->safeUnicodeOutput( $this->textbox1 ) ) .
"
</textarea>
		" );

		$wgOut->addWikiText( $copywarn );
		$wgOut->addHTML( "
{$metadata}
{$editsummary}
{$checkboxhtml}
{$safemodehtml}
");

		$wgOut->addHTML("
<div class='editButtons'>
	{$buttons['save']}
	{$buttons['preview']}
	{$buttons['live']}
	{$buttons['diff']}
	<span class='editHelp'>{$cancel} | {$edithelp}</span>
</div><!-- editButtons -->
</div><!-- editOptions -->");

		$wgOut->addWikiText( wfMsgForContent( 'edittools' ) );

		$wgOut->addHTML( "
<div class='templatesUsed'>
{$templates}
</div>
" );

		if ( $wgUser->isLoggedIn() ) {
			/**
			 * To make it harder for someone to slip a user a page
			 * which submits an edit form to the wiki without their
			 * knowledge, a random token is associated with the login
			 * session. If it's not passed back with the submission,
			 * we won't save the page, or render user JavaScript and
			 * CSS previews.
			 */
			$token = htmlspecialchars( $wgUser->editToken() );
			$wgOut->addHTML( "\n<input type='hidden' value=\"$token\" name=\"wpEditToken\" />\n" );
		}

		# If a blank edit summary was previously provided, and the appropriate
		# user preference is active, pass a hidden tag here. This will stop the
		# user being bounced back more than once in the event that a summary
		# is not required.
		if( $this->missingSummary ) {
			$wgOut->addHTML( "<input type=\"hidden\" name=\"wpIgnoreBlankSummary\" value=\"1\" />\n" );
		}
		
		# For a bit more sophisticated detection of blank summaries, hash the
		# automatic one and pass that in a hidden field.
		$autosumm = $this->autoSumm ? $this->autoSumm : md5( $this->summary );
		$wgOut->addHTML( "<input type=\"hidden\" name=\"wpAutoSummary\" value=\"$autosumm\" />\n" );

		if ( $this->isConflict ) {
			require_once( "DifferenceEngine.php" );
			$wgOut->addWikiText( '==' . wfMsg( "yourdiff" ) . '==' );

			$de = new DifferenceEngine( $this->mTitle );
			$de->setText( $this->textbox2, $this->textbox1 );
			$de->showDiff( wfMsg( "yourtext" ), wfMsg( "storedversion" ) );

			$wgOut->addWikiText( '==' . wfMsg( "yourtext" ) . '==' );
			$wgOut->addHTML( "<textarea tabindex=6 id='wpTextbox2' name=\"wpTextbox2\" rows='{$rows}' cols='{$cols}' wrap='virtual'>"
				. htmlspecialchars( $this->safeUnicodeOutput( $this->textbox2 ) ) . "\n</textarea>" );
		}
		$wgOut->addHTML( "</form>\n" );
		if ( !$wgUser->getOption( 'previewontop' ) ) {

			if ( $this->formtype == 'preview') {
				$this->showPreview();
			} else {
				$wgOut->addHTML( '<div id="wikiPreview"></div>' );
			}
		
			if ( $this->formtype == 'diff') {
				$wgOut->addHTML( $this->getDiff() );
			}

		}

		wfProfileOut( $fname );
	}


function addStructureFields(){
  global $wgOut;
  global $wgStructuredParts;
  
  $ns = $this->mArticle->mTitle->getNamespace();
  if(isset( $wgStructuredParts[$ns] )){
    foreach($wgStructuredParts[$ns] as $item){
      $wgOut->addHTML($item['intro']);
      $wgOut->addHTML("<input type=\"{$item['type']}\"");
      $wgOut->addHTML(" value=\"{$this->{$item['name']}}\"");
      $wgOut->addHTML(" name=\"{$item['name']}\"><br>");
    }
  }
}
 


	/**
	 * @todo document
	 */
	function importFormData( &$request ) {
		global $wgLang, $wgUser, $wgStructuredParts;
		$fname = 'StructuredEditPage::importFormData';
		wfProfileIn( $fname );
        parent::importFormData($request);
		if( $request->wasPosted() ) {
			# These fields need to be checked for encoding.
			# Also remove trailing whitespace, but don't remove _initial_
			# whitespace from the text boxes. This may be significant formatting.
$ns = $this->mArticle->mTitle->getNamespace();
if(isset( $wgStructuredParts[$ns] )){
foreach($wgStructuredParts[$ns] as $item){
$this->{$item['name']} = $this->safeUnicodeInput( $request, $item['name'] );
#print("attempting to access {$item['name']}<br>\n");
#print("got ".$this->{$item['name']}."\n");
}
}
		wfProfileOut( $fname );
	}
}
}
?>