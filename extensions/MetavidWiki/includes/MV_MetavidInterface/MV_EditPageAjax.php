<?
/*
 * Created on Jun 28, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * 
 * The metavid interface class
 * provides the metavid interface for Metavid: requests
 * provides the base metadata
 * 
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 /* very similar to showEditForm in EditPage
 * differences include:
 * 	ajax type display request and processing 
 *  display type based on mvTitle info 
 */
 
 class MV_EditPageAjax extends EditPage{	
	 var $adj_html='';
 	 
 	 function __construct( $article ) {
		$this->mArticle =& $article;		
		$this->mTitle =& $article->mTitle;		
				
		//print "article content: " . $this->mArticle->getContent();
		# Placeholders for text injection by hooks (empty per default)
		$this->editFormPageTop =
		$this->editFormTextTop =
		$this->editFormTextAfterWarn =
		$this->editFormTextAfterTools =
		$this->editFormTextBottom = "";
	} 	 
	function do_pre_annoEdit(){
		
	}
	function getAjaxForm(){
		global $wgUser;
		return '<form id="mvd_form_'.$this->mvd_id.'" name="mvd_form_'.$this->mvd_id.'" method="GET" action="" 
			onSubmit="mv_do_ajax_form_submit(\''.$this->mvd_id.'\', \'save\'); return false;" '.
			'enctype="multipart/form-data" >' .  
			'<input type="hidden" name="fname" value="mv_edit_submit">' . 
				//do the normal edit hidden fields:		
		"\n".'<input type="hidden" value="'. htmlspecialchars( $wgUser->editToken() ) .
		'" name="wpEditToken" />'."\n" . 
		'<input type="hidden" name="title" value="'.$this->mTitle->getDBkey().'">'."\n". 		
		'<input type="hidden" name="mvd_id" value="'.$this->mvd_id.'">'."\n";
	}	
	function loadEditText(){
		//get the article text if it exists		
		if($this->mArticle->mTitle->exists()){					
			$this->stripped_edit_text = $this->mArticle->getContent();
		}else{
			$this->stripped_edit_text='';	
		}
	}
	/*template for transcripts includes a person autocomplete on the left: */
	function do_pre_htEdit(){
		global $wgOut, $wgUser;
		$this->loadEditText();
			
		$MvOverlay = new MV_Overlay();
		//strip semantic tags which are managed by the interface:
		$semantic_data = $MvOverlay->get_and_strip_semantic_tags($this->stripped_edit_text);		
		$out=$js_eval='';
		//add a div for previews: 
		$wgOut->addHTML('<div id="wikiPreview_' . $this->mvd_id .'"></div>');		
		
		//set the default action so save page: 
		$wgOut->addHTML( $this->getAjaxForm() );
		
		//add in adjust html if present: 
		$wgOut->addHTML($this->adj_html);				

		//structure layout via tables (@@todo switch to class based css layout)		
		$wgOut->addHTML('<table style="background: transparent;" width="100%"><tr><td valign="top" width="90">');
			//output the person selector:
			if(!isset($semantic_data['Spoken By']))$semantic_data['Spoken By']='';
			$imgTitle = Title::makeTitle(NS_IMAGE, $semantic_data['Spoken By'] . '.jpg');
			if($imgTitle->exists()){
				$img= wfFindFile($imgTitle);
				if ( !$img ) {
					$img = wfLocalFile( $imgTitle );					
				}																			
			}else{
				//assume 'Missing person.jpg' exist 
				//@@todo put this into the install scripts 
				
				$imgTitle =  Title::makeTitle(NS_IMAGE, MV_MISSING_PERSON_IMG);
				$img= wfFindFile($imgTitle);	
				if ( !$img ) {
					$img = wfLocalFile( $imgTitle );					
				}
			}
			$wgOut->addHTML("<img id=\"mv_edit_im_{$this->mvd_id}\" style=\"display: block;margin-left: auto;margin-right: auto;\" src=\"{$img->getURL()}\" width=\"44\">");				
				$wgOut->addHTML('<input style="font-size:x-small" 
						value="'.$semantic_data['Spoken By'].'" 
						name="smw_Spoken_By"
						onClick="this.value=\'\';" 
						type="text" id="auto_comp_'.$this->mvd_id.'" size="12" 
						maxlength="125" autocomplete="off"/>');
				//only add one auto_comp_choices_ per object/request pass
				if(!isset($this->auto_comp_choices)){
					$this->auto_comp_choices = true;
					$wgOut->addHTML('<div id="auto_comp_choices_'.$this->mvd_id.'" class="autocomplete"></div>');
				}
		//add container formatting for MV_Overlay
		$wgOut->addHTML('</td>' .	
			'<td>');
	}
	/* copy of edit() from edit page (to override empty page)*/
	function edit( $textbox1_override=null) {
		global $wgOut, $wgUser, $wgRequest, $wgTitle;

		$fname = 'MV_EditPage::edit';
		wfProfileIn( $fname );
		wfDebug( "$fname: enter\n" );

		// this is not an article
		$wgOut->setArticleFlag(false);

		$this->importFormData( $wgRequest );
		if($textbox1_override)$this->textbox1=$textbox1_override;
		$this->firsttime = false;

		if( $this->live ) {
			$this->livePreview();
			wfProfileOut( $fname );
			return;
		}

		$permErrors = $this->mTitle->getUserPermissionsErrors('edit', $wgUser);
		if( !$this->mTitle->exists() )
			$permErrors += array_diff( $this->mTitle->getUserPermissionsErrors('create', $wgUser), $permErrors );

		# Ignore some permissions errors.
		$remove = array();
		foreach( $permErrors as $error ) {
			if ($this->preview || $this->diff &&
				($error[0] == 'blockedtext' || $error[0] == 'autoblockedtext'))
			{
				// Don't worry about blocks when previewing/diffing
				$remove[] = $error;
			}

			if ($error[0] == 'readonlytext')
			{
				if ($this->edit) {
					$this->formtype = 'preview';
				} elseif ($this->save || $this->preview || $this->diff) {
					$remove[] = $error;
				}
			}
		}
		# array_diff returns elements in $permErrors that are not in $remove.
		$permErrors = array_diff( $permErrors, $remove );

		if ( !empty($permErrors) )
		{
			wfDebug( "$fname: User can't edit\n" );
			//limt rows for ajax:
			$non_ajax_rows = $wgUser->getIntOption( 'rows' );			
			$wgUser->setOption('rows', 5);
			
			$sk = $wgUser->getSkin();
			$cancel = '<a href="javascript:mv_disp_mvd(\''.$this->mTitle->getDBkey(). '\',\''.
					 $this->mvd_id.'\');">' . wfMsgExt('cancel', array('parseinline')).'</a>';
			
			//get the stream parent:
			$mvd = MV_Index::getMVDbyId($this->mvd_id);
			$stream_name = MV_Stream::getStreamNameFromId($mvd->stream_id);
			
			$lTitle = Title::makeTitle(NS_SPECIAL, 'Userlogin');
			$loginLink = $sk->makeLinkObj( $lTitle,wfMsg('login'), 'returnto='.Namespace::getCanonicalName(MV_NS_STREAM).':'.$stream_name);
								
			$wgOut->addHTML(wfMsg('mv_user_cant_edit',$loginLink, $cancel));
			$wgOut->readOnlyPage(  $this->mArticle->getContent(), true, $permErrors );
			$wgUser->setOption('rows', $non_ajax_rows);
			wfProfileOut( $fname );
			return;
		} else {
			if ( $this->save ) {
				$this->formtype = 'save';
			} else if ( $this->preview ) {
				$this->formtype = 'preview';
			} else if ( $this->diff ) {
				$this->formtype = 'diff';
			} else { # First time through
				$this->firsttime = true;
				if( $this->previewOnOpen() ) {
					$this->formtype = 'preview';
				} else {
					$this->extractMetaDataFromArticle () ;
					$this->formtype = 'initial';
				}
			}
		}

		wfProfileIn( "$fname-business-end" );

		$this->isConflict = false;
		// css / js subpages of user pages get a special treatment
		$this->isCssJsSubpage      = $this->mTitle->isCssJsSubpage();
		$this->isValidCssJsSubpage = $this->mTitle->isValidCssJsSubpage();

		/* Notice that we can't use isDeleted, because it returns true if article is ever deleted
		 * no matter it's current state
		 */
		$this->deletedSinceEdit = false;
		if ( $this->edittime != '' ) {
			/* Note that we rely on logging table, which hasn't been always there,
			 * but that doesn't matter, because this only applies to brand new
			 * deletes. This is done on every preview and save request. Move it further down
			 * to only perform it on saves
			 */
			if ( $this->mTitle->isDeleted() ) {
				$this->lastDelete = $this->getLastDelete();
				if ( !is_null($this->lastDelete) ) {
					$deletetime = $this->lastDelete->log_timestamp;
					if ( ($deletetime - $this->starttime) > 0 ) {
						$this->deletedSinceEdit = true;
					}
				}
			}
		}

		# Show applicable editing introductions
		if( $this->formtype == 'initial' || $this->firsttime )
			$this->showIntro();
	
		if( $this->mTitle->isTalkPage() ) {
			$wgOut->addWikiText( wfMsg( 'talkpagetext' ) );
		}

		# Attempt submission here.  This will check for edit conflicts,
		# and redundantly check for locked database, blocked IPs, etc.
		# that edit() already checked just in case someone tries to sneak
		# in the back door with a hand-edited submission URL.

		if ( 'save' == $this->formtype ) {
			if ( !$this->attemptSave() ) {
				wfProfileOut( "$fname-business-end" );
				wfProfileOut( $fname );
				return;
			}
		}

		# First time through: get contents, set time for conflict
		# checking, etc.
		if ( 'initial' == $this->formtype || $this->firsttime ) {
			if ($this->initialiseForm() === false) {
				$this->noSuchSectionPage();
				wfProfileOut( "$fname-business-end" );
				wfProfileOut( $fname );
				return;
			}
			if( !$this->mTitle->getArticleId() ) 
				wfRunHooks( 'EditFormPreloadText', array( &$this->textbox1, &$this->mTitle ) );
		}

		$this->showEditForm();
		wfProfileOut( "$fname-business-end" );
		wfProfileOut( $fname );
	}
	/********would not have to override if they where not "private" functions 
		/**
	 * Should we show a preview when the edit form is first shown?
	 *
	 * @return bool
	 */
	private function previewOnOpen() {
		global $wgRequest, $wgUser;
		if( $wgRequest->getVal( 'preview' ) == 'yes' ) {
			// Explicit override from request
			return true;
		} elseif( $wgRequest->getVal( 'preview' ) == 'no' ) {
			// Explicit override from request
			return false;
		} elseif( $this->section == 'new' ) {
			// Nothing *to* preview for new sections
			return false;
		} elseif( ( $wgRequest->getVal( 'preload' ) !== '' || $this->mTitle->exists() ) && $wgUser->getOption( 'previewonfirst' ) ) {
			// Standard preference behaviour
			return true;
		} elseif( !$this->mTitle->exists() && $this->mTitle->getNamespace() == NS_CATEGORY ) {
			// Categories are special
			return true;
		} else {
			return false;
		}
	}
	private function showDeletionLog( $out ) {
		$title = $this->mTitle;
		$reader = new LogReader(
			new FauxRequest(
				array(
					'page' => $title->getPrefixedText(),
					'type' => 'delete',
					)
			)
		);
		if( $reader->hasRows() ) {
			$out->addHtml( '<div id="mw-recreate-deleted-warn">' );
			$out->addWikiText( wfMsg( 'recreate-deleted-warn' ) );
			$viewer = new LogViewer( $reader );
			$viewer->showList( $out );
			$out->addHtml( '</div>' );
		}
	}
	/**
	 * Attempt to show a custom editing introduction, if supplied
	 *
	 * @return bool
	 */
	private function showCustomIntro() {
		if( $this->editintro ) {
			$title = Title::newFromText( $this->editintro );
			if( $title instanceof Title && $title->exists() && $title->userCanRead() ) {
				global $wgOut;
				$revision = Revision::newFromTitle( $title );
				$wgOut->addSecondaryWikiText( $revision->getText() );
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	function do_post_HtEdit(){
		global $wgOut;
		/*"<textarea name=\"wpTextbox{$mvd_id}\" 
					id=\"wpTextbox{$this->mvd_id}\" rows='3'
					cols=\"50\" >$text
					</textarea>"*/
		return '</td></tr></table>';
	}
	private function showIntro() {
		global $wgOut, $wgUser;
		if( !$this->showCustomIntro() && !$this->mTitle->exists() ) {
			if( $wgUser->isLoggedIn() ) {
				//$wgOut->addWikiText( wfMsg( 'mv_new_mvd_page' ) );
			} else {
				//$wgOut->addWikiText( wfMsg( 'mv_new_mvd_page_anon' ) );
			}
			$this->showDeletionLog( $wgOut );
		}
	}
	
	function setAdjustHtml($adj_html){
		$this->adj_html = $adj_html;
	}
	function internalAttemptSave( &$result, $bot = false ) {
		global $wgHooks;
		//clear confirmEdit for ajax edits: 
		if(isset($wgHooks['EditFilter'])){
			foreach($wgHooks['EditFilter'] as $k=>$hook){			
				unset($wgHooks['EditFilter'][$k]);
			}
		}
		parent::internalAttemptSave( &$result, $bot = false );
	}	
	function showEditForm( $formCallback=null ) {
		global $wgOut, $wgUser, $wgLang, $wgContLang, $wgMaxArticleSize;
		
		//print "call SHOW EDIT FORM";
		if(!isset($this->stripped_edit_text))$this->stripped_edit_text='';
		
		$fname = 'EditPageAjax::showEditForm';
		wfProfileIn( $fname );
		
		$closeFormHtml='';
		//check if we are in the MVD namespace (and need to use templates for edits:)
		if($this->mTitle->getNamespace() == MV_NS_MVD){
			//get display type get mvTitle if not set
			if(!isset($this->article->mvTitle)){				
				$this->mvTitle = new MV_Title($this->mTitle->getDBkey());			
			}
			$editFormType=strtolower($this->mvTitle->getTypeMarker());
		}else{
			//check if its seq type: 
			if($this->mvd_id == 'seq'){
				$editFormType='seq';
			}else{
				$editFormType='default';
			}
		}
			switch($editFormType){
				case 'ht_en':
					$this->do_pre_htEdit();
					$closeFormHtml=$this->do_post_HtEdit();
				break;	
				case 'anno_en':
					$this->loadEditText();		
					//set the default action so save page: 
					$wgOut->addHTML( $this->getAjaxForm() );			
					//add in adjust html if present: 
					$wgOut->addHTML($this->adj_html);
				break;
				case 'seq':
					$wgOut->addHTML( wfMsg('mv_edit_sequence_desc_help'));
					if($this->mArticle->mTitle->exists()){
						$this->stripped_edit_text=$this->mArticle->getPageContent();
					}else{
						$this->stripped_edit_text='';
					}
					$wgOut->addHTML( $this->getAjaxForm() );
				break;
				default:
					$this->loadEditText();		
					//set the default action so save page: 
					$wgOut->addHTML( $this->getAjaxForm() );
				break;
			}				
		$sk = $wgUser->getSkin();

		//wfRunHooks( 'EditPage::showEditForm:initial', array( &$this ) ) ;

		//$wgOut->setRobotpolicy( 'noindex,nofollow' );

		# Enabled article-related sidebar, top links, etc.
		$wgOut->setArticleRelated( true );

		if ( $this->isConflict ) {
			$s = wfMsg( 'editconflict', $this->mTitle->getPrefixedText() );
			$wgOut->setPageTitle( $s );
			$wgOut->addWikiText( wfMsg( 'explainconflict' ) );

			$this->textbox2 = $this->textbox1;
			$this->textbox1 = $this->stripped_edit_text;
			$this->edittime = $this->mArticle->getTimestamp();
		} else {
			if( $this->section != '' ) {
				if( $this->section == 'new' ) {
					$s = wfMsg('editingcomment', $this->mTitle->getPrefixedText() );
				} else {
					$s = wfMsg('editingsection', $this->mTitle->getPrefixedText() );
					$matches = array();
					if( !$this->summary && !$this->preview && !$this->diff ) {
						preg_match( "/^(=+)(.+)\\1/mi",
							$this->stripped_edit_text,
							$matches );
						if( !empty( $matches[2] ) ) {
							$this->summary = "/* ". trim($matches[2])." */ ";
						}
					}
				}
			} else {
				$s = wfMsg( 'editing', $this->mTitle->getPrefixedText() );
			}
			//$wgOut->addHTML($s);
			//$wgOut->setPageTitle( $s );

			if ( $this->missingComment ) {
				$wgOut->addWikiText( wfMsg( 'missingcommenttext' ) );
			}

			if( $this->missingSummary && $this->section != 'new' ) {
				$wgOut->addWikiText( wfMsg( 'missingsummary' ) );
			}

			if( $this->missingSummary && $this->section == 'new' ) {
				$wgOut->addWikiText( wfMsg( 'missingcommentheader' ) );
			}

			if( !$this->hookError == '' ) {
				$wgOut->addWikiText( $this->hookError );
			}

			if ( !$this->checkUnicodeCompliantBrowser() ) {
				$wgOut->addWikiText( wfMsg( 'nonunicodebrowser') );
			}
			if ( isset( $this->mArticle ) && isset( $this->mArticle->mRevision ) ) {
			// Let sysop know that this will make private content public if saved
				if( $this->mArticle->mRevision->isDeleted( Revision::DELETED_TEXT ) ) {
					$wgOut->addWikiText( wfMsg( 'rev-deleted-text-view' ) );
				}
				if( !$this->mArticle->mRevision->isCurrent() ) {
					$this->mArticle->setOldSubtitle( $this->mArticle->mRevision->getId() );
					$wgOut->addWikiText( wfMsg( 'editingold' ) );
				}
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

		if( $this->mTitle->getNamespace() == NS_MEDIAWIKI ) {
			# Show a warning if editing an interface message
			$wgOut->addWikiText( wfMsg( 'editinginterface' ) );
		} elseif( $this->mTitle->isProtected( 'edit' ) ) {
			# Is the title semi-protected?
			if( $this->mTitle->isSemiProtected() ) {
				$notice = wfMsg( 'semiprotectedpagewarning' );
				if( wfEmptyMsg( 'semiprotectedpagewarning', $notice ) || $notice == '-' )
					$notice = '';
			} else {
			# Then it must be protected based on static groups (regular)
				$notice = wfMsg( 'protectedpagewarning' );
			}
			$wgOut->addWikiText( $notice );
		}
		if ( $this->mTitle->isCascadeProtected() ) {
			# Is this page under cascading protection from some source pages?
			list($cascadeSources, /* $restrictions */) = $this->mTitle->getCascadeProtectionSources();
			if ( count($cascadeSources) > 0 ) {
				# Explain, and list the titles responsible
				$notice = wfMsgExt( 'cascadeprotectedwarning', array('parsemag'), count($cascadeSources) ) . "\n";
				foreach( $cascadeSources as $id => $page )
					$notice .= '* [[:' . $page->getPrefixedText() . "]]\n";
				}
			$wgOut->addWikiText( $notice );
		}

		if ( $this->kblength === false ) {
			$this->kblength = (int)(strlen( $this->stripped_edit_text ) / 1024);
		}
		if ( $this->tooBig || $this->kblength > $wgMaxArticleSize ) {
			$wgOut->addWikiText( wfMsg( 'longpageerror', $wgLang->formatNum( $this->kblength ), $wgMaxArticleSize ) );
		} elseif( $this->kblength > 29 ) {
			$wgOut->addWikiText( wfMsg( 'longpagewarning', $wgLang->formatNum( $this->kblength ) ) );
		}

		#need to parse the preview early so that we know which templates are used,
		#otherwise users with "show preview after edit box" will get a blank list
		if ( $this->formtype == 'preview' ) {
			$previewOutput = $this->getPreviewText();
		}

		//$rows = $wgUser->getIntOption( 'rows' );
		//$cols = $wgUser->getIntOption( 'cols' );
		//for ajax short edit area:
		$rows = 3;
		$cols= 30;

		$ew = $wgUser->getOption( 'editwidth' );
		if ( $ew ) $ew = " style=\"width:100%\"";
		else $ew = '';
		
		//do ajax action:
		//$q = 'action=ajax';
		#if ( "no" == $redirect ) { $q .= "&redirect=no"; }
		//$action = $this->mTitle->escapeLocalURL( $q );
		if($editFormType=='seq'){
			$summary = wfMsg('mv_seq_summary');
		}else{
			$summary = wfMsg('summary');
		}
		$subject = wfMsg('subject');


		if($this->mvd_id=='seq'){
			$cancel = $sk->makeKnownLink( $this->mTitle->getPrefixedText(),
				wfMsgExt('cancel', array('parseinline')) );
			$edithelpurl = Skin::makeInternalOrExternalUrl( wfMsgForContent( 'mv_edithelpsequence' ));
		}else{
			$cancel = '<a href="javascript:mv_disp_mvd(\''.$this->mTitle->getDBkey(). '\',\''.
					 $this->mvd_id.'\');">' . wfMsgExt('cancel', array('parseinline')).'</a>';
			$edithelpurl = Skin::makeInternalOrExternalUrl( wfMsgForContent( 'edithelppage' ));					 
		}
				
		$edithelp = '<a target="helpwindow" href="'.$edithelpurl.'">'.
			htmlspecialchars( wfMsg( 'edithelp' ) ).'</a> '.
			htmlspecialchars( wfMsg( 'newwindow' ) );

		global $wgRightsText;
		//copy right here is too verbose for a ajax window
		/*$copywarn = "<div id=\"editpage-copywarn\">\n" .
			wfMsg( $wgRightsText ? 'copyrightwarning' : 'copyrightwarning2',
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
				$wgRightsText ) . "\n</div>";
		*/
	
		if( $wgUser->getOption('showtoolbar') and !$this->isCssJsSubpage ) {
			# prepare toolbar for edit buttons
			$toolbar = EditPage::getEditToolbar();
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

		$wgOut->addHTML( $this->editFormPageTop );

		if ( $wgUser->getOption( 'previewontop' ) ) {

			if ( 'preview' == $this->formtype ) {
				$this->showPreview( $previewOutput );
			} else {
				$wgOut->addHTML( '<div id="wikiPreview_'.$this->mvd_id.'"></div>' );
			}

			if ( 'diff' == $this->formtype ) {
				$this->showDiff();
			}
		}

		$wgOut->addHTML( $this->editFormTextTop );

		# if this is a comment, show a subject line at the top, which is also the edit summary.
		# Otherwise, show a summary field at the bottom
		$summarytext = htmlspecialchars( $wgContLang->recodeForEdit( $this->summary ) ); # FIXME
		if( $this->section == 'new' ) {
			$commentsubject="<br /><span id='wpSummaryLabel'><label for='wpSummary'>{$subject}:</label></span>\n<div class='editOptions'>\n<input tabindex='1' type='text' value=\"$summarytext\" name='wpSummary' id='wpSummary' maxlength='200' size='60' /><br />";
			$editsummary = '';
			$subjectpreview = $summarytext && $this->preview ? "<div class=\"mw-summary-preview\">".wfMsg('subject-preview').':'.$sk->commentBlock( $this->summary, $this->mTitle )."</div>\n" : '';
			$summarypreview = '';
		} else {
			$commentsubject = '';
			$editsummary="<br /><span id='wpSummaryLabel'><label for='wpSummary'>{$summary}:</label></span>\n<div class='editOptions'>\n<input tabindex='2' type='text' value=\"$summarytext\" name='wpSummary' id='wpSummary' maxlength='200' size='60' /><br />";
			$summarypreview = $summarytext && $this->preview ? "<div class=\"mw-summary-preview\">".wfMsg('summary-preview').':'.$sk->commentBlock( $this->summary, $this->mTitle )."</div>\n" : '';
			$subjectpreview = '';
		}

		# Set focus to the edit box on load, except on preview or diff, where it would interfere with the display
		/*if( !$this->preview && !$this->diff ) {
			$wgOut->setOnloadHandler( 'document.editform.wpTextbox1.focus()' );
		}*/
		
		$templates = ($this->preview || $this->section != '') ? $this->mPreviewTemplates : $this->mArticle->getUsedTemplates();
		$formattedtemplates = $sk->formatTemplates( $templates, $this->preview, $this->section != '');

		global $wgUseMetadataEdit ;
		if ( $wgUseMetadataEdit ) {
			$metadata = $this->mMetaData ;
			$metadata = htmlspecialchars( $wgContLang->recodeForEdit( $metadata ) ) ;
			$top = wfMsgWikiHtml( 'metadata_help' );
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

		$tabindex = 2;

		$checkboxes = self::getCheckboxes( $tabindex, $sk,
			array( 'minor' => $this->minoredit, 'watch' => $this->watchthis ) );

		$checkboxhtml = implode( $checkboxes, "\n" );
		
		$button_action = 'mv_do_ajax_form_submit(\''.$this->mvd_id.'\', \'%s\');';
		
		$buttons = $this->getEditButtons( $tabindex , $button_action);
		$buttonshtml = implode( $buttons, "\n" );

		$safemodehtml = $this->checkUnicodeCompliantBrowser()
			? '' : Xml::hidden( 'safemode', '1' );

		$wgOut->addHTML( <<<END
{$toolbar}
END
);
//remove form because set earlier
//<form id="editform" name="editform" method="post" action="$action" enctype="multipart/form-data">

		if( is_callable( $formCallback ) ) {
			call_user_func_array( $formCallback, array( &$wgOut ) );
		}

		wfRunHooks( 'EditPage::showEditForm:fields', array( &$this, &$wgOut ) );

		// Put these up at the top to ensure they aren't lost on early form submission
		$wgOut->addHTML( "
<input type='hidden' value=\"" . htmlspecialchars( $this->section ) . "\" name=\"wpSection\" />
<input type='hidden' value=\"{$this->starttime}\" name=\"wpStarttime\" />\n
<input type='hidden' value=\"{$this->edittime}\" name=\"wpEdittime\" />\n
<input type='hidden' value=\"{$this->scrolltop}\" name=\"wpScrolltop\" id=\"wpScrolltop\" />\n" );

		$wgOut->addHTML( <<<END
$recreate
{$commentsubject}
{$subjectpreview}
<textarea class="mv_ajax_textarea" tabindex='1' accesskey="," name="wpTextbox1" id="wpTextbox1" rows='{$rows}'
cols='{$cols}' {$ew} $hidden>
END
. htmlspecialchars( $this->safeUnicodeOutput( $this->stripped_edit_text ) ) .
"
</textarea>
		" );

		//$wgOut->addWikiText( $copywarn );
		$wgOut->addHTML( $this->editFormTextAfterWarn );
		$wgOut->addHTML( "
{$metadata}
{$editsummary}
{$summarypreview}
{$checkboxhtml}
{$safemodehtml}
");

		$wgOut->addHTML(
"<div class='editButtons'>
{$buttonshtml}
	<span class='editHelp'>{$cancel} | {$edithelp}</span>
</div><!-- editButtons -->
</div><!-- editOptions -->");

		$wgOut->addHtml( '<div class="mw-editTools">' );
		$wgOut->addWikiText( wfMsgForContent( 'edittools' ) );
		$wgOut->addHtml( '</div>' );

		$wgOut->addHTML( $this->editFormTextAfterTools );

		$wgOut->addHTML( "
<div class='templatesUsed'>
{$formattedtemplates}
</div>
" );

		/**
		 * To make it harder for someone to slip a user a page
		 * which submits an edit form to the wiki without their
		 * knowledge, a random token is associated with the login
		 * session. If it's not passed back with the submission,
		 * we won't save the page, or render user JavaScript and
		 * CSS previews.
		 *
		 * For anon editors, who may not have a session, we just
		 * include the constant suffix to prevent editing from
		 * broken text-mangling proxies.
		 */
		$token = htmlspecialchars( $wgUser->editToken() );
		$wgOut->addHTML( "\n<input type='hidden' value=\"$token\" name=\"wpEditToken\" />\n" );


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
		$wgOut->addHtml( wfHidden( 'wpAutoSummary', $autosumm ) );

		if ( $this->isConflict ) {
			$wgOut->addWikiText( '==' . wfMsg( "yourdiff" ) . '==' );

			$de = new DifferenceEngine( $this->mTitle );
			$de->setText( $this->textbox2, $this->stripped_edit_text );
			$de->showDiff( wfMsg( "yourtext" ), wfMsg( "storedversion" ) );

			$wgOut->addWikiText( '==' . wfMsg( "yourtext" ) . '==' );
			$wgOut->addHTML( "<textarea tabindex=6 id='wpTextbox2' name=\"wpTextbox2\" rows='{$rows}' cols='{$cols}' wrap='virtual'>"
				. htmlspecialchars( $this->safeUnicodeOutput( $this->textbox2 ) ) . "\n</textarea>" );
		}
		$wgOut->addHTML( $this->editFormTextBottom );
		$wgOut->addHTML( "</form>\n" );
		if ( !$wgUser->getOption( 'previewontop' ) ) {

			if ( $this->formtype == 'preview') {
				$this->showPreview( $previewOutput );
			} else {
				$wgOut->addHTML( '<div id="wikiPreview"></div>' );
			}

			if ( $this->formtype == 'diff') {
				$this->showDiff();
			}

		}
		$wgOut->addHTML($closeFormHtml);
		wfProfileOut( $fname );
	}
 		/**
	 * Returns an array of html code of the following buttons: (in ajax mode we onclick action
	 * save, diff, preview and live
	 *
	 * @param $tabindex Current tabindex
	 *
	 * @return array
	 */
	public function getEditButtons(&$tabindex, $button_action='') {
		global $wgLivePreview, $wgUser;

		if($button_action==''){
			$btype='submit';
		}
		$buttons = array();

		$temp = array(
			'id'        => 'wpSave',
			'name'      => 'wpSave',
			'type'      => ($button_action=='')?'submit':'button',			
			'tabindex'  => ++$tabindex,
			'value'     => wfMsg('savearticle'),
			'accesskey' => wfMsg('accesskey-save'),
			'title'     => wfMsg( 'tooltip-save' ).' ['.wfMsg( 'accesskey-save' ).']',
		);
		if($this->mvd_id=='seq')
			$temp['value']=wfMsg('mv_save_sequence');
		
		if($button_action!='')
			$temp['onMouseUp']= sprintf($button_action, 'save');
			
		$buttons['save'] = wfElement('input', $temp, '');

		++$tabindex; // use the same for preview and live preview
		if ( $wgLivePreview && $wgUser->getOption( 'uselivepreview' ) ) {
			$temp = array(
				'id'        => 'wpPreview_'.$this->mvd_id,
				'name'      => 'wpPreview',
				'type'      => ($button_action=='')?'submit':'button',
				'tabindex'  => $tabindex,
				'value'     => wfMsg('showpreview'),
				'accesskey' => '',
				'title'     => wfMsg( 'tooltip-preview' ).' ['.wfMsg( 'accesskey-preview' ).']',
				'style'     => 'display: none;',
			);
			if($button_action!='')
				$temp['onMouseUp']= sprintf($button_action, 'preview');
			$buttons['preview'] = wfElement('input', $temp, '');

			$temp = array(
				'id'        => 'wpLivePreview',
				'name'      => 'wpLivePreview',
				'type'      => ($button_action=='')?'submit':'button',
				'tabindex'  => $tabindex,
				'value'     => wfMsg('showlivepreview'),
				'accesskey' => wfMsg('accesskey-preview'),
				'title'     => '',
				'onclick'   => $this->doLivePreviewScript(),
			);
			if($button_action!='')
				$temp['onMouseUp']= sprintf($button_action, 'live');
			$buttons['live'] = wfElement('input', $temp, '');
		} else {
			$temp = array(
				'id'        => 'wpPreview_'.$this->mvd_id,
				'name'      => 'wpPreview',
				'type'      => ($button_action=='')?'submit':'button',	
				'tabindex'  => $tabindex,
				'value'     => wfMsg('showpreview'),
				'accesskey' => wfMsg('accesskey-preview'),
				'title'     => wfMsg( 'tooltip-preview' ).' ['.wfMsg( 'accesskey-preview' ).']',
			);
			if($button_action!='')
				$temp['onMouseUp']= sprintf($button_action, 'preview');
				
			$buttons['preview'] = wfElement('input', $temp, '');
			$buttons['live'] = '';
		}

		$temp = array(
			'id'        => 'wpDiff',
			'name'      => 'wpDiff',
			'type'      => ($button_action=='')?'submit':'button',	
			'tabindex'  => ++$tabindex,
			'value'     => wfMsg('showdiff'),
			'accesskey' => wfMsg('accesskey-diff'),
			'title'     => wfMsg( 'tooltip-diff' ).' ['.wfMsg( 'accesskey-diff' ).']',
		);
		if($button_action!='')
				$temp['onMouseUp']= sprintf($button_action, 'diff');
		$buttons['diff'] = wfElement('input', $temp, '');

		return $buttons;
	}
	function showPreview( $text ) {
		global $wgOut;
		$wgOut->addHTML($text);
		//$wgOut->addHTML( '<div id="wikiPreview">' );
		//if($this->mTitle->getNamespace() == NS_CATEGORY) {
		//	$this->mArticle->openShowCategory();
		//}
		//$wgOut->addHTML( $text );
		//if($this->mTitle->getNamespace() == NS_CATEGORY) {
		//	$this->mArticle->closeShowCategory();
		//}
		//$wgOut->addHTML( '</div>' );
	}		
 }   
?>
